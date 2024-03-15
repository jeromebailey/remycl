<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StringHelper extends Model
{
    use HasFactory;

    public static function getFirstAndLastNameFromString($fullNameString){

        if( $fullNameString !== null ){
            $firstName = $lastName = '';
            //$partsArray = substr() strrpos(trim($fullNameString), ' ')
            $parts = explode(' ', trim($fullNameString));
            $lastName = ucfirst($parts[count($parts)-1]);

            if( count($parts) == 2 )
                $firstName = $parts[0];
            else {
                for($i = 0; $i <= count($parts)-2; $i++){
                    $firstName .= ucfirst($parts[$i]);
                    if ($i< count($parts)-2)
                        $firstName .= ' ';
                }
            }
            $namePartsArray[0] = $firstName;
            $namePartsArray[1] = $lastName;
            return $namePartsArray;
        }
    }

    public static function formatStringForFormInputs($stringToFormat){
        $returnString = '';

        $returnString = stripslashes($stringToFormat);

        return $returnString;
    }

    public static function sanitizeString( $stringToSanitize, $isEmail = false ){
        $safeString = '';
        
        if( $stringToSanitize !== null && $stringToSanitize !== '' ){
            if( $isEmail == false ){
                $safeString = trim( $stringToSanitize );
                //$safeString = htmlentities( $stringToSanitize, ENT_QUOTES, 'UTF-8' );
                //$safeString = filter_var( $stringToSanitize, FILTER_SANITIZE_STRING );
                $safeString = filter_var( $stringToSanitize, FILTER_SANITIZE_ADD_SLASHES );
                //$safeString = filter_var( $stringToSanitize, FILTER_SANITIZE_SPECIAL_CHARS );
            } else {
                $safeString = filter_var( $stringToSanitize, FILTER_SANITIZE_EMAIL );
            }
        }

        return $safeString;
    }

    public static function sanitizeInt( $intToSanitize ){
        $safeInt = 0;
        
        if( $intToSanitize !== null && $intToSanitize !== '' ){
            $safeInt = trim( $intToSanitize );
            $safeInt = filter_var( $intToSanitize, FILTER_SANITIZE_NUMBER_INT );
        }

        return $safeInt;
    }

    public static function formatStringForGraph($array, $display_column_name, $count_column_name){
        $formattedGraphString = '';

        if($array !== null && !empty( $array )){
            $counter = 1;
            foreach ($array as $key => $value) {
                //dd($value);
                if( $counter < count( $array ) ){
                    $formattedGraphString .= "['" . $value->$display_column_name . "'" . ", " . $value->$count_column_name . "],";
                    $counter++;
                } else
                    $formattedGraphString .= "['" . $value->$display_column_name . "'" . ", " . $value->$count_column_name . "]";
            }
        }

        return $formattedGraphString;
    }

    public static function formatStringForBarGraph($array, $display_column_name, $count_column_name){
        $formattedGraphString = '';

        if($array !== null && !empty( $array )){
            $counter = 1;
            foreach ($array as $key => $value) {
                //dd($value);
                if( $counter < count( $array ) ){
                    $formattedGraphString .= "{y: '" . $value->$display_column_name . "'" . ", a: " . $value->$count_column_name . "},";
                    $counter++;
                } else
                    $formattedGraphString .= "{y: '" . $value->$display_column_name . "'" . ", a: " . $value->$count_column_name . "}";
            }
        }

        return $formattedGraphString;
    }

    public static function formatBarGraphStringForBPAndBGMonthlyCountByYear($monthlyBPReadings, $monthlyBGReadings)
    {
        if( count($monthlyBPReadings) > 0 || count($monthlyBGReadings) > 0 )
        {
            $graph_string = "";
            
            for( $i = 1; $i <= 12; $i++ )
            {
                $bgMonthValue = $bpMonthValue = "0";
                
                //$month_name = Carbon::createFromFormat('m', $i)->format('F');
                $month_name = DateTime::createFromFormat('!m', $i)->format('F');
                //echo $i . " -- " . $month_name . " -- ";
                if( !empty($monthlyBPReadings) )
                {
                    
                    foreach ($monthlyBPReadings as $key => $value) {
                        if( $i === $value->month_no ){
                            $bpMonthValue = $value->month_total;
                            break;
                        }
                        else
                            $bpMonthValue = 0;
                    }
                }

                if( !empty($monthlyBGReadings)){
                    foreach ($monthlyBGReadings as $key => $bgValue) {
                        if( $i === $bgValue->month_no ){
                            $bgMonthValue = $bgValue->month_total;
                            break;
                        }
                        else
                            $bgMonthValue = 0;
                    }
                } 

                $graph_string .= "{ y: '".$month_name."', a: ".$bpMonthValue.", b: ".$bgMonthValue." },";
            }

            return $graph_string;
        }
    }

    public static function formatBarGraphStringForAvgBPMonthlyReadingByYear($monthlyBPReadings)
    {
        if( count($monthlyBPReadings) > 0 )
        {
            $graph_string = "";
            
            foreach( $monthlyBPReadings as $key => $item )
            {
                $avgSystolicValue = $avgDiastolicValue = "0";
                
                //$month_name = Carbon::createFromFormat('m', $i)->format('F');
                $month_name = DateTime::createFromFormat('!m', $item->month_no)->format('F');
                //echo $i . " -- " . $month_name . " -- ";
                // if( !empty($monthlyBPReadings) )
                // {
                    
                //     foreach ($monthlyBPReadings as $key => $value) {
                //         if( $i === $value->month_no ){
                //             $bpMonthValue = $value->month_total;
                //             break;
                //         }
                //         else
                //             $bpMonthValue = 0;
                //     }
                // }
                $avgSystolicValue = ($item->average_systolic == '0.000') ? '0' : number_format($item->average_systolic, 0);
                $avgDiastolicValue = ($item->average_diastolic == '0.000') ? '0' : number_format($item->average_diastolic, 0);

                $graph_string .= "{ y: '".$month_name."', a: ".$avgSystolicValue.", b: ".$avgDiastolicValue." },";
            }

            return $graph_string;
        }
    }

    public static function formatDataForLineGraphByMonthName($arrayData)
    {
        if( count($arrayData ) > 0 ){
            $monthNameString = $systolicPointsString = $diastolicPointsString = "";
            
            for( $i = 1; $i <= 12; $i++ )
            {
                $systolicValue = $diastolicValue = "0";
                
                //$month_name = Carbon::createFromFormat('m', $i)->format('F');
                $month_name = DateTime::createFromFormat('!m', $i)->format('F');
                //echo $i . " -- " . $month_name . " -- ";
                if( !empty($arrayData) )
                {
                    foreach ($arrayData as $key => $value) {
                        if( $i === $value->month ){
                            $systolicValue = number_format($value->average_systolic, 2);
                            $diastolicValue = number_format($value->average_diastolic, 2);
                            break;
                        }
                        else
                        {
                            $systolicValue = 0;
                            $diastolicValue = 0;
                        }
                    }

                    if( $i == 12 )
                    {
                        $monthNameString .= "'$month_name'";
                        $systolicPointsString .= $systolicValue.",";
                        $diastolicPointsString .= $diastolicValue.",";
                    } else 
                    {
                        $monthNameString .= "'$month_name',";
                        $systolicPointsString .= $systolicValue.",";
                        $diastolicPointsString .= $diastolicValue.",";
                    }
                }
            }

            return array(
                'month_names' => $monthNameString,
                'systolic_values' => $systolicPointsString,
                'diastolic_values' => $diastolicPointsString
            );
        }
    }

    public static function formatDataForLineGraphByDate($arrayData, $startDate, $endDate)
    {
        //if( !empty($arrayData) ){
            $dateString = $systolicPointsString = $diastolicPointsString = $systolicFillPointColours = $diastolicFillPointColours = "";

            $i = 0;
            $arrayCount = count($arrayData);
            for( $currentDate = $startDate; $currentDate <= $endDate;)
            {
                $day = date('Y-m-d', strtotime($currentDate));
                //echo date('Y-m-d', strtotime($value->time)) . '--' . $key .' -- ,';
                if($i < $arrayCount){
                    if( $currentDate === date('Y-m-d', strtotime($arrayData[$i]->time))){

                        if( $arrayData[$i]->systolic > 140 || $arrayData[$i]->systolic < 100 )
                        {
                            //echo 'sys is > 140 or < 100 <br/>';
                            $systolicFillPointColours .= "'#e55353',";
                        } else {
                            //echo 'sys is good <br/>';
                            $systolicFillPointColours .= "'#39f',";
                        }
    
                        if( $arrayData[$i]->diastolic > 90 || $arrayData[$i]->diastolic < 60 )
                        {
                            //echo 'dias is > 90 or < 60 <br/>';
                            $diastolicFillPointColours .= "'#e55353',";
                        } else {
                            //echo 'dias is good <br/>';
                            $diastolicFillPointColours .= "'#2eb85c',";
                        }
    
                        if( $currentDate == $endDate )
                        {
                            $dateString .= "'$day'";
                            $systolicPointsString .= $arrayData[$i]->systolic.",";
                            $diastolicPointsString .= $arrayData[$i]->diastolic.",";
                        } else 
                        {
                            $dateString .= "'$day',";
                            $systolicPointsString .= $arrayData[$i]->systolic.",";
                            $diastolicPointsString .= $arrayData[$i]->diastolic.",";
                        }
                        //break;
                        if( $i < $arrayCount )
                            $i++;
                        else
                            break;
                    }
                    else
                    {
                        $systolicFillPointColours .= "'#e55353',";
                        $diastolicFillPointColours .= "'#e55353',";
    
                        if( $currentDate == $endDate )
                        {
                            $dateString .= "'$day'";
                            $systolicPointsString .= ",";
                            $diastolicPointsString .= ",";
                        } else
                        {
                            $dateString .= "'$day',";
                            $systolicPointsString .= ",";
                            $diastolicPointsString .= ",";
                        }
                    }
                } else{
                    $systolicFillPointColours .= "'#e55353',";
                        $diastolicFillPointColours .= "'#e55353',";
    
                        if( $currentDate == $endDate )
                        {
                            $dateString .= "'$day'";
                            $systolicPointsString .= ",";
                            $diastolicPointsString .= ",";
                        } else
                        {
                            $dateString .= "'$day',";
                            $systolicPointsString .= ",";
                            $diastolicPointsString .= ",";
                        }
                }
                
                $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
            }
            //exit;
// echo $dateString ."<br />";
// echo $systolicPointsString ."<br />";
// echo $diastolicPointsString ."<br />";
// echo $systolicFillPointColours ."<br />";
// echo $diastolicFillPointColours ."<br />";exit;
            return array(
                'days' => $dateString,
                'systolic_values' => $systolicPointsString,
                'diastolic_values' => $diastolicPointsString,
                'systolic_fill_colours' => $systolicFillPointColours,
                'diastolic_fill_colours' => $diastolicFillPointColours
            );
        //}
    }
//     public static function formatDataForLineGraphByDate($arrayData, $startDate, $endDate)
//     {
//         if( count($arrayData ) > 0 ){
//             $dateString = $systolicPointsString = $diastolicPointsString = $systolicFillPointColours = $diastolicFillPointColours = "";
            
//             // for( $currentDate = $startDate; $currentDate <= $endDate;)
//             // {
//                 //$systolicValue = $diastolicValue = "0";
//                 $currentDate = $startDate;
//                 //$day = date('Y-m-d', strtotime($currentDate));

//                 if( !empty($arrayData) )
//                 {
//                     foreach ($arrayData as $key => $value) {
//                         $day = date('Y-m-d', strtotime($currentDate));
//                         //echo date('Y-m-d', strtotime($value->time)) . '--' . $key .' -- ,';
//                         if( $currentDate === date('Y-m-d', strtotime($value->time))){
//                             echo 'has--'.$currentDate . ' --' . date('Y-m-d', strtotime($value->time)) . '--' . $key .' -- <br>';
//                             // $systolicValue = number_format($value->systolic, 0);
//                             // $diastolicValue = number_format($value->diastolic, 0);

//                             if( $value->systolic > 140 || $value->systolic < 100 )
//                             {
//                                 //echo 'sys is > 140 or < 100 <br/>';
//                                 $systolicFillPointColours .= "'#e55353',";
//                             } else {
//                                 //echo 'sys is good <br/>';
//                                 $systolicFillPointColours .= "'#39f',";
//                             }

//                             if( $value->diastolic > 90 || $value->diastolic < 60 )
//                             {
//                                 //echo 'dias is > 90 or < 60 <br/>';
//                                 $diastolicFillPointColours .= "'#e55353',";
//                             } else {
//                                 //echo 'dias is good <br/>';
//                                 $diastolicFillPointColours .= "'#2eb85c',";
//                             }

//                             if( $currentDate == $endDate )
//                             {
//                                 $dateString .= "'$day'";
//                                 $systolicPointsString .= $value->systolic.",";
//                                 $diastolicPointsString .= $value->systolic.",";
//                             } else 
//                             {
//                                 $dateString .= "'$day',";
//                                 $systolicPointsString .= $value->systolic.",";
//                                 $diastolicPointsString .= $value->diastolic.",";
//                             }
//                             //break;
//                         }
//                         else
//                         {
//                             echo 'not --' .$currentDate . ' -- ' . date('Y-m-d', strtotime($value->time)) . '--' . $key .' -- <br>';
//                             $systolicValue = 0;
//                             $diastolicValue = 0;

//                             if( $value->systolic > 140 || $value->systolic < 100 )
//                             {
//                                 //echo 'sys is > 140 or < 100 <br/>';
//                                 $systolicFillPointColours .= "'#e55353',";
//                             } else {
//                                 //echo 'sys is good <br/>';
//                                 $systolicFillPointColours .= "'#39f',";
//                             }

//                             if( $value->diastolic > 90 || $value->diastolic < 60 )
//                             {
//                                 //echo 'dias is > 90 or < 60 <br/>';
//                                 $diastolicFillPointColours .= "'#e55353',";
//                             } else {
//                                 //echo 'dias is good <br/>';
//                                 $diastolicFillPointColours .= "'#2eb85c',";
//                             }

//                             if( $currentDate == $endDate )
//                             {
//                                 $dateString .= "'$day'";
//                                 $systolicPointsString .= "0,";
//                                 $diastolicPointsString .= "0,";
//                             } else 
//                             {
//                                 $dateString .= "'$day',";
//                                 $systolicPointsString .= "0,";
//                                 $diastolicPointsString .= "0,";
//                             }
//                             //break;
//                         }

//                         // if( $value->systolic > 140 || $value->systolic < 100 )
//                         // {
//                         //     //echo 'sys is > 140 or < 100 <br/>';
//                         //     $systolicFillPointColours .= "'#e55353',";
//                         // } else {
//                         //     //echo 'sys is good <br/>';
//                         //     $systolicFillPointColours .= "'#39f',";
//                         // }

//                         // if( $value->diastolic > 90 || $value->diastolic < 60 )
//                         // {
//                         //     //echo 'dias is > 90 or < 60 <br/>';
//                         //     $diastolicFillPointColours .= "'#e55353',";
//                         // } else {
//                         //     //echo 'dias is good <br/>';
//                         //     $diastolicFillPointColours .= "'#2eb85c',";
//                         // }
//                     //     echo $value->systolic;
//                     // echo $systolicValue;exit;
//                     $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
//                     }
                    

//                     // if( $currentDate == $endDate )
//                     // {
//                     //     $dateString .= "'$day'";
//                     //     $systolicPointsString .= $value->systolic.",";
//                     //     $diastolicPointsString .= $value->systolic.",";
//                     // } else 
//                     // {
//                     //     $dateString .= "'$day',";
//                     //     $systolicPointsString .= $value->systolic.",";
//                     //     $diastolicPointsString .= $value->diastolic.",";
//                     // }
//                 }exit;
//                 //$currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
//             //}
// // echo $dateString ."<br />";
// // echo $systolicPointsString ."<br />";
// // echo $diastolicPointsString ."<br />";
// // echo $systolicFillPointColours ."<br />";
// // echo $diastolicFillPointColours ."<br />";exit;
//             return array(
//                 'days' => $dateString,
//                 'systolic_values' => $systolicPointsString,
//                 'diastolic_values' => $diastolicPointsString,
//                 'systolic_fill_colours' => $systolicFillPointColours,
//                 'diastolic_fill_colours' => $diastolicFillPointColours
//             );
//         }
//     }

    public static function formatDataForLineGraphByDate2($arrayData, $startDate, $endDate)
    {
        if( count($arrayData ) > 0 ){
            $dateString = $systolicPointsString = $diastolicPointsString = "";
            $lineGraphData = "";
            
            for( $currentDate = $startDate; $currentDate <= $endDate;)
            {
                $systolicValue = $diastolicValue = "0";
                $day = date('Y-m-d', strtotime($currentDate));

                if( !empty($arrayData) )
                {
                    foreach ($arrayData as $key => $value) {
                        if( $currentDate === date('Y-m-d', strtotime($value->time))){
                            $systolicValue = number_format($value->systolic, 2);
                            $diastolicValue = number_format($value->diastolic, 2);
                            break;
                        }
                        else
                        {
                            $systolicValue = 0;
                            $diastolicValue = 0;
                        }
                    }

                    if( $currentDate == $endDate )
                    {
                        // $dateString .= "'$day'";
                        // $systolicPointsString .= $systolicValue.",";
                        // $diastolicPointsString .= $diastolicValue.",";
                        $lineGraphData .= "{ y: '".$day."', a: $systolicValue, b: $diastolicValue }";
                    } else 
                    {
                        // $dateString .= "'$day',";
                        // $systolicPointsString .= $systolicValue.",";
                        // $diastolicPointsString .= $diastolicValue.",";
                        $lineGraphData .= "{ y: '".$day."', a: $systolicValue, b: $diastolicValue },";
                    }
                }
                $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
            }

            return array(
                // 'days' => $dateString,
                // 'systolic_values' => $systolicPointsString,
                // 'diastolic_values' => $diastolicPointsString
                $lineGraphData
            );
        }
    }
}
