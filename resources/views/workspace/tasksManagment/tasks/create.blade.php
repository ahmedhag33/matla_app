<div class="modal fade" id="add-task">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header-matla">
                <h4 class="modal-title">
                    <i class="fas fa-tasks"></i>
                    {{ __('Add Task') }}
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body p-0">

                    <div class="bs-stepper">

                        <div class="bs-stepper-header" role="tablist">

                            <div class="step" data-target="#task-context-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="task-context-part" id="task-context-part-trigger">
                                    <span class="bs-stepper-circle-matla">1</span>
                                    <span class="bs-stepper-label">{{ __('Task Context') }}</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#content-type-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="content-type-part" id="content-type-part-trigger">
                                    <span class="bs-stepper-circle-matla">2</span>
                                    <span class="bs-stepper-label">{{ __('Content Type') }}</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#content-details-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="content-details-part" id="content-details-part-trigger">
                                    <span class="bs-stepper-circle-matla">3</span>
                                    <span class="bs-stepper-label">{{ __('Content Details') }}</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#date-and-task-part">
                                <button type="button" class="step-trigger" role="tab"
                                    aria-controls="date-and-task-part" id="date-and-task-part-trigger">
                                    <span class="bs-stepper-circle-matla">4</span>
                                    <span class="bs-stepper-label">{{ __('Date And Task') }}</span>
                                </button>
                            </div>
                        </div>
                        <form id="add-task-form">
                            @csrf
                            <div class="bs-stepper-content">
                                @include('workspace.tasksManagment.tasks.task-context')
                                @include('workspace.tasksManagment.tasks.content-type')
                                @include('workspace.tasksManagment.tasks.content-details')
                                @include('workspace.tasksManagment.tasks.date-and-task')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
