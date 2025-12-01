<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.create')); ?> <?php echo e(trans('global.permission_title_singular')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route("admin.permissions.store")); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
                            <label class="required" for="title"><?php echo e(trans('global.title')); ?></label>
                            <input class="form-control" type="text" name="title" id="title" value="<?php echo e(old('title', '')); ?>" required>
                            <?php if($errors->has('title')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('title')); ?></span>
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/permissions/create.blade.php ENDPATH**/ ?>