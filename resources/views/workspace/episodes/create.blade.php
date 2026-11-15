<div class="modal fade" id="addSegmentModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header-matla">
                <h4 class="modal-title">
                    <i class="fas fa-layer-group"></i>
                    {{ __('Add New Segment') }}
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body p-0">
                    <form id="addSegmentForm">
                        @csrf
                        <div class="row">
                            {{-- Segment Name --}}
                            <div class="col-md-6 form-group">
                                <label for="name">
                                    {{ __('Segment Name') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="{{ __('Enter segment name') }}">
                            </div>

                            {{-- Segment Type --}}
                            <div class="col-md-6 form-group">
                                <label for="type">
                                    {{ __('Segment Type') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="type" id="type" class="form-control select2">
                                    @foreach (segmentTypes() as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Duration --}}
                            <div class="col-md-6 form-group">
                                <label for="duration">
                                    {{ __('Duration (Minutes)') }}
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="number" name="duration" id="duration" class="form-control" min="1"
                                    placeholder="{{ __('Enter duration in minutes') }}">
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12 form-group">
                                <label for="description">
                                    {{ __('Description') }}
                                </label>

                                <textarea name="description" id="description" class="form-control" rows="3"
                                    placeholder="{{ __('Enter segment description') }}"></textarea>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>

                            <button type="submit" class="btn btn-matla btn-segment">
                                <i class="fas fa-save"></i>
                                {{ __('Save Segment') }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
