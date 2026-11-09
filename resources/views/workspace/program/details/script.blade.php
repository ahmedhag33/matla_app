<script>
    $(document).ready(function() {
        moment.locale('{{ app()->getLocale() }}');
        const programDays = @json(array_keys($programDays));
        const date = moment().format('dddd، D MMMM YYYY');
        $('#reservationdate').datetimepicker({
            format: 'dddd، D MMMM YYYY',
            locale: '{{ app()->getLocale() }}',
            daysOfWeekDisabled: programDays,
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'));
    });
</script>
