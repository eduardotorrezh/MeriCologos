<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Models\DatesInfo;
use App\Models\Sale;
use App\Models\SaleInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;
use DB;

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use \PayPal\Rest\ApiContext;
use PayPal\Exception\PayPalConnectionException;
use Config;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

use App\Traits\ApiResponser;

class DateController extends Controller
{
    use ApiResponser;
    
    private $apiContext;

    public function __construct()
    {
        $payPalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],
                $payPalConfig['secret']
            )
        );

        $this->apiContext->setConfig($payPalConfig['settings']);
    }

    public function index()
    {
        return $this->successResponse(Date::all());
    }


        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'init_hour' => 'required',
            'end_hour' => 'required',
            'payment_type' => 'required',
        ]);
        if($validator->fails()){
            return response(
                [
                    'message' => 'Validation errors', 
                    'errors' =>  $validator->errors()
                ], 422
            );
        }
        DB::beginTransaction();
        try {



            $init_date = getDate(strtotime($request->init_hour))["hours"];
            $end_date = getDate(strtotime($request->end_hour))["hours"];
            //crea la informacion de la cita
            if(getDate(strtotime($request->init_hour))["minutes"] !=0 ){
                $init_hour = $init_hour + 0.5;
            }
            if(getDate(strtotime($request->end_hour))["minutes"] !=0 ){
                $end_date = $end_date + 0.5;
            }
            $DI = DatesInfo::create();




            $request["date"] = $request->init_hour;
            $request["dates_infos_id"] = $DI->id;

            //crea los turnos que ocupara la cita y valida que esos turnos esten disponibles
            //calcula el costo de la cita
            $amount = 0;
            for ($i=$init_date; $i < $end_date; $i = $i + 0.5) {
                if(count(Date::where("shift_id",$i * 2)->where("date",date("Y-m-d",strtotime($request->init_hour )))->where("doctor_id",$request->doctor_id)->get() ) != 0 ){
                    DB::rollback();
                    return $this->errorResponse('este turno ya esta ocupado', 400);
                }else{
                    $amount = $amount + 100;
                    $request["shift_id"] = $i *2;
                    $i *2;
                    $date = Date::create($request->all());
                }
            }

            //se intenta hacer el pago
            //pay_id es la cadena que regresa paypal al hacer el pago de manera exitosa
            $SI = SaleInfo::create();

            if($request->payment_type == "paypal"){
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');

                $pay_amount = new Amount();
                $pay_amount->setTotal(strval($amount));
                $pay_amount->setCurrency('MXN');
                
                $transaction = new Transaction();
                $transaction->setAmount($pay_amount);
                $transaction->setDescription('Cita');

                $callbackUrl = url('/api/paypal/status');
                $callbackUrlAccept = url('/api/paypal/status/'.$SI->id);

                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl($callbackUrlAccept)
                    ->setCancelUrl($callbackUrl);

                $payment = new Payment();
                $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);
                
                try {
                    $payment->create($this->apiContext);
                    $S = Sale::create(["amount"=>$amount,"date_info_id"=>$DI->id,"user_id"=> Auth::user()->id,"sale_info_id"=>$SI->id]);
                    DB::commit();
                    return $this->successResponse( $payment->getApprovalLink() , 200 );
                    // return redirect()->away( $payment->getApprovalLink() );
                } catch (PayPalConnectionException $ex) {
                    echo $ex->getData();
                }

            }
            
            if($request->payment_type == "stripe"){

                try {
                    $stripeConfig = Config::get('stripe');
                    Stripe::setApiKey($stripeConfig['secret']);
                    
                    $customer = Customer::create(array(
                        'email' => $request->stripeEmail,
                        'source' => $request->stripeToken,
                        'address'=>$request->stripeAddress,
        
                    ));

                    $charge = Charge::create(array(
                        'customer' => $customer->id,
                        'amount' => $amount*100,
                        'currency' => 'mxn'
                    ));
                    $SI->update(["pay_id"=>$charge->id,"payment_type"=>"stripe"]);
                    $S = Sale::create(["amount"=>$amount,"date_info_id"=>$DI->id,"user_id"=> Auth::user()->id,"sale_info_id"=>$SI->id]);
                    DB::commit();
                    return $this->successResponse( $payment->getApprovalLink() , 200 );
                    
                } catch (\Exception $ex) {
                    return $ex->getMessage();
                }

            }
            
            // $S = Sale::create(["amount"=>$amount,"date_info_id"=>$DI->id,"user_id"=> Auth::user()->id,"sale_info_id"=>$SI->id]);
            // DB::commit();
            // return $this->successResponse($DI, Response::HTTP_CREATED);
            //nota para el dani del futuro, pensar que pasaria en caso de que fallara en este fraccmento de codigo despues de hacer el pago en paypal


        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    public function setAbsence(Request $request, DatesInfo $datesInfo)
    {
        DB::beginTransaction();
        try {
            $datesInfo->update(["assistance"=>false]);
            if($datesInfo->assistance){
                $firstDate = $datesInfo->Dates->first();
                $firstDate->patient->update(["absences"=>$firstDate->patient->absences+1]);
            }
            DB::commit();
            return $this->successResponse($datesInfo, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    public function payPalStatus(Request $request, SaleInfo $saleInfo)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar ERR1.';
            // return redirect('/paypal/failed')->with(compact('status'));
            return $this->errorResponse($status, 400);
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            $saleInfo->update(["pay_id"=>$request->paymentId,"payment_type"=>"paypal"]);
            $status = 'Gracias! El pago a través de PayPal se ha ralizado correctamente.';
            return  $this->successResponse($status);
            // return redirect('/results')->with(compact('status'));
        }

        $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar ERR2.';
        return $this->errorResponse($status, 400);
        // return redirect('/results')->with(compact('status'));
    }
}
