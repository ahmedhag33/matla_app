<div class="modal fade" id="update-profile-model" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="login col-sm-12 login_click">
                    <h4 class="login_register_title">{{ __('Update Profile') }}</h4>
                    <form id="update-profile-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="name" value="{{ auth()->user()->name }}"
                                class=" form-control requiredField input-label" placeholder="{{ __('Name') }}"
                                name="name">
                        </div>
                        <div class="form-group col-md-12 mbnone">
                            <button class="btn btn-contact-bg" type="submit"
                                id="btn-update-profile">{{ __('Update Profile') }}</button>
                        </div>
                    </form>
                    <br>
                    <div id="update-profile-loading" class="spinner-grow text-dark" role="status"
                        style="display: none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div><!--- END COL -->
        </div>
    </div>
</div>
