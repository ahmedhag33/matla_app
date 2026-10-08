<div class="register col-sm-12 register_click" id="register-form-container">
    <h4 class="login_register_title">{{ __('Create a new password') }}</h4>
    <form id="reset-password-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="password" id="reset_password" class="form-control requiredField input-label"
                placeholder="{{ __('Password') }}" name="password">
            <span class="text-danger error-text password_err"></span>
        </div>
        <label class="container1">{{ __('Show Password') }}
            <input type="checkbox" id="check_reset_password">
            <span class="checkmark1" for="check_reset_password"></span>
        </label>
        <label class="container1">{{ __('Create a Strong Password') }}
            <input type="checkbox" id="create_reset_password">
            <span class="checkmark1" for="create_password"></span>
        </label>
        <div class="form-group">
            <input type="password" id="reset_password_confirmation" class="form-control requiredField input-label"
                placeholder="{{ __('Confirm Password') }}" name="password_confirmation">
            <span class="text-danger error-text password_confirmation_err"></span>
        </div>
        <div class="form-group col-md-12 mbnone">
            <button class="btn btn-contact-bg" type="submit" id="btn-reset-password">{{ __('Reset Password') }}</button>
        </div>
    </form>
    <div id="reset-password-loading" class="spinner-grow text-dark" role="status" style="display: none;">
        <span class="sr-only">Loading...</span>
    </div>
</div>
