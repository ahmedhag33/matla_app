 <div class="modal fade" id="add-program">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header-matla">
                 <img src="{{ asset('public/img/tv-solid-full.svg') }}" alt="Program Management" style="width: 30px;">
                 <h4 class="modal-title">{{ __('Add New Program') }}</h4>
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
                                 <button type="button" class="step-trigger" role="tab"
                                     aria-controls="basic-information-part" id="basic-information-part-trigger">
                                     <span class="bs-stepper-circle-matla">1</span>
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
                             <div class="line"></div>
                             <div class="step" data-target="#duration-and-broadcast-part">
                                 <button type="button" class="step-trigger" role="tab"
                                     aria-controls="duration-and-broadcast-part"
                                     id="duration-and-broadcast-part-trigger">
                                     <span class="bs-stepper-circle-matla">3</span>
                                     <span class="bs-stepper-label">{{ __('Duration and Broadcast') }}</span>
                                 </button>
                             </div>
                             <div class="line"></div>
                             <div class="step" data-target="#additional-settings-part">
                                 <button type="button" class="step-trigger" role="tab"
                                     aria-controls="additional-settings-part" id="additional-settings-part-trigger">
                                     <span class="bs-stepper-circle-matla">4</span>
                                     <span class="bs-stepper-label">{{ __('Additional Settings') }}</span>
                                 </button>
                             </div>
                         </div>
                         <form id="add-program-form">
                             @csrf
                             <div class="bs-stepper-content">
                                 <!-- your steps content here -->
                                 <div id="basic-information-part" class="content" role="tabpanel"
                                     aria-labelledby="basic-information-part-trigger">
                                     <div class="form-group">
                                         <label for="basic-information">{{ __('Basic Information') }}</label>
                                     </div>
                                     <a class="btn btn-matla" onclick="stepper.next()">{{ __('Next') }}</a>
                                 </div>
                                 <div id="program-providers-part" class="content" role="tabpanel"
                                     aria-labelledby="program-providers-part-trigger">
                                     <div class="form-group">
                                         <label for="program-providers">{{ __('Program Providers') }}</label>
                                     </div>
                                     <a class="btn btn-matla"
                                         onclick="stepper.previous()">{{ __('Previous') }}</a>
                                     <a class="btn btn-matla"
                                         onclick="stepper.next()">{{ __('Next') }}</a>
                                 </div>
                                 <div id="duration-and-broadcast-part" class="content" role="tabpanel"
                                     aria-labelledby="duration-and-broadcast-part-trigger">
                                     <div class="form-group">
                                         <label for="duration-and-broadcast">{{ __('Duration and Broadcast') }}</label>
                                     </div>
                                     <a class="btn btn-matla"
                                         onclick="stepper.previous()">{{ __('Previous') }}</a>
                                     <a class="btn btn-matla"
                                         onclick="stepper.next()">{{ __('Next') }}</a>
                                 </div>
                                 <div id="additional-settings-part" class="content" role="tabpanel"
                                     aria-labelledby="additional-settings-part-trigger">
                                     <div class="form-group">
                                         <label for="additional-settings">{{ __('Additional Settings') }}</label>
                                     </div>
                                     <a class="btn btn-matla"
                                         onclick="stepper.previous()">{{ __('Previous') }}</a>
                                     <button class="btn btn-matla btn-save">{{ __('Save') }}</button>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
