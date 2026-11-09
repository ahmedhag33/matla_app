 <div id="date-time-part" class="content" role="tabpanel" aria-labelledby="date-time-part-trigger">

     <div class="form-group">
         <label>{{ __('Date and Duration') }}</label>
     </div>
     <div class="form-group">
         <label>{{ __('Episode Date') }}
            <span class="text-muted">* {{ __('Available Days:') }} {{ $programDaysTostring ?? '' }}</span>
         </label>
         <div class="input-group date" id="reservationdate" data-target-input="nearest">

             <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" />

             <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">

                 <div class="input-group-text">
                     <i class="fa fa-calendar"></i>
                 </div>

             </div>
         </div>
     </div>
     <button type="button" class="btn btn-matla btn-next-step" onclick="stepper.next()">
         {{ __('Next') }}
     </button>
     <button type="button" class="btn btn-matla btn-previous-step" onclick="stepper.previous()">
         {{ __('Previous') }}
     </button>
 </div>
