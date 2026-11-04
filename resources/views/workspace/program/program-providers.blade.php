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
                     <input type="hidden" name="person_program_id"  value="">
                     <div class="card-body table-responsive p-0">
                         <table class="table table-hover text-nowrap">
                             <thead class="table-matla">
                                 <tr>
                                     <th>{{ __('Name') }}</th>
                                     <th>{{ __('The Email') }}</th>
                                     <th>{{ __('The Role') }}</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($presenters as $presenter)
                                     <tr>
                                         <td>
                                             <div class="d-flex align-items-center">
                                                 <img alt="{{ $presenter->name }}"
                                                     class="table-avatar rounded-circle mr-2"
                                                     src="{{ asset('public/img/da7ed7b0-5f66-4f97-a610-51100d3b9fd2.jpg') }}"
                                                     width="40" height="40">
                                                 <span>{{ $presenter->name }}</span>
                                             </div>
                                         </td>
                                         <td>{{ $presenter->email }}</td>
                                         <td>{{ $presenter->role->name }}</td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </form>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
