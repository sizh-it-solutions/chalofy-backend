@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('global.review_title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.reviews.update", [$reviewList->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group {{ $errors->has('host_name') ? 'has-error' : '' }}">
                            <label class="required" for="host_name">{{ trans('global.host') }}</label>
                            <input class="form-control" type="text" name="host_name" id="host_name" value="{{ old('host_name', $reviewList->host_name) }}"  readonly >
                            @if($errors->has('host_name'))
                                <span class="help-block" role="alert">{{ $errors->first('host_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('item_name') ? 'has-error' : '' }}">
                            <label class="required" for="item_name">{{ trans('global.item_name') }}</label>
                            <input class="form-control" type="text" name="item_name" id="item_name" value="{{ old('item_name', $reviewList->item_name) }}" step="1" readonly>
                            @if($errors->has('item_name'))
                                <span class="help-block" role="alert">{{ $errors->first('item_name') }}</span>
                            @endif
                        </div>
                      
                        <div class="form-group {{ $errors->has('rating') ? 'has-error' : '' }}">
                            <label class="required" for="guest_rating">{{ trans('global.user') }} {{ trans('global.rating') }}</label>
                            <input class="form-control" type="number" name="guest_rating" id="guest_rating" value="{{ old('guest_rating', $reviewList->guest_rating) }}" step="1" required>
                            @if($errors->has('guest_rating'))
                                <span class="help-block" role="alert">{{ $errors->first('rating') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label for="message">{{ trans('global.user') }} {{ trans('global.message') }} </label>
                            <textarea class="form-control" name="guest_message" id="message">{{ old('guest_message', $reviewList->guest_message) }}</textarea>
                            @if($errors->has('guest_message'))
                                <span class="help-block" role="alert">{{ $errors->first('message') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('rating') ? 'has-error' : '' }}">
                            <label class="required" for="host_rating">{{ trans('global.vendor') }} {{ trans('global.rating') }}</label>
                            <input class="form-control" type="number" name="host_rating" id="host_rating" value="{{ old('host_rating', $reviewList->host_rating) }}" step="1" required>
                            @if($errors->has('host_rating'))
                                <span class="help-block" role="alert">{{ $errors->first('rating') }}</span>
                            @endif
                        </div>
                       
                        <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label for="host_message">{{ trans('global.host_message') }}</label>
                            <textarea class="form-control" name="host_message" id="message">{{ old('message', $reviewList->host_message) }}</textarea>
                            @if($errors->has('host_message'))
                                <span class="help-block" role="alert">{{ $errors->first('host_message') }}</span>
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