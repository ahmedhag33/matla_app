<div class="modal fade" id="verificationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <section class="works_area">
                    <div class="container" id="verification-form-container">
                        <form id="verification-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h4 class="login_register_title input-content-access-title">
                                {{ __('Please enter the verification code sent to your email') }}</h4>
                            <div class="form-group">
                                <input type="text" id="verification-code"
                                    class=" form-control requiredField input-label"
                                    placeholder="{{ __('Verification code') }}" name="verification_code">
                                <span class="text-danger error-text verification_code_err"></span>
                            </div>
                            <div class="form-group col-md-12 mbnone" id="show-btn-verification">
                                <button class="btn btn-contact-bg" type="submit"
                                    id="btn-verification">{{ __('Verify') }}</button>
                            </div>
                            <span id="verification-timer">
                                <b>{{ __('Verification Code Expired In') }}</b>
                                <span id="verification-countdown"></span>
                            </span>
                            <div id="verification-loading" class="spinner-grow text-dark" role="status"
                                style="display: none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </form>
                    </div>
                    <div class="container" id="verification-resend-container" style="display: none;">
                        <div class="card">
                            <div class="card-body" id="resend-code">
                                <button type="button"
                                    class="btn btn-light" onclick="resendCode();">{{ __('Resend Verification Code') }}</button>
                            </div>
                            <div id="resend-loading" class="spinner-grow text-dark" role="status"
                                style="display: none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
