<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IntlCalendar;

class DateHelper extends Model
{
    use HasFactory;
    static $fullDateLength = 10;
    //protected static $year = date("Y");

    public static function getStartDateOfCurrentWeek(){
        //$weekNo = date('W');
        $dateObj = new DateTime();

        return $dateObj->setISODate(date("Y"), date('W'))->format('Y-m-d');
    }

    public static function getEndDateOfCurrentWeek(){
        //$weekNo = date('W');
        $dateObj = new DateTime();
        $dateObj->setISODate(date("Y"), date('W'));

        return $dateObj->modify('+6 days')->format('Y-m-d');
    }

    public static function formatDateForDBStore($date){
        if( $date != null )
            return trim(\Carbon\Carbon::parse(preg_replace('/\//','-',$date))->format('Y-m-d'));
        return null;
    }

    public static function formatDateForFormInput( $date ){
        if($date != null)
            return Carbon::createFromFormat('Y-m-d', $date);
        return null;
    }

    public static function isProperDate($date, $separator = '-'){
        $isProperDate = true;

        if( $date === null || $date === '')
            $isProperDate = false;
        else {
            if( strlen($date) < DateHelper::$fullDateLength )
                $isProperDate = false;

            if(substr_count($date, $separator) < 2)
                $isProperDate = false;
        }

        return $isProperDate;
    }

    public static function getDaysInAMonth($month, $year){
        $days_array = null;

        if( $month != null ){
            //$no_of_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
            $no_of_days = Carbon::now()->month($month)->daysInMonth;

            for( $i = 1; $i <= $no_of_days; $i++ ){
                if( $i < 10 )
                    $day = '0' . $i;
                else
                    $day = $i;

                $days_array[$i] = $day;
            }

            return $days_array;
        }
    }

    public static function getMonthsOfTheYearList(){
        $months_of_the_year = null;

        for( $i = 1; $i <= 12; $i++ ){
            $dateObj   = DateTime::createFromFormat('!m', $i);
            $month_name = $dateObj->format('F');

            $months_of_the_year[$i] = $month_name;
        }

        return $months_of_the_year;
    }
}
