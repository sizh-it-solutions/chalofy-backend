<?php $__env->startSection('content'); ?>
<?php
    $i = 0;
    $j = 0;
  $title = 'vehicle';
?>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.create')); ?> <?php echo e(trans('global.' . $title . '_title_singular')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route('admin.' . $realRoute . '.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <?php $__currentLoopData = $supportedLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $localeName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border p-2 mb-2 rounded bg-light">
                                <!-- <h5><?php echo e($localeName); ?> (<?php echo e($localeCode); ?>)</h5> -->

                                
                                <div class="form-group <?php echo e($errors->has('title.'.$localeCode) ? 'has-error' : ''); ?>">
                                    <label class="required" for="title_<?php echo e($localeCode); ?>"><?php echo e(trans('global.title')); ?> </label>
                                    <input class="form-control" type="text" name="title[<?php echo e($localeCode); ?>]" id="title_<?php echo e($localeCode); ?>"
                                           value="<?php echo e(old('title.'.$localeCode, '')); ?>" required>
                                    <?php if($errors->has('title.'.$localeCode)): ?>
                                        <span class="help-block" role="alert"><?php echo e($errors->first('title.'.$localeCode)); ?></span>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="form-group <?php echo e($errors->has('description.'.$localeCode) ? 'has-error' : ''); ?>">
                                    <label for="description_<?php echo e($localeCode); ?>"><?php echo e(trans('global.description')); ?></label>
                                    <textarea class="form-control" name="description[<?php echo e($localeCode); ?>]" id="description_<?php echo e($localeCode); ?>"><?php echo e(old('description.'.$localeCode)); ?></textarea>
                                    <?php if($errors->has('description.'.$localeCode)): ?>
                                        <span class="help-block" role="alert"><?php echo e($errors->first('description.'.$localeCode)); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        <div class="form-group <?php echo e($errors->has('userid_id') ? 'has-error' : ''); ?>">
                            <label for="userid_id"><?php echo e(trans('global.vendor')); ?></label>
                            <select class="form-control select2" name="userid_id" id="userid_id" required>
                                <?php $__currentLoopData = $userids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(old('userid_id') == $id ? 'selected' : ''); ?>><?php echo e($entry); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('userid_id')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('userid_id')); ?></span>
                            <?php endif; ?>
                        </div>

                        
                        <div class="form-group <?php echo e($errors->has('place_id') ? 'has-error' : ''); ?>">
                            <label class="required" for="place_id"><?php echo e(trans('global.place')); ?></label>
                            <select class="form-control select2" name="place_id" id="place_id" required>
                                <?php $__currentLoopData = $places; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(old('place_id') == $id ? 'selected' : ''); ?>><?php echo e($entry); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('place_id')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('place_id')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                <?php echo e(trans('global.save')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.multipleaddselect').select2({
            tags: true
        });

        const selectedAmenities = <?php echo json_encode(old('features_id', [])); ?>;
        $('.multipleaddselect').val(selectedAmenities).trigger('change');
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/create.blade.php ENDPATH**/ ?>