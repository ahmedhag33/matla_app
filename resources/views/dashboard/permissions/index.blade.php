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
                                    <select class="custom-select form-control-border" id="role_id" name="role_id">
                                        <option value="0" data-slug="0">{{ __('The Role') }}</option>
                                        @foreach ($roles as $role)
                                            <option data-slug="{{ $role->slug }}" value="{{ $role->id }}"
                                                @if ($code == $role->slug) selected @endif>{{ $role->name }}
                                            </option>
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
                                                    <input class="custom-control-input" name="permission_id" type="checkbox"
                                                        id="permission_{{ $item->id }}" value="{{ $item->id }}"
                                                        @if ($code == null) disabled @endif
                                                        @if (in_array($item->id, $permissions_ids)) checked @endif>
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
@section('script')
    <script>
        $('#role_id').change(function() {
            var role = $(this).find('option:selected').data('slug');

            if (role != 0) {
                window.location.href = "{{ url()->current() }}?role=" + role;
            } else {
                window.location.href = "{{ url()->current() }}";
            }
        });
    </script>
    <script>
        $('input[name="permission_id"]').change(function() {
            // Avoid triggering the change event recursively
            var $this = $(this);
            if ($this.is(':checked')) {
                var route = "{{ route('dashboard.permissions.update') }}";
            } else {
                var route = "{{ route('dashboard.permissions.delete') }}";
            }
            // Use the value of the permission_id, not the jQuery object
            var permission_id = $this.val();
            var role_id = $('#role_id').val();
            var role = $('#role_id').find('option:selected').data('slug');
            $.ajax({
                type: 'post',
                url: route,
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    'role_id': role_id,
                    'permission_id': permission_id
                },
                success: function(data) {
                    window.location.href = "{{ url()->current() }}?role=" + role;
                }
            });
        });
    </script>
@endsection
