<div class="modal fade" id="update-password-model" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="login col-sm-12 login_click">
                    <h4 class="login_register_title">{{ __('Update Password') }}</h4>
                    <form id="update-password-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="password" id="update_old_password" class="form-control requiredField input-label"
                                placeholder="{{ __('Current Password') }}" name="old_password">
                        </div>
                        <label class="container1">{{ __('Show Password') }}
                            <input type="checkbox" id="update_old_check">
                            <span class="checkmark1" for="update_old_check"></span>
                        </label>
                        <div class="form-group">
                            <input type="password" id="update_new_password" class="form-control requiredField input-label"
                                placeholder="{{ __('New Password') }}" name="new_password">
                        </div>
                        <label class="container1">{{ __('Show Password') }}
                            <input type="checkbox" id="update_new_check">
                            <span class="checkmark1" for="update_new_check"></span>
                        </label>
                        <div class="form-group col-md-12 mbnone">
                            <button class="btn btn-contact-bg" type="submit"
                                id="btn-update-password">{{ __('Update Password') }}</button>
                        </div>
                    </form>
                    <br>
                    <div id="update-password-loading" class="spinner-grow text-dark" role="status"
                        style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div><!--- END COL -->
        </div>
    </div>
</div>
