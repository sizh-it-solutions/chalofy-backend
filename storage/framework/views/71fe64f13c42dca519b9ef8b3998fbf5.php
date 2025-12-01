<?php $__env->startSection('content'); ?>

<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.my_profile')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route("profile.password.updateProfile")); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label class="required" for="name"><?php echo e(trans('global.name')); ?></label>
                            <input class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>" type="text" name="name" id="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" required>
                            <?php if($errors->has('name')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('name')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label class="required" for="title"><?php echo e(trans('global.email')); ?></label>
                            <input class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>" type="text" name="email" id="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" required>
                            <?php if($errors->has('email')): ?>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('email')); ?>

                                </div>
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
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.change_password')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route("profile.password.update")); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                            <label class="required" for="password"> <?php echo e(trans('global.newPassword')); ?></label>
                            <input class="form-control" type="password" name="password" id="password" required>
                            <?php if($errors->has('password')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('password')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label class="required" for="password_confirmation"> <?php echo e(trans('global.repeat_new_password')); ?></label>
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
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
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.delete_account')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route("profile.password.destroyProfile")); ?>" onsubmit="return prompt('<?php echo e(__('global.delete_account_warning')); ?>') == '<?php echo e(auth()->user()->email); ?>'">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                <?php echo e(trans('global.delete')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/auth/passwords/edit.blade.php ENDPATH**/ ?>