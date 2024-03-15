<div class="modal fade modal-xl" id="onboard-patient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Onboard Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="patient-information-tab" data-toggle="tab" href="#patient-information" role="tab" aria-controls="patient-information" aria-selected="true">Patient Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Address Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="medical-tab" data-toggle="tab" href="#medical" role="tab" aria-controls="medical" aria-selected="false">Medical Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="objective-tab" data-toggle="tab" href="#objective" role="tab" aria-controls="objective" aria-selected="false">Objective</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="patient-information" role="tabpanel" aria-labelledby="patient-information-tab">
                            @include('patients.onboarding.patient-information')
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">Content for Tab 2</div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Content for Tab 3</div>
                        <div class="tab-pane fade" id="medical" role="tabpanel" aria-labelledby="medical-tab">Content for Tab 3</div>
                        <div class="tab-pane fade" id="objective" role="tabpanel" aria-labelledby="objective-tab">
                            @include('patients.onboarding.objectives')
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>