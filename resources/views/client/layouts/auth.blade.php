 <div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body text-center">
                 <section class="works_area">
                     <div class="container">

                         <ul class="portfolio-filters" id="ui-filters-login-register">
                             <li class="filter active" data-target="login_box">
                                 {{ __('Login') }}
                             </li>
                             <li class="filter" data-target="register_box">
                                 {{ __('Create a new account') }}
                             </li>
                         </ul>

                         <div id="login_box">
                             @include('client.auth.login')
                         </div>

                         <div id="register_box" style="display:none">
                             @include('client.auth.register')
                         </div>
                         <div id="forget_password_box" style="display:none">
                             @include('client.auth.forget')
                         </div>
                         <div id="verify_email_box" style="display:none">
                             @include('client.auth.verfiy')
                         </div>
                         <div id="reset_password_box" style="display:none">
                             @include('client.auth.reset')
                         </div>
                     </div>
                 </section>
             </div>
         </div>
     </div>
 </div>
