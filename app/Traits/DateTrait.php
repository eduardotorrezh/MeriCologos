<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait DateTrait
{



    public function getDates($results)
    {
        $dates = [];
        $patient_id = $results[0]["patient_id"];
        $doctor_id = $results[0]["doctor_id"];
        $shiftTemp = $results[0]["shift"];
        $date = $results[0]["date"];
        $length = count($results);

        foreach ($results as $key => $value) {

            if($key != $length  -1){
                if($patient_id == $value["patient_id"] && $doctor_id == $value["doctor_id"] && $date == $value["date"]){


                }else{
                    
                    array_push($dates,["shiftInit"=> $shiftTemp,"shiftEnd"=> $results[$key - 1]["shift"],  "dates_info"=> $results[$key - 1]["dates_info"],"patient"=>$results[$key - 1]["patient"],"doctor"=>$results[$key - 1]["doctor"], "date"=> $results[$key - 1]["date"]]);
                    $patient_id = $value["patient_id"];
                    $doctor_id = $value["doctor_id"];
                    $shiftTemp = $value["shift"];
                    $date = $value["date"];


                }
            }else{

                array_push($dates,["shiftInit"=> $shiftTemp,"shiftEnd"=> $results[$key - 1]["shift"],  "dates_info"=> $results[$key - 1]["dates_info"],"patient"=>$results[$key - 1]["patient"],"doctor"=>$results[$key - 1]["doctor"], "date"=> $results[$key - 1]["date"]]);
            
            }

        }

        return $dates;
    }


}
