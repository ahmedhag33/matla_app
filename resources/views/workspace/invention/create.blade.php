<div class="modal fade" id="add-invention">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add Invitation') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-invention-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="{{ __('Name') }}">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="{{ __('The Email') }}">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="form-group">
                        <select class="form-control role" name="role_id" style="width: 100%;">
                            <option value="0" selected="selected">{{ __('The Role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text role_id_error"></span>
                    </div>
                    <button type="button" class="btn btn-matla btn-send">{{ __('Send') }}</button>
                </form>
                <div id="add-invention-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
