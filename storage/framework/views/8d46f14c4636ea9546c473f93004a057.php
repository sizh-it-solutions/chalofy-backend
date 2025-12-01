<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.edit')); ?> <?php echo e(trans('global.user_title_singular')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route("admin.users.update", [$user->id])); ?>" enctype="multipart/form-data">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                            <label class="required" for="name"><?php echo e(trans('global.name')); ?></label>
                            <input class="form-control" type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                            <?php if($errors->has('name')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('name')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                            <label class="required" for="email"><?php echo e(trans('global.email')); ?></label>
                            <input class="form-control" type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                            <?php if($errors->has('email')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('email')); ?></span>
                            <?php endif; ?>
                           
                        </div>
                        <div class="form-group <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                            <label class="required" for="password"><?php echo e(trans('global.password')); ?></label>
                            <input class="form-control" type="password" name="password" id="password">
                            <?php if($errors->has('password')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('password')); ?></span>
                            <?php endif; ?>
                            
                        </div>
                        <div class="form-group <?php echo e($errors->has('roles') ? 'has-error' : ''); ?>">
                            <label class="required" for="roles"><?php echo e(trans('global.role_title_singular')); ?></label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0"><?php echo e(trans('global.select_all')); ?></span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0"><?php echo e(trans('global.deselect_all')); ?></span>
                            </div>
                            <select class="form-control select2" name="roles[]" id="roles" multiple required>
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($id); ?>" <?php echo e((in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : ''); ?>><?php echo e($role); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php if($errors->has('roles')): ?>
        <span class="help-block" role="alert"><?php echo e($errors->first('roles')); ?></span>
    <?php endif; ?>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select-all').click(function () {
            $('#roles option').prop('selected', true);
            $('.select2').trigger('change');
        });

        $('.deselect-all').click(function () {
            $('#roles option').prop('selected', false);
            $('.select2').trigger('change');
        });

        $('.select2').select2();
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/users/edit.blade.php ENDPATH**/ ?>