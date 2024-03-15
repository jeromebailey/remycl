<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    public static function getAllPatients($active=1)
    {
        return DB::select("select u._uid '_patientID', u.first_name, u.last_name, u.email
        from users u
        inner join roles_users ru on ru.`user_id` = u.`id`
        inner join roles r on r.`id` = ru.`role_id`
        where r.`slug` = 'patient'
        and u.active = ?", [$active]);
    }

    public static function getAllPatientsByPhysicianId($id)
    {
        return DB::select("select u._uid '_patientID', u.first_name, u.last_name, u.email
        from users u
        inner join roles_users ru on ru.`user_id` = u.`id`
        inner join roles r on r.`id` = ru.`role_id`
        where r.`slug` = 'patient'
        and u.id in (select patient_id from physicians_patients where physician_id = ?)", [$id]);

        // return DB::select('select u._uid, u.first_name, u.last_name, u.email
        // from users u
        // inner join physicians_patients pp on pp.patient_id = u.id
        // where pp.physician_id = ?', [$id]);
    }

    public static function getPhysiciansPatientsDDL($id)
    {
        return DB::select("select u._uid '_patientID', u.first_name, u.last_name
        from users u
        inner join roles_users ru on ru.`user_id` = u.`id`
        inner join roles r on r.`id` = ru.`role_id`
        where r.`slug` = 'patient'
        and u.id in (select patient_id from physicians_patients where physician_id = ?)", [$id]);
    }

    public static function getAllPatientsDDL()
    {
        return DB::select("select u._uid '_patientID', u.first_name, u.last_name
        from users u
        inner join roles_users ru on ru.`user_id` = u.`id`
        inner join roles r on r.`id` = ru.`role_id`
        where r.`slug` = 'patient'");
    }

    public static function getPatientInformation($id)
    {
        return DB::select("select u._uid, u.first_name, u.last_name, u.email, pd.dob, g.gender, pd.gender_id, pci.primary_phone_no, pci.secondary_phone_no, prs.rpm_service_id, service_duration_id,
        rs.rpm_service, sd.duration, pp.prn
        from users u
        inner join personaldetails pd on pd.user_id = u.id
        inner join genders g on g.id = pd.gender_id
        inner join contactinformation pci on pci.patient_id = u.id
        inner join patient_rpm_services prs on prs.patient_id = u.id
        inner join rpm_services rs on rs.id = prs.rpm_service_id
        inner join service_durations sd on sd.id = prs.service_duration_id
        inner join patientprns pp on pp.patient_id = u.id
        where u.id = ?", [$id]);
    }

    public static function getDeviceAssignedToPatient($id)
    {
        return DB::select("select dt.device_type_name , ad.device_unique_id
        from devicetypes dt
        inner join devices d on d.device_type_id = dt.id
        inner join assigneddevices ad on ad.device_unique_id = d.imei
        where ad.patient_user_id = ?", [$id]);
    }

    public static function getPatientCaregivers($id)
    {
        return DB::select("select u._uid, u.first_name, u.last_name, u.email, pd.dob, g.gender, c.is_primary_caregiver, c.is_next_of_kin
        FROM users u 
            INNER JOIN personaldetails pd ON pd.user_id = u.id
            inner join genders g on g.id = pd.gender_id
            inner join caregivers c on c.user_id = u.id
            inner join patient_caregivers pc on pc.caregiver_id = u.id
        WHERE pc.caregiver_id in (select caregiver_id from patient_caregivers where patient_id = ?)
        ORDER BY u.created_at desc;", [$id]);
    }

    public static function countSystolicBPReadingsByStatusForPatient($id, $statusId, $year)
    {
        return DB::select("select count(*) amount
        from bpreadings b
        WHERE (b.systolic_status_id = ? OR b.diastolic_status_id = ?)
        and b.patient_id = ?
        and year(time) = ?", [$statusId, $statusId, $id, $year]);
    }

    public static function getAllPatientsToBeOnboarded($limit)
    {
        $limitStr = ($limit !== null) ? " limit $limit" : "";

        return DB::select("SELECT u._uid, u.first_name, u.last_name, u.created_at, pd.dob, s.rpm_service, o.onboarded, g.gender
        FROM users u 
            INNER JOIN personaldetails pd ON pd.user_id = u.id
            INNER JOIN patient_rpm_services ps ON ps.patient_id = u.id
            INNER JOIN rpm_services s ON s.id = ps.rpm_service_id
            inner join onboardeds o on o.patient_id = u.id
            inner join genders g on g.id = pd.gender_id
        WHERE o.onboarded = 0
        ORDER BY u.created_at desc
        $limitStr;");
    }

    public static function calculateLOCForAPatient($patientId, $statusId, $startDate, $endDate) //calculate the level of control
    {
        $readingsWithinRange = $patientsTotalReading = 0;
        $levelOfControlStatus = '';
        try{
            $readingsWithinRangeResult = Bpreading::getNoOfBPReadingsByStatusIdForAPatient($patientId, 3, $startDate, $endDate);
            $readingsWithinRange = $readingsWithinRangeResult[0]->readings_within_range;
        } catch(Exception $e)
        {

        }

        try{
            $patientsTotalReadingResult = Bpreading::getTotalNoOfBPReadingsForAPatient($patientId, $startDate, $endDate);
            $patientsTotalReading = $patientsTotalReadingResult[0]->total_readings;
        } catch(Exception $e)
        {
            
        }
        
        $levelOfControlValue = number_format($readingsWithinRange/$patientsTotalReading * 100);

        if( $levelOfControlValue < 50 )
            $levelOfControlStatus = 'Uncontrolled';
        else if( $levelOfControlValue >= 50 && $levelOfControlValue <= 70 )
            $levelOfControlStatus = 'Partially Controlled';
        else
            $levelOfControlStatus = 'Well Controlled';

        return array(
            'levelOfControlValue' => $levelOfControlValue,
            'levelOfControlStatus' => $levelOfControlStatus
        );
    }

    public static function calculatePatienceAdherenceRate($patientId, $startDate, $endDate)
    {
        $adherenceRate = "";
        $noOfDaysForTransmittedReadings = Bpreading::getNoOfDaysDataWasTransmittedForAPatientByDateRange($patientId, $startDate, $endDate);
        $noOfDaysForTransmittedReadings = $noOfDaysForTransmittedReadings[0]->no_of_days;
//dd($noOfDaysForTransmittedReadings);
        if($noOfDaysForTransmittedReadings >= 16)
            $adherenceRate = "Adherent";
        else if( $noOfDaysForTransmittedReadings > 12 && $noOfDaysForTransmittedReadings <= 15 )
            $adherenceRate = "Partially Adherent";
        else if( $noOfDaysForTransmittedReadings > 8 and $noOfDaysForTransmittedReadings <= 12 )
            $adherenceRate = "Low Adherence";
        else if( $noOfDaysForTransmittedReadings <= 8 )
            $adherenceRate = "Non-adherent";

        return $adherenceRate;
    }

    public static function getBPDataYearsDDL($patientId)
    {
        return DB::select("select distinct(year(b.time)) year
        from bpreadings b
        where patient_id = ?;", [$patientId]);
    }
}
