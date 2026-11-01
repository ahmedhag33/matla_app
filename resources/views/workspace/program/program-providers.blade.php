 <div id="program-providers-part" class="content" role="tabpanel" aria-labelledby="program-providers-part-trigger">

     <div class="row">
         <div class="col-md-6">
             <div class="form-group">
                 <label>{{ __('Select Presenters') }}
                     <span class="text-muted">*</span>
                 </label>

                 <select class="select-presenters" multiple="multiple" data-placeholder="{{ __('Select Presenters') }}"
                     style="width: 100%;" name="presenters[]">

                     @foreach ($presenters as $presenter)
                         <option value="{{ $presenter->id }}">
                             {{ $presenter->name }}
                         </option>
                     @endforeach
                 </select>
                 <span class="text-danger" data-error="presenters"></span>
             </div>
         </div>
     </div>

     <a class="btn btn-matla" onclick="stepper.previous()">
         {{ __('Previous') }}
     </a>

     <a class="btn btn-matla btn-next-step" data-step="2">
         {{ __('Next') }}
     </a>

 </div>
