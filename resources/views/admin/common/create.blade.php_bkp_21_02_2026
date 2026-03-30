@extends('layouts.admin')
@section('content')
@php
    $i = 0;
    $j = 0;
  $title = 'vehicle';
@endphp

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.create') }} {{ trans('global.' . $title . '_title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.' . $realRoute . '.store') }}" enctype="multipart/form-data">
                        @csrf

                        @foreach($supportedLocales as $localeCode => $localeName)
                            <div class="border p-2 mb-2 rounded bg-light">
                                <!-- <h5>{{ $localeName }} ({{ $localeCode }})</h5> -->

                                {{-- Title --}}
                                <div class="form-group {{ $errors->has('title.'.$localeCode) ? 'has-error' : '' }}">
                                    <label class="required" for="title_{{ $localeCode }}">{{ trans('global.title') }} </label>
                                    <input class="form-control" type="text" name="title[{{ $localeCode }}]" id="title_{{ $localeCode }}"
                                           value="{{ old('title.'.$localeCode, '') }}" required>
                                    @if($errors->has('title.'.$localeCode))
                                        <span class="help-block" role="alert">{{ $errors->first('title.'.$localeCode) }}</span>
                                    @endif
                                </div>

                                {{-- Description --}}
                                <div class="form-group {{ $errors->has('description.'.$localeCode) ? 'has-error' : '' }}">
                                    <label for="description_{{ $localeCode }}">{{ trans('global.description') }}</label>
                                    <textarea class="form-control" name="description[{{ $localeCode }}]" id="description_{{ $localeCode }}">{{ old('description.'.$localeCode) }}</textarea>
                                    @if($errors->has('description.'.$localeCode))
                                        <span class="help-block" role="alert">{{ $errors->first('description.'.$localeCode) }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        {{-- User Select --}}
                        <div class="form-group {{ $errors->has('userid_id') ? 'has-error' : '' }}">
                            <label for="userid_id">{{ trans('global.vendor') }}</label>
                            <select class="form-control select2" name="userid_id" id="userid_id" required>
                                @foreach($userids as $id => $entry)
                                    <option value="{{ $id }}" {{ old('userid_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('userid_id'))
                                <span class="help-block" role="alert">{{ $errors->first('userid_id') }}</span>
                            @endif
                        </div>

                        {{-- Place Select --}}
                        <div class="form-group {{ $errors->has('place_id') ? 'has-error' : '' }}">
                            <label class="required" for="place_id">{{ trans('global.place') }}</label>
                            <select class="form-control select2" name="place_id" id="place_id" required>
                                @foreach($places as $id => $entry)
                                    <option value="{{ $id }}" {{ old('place_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('place_id'))
                                <span class="help-block" role="alert">{{ $errors->first('place_id') }}</span>
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
    $(document).ready(function() {
        $('.multipleaddselect').select2({
            tags: true
        });

        const selectedAmenities = {!! json_encode(old('features_id', [])) !!};
        $('.multipleaddselect').val(selectedAmenities).trigger('change');
    });
</script>
@endsection
