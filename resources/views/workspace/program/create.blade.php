 <div class="modal fade" id="add-program">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">{{ __('Add Program') }}</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="card-body p-0">
                     <div class="bs-stepper">
                         <div class="bs-stepper-header" role="tablist">
                             <!-- your steps here -->
                             <div class="step" data-target="#basic-information-part">
                                 <button type="button" class="step-trigger" role="tab" aria-controls="basic-information-part"
                                     id="basic-information-part-trigger">
                                     <span class="bs-stepper-circle-matla">2</span>
                                     <span class="bs-stepper-label">{{ __('Basic Information') }}</span>
                                 </button>
                             </div>
                             <div class="line"></div>
                             <div class="step" data-target="#program-providers-part">
                                 <button type="button" class="step-trigger" role="tab"
                                     aria-controls="program-providers-part" id="program-providers-part-trigger">
                                     <span class="bs-stepper-circle-matla">2</span>
                                     <span class="bs-stepper-label">{{ __('Program Providers') }}</span>
                                 </button>
                             </div>
                         </div>
                         <div class="bs-stepper-content">
                             <!-- your steps content here -->
                             <div id="basic-information-part" class="content" role="tabpanel"
                                 aria-labelledby="basic-information-part-trigger">
                                 <div class="form-group">
                                     <label for="basic-information">{{ __('Basic Information') }}</label>
                                 </div>
                                 <button class="btn btn-matla" onclick="stepper.next()">{{ __('Next') }}</button>
                             </div>
                             <div id="program-providers-part" class="content" role="tabpanel"
                                 aria-labelledby="program-providers-part-trigger">
                                 <div class="form-group">
                                     <label for="program-providers">{{ __('Program Providers') }}</label>
                                 </div>
                                 <button class="btn btn-matla" onclick="stepper.previous()">{{ __('Previous') }}</button>
                                 <button type="submit" class="btn btn-matla">{{ __('Save') }}</button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
