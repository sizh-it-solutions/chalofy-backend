<?php $__env->startSection('content'); ?>
<?php $i = 0;
$j = 0;
if ($title == 'vehicles')
$title = 'vehicle';
else
$title = $title;

?>
<div class="content">

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($title . '_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<?php echo e(route('admin.' . $realRoute . '.create')); ?>">
                <?php echo e(trans('global.add')); ?> <?php echo e($title); ?>

            </a>
        </div>
    </div>
    <?php endif; ?>



    <div class="row">

        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-horizontal" id="itemFilterForm" action="" method="GET" accept-charset="UTF-8">

                        <div>
                            <input class="form-control" type="hidden" id="startDate" name="from" value="">
                            <input class="form-control" type="hidden" id="endDate" name="to" value="">
                        </div>


                        <div class="row">
                            <div class="col-md-1 col-sm-12 col-xs-12">
                                <label>Type</label>
                                <select class="form-control select2" name="type" id="type">
                                    <option value=""> <?php echo e($typeName); ?> </option>

                                </select>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label><?php echo e(trans('global.date_range')); ?></label>
                                <div class="input-group col-xs-12">

                                    <input type="text" class="form-control" id="daterange-btn" autocomplete="off">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label> <?php echo e(trans('global.status')); ?></label>
                                <select class="form-control select2" name="status" id="status">
                                    <option value="">All</option>
                                    <option value="active" <?php echo e(request()->input('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                                    <option value="inactive" <?php echo e(request()->input('status') === 'inactive' ? 'selected' :
                                        ''); ?>>Inactive</option>
                                    <option value="verified" <?php echo e(request()->input('status') === 'verified' ? 'selected' :
                                        ''); ?>>Verified</option>
                                    <option value="featured" <?php echo e(request()->input('status') === 'featured' ? 'selected' :
                                        ''); ?>>Featured</option>
                                </select>

                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>Progress</label>
                                <select class="form-control select2" id="step_progress_range"
                                    name="step_progress_range">
                                    <option value="">Select a range</option>
                                    <option value="0-25" <?php echo e(request()->input('step_progress_range') == '0-25' ?
                                        'selected' : ''); ?>>0% - 25%</option>
                                    <option value="26-50" <?php echo e(request()->input('step_progress_range') == '26-50' ?
                                        'selected' : ''); ?>>26% - 50%</option>
                                    <option value="51-75" <?php echo e(request()->input('step_progress_range') == '51-75' ?
                                        'selected' : ''); ?>>51% - 75%</option>
                                    <option value="76-100" <?php echo e(request()->input('step_progress_range') == '76-100' ?
                                        'selected' : ''); ?>>76% - 100%</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label><?php echo e(trans('global.host')); ?></label>
                                <select class="form-control select2" name="vendor" id="vendor">
                                    <option value=""><?php echo e($vendorname); ?></option>

                                </select>
                            </div>


                            

                             <div class="col-md-1 col-sm-12 col-xs-12">
    <label><?php echo e($currentModule->name); ?> Name</label>
    <input 
        type="text" 
        class="form-control" 
        name="title" 
        id="title" 
        value="<?php echo e(request()->input('title', '')); ?>" 
        placeholder="Enter <?php echo e($currentModule->name); ?> Name">
</div>


                            <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">
                                <br>
                                <button type="submit" name="btn" class="btn btn-primary btn-flat filterproduct"><?php echo e(trans('global.filter')); ?></button>
                                <button type="button" id="resetBtn" class="btn btn-primary btn-flat resetproduct"><?php echo e(trans('global.reset')); ?></button>
                            </div>

                        </div>

                </div>
                </form>
            </div>

        </div>
        <?php echo $__env->make('admin.common.liveTrashSwitcher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.' . strtolower($title))); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable  datatable-Booking">
                            <thead>
                                <tr>
                                    <th>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.id')); ?>#
                                    </th>
                                    <th>
                                            <?php echo e($currentModule->name); ?> <?php echo e(trans('global.name')); ?>

                                        </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        <?php echo e(trans('global.host')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.image')); ?>

                                    </th>
                                    <th>
                                        Document
                                    </th>
                                    <th width="50">
                                        <?php echo e(trans('global.price')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.place')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.verified')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.is_featured')); ?>

                                    </th>
                                    <th>
                                        Step Progress
                                    </th>
                                    <th>
                                        <?php echo e(trans('global.status')); ?>

                                    </th>

                                    <th> <?php echo e(trans('global.actions')); ?> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-entry-id="<?php echo e($item->id); ?>">
                                    <td>
                                    </td>
                                    <td>
                                        <?php echo e($item->id ?? ''); ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.vehicles.base', ['id' => $item->id])); ?>">
                                            <?php echo e($item->title ?? ''); ?>

                                        </a>
                                    </td>
                                    <td><?php echo e($item->item_type ? $item->item_type->name : 'N/A'); ?></td>
                                    <?php
                                    $userType = $item->userid->user_type ?? 'user'; // default fallback
                                    $routeName = 'admin.vendor.profile';
                                    ?>

                                    <td>
                                        <a target="_blank"
                                            href="<?php echo e(route($routeName, $item->userid_id)); ?>?user_type=<?php echo e($userType); ?>">
                                            <?php echo e($item->userid->first_name ?? ''); ?> <?php echo e($item->userid->last_name ?? ''); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php if($item->front_image): ?>
                                        <a href="<?php echo e($item->front_image->url); ?>">
                                            <img src="<?php echo e($item->front_image->thumbnail); ?>" alt="<?php echo e($item->title); ?>"
                                                class="item-image-size">
                                        </a>

                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if($item->front_image_doc): ?>
                                        <a href="<?php echo e($item->front_image_doc->url); ?>">
                                            <img src="<?php echo e($item->front_image_doc->thumbnail); ?>" alt="<?php echo e($item->title); ?>"
                                                class="item-image-size">
                                        </a>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e(($general_default_currency->meta_value ?? '') . ' ' . ($item->price ?? '')); ?>


                                    </td>
                                    <td>
                                        <?php
                                        $parts = [];
                                        if (!empty($item->city_name)) {
                                        $parts[] = $item->city_name;
                                        }
                                        if (!empty($item->state_region)) {
                                        $parts[] = $item->state_region;
                                        }
                                        if (!empty($item->country)) {
                                        $parts[] = $item->country;
                                        }
                                        ?>

                                        <?php echo e(implode(' , ', $parts)); ?>

                                    </td>
                                    <td>


                                        <div class="status-toggle d-flex justify-content-between align-items-center">
                                            <input data-id="<?php echo e($item->id); ?>" class="check isvefifieddata" type="checkbox"
                                                data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($item->is_verified ? 'checked' : ''); ?>>
                                            <label for="<?php echo e('user' . $j++); ?>" class="checktoggle">checkbox</label>
                                        </div>
                                    </td>
                                    <td>


                                        <div class="status-toggle d-flex justify-content-between align-items-center">
                                            <input data-id="<?php echo e($item->id); ?>" class="check isfeatureddata" type="checkbox"
                                                data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($item->is_featured ? 'checked' : ''); ?>>
                                            <label for="<?php echo e('user' . $j++); ?>" class="checktoggle">checkbox</label>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $completionPercentage = $item->step_progress ?? 0;
                                        $steps = json_decode($item->steps_completed, true);
                                        if ($steps !== null && is_array($steps)) {
                                        $incompleteSteps = array_keys(array_filter($steps, function ($step) {
                                        return !$step;
                                        }));
                                        }

                                        ?>

                                        <div class="progress-circle" data-item-id="<?php echo e($item->id); ?>"
                                            data-incomplete-steps="<?php echo e(json_encode($incompleteSteps)); ?>"
                                            style="background: conic-gradient(#28c76f <?php echo e($completionPercentage); ?>%, #dd4b39 <?php echo e($completionPercentage); ?>% 100%);">
                                            <span><?php echo e(round($completionPercentage)); ?>%</span>
                                        </div>
                                    </td>
                                    <td>


                                        <div class="status-toggle d-flex justify-content-between align-items-center">
                                            <input data-id="<?php echo e($item->id); ?>" class="check statusdata" type="checkbox"
                                                data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                                data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($item->status ? 'checked' : ''); ?>>
                                            <label for="<?php echo e('user' . $j++); ?>" class="checktoggle">checkbox</label>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if($item->trashed()): ?>
                                        <form id="restore-form-<?php echo e($item->id); ?>"
                                            action="<?php echo e(route('admin.common.trash.restore', $item->id)); ?>" method="POST"
                                            style="display: inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <button type="button" class="btn btn-xs btn-success restore-btn"
                                                data-id="<?php echo e($item->id); ?>">
                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                            </button>
                                        </form>



                                        <form id="delete-form-<?php echo e($item->id); ?>"
                                            action="<?php echo e(route('admin.common.trash.permanentDelete', $item->id)); ?>"
                                            method="POST" style="display: inline-block;">
                                            <?php echo method_field('POST'); ?>
                                            <?php echo csrf_field(); ?>
                                            <button type="button" class="btn btn-xs btn-danger permanent-delete"
                                                data-id="<?php echo e($item->id); ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form> <?php else: ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($title . '_edit')): ?>
                                        <?php
                                        $base = $realRoute;
                                        ?>

                                        <a style="margin-bottom:5px;margin-top:5px" class="btn btn-xs btn-info"
                                            href="<?php echo e(route('admin.' . $base . '.base', ['id' => $item->id])); ?>">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('title_delete')): ?>
                                        <button type="button" class="btn btn-xs btn-danger delete-new-button"
                                            data-id="<?php echo e($item->id); ?>">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                <?php if($items->currentPage() > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($items->previousPageUrl()); ?>" tabindex="-1">
                                        <?php echo e(trans('global.previous')); ?></a>
                                </li>
                                <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link"> <?php echo e(trans('global.previous')); ?></span>
                                </li>
                                <?php endif; ?>
                                <?php for($i = 1; $i <= $items->lastPage(); $i++): ?>
                                    <li class="page-item <?php echo e($i == $items->currentPage() ? 'active' : ''); ?>">
                                        <a class="page-link" href="<?php echo e($items->url($i)); ?>"><?php echo e($i); ?></a>
                                    </li>
                                    <?php endfor; ?>
                                    <?php if($items->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($items->nextPageUrl()); ?>">
                                            <?php echo e(trans('global.next')); ?></a>
                                    </li>
                                    <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"> <?php echo e(trans('global.next')); ?></span>
                                    </li>
                                    <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        handleToggleUpdate(
            '.statusdata',
            '<?php echo e(route("admin.update-item-status")); ?>',
            'status',
            {
                title: '<?php echo e(trans("global.are_you_sure")); ?>',
                text: '<?php echo e(trans("global.update_status_confirmation")); ?>',
                confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
                cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
            }
        );

        handleToggleUpdate(
            '.isvefifieddata',
            '<?php echo e(route("admin.update-item-verified")); ?>',
            'isverified',
            {
                title: '<?php echo e(trans("global.are_you_sure")); ?>',
                text: '<?php echo e(trans("global.update_status_confirmation")); ?>',
                confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
                cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
            }
        );

        handleToggleUpdate(
            '.isfeatureddata',
            '<?php echo e(route("admin.update-item-featured")); ?>',
            'featured',
            {
                title: '<?php echo e(trans("global.are_you_sure")); ?>',
                text: '<?php echo e(trans("global.update_status_confirmation")); ?>',
                confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
                cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
            }
        );
        attachIncompleteStepTooltips();
        attachDeleteButtons(
            '<?php echo e($realRoute); ?>',
            {
                title: '<?php echo e(trans("global.are_you_sure")); ?>',
                text: '<?php echo e(trans("global.you_able_revert_this")); ?>',
                icon: 'warning',
                confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
                cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
            }
        );

        attachFilterResetButton('#itemFilterForm', ['#vendor', '#type']);


    });
    $(document).ready(function () {
   attachRestoreOrDeleteButtons('.restore-btn', {
                title: "Restore Vehicle",
                text: "Are you sure you want to restore this vehicle?",
                confirmButtonText: "Yes, restore it!",
                processingTitle: "Restoring",
                processingText: "Please wait while restoring...",
                successMessage: "Booking restored successfully!",
                errorMessage: "An error occurred while restoring the vehicle."
            });

            attachRestoreOrDeleteButtons('.permanent-delete', {
                title: "Delete Vehicle Permanently",
                text: "Are you sure you want to permanently delete this vehicle?",
                confirmButtonText: "Yes, delete it!",
                processingTitle: "Deleting",
                processingText: "Please wait while deleting...",
                successMessage: "Booking permanently deleted!",
                errorMessage: "An error occurred while deleting the vehicle."
            });

        attachAjaxSelect(
            '#type',
            '<?php echo e(route("admin.typeSearch")); ?>',
            item => ({ id: item.id, text: item.name }),
            <?php echo json_encode(isset($typeId) ? ['id' => $typeId, 'text' => $typeName] : null, 512) ?>
        );

        attachAjaxSelect(
            '#vendor',
            '<?php echo e(route("admin.searchcustomer")); ?>',
            item => ({ id: item.id, text: item.first_name }),
            <?php echo json_encode(isset($vendorId) ? ['id' => $vendorId, 'text' => $vendorname] : null, 512) ?>,
            { data_type: 'host' }
        );
          

        let deleteRoute = "<?php echo e(route('admin.delete.rows')); ?>";
        if (window.location.href.indexOf('trash') !== -1) {
            deleteRoute = "<?php echo e(route('admin.trash-delete.rows')); ?>";
        }
        attachBulkDeleteButton({
            datatableSelector: '.datatable-Booking:not(.ajaxTable)',
            deleteRoute: deleteRoute,
            buttonText: '<?php echo e(trans('global.delete_all')); ?>',
            buttonClass: 'btn-danger',
            swalOptions: {
                title: '<?php echo e(trans('global.are_you_sure')); ?>',
                text: '<?php echo e(trans('global.delete_confirmation')); ?>',
                confirmButtonText: '<?php echo e(trans('global.yes_delete')); ?>',
                cancelButtonText: '<?php echo e(trans('global.cancel')); ?>',
                noSelectionTitle: '<?php echo e(trans('global.no_entries_selected')); ?>',
                okButtonText: 'OK'
            }
        });

    });
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/index.blade.php ENDPATH**/ ?>