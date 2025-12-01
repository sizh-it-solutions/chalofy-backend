<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="row gap-2">

		<?php echo $__env->make($leftSideMenu, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

		<div class="col-md-9">
			<form id="featuresFormupdate">
				<?php echo csrf_field(); ?>
				<input type="hidden" name="id" value="<?php echo e($id); ?>">
				<div class="box box-info">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12  mb-15">
								<p class="fs-18">
									<?php if(Str::contains(Request::url(), '/bookable/')): ?>
										<?php echo e(trans('global.feature_title')); ?>

									<?php else: ?>
										<?php echo e(trans('global.feature_title')); ?>

									<?php endif; ?>

									<span class="text-danger">*</span>
								</p>
								<?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<input type="checkbox" name="features[]" value="<?php echo e($feature['id']); ?>" <?php echo e(in_array($feature['id'], $features_ids) ? 'checked' : ''); ?>>
									<?php echo e($feature['name']); ?><br>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<span class="text-danger" id="featureserror-features"></span>
							</div>

						</div>
						<div class="row">

							<div class="col-6  col-lg-6  text-left">
								<a data-prevent-default="" href="<?php echo e(route($backButtonRoute, [$id])); ?>"
									class="btn btn-large btn-primary f-14"><?php echo e(trans('global.back')); ?></a>
							</div>
							<div class="col-6  col-lg-6 text-right">
								<button type="button"
									class="btn btn-large btn-primary next-section-button next"><?php echo e(trans('global.next')); ?></button>

							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
	$(document).ready(function () {
		$('.next').click(function () {
			var id = <?php echo e($id); ?>;
			$.ajax({
				type: 'POST',
				url: '<?php echo e(route($updateLocationFeature)); ?>',
				data: $('#featuresFormupdate').serialize(),
				success: function (data) {
					$('.error-message').text('');
					window.location.href = '<?php echo e($nextButton); ?>' + id;
				},
				error: function (response) {
					if (response.responseJSON && response.responseJSON.errors) {
						var errors = response.responseJSON.errors;
						$('.error-message').text('');

						// Then display new error messages
						for (var field in errors) {
							if (errors.hasOwnProperty(field)) {
								var errorMessage = errors[field][
									0
								]; // get the first error message
								$('#featureserror-' + field).text(errorMessage);
							}
						}
					}
				}
			});
		});


	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/addSteps/features/features.blade.php ENDPATH**/ ?>