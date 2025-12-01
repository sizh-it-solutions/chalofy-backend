<?php $__env->startSection('content'); ?>
    <?php
        $i = 0;
    ?>

    <section class="content">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 settings_bar_gap">
                <div class="box box-info box_info">
                    <h4 class="all_settings f-18 mt-1 ms-3"><?php echo e(trans('global.manage_settings')); ?></h4>
                    <?php echo $__env->make('admin.generalSettings.general-setting-links.links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">

                <div class="nav-tabs-custom">
                    <?php echo $__env->make('admin.generalSettings.paymentmethods.paymentlinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <div class="tab-content">
                        <div class="tab-pane active" id="banks">
                            <div class="box-body">

                                <form method="POST" action="<?php echo e(route('admin.payment-methods.update', $method)); ?>"
                                    class="form-horizontal">
                                    <?php echo csrf_field(); ?>

                                    <div class="box-body">

                                        <?php
                                            $modes = ['test', 'live'];
                                            $fields = $fields_per_method ?? [];
                                            $statusValue = $status->meta_value ?? 'Inactive';
                                            $checkboxId = 'status_toggle_' . $i++;
                                        ?>

                                        
                                        <div class="form-group">
                                            <div class="col-sm-12 text-right">

                                                <input class="check statusdata" type="checkbox" data-onstyle="success"
                                                    data-offstyle="danger" data-toggle="toggle" data-on="Active"
                                                    data-off="Inactive" id="<?php echo e($checkboxId); ?>" <?php echo e($statusValue == 'Active' ? 'checked' : ''); ?>>
                                                <label for="<?php echo e($checkboxId); ?>" class="control-label checktoggle"
                                                    style="margin-right:10px;">
                                                    <?php echo e(__('global.status')); ?>

                                                </label>


                                            </div>
                                        </div>

                                        
                                      <?php if($options_field !== null && isset($modes) && count($modes)): ?>
    
    <?php $__currentLoopData = $modes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="radio">
                    <label>
                        <input type="radio"
                               name="<?php echo e($options_field); ?>"
                               value="<?php echo e($mode); ?>"
                               id="<?php echo e($method); ?>_<?php echo e($mode); ?>"
                               <?php echo e((isset($$options_field) && $$options_field->meta_value == $mode) || (!isset($$options_field) && $mode == 'test') ? 'checked' : ''); ?>>
                        <strong><?php echo e(ucfirst($mode)); ?></strong>
                    </label>
                </div>
            </div>
        </div>

        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $key = "{$mode}_{$method}_{$field}";
                $label = $field_labels[$mode . '_' . $field] ?? ucfirst(str_replace('_', ' ', $field));
            ?>
            <div class="form-group">
                <label for="<?php echo e($key); ?>" class="col-sm-4 control-label">
                    <?php echo e($label); ?> <span class="text-danger">*</span>
                </label>
                <div class="col-sm-6">
                    <input type="password"
                           class="form-control"
                           id="<?php echo e($key); ?>"
                           name="<?php echo e($key); ?>"
                           value="<?php echo e($$key->meta_value ?? ''); ?>"
                           placeholder="<?php echo e($label); ?>">
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


                                        
                                        <div class="box-footer">
                                          
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-save"></i> <?php echo e(__('global.save')); ?>

                                                </button>
                                          
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div> <!-- /.tab-pane -->
                    </div> <!-- /.tab-content -->
                </div> <!-- /.nav-tabs-custom -->
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>

    <script>
       handleToggleUpdate(
    '.statusdata',
    "<?php echo e(url('admin/payment-methods')); ?>/<?php echo e($method); ?>/status",
    'status',
    {
        title: 'Are you sure?',
        text: 'Do you want to update the payment method status?',
        confirmButtonText: 'Yes, update',
        cancelButtonText: 'Cancel'
    }
);


    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/paymentmethods/form.blade.php ENDPATH**/ ?>