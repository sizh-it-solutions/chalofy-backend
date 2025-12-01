<?php $__env->startSection('content'); ?>
<section class="content">
			<div class="row">
				<div class="col-md-3 settings_bar_gap">
					<div class="box box-info box_info">
	<div class="">
	<h4 class="all_settings f-18 mt-1" style="margin-left:15px;"><?php echo e(trans('global.manage_settings')); ?></h4>
		<?php echo $__env->make('admin.generalSettings.general-setting-links.links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	</div>
</div>
				</div>

				<div class="col-md-9">
					<div class="box box-info">
                        
						<div class="box-header with-border">
							<h3 class="box-title">Bookings Settings Wizard</h3><span class="email_status" style="display: none;">(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="fees_setting" method="post" action="<?php echo e(route('admin.updateBookingSetting')); ?>" class="form-horizontal " novalidate="novalidate">
							<?php echo e(csrf_field()); ?>

							<div class="box-body">
																			

                                <div class="form-group accomodation_tax">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Total Number Of Bookings <span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                                <input type="text" name="total_number_of_bookings_per_day" class="form-control " id="total_number_of_bookings_per_day" value="<?php echo e($total_number_of_bookings_per_day->meta_value ?? ''); ?>" placeholder="Total Number of bookings">
                                                <span class="text-danger"></span>
                                        </div><span class="text">/ Day</span>
                         
                                </div>	
								
                                <div class="text-center" id="error-message"></div>
								
							</div>

							<div class="box-footer">
								<button type="submit" class="btn btn-info btn-space"><?php echo e(trans('global.save')); ?></button>
								<a class="btn btn-danger" href="<?php echo e(route('admin.settings')); ?>"><?php echo e(trans('global.cancel')); ?></a>
															</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php $__env->stopSection(); ?>
	
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/bookingsettings/bookings.blade.php ENDPATH**/ ?>