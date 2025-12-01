@extends('layouts.admin')
@section('content')
<section class="content">
			<div class="row">
				<div class="col-md-3 settings_bar_gap">
					<div class="box box-info box_info">
	<div class="">
	<h4 class="all_settings f-18 mt-1" style="margin-left:15px;"> {{ trans('global.manage_settings') }}</h4>
        @include('admin.generalSettings.general-setting-links.links')
	</div>
</div>
				</div>

				<div class="col-md-9">
					<div class="box box-info">
                        
						<div class="box-header with-border">
							<h3 class="box-title">{{ trans('global.becomeHost_title_singular') }}</h3><span class="email_status" style="display: none;">(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="general_form" method="post" action="{{ route('admin.addbecomehost') }}" class="form-horizontal " enctype="multipart/form-data" novalidate="novalidate">
						{{ csrf_field() }}
							<div class="box-body">
																	<div class="form-group name">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.image') }} <span class="text-danger">*</span></label>
			<div class="col-sm-6">
		<input type="file" name="general_becomehost_image" class="form-control " id="photos[logo]" value="" placeholder="Image">
		<span class="text-danger"></span>
		@if (!empty($general_becomehost_image->meta_value))
		<br><img class="file-img" src="{{ ('/public/uploads/image/' . $general_becomehost_image->meta_value) }}" width="150" height="60" alt="Logo" >
		@endif
		
	</div>

	<div class="col-sm-3">
		<small></small>
	</div>
</div>			
					<div class="form-group email" >
            <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.title_1') }} <span class="text-danger">*</span></label>
        <div class="col-sm-6">
        <input type="text" name="general_host_title_first" class="form-control " id="email" value=" {{$general_host_title_first->meta_value ?? ''}}" placeholder="Email">
        <span class="text-danger"></span>
    </div>
    <div class="col-sm-3">
        <small></small>
    </div>
</div>
					<div class="form-group email" >
            <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.title_2') }} <span class="text-danger">*</span></label>
        <div class="col-sm-6">
        <input type="text" name="general_host_title_second" class="form-control " id="email" value=" {{$general_host_title_second->meta_value ?? ''}}" placeholder="Email">
        <span class="text-danger"></span>
    </div>
    <div class="col-sm-3">
        <small></small>
    </div>
</div>
					<div class="form-group email" >
            <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.title_3') }} <span class="text-danger">*</span></label>
        <div class="col-sm-6">
        <input type="text" name="general_host_title_third" class="form-control " id="email" value=" {{$general_host_title_third->meta_value ?? ''}}" placeholder="Email">
        <span class="text-danger"></span>
    </div>
    <div class="col-sm-3">
        <small></small>
    </div>
</div>
					<div class="form-group email" >
            <label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.title_4') }} <span class="text-danger">*</span></label>
        <div class="col-sm-6">
        <input type="text" name="general_host_title_fourth" class="form-control " id="email" value=" {{$general_host_title_fourth->meta_value ?? ''}}" placeholder="Email">
        <span class="text-danger"></span>
    </div>
    <div class="col-sm-3">
        <small></small>
    </div>
</div>
					
					<div class="form-group phone" >
            <label for="input" class="col-sm-3 control-label">{{ trans('global.button') }} <span class="text-danger">*</span></label>
        <div class="col-sm-6">
        <input type="text" name="general_host_link" class="form-control " id="phone" value=" {{ $general_host_link->meta_value ?? ''}}">
        <span class="text-danger"></span>
    </div>
    <div class="col-sm-3">
        <small></small>
    </div>
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