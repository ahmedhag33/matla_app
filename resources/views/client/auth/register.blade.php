<div class="register col-sm-12 register_click" id="register-form-container">
    <h4 class="login_register_title">{{ __('Create a new account') }}</h4>
    <form id="register-form" ethod="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="text" id="name" class=" form-control requiredField input-label"
                placeholder="{{ __('UserName') }}" name="name">
            <span class="text-danger error-text name_err"></span>
        </div>
        <div class="form-group">
            <input type="email" id="email" class=" form-control requiredField input-label"
                placeholder="{{ __('The Email') }}" name="email">
            <span class="text-danger error-text email_err"></span>
        </div>
        <div class="form-group">
            <input type="password" id="register_password" class="form-control requiredField input-label"
                placeholder="{{ __('Password') }}" name="password">
            <span class="text-danger error-text password_err"></span>
        </div>
        <label class="container1">{{ __('Show Password') }}
            <input type="checkbox" id="check_register">
            <span class="checkmark1" for="check_register"></span>
        </label>
        <label class="container1">{{ __('Create a Strong Password') }}
            <input type="checkbox" id="create_password">
            <span class="checkmark1" for="create_password"></span>
        </label>
        <div class="form-group">
            <input type="password" id="password_confirmation" class="form-control requiredField input-label"
                placeholder="{{ __('Confirm Password') }}" name="password_confirmation">
            <span class="text-danger error-text password_confirmation_err"></span>
        </div>
        <div class="form-group col-md-12 mbnone">
            <button class="btn btn-contact-bg" type="submit" id="btn-register">{{ __('Register') }}</button>
        </div>
    </form>
    <div id="register-loading" class="spinner-grow text-dark" role="status" style="display: none;">
        <span class="sr-only">Loading...</span>
    </div>
    <br>
    @include('client.auth.social')
</div>
