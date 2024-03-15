<?php
use App\Models\Genders;
use App\Models\Maritalstatus;
?>

<form method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row mt-3">
                <label for="staticEmail" class="col-md-3 col-form-label">Overall Objective</label>
                <div class="col-md-12">
                    <textarea cols="3" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row mt-3">
                <label for="staticEmail" class="col-md-4 col-form-label">Objective Timeframe</label>
                <div class="col-md-2">
                    <select class="form-control" >
                        <option value="6">6</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" >
                            <option value="">Months</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" readonly disabled class="form-control" id="staticEmail" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group row mt-3">
                <label for="staticEmail" class="col-md-3 col-form-label">Description</label>
                <div class="col-md-12">
                    <textarea cols="3" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group row mt-3">
                <label for="staticEmail" class="col-md-3 col-form-label">Medical History Summary</label>
                <div class="col-md-12">
                    <textarea cols="3" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
</form>


