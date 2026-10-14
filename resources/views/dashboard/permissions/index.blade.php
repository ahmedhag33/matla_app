@extends('dashboard.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="card card-matla">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Permission') }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="form-group">
                                    <select class="custom-select form-control-border" id="exampleSelectBorder">
                                        <option>{{ __('The Role') }}</option>
                                       @foreach ($roles as $role)
                                         <option value="{{ $role->id }}">{{ $role->name }}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-sm-6">
                                        <h4>{{ $permission->name }}</h4>
                                        @foreach ($permission->children as $item)
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        id="permission_{{ $item->id }}" value="{{ $item->id }}">
                                                    <label for="permission_{{ $item->id }}"
                                                        class="custom-control-label">{{ $item->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    </div>
@endsection
