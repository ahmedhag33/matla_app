<div class="login col-sm-12 login_click">
    <h4 class="login_register_title">{{ __('Login') }}</h4>
    <form id="login-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="email" id="email" class=" form-control requiredField input-label"
                placeholder="{{ __('The Email') }}" name="email">
            <span class="text-danger email_err"></span>
        </div>
        <div class="form-group">
            <input type="password" id="password" class="form-control requiredField input-label"
                placeholder="{{ __('Password') }}" name="password">
            <span class="text-danger password_err"></span>
        </div>
        <label class="container1">{{ __('Show Password') }}
            <input type="checkbox" id="check">
            <span class="checkmark1" for="check"></span>
        </label>
        <div class="form-group col-md-12 mbnone">
            <button class="btn btn-contact-bg" type="submit" id="btn-login">{{ __('Login') }}</button>
        </div>
    </form>
    <br>
    <div id="forget-password" class="form-group col-md-12 mbnone">
        <button class="btn btn-primary" id="forget_password">{{ __('Did you forget your password?') }}</button>
    </div>
    <div id="login-loading" class="spinner-grow text-dark" role="status" style="display: none;">
        <span class="sr-only">Loading...</span>
    </div>
    <br>
    @include('client.auth.social')
</div>
</div><!--- END COL -->
