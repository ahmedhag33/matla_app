 <script src="{{ asset('public/client/js/jquery-1.12.4.min.js') }}"></script>
 <!-- Latest compiled and minified Bootstrap -->
 <script src="{{ asset('public/client/bootstrap/js/bootstrap.min.js') }}"></script>
 <!-- modernizer JS -->
 <script src="{{ asset('public/client/js/modernizr-2.8.3.min.js') }}"></script>
 <!-- stellar js -->
 <script src="{{ asset('public/client/js/jquery.stellar.min.js') }}"></script>
 <!-- Menu js -->
 <script src="{{ asset('public/client/js/menu.js') }}"></script>
 <script src="{{ asset('public/client/js/jquery.sticky.js') }}"></script>
 <!-- owl-carousel min js  -->
 <script src="{{ asset('public/client/owlcarousel/js/owl.carousel.min.js') }}"></script>
 <!-- MAGNIFICANT JS -->
 <script src="{{ asset('public/client/js/jquery.magnific-popup.min.js') }}"></script>
 <!-- Slick JS -->
 <script src="{{ asset('public/client/js/slick.min.js') }}"></script>
 <!-- jquery mixitup min js -->
 <script src="{{ asset('public/client/js/jquery.mixitup.js') }}"></script>
 <!-- jquery.prettyPhoto js -->
 <script src="{{ asset('public/client/js/jquery.prettyPhoto.js') }}"></script>
 <!-- scrolltopcontrol js -->
 <script src="{{ asset('public/client/js/scrolltopcontrol.js') }}"></script>
 <!-- WOW - Reveal Animations When You Scroll -->
 <script src="{{ asset('public/client/js/wow.min.js') }}"></script>
 <!-- scripts js -->
 <script src="{{ asset('public/client/js/scripts.js') }}"></script>
 <!-- sweetalert2 js -->
 <script src="{{ asset('public/js/sweetalert2@11.js') }}"></script>
 <script src="{{ asset('public/js/toastr.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('public/js/jquery.ui.widget.js') }}"></script>
 <script type="text/javascript" src="{{ asset('public/js/jquery.iframe-transport.js') }}"></script>
 <script type="text/javascript" src="{{ asset('public/js/jquery.fileupload.js') }}"></script>
 <script type="text/javascript" src="{{ asset('public/js/cloudinary-jquery-file-upload.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('public/js/select2.min.js') }}"></script>
 <script src="https://widget.cloudinary.com/v2.0/global/all.js"></script>
 <script src="{{ asset('public/js/treeview.js') }}" type="text/javascript"></script>
 <script src="{{ asset('public/js/jquery.star-rating-svg.js') }}"></script>
 <script src="{{ asset('public/js/jquery.star-rating-svg.min.js') }}"></script>
 <script>
     $.cloudinary.config({
         cloud_name: '{{ env('CLOUDINARY_NAME') }}'
     });
 </script>
 <script>
     toastr.options = {
         "closeButton": true,
         "debug": false,
         "newestOnTop": false,
         "progressBar": true,
         "positionClass": "toast-top-left",
         "preventDuplicates": true,
         "onclick": null,
         "showDuration": "300",
         "hideDuration": "1000",
         "timeOut": "5000",
         "extendedTimeOut": "1000",
         "showEasing": "swing",
         "hideEasing": "linear",
         "showMethod": "fadeIn",
         "hideMethod": "fadeOut"
     }
 </script>
