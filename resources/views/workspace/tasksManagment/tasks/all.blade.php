   <section class="content">
       <div class="container-fluid">
           <div class="row">
               <div class="col-12">
                   <div class="card">
                       <div class="card-header">
                           <h3 class="card-title">
                               <button type="button" class="btn btn-matla" data-toggle="modal"
                                   data-target="#add-task">
                                   <i class="fas fa-plus"></i>
                                   {{ __('Add Task') }}
                               </button>
                           </h3>
                       </div>
                       <div class="card-body">
                           <section class="content">
                               <div class="error-page">

                                   <div class="error-content">
                                       <h3> <i class="fas fa-tasks"></i>
                                           {{ __('No Tasks Found') }}</h3>
                                       <p>{{ __('Start by adding the first task.') }}</p>
                                   </div>
                                   <!-- /.error-content -->
                               </div>
                               <!-- /.error-page -->
                           </section>
                       </div>
                       <!-- /.card-body -->
                   </div>
                   <!-- /.card -->
               </div>
           </div>
       </div>
   </section>
