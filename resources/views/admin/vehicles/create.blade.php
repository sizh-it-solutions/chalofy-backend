@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('global.vehicle') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.vehicles.store") }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="module_id" value="{{ $moduleId }}">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label class="required" for="title">{{ trans('global.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                            @if($errors->has('title'))
                                <span class="help-block" role="alert">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label for="description">{{ trans('global.description') }}</label>
                            <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                            @if($errors->has('description'))
                                <span class="help-block" role="alert">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('userid') ? 'has-error' : '' }}">
                            <label for="userid_id">{{ trans('global.userid') }}</label>
                            <select class="form-control select2" name="userid_id" id="userid_id" required>
                                @foreach($userids as $id => $entry)
                                    <option value="{{ $id }}" {{ old('userid_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('userid'))
                                <span class="help-block" role="alert">{{ $errors->first('userid') }}</span>
                            @endif
                        </div>
                      
                       
                        
                        <div class="form-group {{ $errors->has('place') ? 'has-error' : '' }}">
                            <label class="required" for="place_id">{{ trans('global.place') }}</label>
                            <select class="form-control select2" name="place_id" id="place_id" required>
                                @foreach($places as $id => $entry)
                                    <option value="{{ $id }}" {{ old('place_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('place'))
                                <span class="help-block" role="alert">{{ $errors->first('place') }}</span>
                            @endif
                        </div>
                        
                       
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // Initialize Select2 on the features_id select element
    $(document).ready(function() {
        // Get the selected features IDs from the server-side
        const selectedFeatures = {!! json_encode(old('features_id', [])) !!};

        $('.multipleaddselect').select2({
            tags: true // Allow custom tags to be added
        });

        // Set the selected options in Select2
        $('.multipleaddselect').val(selectedFeatures).trigger('change');
    });
</script>
@endsection