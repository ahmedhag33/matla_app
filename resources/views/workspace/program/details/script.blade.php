<script>
    $(document).ready(function() {
        moment.locale('{{ app()->getLocale() }}');
        const programDays = @json(array_keys($programDays));
        const date = moment().format('dddd، D MMMM YYYY');
        $('#air_date').datetimepicker({
            format: 'dddd، D MMMM YYYY',
            locale: '{{ app()->getLocale() }}',
            daysOfWeekDisabled: programDays,
        });
        $('#air_time').datetimepicker({
            format: 'h:mm A',
            locale: '{{ app()->getLocale() }}',
        });
        $('.reminder-checkbox').change(function() {
            if ($(this).is(':checked')) {
                $('#reminder-time-container').show();
            } else {
                $('#reminder-time-container').hide();
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'));
    });
</script>
