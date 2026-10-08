@extends('dashboard.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1 class="m-0">{{ __('Dashboard') }}</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
@section('script')
    @if (session()->has('error-admin-is-authticate'))
        <script>
            toastr.error("{{ session()->get('error-admin-is-authticate') }}");
        </script>
    @endif
    @if (session()->has('error-admin-password-change'))
        <script>
            toastr.error("{{ session()->get('error-admin-password-change') }}");
        </script>
    @endif
    @if (session()->has('login-success'))
        <script>
            toastr.success("{{ session()->get('login-success') }}");
        </script>
    @endif
    @if (session()->has('update-password-success-message'))
        <script>
            toastr.success("{{ session()->get('update-password-success-message') }}");
        </script>
    @endif
@endsection
