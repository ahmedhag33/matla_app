 <div id="reminder-part" class="content" role="tabpanel" aria-labelledby="reminder-part-trigger">

     <div class="form-group">
         <label>{{ __('Reminder for Episode') }}</label>
     </div>
     <div class="form-group">
         <div class="row align-items-center">

             <div class="col-md-6 mb-3">
                 <div class="custom-control custom-checkbox">
                     <input type="checkbox" class="custom-control-input reminder-checkbox" id="reminder">

                     <label class="custom-control-label" for="reminder">
                         {{ __('Set a Reminder') }}
                     </label>
                 </div>
             </div>

             <div class="col-md-6 mb-3" style="display: none;" id="reminder-time-container">

                 <label for="reminder_count">
                     {{ __('Reminder Before') }}
                 </label>

                 <div class="input-group">
                     <input type="number" class="form-control" id="reminder_count" name="reminder_count"
                         min="1">

                     <div class="input-group-append">
                         <span class="input-group-text">
                             {{ __('Days') }}
                         </span>
                     </div>
                 </div>

             </div>

         </div>
     </div>
     <button type="button" class="btn btn-matla btn-previous-step" onclick="stepper.previous()">
         {{ __('Previous') }}
     </button>

     <button type="submit" class="btn btn-matla">
         {{ __('Save') }}
     </button>

 </div>
