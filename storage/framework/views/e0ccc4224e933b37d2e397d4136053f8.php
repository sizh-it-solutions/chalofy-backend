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
                    <h3 class="box-title">App Screen Settings</h3>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form id="app_screen_settings" method="post" action="<?php echo e(route('admin.updateappscreensetting')); ?>" class="form-horizontal">
                    <?php echo e(csrf_field()); ?>

                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <?php                               
                                    $checkboxes = [
                                        'item_type' => 'Item Type',
                                        'popular_region' => 'Popular Region',
                                        'near_you' => 'Near by You',
                                        'make' => 'Make',
                                        'most_viewed' => 'Most Viewed',
                                        'become_lend' => 'Become Lend',
                                        'show_distance'=>'Show Distance',
                                    ];
                                ?>

                                <?php $__currentLoopData = $checkboxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                 $reslKey = "app_" . $key;
                                ?> 

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="app_<?php echo e($key); ?>" name="settings[]" value="<?php echo e($key); ?>" <?php echo e(isset($settings[$reslKey]) && $settings[$reslKey]->meta_value === 'Active' ? 'checked' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <span class="text-danger"></span>
                            </div>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/appscreensettings/appscreensettings.blade.php ENDPATH**/ ?>