<div class="modal fade" id="update-email-model" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="login col-sm-12 login_click">
                    <h4 class="login_register_title">{{ __('Update Email') }}</h4>
                    <form id="update-email-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="email" value="{{ auth()->user()->email }}"
                                class=" form-control requiredField input-label" placeholder="{{ __('Email') }}"
                                name="email">
                        </div>
                        <div class="form-group col-md-12 mbnone">
                            <button class="btn btn-contact-bg" type="submit"
                                id="btn-update-email">{{ __('Update Email') }}</button>
                        </div>
                    </form>
                    <br>
                    <div id="update-email-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <form id="verfiy-update-email-code-form" method="POST" enctype="multipart/form-data"
                        style="display: none;">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="verification-code" class=" form-control requiredField input-label"
                                placeholder="{{ __('Verification code') }}" name="verification_code">
                            <span class="text-danger error-text verification_code_err"></span>
                        </div>
                        <span>
                            <b>{{ __('Verification Code Expired In') }}</b>
                            <span id="update-countdown"></span>
                        </span>
                        <div class="form-group col-md-12 mbnone">
                            <button class="btn btn-contact-bg" type="submit"
                                id="btn-update-done-email">{{ __('Verify') }}</button>
                        </div>
                    </form>
                    <br>
                    <div id="update-email-done-loading" class="spinner-grow text-dark" role="status" style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div><!--- END COL -->
        </div>
    </div>
</div>
