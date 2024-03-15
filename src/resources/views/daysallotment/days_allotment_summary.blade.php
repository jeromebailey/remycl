<?php
use App\Models\Leaverequest;
use Illuminate\Support\Facades\Auth;

$vacationDays = Leaverequest::getDaysAllotmentForUserByLeavetypeIdAndYear(Auth::user()->id, 1, now()->year);
$usedVacationDays = Leaverequest::getTotalUsedDaysForUserByLeavetypeIdAndYear(Auth::user()->id, 1, now()->year);

$sickDays = Leaverequest::getDaysAllotmentForUserByLeavetypeIdAndYear(Auth::user()->id, 2, now()->year);
$usedSickDays = Leaverequest::getTotalUsedDaysForUserByLeavetypeIdAndYear(Auth::user()->id, 2, now()->year);

$vacation_days = (is_float($vacationDays[0]->amount) ? $vacationDays[0]->amount : intval($vacationDays[0]->amount));
$vacation_days_bf = (is_float($vacationDays[0]->brought_forward) ? $vacationDays[0]->brought_forward : intval($vacationDays[0]->brought_forward));
$vacation_days_used = (is_float($usedVacationDays[0]->used) ? $usedVacationDays[0]->used : intval($usedVacationDays[0]->used));
$vacation_days_balance = (is_float($vacationDays[0]->total - $usedVacationDays[0]->used) ? $vacationDays[0]->total - $usedVacationDays[0]->used : intval($vacationDays[0]->total - $usedVacationDays[0]->used));
$sick_days = (is_float($sickDays[0]->amount) ? $sickDays[0]->amount : intval($sickDays[0]->amount));
$sick_days_used = (is_float($usedSickDays[0]->used) ? $usedSickDays[0]->used : intval($usedSickDays[0]->used));
$sick_days_balance = (is_float($sickDays[0]->total - $usedSickDays[0]->used) ? $sickDays[0]->total - $usedSickDays[0]->used : intval($sickDays[0]->total - $usedSickDays[0]->used));
?>

<div class="row text-center">
    <div class="col-md-4 offset-md-2">
        <div class="card mb-4">
            <div class="card-header">Vacation</div>
            <div class="card-body row text-center">
                <div class="col">
                    <div class="fs-5 fw-semibold"><?php echo $vacation_days?></div>
                    <div class="text-uppercase text-medium-emphasis small">Annual</div>
                </div>
                <div class="vr"></div>
                <div class="col">
                    <div class="fs-5 fw-semibold"><?php echo $vacation_days_bf?></div>
                    <div class="text-uppercase text-medium-emphasis small">B/F</div>
                </div>
                <div class="vr"></div>
                <div class="col">
                    <div class="fs-5 fw-semibold"><?php echo $vacation_days_used?></div>
                    <div class="text-uppercase text-medium-emphasis small">Used</div>
                </div>
                <div class="vr"></div>
                <div class="col">
                    <div class="fs-5 fw-semibold"><?php echo $vacation_days_balance?></div>
                    <div class="text-uppercase text-medium-emphasis small">Balance</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
        <div class="card-header">Sick</div>
        <div class="card-body row text-center">
                <div class="col">
                    <div class="fs-5 fw-semibold"><?php echo $sick_days?></div>
                    <div class="text-uppercase text-medium-emphasis small">Annual</div>
                </div>
                <div class="vr"></div>
                <div class="col">
                    <div class="fs-5 fw-semibold"><?php echo $sick_days_used?></div>
                    <div class="text-uppercase text-medium-emphasis small">Used</div>
                </div>
                <div class="vr"></div>
                <div class="col">
                    <div class="fs-5 fw-semibold"><?php echo $sick_days_balance?></div>
                    <div class="text-uppercase text-medium-emphasis small">Balance</div>
                </div>
            </div>
        </div>
    </div>
</div>
