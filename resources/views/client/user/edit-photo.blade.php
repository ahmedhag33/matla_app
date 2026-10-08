<div class="modal fade" id="update-photo-model" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="login col-sm-12 login_click">
                    <h4 class="login_register_title">{{ __('Update Photo') }}</h4>
                    <form id="update-photo-form" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <Label><b>{{ __('Photo') }}</b></Label>
                                <input type="file" id="photo" name="photo">
                                <span class="text-danger error-text photo_err"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mbnone">
                            <button class="btn btn-contact-bg" type="submit"
                                id="btn-update-photo">{{ __('Update Photo') }}</button>
                        </div>
                    </form>
                    <br>
                    <div id="update-photo-loading" class="spinner-grow text-dark" role="status"
                        style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div><!--- END COL -->
        </div>
    </div>
</div>
