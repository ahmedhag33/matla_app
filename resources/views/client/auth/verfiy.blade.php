<div class="login col-sm-12 login_click">
    <h4 class="login_register_title">{{ __('Please enter the verification code sent to your email') }}</h4>
    <form id="verfiy-email-code-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="text" id="verification-code" class=" form-control requiredField input-label"
                placeholder="{{ __('Verification code') }}" name="verification_code">
            <span class="text-danger error-text verification_code_err"></span>
        </div>
        <span id="forget-timer">
            <b>{{ __('Verification Code Expired In') }}</b>
            <span id="forget-countdown"></span>
        </span>
        <div class="form-group col-md-12 mbnone">
            <button class="btn btn-contact-bg" type="submit" id="btn-verify-email">{{ __('Verify') }}</button>
        </div>
    </form>
    <div id="verfiy-email-code-loading" class="spinner-grow text-dark" role="status" style="display: none;">
        <span class="sr-only">Loading...</span>
    </div>
</div>
