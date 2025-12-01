@extends('layouts.admin')
@section('content')
<section class="content">
	<div class="row">
		

		<div class="col-md-12">
			<div class="box box-info">

				<div class="box-header with-border">
					<h3 class="box-title">{{$mainHeadingTitle}}</h3><span class="email_status"
						style="display: none;">(<span class="text-green"><i class="fa fa-check"
								aria-hidden="true"></i>Verified</span>)</span>
				</div>

				<form id="general_form" method="post" action="{{ route($updateSetting) }}"
					class="form-horizontal " enctype="multipart/form-data" novalidate="novalidate">
					{{ csrf_field() }}
					<input type="hidden" name="module" value="{{$module}}">
					<div class="box-body">
						<div class="form-group name">
							<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.title') }} <span
									class="text-danger">*</span></label>
							<div class="col-sm-6">

								<input type="text" name="title" class="form-control " id="title"
									value=" {{$title->meta_value ?? ''}}" placeholder="Name">
								<span class="text-danger"></span>
							</div>
							<div class="col-sm-3">
								<small></small>
							</div>
						</div>

						<div class="form-group name">
							<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.head_title') }} <span
									class="text-danger"></span></label>
							<div class="col-sm-6">

								<input type="text" name="head_title" class="form-control " id="head_title"
									value=" {{$head_title->meta_value ?? ''}}" placeholder="Head Title">
								<span class="text-danger"></span>
							</div>
							<div class="col-sm-3">
								<small></small>
							</div>
						</div>

						<div class="form-group phone">
							<label for="input" class="col-sm-3 control-label">{{ trans('global.image_text') }} <span
									class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="image_text" class="form-control " id="image_text"
									value=" {{ $image_text->meta_value ?? ''}}">
								<span class="text-danger"></span>
							</div>
							<div class="col-sm-3">
								<small></small>
							</div>
						</div>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">{{ trans('global.image') }}</label>

							<div class="col-sm-6">
								<input type="file" name="item_setting_image" class="form-control " id="item_setting_image" value=""
									placeholder="Backgroud">
								<span class="text-danger"></span>

							
								@if (!empty($item_setting_image->meta_value))
								<br><img class="file-img"
									src="{{ ('/storage/' . $item_setting_image->meta_value) }}" width="150"
									 alt="Backgroud">
								@endif

							</div>

							<div class="col-sm-3">
								<small></small>
							</div>
						</div>

					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-info btn-space"> {{ trans('global.save') }}</button>
						<a class="btn btn-danger" href="{{ route('admin.settings') }}"> {{ trans('global.cancel') }}</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/45.2.0/classic/ckeditor.js"></script>

<script>

	document.addEventListener("DOMContentLoaded", function () {

		ClassicEditor
			.create(document.querySelector('.editor'))

	});
</script>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		ClassicEditor
			.create(document.querySelector('.editor2'))

	});
</script>
@endsection