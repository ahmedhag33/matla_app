@extends('workspace.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/episode.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dashboard/dist/css/matla-calendar.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <i class="fas fa-tasks"></i>
                            {{ __('My Tasks') }}
                        </h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <main class="matla-program-details">
            <section class="matla-program-content">
                <div class="matla-tabs-header">
                    <ul class="nav nav-pills matla-program-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#calendar" data-toggle="tab" role="tab"><i
                                    class="fas fa-calendar"></i>{{ __('Calendar') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#task-list" data-toggle="tab" role="tab"><i
                                    class="fas fa-list"></i>{{ __('Task List') }}</a></li>
                    </ul>
                </div>
                <div class="tab-content matla-program-tab-content">
                    <div class="tab-pane fade show active" id="calendar" role="tabpanel">
                        <div class="col-md-12">
                            <div class="card card-matla">
                                <div class="card-body p-0">
                                    <!-- THE CALENDAR -->
                                    <div id="task-calendar"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="task-list" role="tabpanel">
                        <h1>{{ __('Task List') }}</h1>
                    </div>
                </div>
            </section>
        </main>
    </div> <!-- End content-wrapper -->
@endsection
@section('script')
    <script>
        $(function() {
            var Calendar = FullCalendar.Calendar;
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var calendarEl = document.getElementById('task-calendar');
            var calendar = new Calendar(calendarEl, {
                locale: '{{ app()->getLocale() }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                buttonText: {
                    today: '{{ __('Today') }}',
                    month: '{{ __('Month') }}',
                    week: '{{ __('Week') }}',
                    day: '{{ __('The Day') }}',
                },
                themeSystem: 'bootstrap',
                //Random default events
                events: [{
                    title: 'All Day Event',
                    start: new Date(y, m, 1),
                    backgroundColor: '#f56954', //red
                    borderColor: '#f56954', //red
                    allDay: true
                }],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
            });
            calendar.render();
        });
    </script>
@endsection
