	
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
							<h3 class="box-title"><?php echo e(trans('global.fees_title_singular')); ?></h3><span class="email_status" style="display: none;">(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="fees_setting" method="post" action="<?php echo e(route('admin.FeesSetupadd')); ?>" class="form-horizontal " novalidate="novalidate">
							<?php echo e(csrf_field()); ?>

							<div class="box-body">
																	<!-- <div class="form-group guest_service_charge">
			<label for="inputEmail3" class="col-sm-3 control-label"><?php echo e(trans('global.guest_service_charge')); ?> <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="feesetup_guest_service_charge" class="form-control " id="guest_service_charge" value="<?php echo e($feesetup_guest_service_charge->meta_value ?? ''); ?>" placeholder="Guest service charge (%)">
		<span class="text-danger"></span>
	</div> -->
	<!-- <div class="col-sm-3">
		<small>
			 <input type="radio" id="admin" name="feesetup_guest_service_charge_get" value="admin" <?php echo e(($feesetup_guest_service_charge_get->meta_value ?? 'admin') === 'admin' ? 'checked' : ''); ?>>
        <label for="admin"><?php echo e(trans('global.admin')); ?></label>

        <input type="radio" id="vendor" name="feesetup_guest_service_charge_get" value="vendor" <?php echo e(($feesetup_guest_service_charge_get->meta_value ?? 'admin') === 'vendor' ? 'checked' : ''); ?>>
        <label for="vendor"><?php echo e(trans('global.vendor')); ?></label>
	</small>
	</div> 
</div>		-->														
	<!-- <div class="form-group iva_tax">
			<label for="inputEmail3" class="col-sm-3 control-label"><?php echo e(trans('global.iva_tax')); ?> <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="feesetup_iva_tax" class="form-control " id="iva_tax" value="<?php echo e($feesetup_iva_tax->meta_value ?? ''); ?>" placeholder="I.V.A Tax (%)">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3">
		<small><input type="radio" id="admin" name="feesetup_iva_tax_get" value="admin" <?php echo e(($feesetup_iva_tax_get->meta_value ?? 'admin') === 'admin' ? 'checked' : ''); ?>>
<label for="admin"><?php echo e(trans('global.admin')); ?></label>

<input type="radio" id="vendor" name="feesetup_iva_tax_get" value="vendor" <?php echo e(($feesetup_iva_tax_get->meta_value ?? 'vendor') === 'vendor' ? 'checked' : ''); ?>>
<label for="vendor"><?php echo e(trans('global.vendor')); ?></label>
</small>
	</div>
</div>		 -->															

<div class="form-group accomodation_tax">
			<label for="inputEmail3" class="col-sm-3 control-label"><?php echo e(trans('global.iva_tax')); ?> <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="feesetup_iva_tax" class="form-control " id="accomodation_tax" value="<?php echo e($feesetup_iva_tax->meta_value ?? ''); ?>" placeholder="Accomadation Tax (%)">
		<span class="text-danger"></span>
	</div>
	<div class="col-sm-3" style="display: none;">
		<small><input type="radio" id="admin" name="feesetup_accomodation_tax_get" value="admin" <?php echo e(($feesetup_accomodation_tax_get->meta_value ?? 'admin') === 'admin' ? 'checked' : ''); ?>>
<label for="admin"><?php echo e(trans('global.admin')); ?></label> 

 <!-- <input type="radio" id="vendor" name="feesetup_accomodation_tax_get" value="vendor" <?php echo e(($feesetup_accomodation_tax_get->meta_value ?? 'vendor') === 'vendor' ? 'checked' : ''); ?>>
<label for="vendor"><?php echo e(trans('global.vendor')); ?></label>  -->
</small>
	</div>
</div>				<div class="form-group accomodation_tax">
			<label for="inputEmail3" class="col-sm-3 control-label"><?php echo e(trans('global.admin_commission')); ?>  <span class="text-danger">*</span></label>
		<div class="col-sm-6">
		<input type="text" name="feesetup_admin_commission" class="form-control " id="admin_commission" value="<?php echo e($feesetup_admin_commission->meta_value ?? ''); ?>" placeholder="Admin Commission">
		<span class="text-danger"></span>
	</div>
	
</div>														<div class="text-center" id="error-message"></div>
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
		
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/fees/FinancialSettingsForm.blade.php ENDPATH**/ ?>