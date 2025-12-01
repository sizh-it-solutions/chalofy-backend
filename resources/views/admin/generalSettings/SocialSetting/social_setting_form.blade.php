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
							<h3 class="box-title">{{ trans('global.socialLinks_title_singular') }}</h3><span class="email_status" style="display: none;">(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="social_setting" method="post" action="{{ route('admin.socialmediaadd')}}" class="form-horizontal " novalidate="novalidate">
							{{ csrf_field() }}
							<div class="box-body">
																	<div class="form-group facebook">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.facebook') }} <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="socialmedia_facebook" class="form-control " id="facebook" value="{{ $socialmedia_facebook->meta_value ?? '' }}" placeholder="Facebook">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small></small>
	</div>
</div>																	<div class="form-group google_plus">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.google_plus') }} <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="socialmedia_google_plus" class="form-control " id="google_plus" value="{{ $socialmedia_google_plus->meta_value ?? '' }}" placeholder="Google Plus">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small></small>
	</div>
</div>																	<div class="form-group twitter">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.twitter') }} <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="socialmedia_twitter" class="form-control " id="twitter" value="{{ $socialmedia_twitter->meta_value ?? '' }}" placeholder="Twitter">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small></small>
	</div>
</div>																	<div class="form-group linkedin">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.linkedin') }} <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="socialmedia_linkedin" class="form-control " id="linkedin" value="{{ $socialmedia_linkedin->meta_value ?? '' }}" placeholder="Linkedin">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small></small>
	</div>
</div>																	<div class="form-group pinterest">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.pinterest') }} <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="socialmedia_pinterest" class="form-control " id="pinterest" value="{{$socialmedia_pinterest->meta_value ?? '' }}" placeholder="Pinterest">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small></small>
	</div>
</div>																	<div class="form-group youtube">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.youtube') }} <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="socialmedia_youtube" class="form-control " id="youtube" value="{{ $socialmedia_youtube->meta_value ?? '' }}" placeholder="Youtube">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small></small>
	</div>
</div>																	<div class="form-group instagram">
			<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.instagram') }} <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="socialmedia_instagram" class="form-control " id="instagram" value="{{ $socialmedia_instagram->meta_value ?? '' }}" placeholder="Instagram">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small></small>
	</div>
</div>																<div class="text-center" id="error-message"></div>
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