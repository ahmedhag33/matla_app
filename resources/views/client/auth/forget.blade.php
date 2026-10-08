<div class="login col-sm-12 login_click">
    <h4 class="login_register_title">{{ __('Enter your email') }}</h4>
    <form id="send-email-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="email" id="email_forget" class=" form-control requiredField input-label"
                placeholder="{{ __('The Email') }}" name="email">
            <span class="text-danger error-text email_forget_err"></span>
        </div>
        <div class="form-group col-md-12 mbnone">
            <button class="btn btn-contact-bg" type="submit" id="btn-send-email">{{ __('Verify') }}</button>
        </div>
    </form>
    <div id="send-email-loading" class="spinner-grow text-dark" role="status" style="display: none;">
        <span class="sr-only">Loading...</span>
    </div>
</div>
