<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="row gap-2">
        <?php echo $__env->make($leftSideMenu, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="col-md-9">
            <form id="descriptionFormupdate">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($id); ?>">

                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 col-xs-12 mb-15">
                                <label class="label-large fw-bold"><?php echo e(trans('global.listing_name')); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control f-14" value="<?php echo e($itemData->title ?? ''); ?>" placeholder="" maxlength="100" required>
                                <span class="text-danger"></span>
                                <span class="error-message" id="descriptionerror-name"></span>
                            </div>

                            <div class="col-md-8 col-sm-12 col-xs-12 mb-15">
                                <label class="label-large fw-bold"><?php echo e(trans('global.summary')); ?> <span class="text-danger">*</span></label>
                                <textarea class="form-control f-14" name="summary" rows="6" placeholder="" required><?php echo e($itemData->description ?? ''); ?></textarea>
                                <span class="text-danger"></span>
                                <span class="error-message" id="descriptionerror-summary"></span>
                            </div>
                            
                            <div class="col-md-8 col-sm-12 col-xs-12 mb-15">
                                <div class="form-group <?php echo e($errors->has('userid') ? 'has-error' : ''); ?>">
                                    <label for="userid_id"><?php echo e(trans('global.userid')); ?></label>
                                    <select class="form-control select2" name="userid_id" id="userid_id" required>
                                        <?php $__currentLoopData = $userids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userid => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($userid); ?>" <?php echo e((isset($itemData->userid_id) && $itemData->userid_id == $userid) ? 'selected' : ''); ?>>
                                                <?php echo e($entry); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('userid')): ?>
                                        <span class="help-block" role="alert"><?php echo e($errors->first('userid')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php
                            $currentPath = request()->path();
                        ?>

                        <?php if(str_contains($currentPath, 'admin/bookable/description')): ?>
                            <div class="row mt-3">
                                <div class="col-md-8 col-sm-12 col-xs-12 mb20">
                                    <label class="label-large fw-bold"><?php echo e(trans('global.style_note')); ?> <span class="text-danger">*</span></label>
                                    <textarea class="form-control f-14" name="style_note" rows="6" placeholder="" required><?php echo e($styleNote->meta_value ?? ''); ?></textarea>
                                    <span class="text-danger"></span>
                                    <span class="error-message" id="descriptionerror-style_note"></span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8 col-sm-12 col-xs-12 mb20">
                                    <div class="form-group <?php echo e($errors->has('image') ? 'has-error' : ''); ?>">
                                        <label for="chrt-image"><?php echo e(trans('global.Other_image_to_upload')); ?></label>
                                        <div class="needsclick dropzone" id="chart-dropzone"></div>
                                        <?php if($errors->has('image')): ?>
                                            <span class="help-block" role="alert"><?php echo e($errors->first('image')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <br>
                        <div class="row">
                            <div class="col-6 col-lg-6 text-left">
                                <a data-prevent-default href="<?php echo e(route('admin.vehicles.base', [$id])); ?>" class="btn btn-large btn-primary f-14 backStep"><?php echo e(trans('global.back')); ?></a>
                            </div>
                            <div class="col-6 col-lg-6 text-right">
                                <button type="button" class="btn btn-large btn-primary next-section-button nextStep"><?php echo e(trans('global.next')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    $('.nextStep').click(function() {
        var id = <?php echo e($id); ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo e(route('admin.vehicles.description-Update')); ?>',
            data: $('#descriptionFormupdate').serialize(),
            success: function(data) {
                $('.error-message').text('');
                window.location.href = '<?php echo e($nextButton); ?>' + id;
            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    var errors = response.responseJSON.errors;
                    $('.error-message').text('');

                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            var errorMessage = errors[field][0];
                            $('#descriptionerror-' + field).text(errorMessage);
                        }
                    }
                }
            }
        });
    });
});
</script>

<script>
Dropzone.options.chartDropzone = {
    url: '<?php echo e(route('admin.vehicles.storeMedia')); ?>',
    maxFilesize: 2,
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
    },
    params: {
        size: 2,
        width: 4096,
        height: 4096
    },
    success: function (file, response) {
        $('form').find('input[name="chart_image"]').remove();
        $('form').append('<input type="hidden" name="chart_image" value="' + response.name + '">');
    },
    removedfile: function (file) {
        file.previewElement.remove();
        if (file.status !== 'error') {
            $('form').find('input[name="chart_image"]').remove();
            this.options.maxFiles = this.options.maxFiles + 1;
        }
    },
    init: function () {
        <?php if(isset($itemData) && $itemData->chart_image): ?>
            var file = <?php echo json_encode($itemData->chart_image); ?>

            this.options.addedfile.call(this, file);
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url);
            file.previewElement.classList.add('dz-complete');
            $('form').append('<input type="hidden" name="chart_image" value="' + file.file_name + '">');
            this.options.maxFiles = this.options.maxFiles - 1;
        <?php endif; ?>
    },
    error: function (file, response) {
        var message = $.type(response) === 'string' ? response : response.errors.file;
        file.previewElement.classList.add('dz-error');
        var nodes = file.previewElement.querySelectorAll('[data-dz-errormessage]');
        nodes.forEach(node => node.textContent = message);
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/description.blade.php ENDPATH**/ ?>