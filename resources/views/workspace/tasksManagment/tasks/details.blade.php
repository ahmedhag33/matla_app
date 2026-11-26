<div class="modal fade" id="show-task">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header-matla">
                <h4 class="modal-title">
                    <i class="fas fa-tasks"></i>
                    {{ __('Task Details') }}
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        @if ($data)
                            <tbody>
                                <tr>
                                    <th scope="row">{{ __('Title') }}</th>
                                    <td>{{ $data->title }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Description') }}</th>
                                    <td>{!! $data->description !!}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Episode') }}</th>
                                    <td>{{ $data->episode->title . '-' . $data->episode->program->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Status') }}</th>
                                    <td>{!! $data->status_formatted !!}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Due Date') }}</th>
                                    <td>{{ $data->due_at_formatted }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Priority') }}</th>
                                    <td>{!! $data->priority_formatted !!}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Completed At') }}</th>
                                    <td>{{ $data->completed_at_formatted ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('Assigned To') }}</th>
                                    <td>{{ $data->assignee->name }}</td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
