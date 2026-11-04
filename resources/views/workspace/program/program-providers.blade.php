 <div class="modal fade" id="add-program-providers">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header-matla">
                 <img src="{{ asset('public/img/user-group-solid-full.svg') }}" alt="Program Management"
                     style="width: 30px;">

                 <h4 class="modal-title">{{ __('Add Presenters') }}</h4>

                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form id="add-program-providers-form">
                     @csrf
                     <input type="hidden" name="person_program_id" value="">
                     <div class="form-group">
                         <select id="presenters" name="presenters[]" class="form-control select2" multiple>
                             @foreach ($presenters as $presenter)
                                 <option value="{{ $presenter->id }}"
                                     data-image="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}">
                                     {{ $presenter->name }}
                                 </option>
                             @endforeach
                         </select>
                     </div>
                     <span class="text-danger" data-error="presenters"></span>
                     <div class="row">
                         <div class="col-12">
                             <button type="submit" class="btn btn-matla save-program-providers">{{ __('Save') }}</button>
                         </div>
                         <!-- /.col -->
                     </div>
                 </form>
                 <div id="add-program-providers-loading" class="spinner-grow text-dark" role="status"
                     style="display: none;">
                     <span class="sr-only">Loading...</span>
                 </div>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
