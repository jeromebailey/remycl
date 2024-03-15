<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPRN extends Model
{
    use HasFactory;

    protected $table = 'patientprns';
    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'prn',
    ];

    public static function generatePRNCode(){
        
        $prn = random_int(100000, 999999);
        
        //check if string exist in db
        while(PatientPRN::prnCodeExist($prn) ){
            $prn = random_int(100000, 999999);
        }

        return $prn;
    }

    public static function prnCodeExist( $code ){
        
        if( $code != null ){
            $prnCodes = PatientPRN::all()->pluck('prn');

            foreach ($prnCodes as $key => $value) {
                $sections = explode('-', $value);
                if( !empty( $sections )){
                    $codeForUser = $sections[1];

                    if( $codeForUser == $code )
                        return true;
                    else
                        continue;
                }
                return false;
            }
        }
    }

    public static function getUserCodeFromPRNCode( $code ){
        
        if( $code != null ){
            //$prnCodes = Applications::all()->pluck('prn');

            //foreach ($prnCodes as $key => $value) {
                $sections = explode('-', $code);
                if( !empty( $sections )){
                    $codeForUser = $sections[1];

                    return $codeForUser;
                }
                return null;
            //}
        }
    }

    public static function getFullPRNCode( $code ){
        
        if( $code != null ){
            $prnCodes = PatientPRN::all()->pluck('prn');

            foreach ($prnCodes as $key => $value) {
                $sections = explode('-', $value);
                if( !empty( $sections )){
                    $codeForUser = $sections[1];

                    if( $codeForUser == $code )
                        return $value;
                    else
                        continue;
                }
                return null;
            }
        }
    }
}
