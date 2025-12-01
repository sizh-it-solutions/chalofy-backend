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
							<h3 class="box-title">Bookings Settings Wizard</h3><span class="email_status" style="display: none;">(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="fees_setting" method="post" action="{{ route('admin.updateBookingSetting') }}" class="form-horizontal " novalidate="novalidate">
							{{ csrf_field() }}
							<div class="box-body">
																			

                                <div class="form-group accomodation_tax">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Total Number Of Bookings <span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                                <input type="text" name="total_number_of_bookings_per_day" class="form-control " id="total_number_of_bookings_per_day" value="{{ $total_number_of_bookings_per_day->meta_value ?? '' }}" placeholder="Total Number of bookings">
                                                <span class="text-danger"></span>
                                        </div><span class="text">/ Day</span>
                         
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
	