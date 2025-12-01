@extends('layouts.admin')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-3 settings_bar_gap">
            <div class="box box-info box_info">
                <div class="">
                    <h4 class="all_settings f-18 mt-1" style="margin-left:15px;">{{ trans('global.manage_settings') }}</h4>
                    @include('admin.generalSettings.general-setting-links.links')
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title">App Screen Settings</h3>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="app_screen_settings" method="post" action="{{ route('admin.updateappscreensetting') }}" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-6">
                                @php                               
                                    $checkboxes = [
                                        'item_type' => 'Item Type',
                                        'popular_region' => 'Popular Region',
                                        'near_you' => 'Near by You',
                                        'make' => 'Make',
                                        'most_viewed' => 'Most Viewed',
                                        'become_lend' => 'Become Lend',
                                        'show_distance'=>'Show Distance',
                                    ];
                                @endphp

                                @foreach ($checkboxes as $key => $label)
                                @php
                                 $reslKey = "app_" . $key;
                                @endphp 

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="app_{{ $key }}" name="settings[]" value="{{ $key }}" {{ isset($settings[$reslKey]) && $settings[$reslKey]->meta_value === 'Active' ? 'checked' : '' }}>
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach

                                <span class="text-danger"></span>
                            </div>
                        </div>

                        <div class="text-center" id="error-message"></div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-space">{{ trans('global.save') }}</button>
                        <a class="btn btn-danger" href="{{ route('admin.settings') }}">{{ trans('global.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
