<script>
    $(document).ready(function() {
        moment.locale('ar');

        const date = moment().format('dddd، D MMMM YYYY');
        $('#reservationdate').datetimepicker({
            format: 'dddd، D MMMM YYYY',
            locale: 'ar'
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'));
    });
</script>
