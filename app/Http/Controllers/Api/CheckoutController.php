<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;


class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {   
        // Enter Your Stripe Secret
        $stripeConfig = Config::get('stripe');
        Stripe::setApiKey($stripeConfig['secret']);
		$amount = 1000;
		$amount *= 100;
        $amount = (int) $amount;
        
        $payment_intent = \Stripe\PaymentIntent::create([
			'description' => 'Stripe Test Payment',
			'amount' => $amount,
			'currency' => 'INR',
			'description' => 'Payment From INS',
			'payment_method_types' => ['card'],
		]);
		$intent = $payment_intent->client_secret;
        // dd($intent);
		return view('test2',compact('intent'));

    }

    public function afterPayment(Request $request)
    {
        dd( $request->all() );
        return 'Payment Has been Received';
    }


    public function pay(Request $request)
    {
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
                'amount' => 10000,
                'currency' => 'mxn'
            ));
            
            return [
                "customer"=>$customer,
                "charge"=>$charge
            ];
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function showStripeView($idAddress){
        try {
            return "a";
            return view('payments.stripe',['total'=>$total,'itemsproducts'=>$collection,'address_id'=>$idAddress]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['fail'=>'No se pudo realizar el pago con Stripe, contacte al administrador']);
        }
       
    }

}