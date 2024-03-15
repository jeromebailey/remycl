<?php

namespace App\Http\Controllers;

use App\Models\Bpreading;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use function PHPSTORM_META\type;

class BpreadingsController extends Controller
{
    //
    public function insertRandomReadings($patientId, $year, $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $systolic = rand(80, 180);
            $diastolic = rand(40, 120);

            $systolicStatusId = $this->determineStatusId($systolic, 'systolic');
            $diastolicStatusId = $this->determineStatusId($diastolic, 'diastolic');

            Bpreading::create([
                '_uid' => Str::uuid(),
                'patient_id' => $patientId,
                'device_id' => $this->generateImei(),
                'time' => $date->toDateTimeString(),
                'systolic' => $systolic,
                'diastolic' => $diastolic,
                'pulse' => rand(60, 100),
                'arrhythmia' => rand(0, 1),
                'systolic_status_id' => $systolicStatusId,
                'diastolic_status_id' => $diastolicStatusId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        echo "done";
    }

    private function determineStatusId($value, $type)
    {
        $status_id = 0;
        if( $type == 'systolic' )
        {
            switch($value)
            {
                case ($value <= 90):
                    $status_id = 1;
                    break;

                case ($value >= 90 && $value <= 100):
                    $status_id = 2;
                    break;

                case ($value >= 100 && $value <= 140):
                    $status_id = 3;
                    break;

                case ($value >= 140 && $value <= 160):
                    $status_id = 4;
                    break;

                case ($value >= 170):
                    $status_id = 5;
                    break;
            }
        } else if ($type == 'diastolic')
        {
            switch($value)
            {
                case ($value <= 50):
                    $status_id = 1;
                    break;

                case ($value >= 50 && $value <= 60):
                    $status_id = 2;
                    break;

                case ($value >= 60 && $value <= 90):
                    $status_id = 3;
                    break;

                case ($value >= 90 && $value <= 160):
                    $status_id = 4;
                    break;

                case ($value >= 170):
                    $status_id = 5;
                    break;
            }
        }
        return $status_id;
    }

    private function generateImei() {
        $imei = '';
        for ($i = 0; $i < 14; $i++) {
            $imei .= rand(0, 9);
        }
    
        return $imei . $this->calculateLuhnDigit($imei);
    }
    
    private function calculateLuhnDigit($number) {
        $sum = 0;
        $length = strlen($number);
        for ($i = $length - 1; $i >= 0; $i--) {
            $digit = substr($number, $i, 1);
            if ($i % 2 == $length % 2) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }
    
        return (10 - $sum % 10) % 10;
    }
}
