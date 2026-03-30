<?php $i = 0;
$j = 0; ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_create')): ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<?php echo e($userType === 'vendor' 
           ? route('admin.app-vendors.create') 
           : route('admin.app-users.create')); ?>">
                <?php echo e(trans('global.add')); ?>

                <?php echo e($userType === 'vendor' ? trans('global.vendor') : trans('global.appUser_title_singular')); ?>

            </a>
        </div>
    </div>
    <?php endif; ?>
    <div class="box">
        <div class="box-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="" method="GET" accept-charset="UTF-8"
                id="appusersFilterForm">

                <div class="col-md-12 d-none">
                    <input class="form-control" type="hidden" id="startDate" name="from" value="">
                    <input class="form-control" type="hidden" id="endDate" name="to" value="">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo e(trans('global.date_range')); ?></label>
                            <div class="input-group col-xs-12">
                                <input autocomplete="off" type="text" class="form-control" id="daterange-btn">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo e(trans('global.status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="">All</option>
                                <option value="1" <?php echo e(request()->input('status') == '1' ? 'selected' : ''); ?>>Active
                                </option>
                                <option value="0" <?php echo e(request()->input('status') == '0' ? 'selected' : ''); ?>>Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label> <?php echo e($userType === 'vendor' ? trans('global.vendor') : trans('global.customer')); ?></label>
                            <select class="form-control select2"
                                data-type="<?php echo e($userType === 'vendor' ? 'vendor' :'user'); ?>" name="customer"
                                id="customer">
                                <option value=""><?php echo e($searchfield); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-4 mt-5 mt-4">
                            <button type="submit" name="btn" class="btn btn-primary btn-flat"><?php echo e(trans('global.filter')); ?></button>
                            <button type="button" id="resetBtn" class="btn btn-primary btn-flat "><?php echo e(trans('global.reset')); ?></button>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
    <div style="margin-bottom: 6px;" class="row">
        <div class="col-lg-12">
            <a class="btn <?php echo e(($userType === 'vendor' && request()->routeIs('admin.app-vendors.index') 
        || $userType !== 'vendor' && request()->routeIs('admin.app-users.index') && is_null(request()->query('status')) && !request()->has('host_status')) 
        ? 'btn-primary' : 'btn-inactive'); ?>" href="<?php echo e($userType === 'vendor' 
           ? route('admin.app-vendors.index') 
           : route('admin.app-users.index')); ?>">

                <?php echo e(trans('global.all')); ?>

                <span class="badge badge-pill badge-primary"><?php echo e($statusCounts['live'] > 0 ? $statusCounts['live'] : 0); ?></span>
            </a>
            <?php if($userType === 'user'): ?>
            <a class="btn <?php echo e(request()->query('status') === '1' && !request()->has('host_status') ? 'btn-primary' : 'btn-inactive'); ?>"
                href="<?php echo e(route('admin.app-users.index', array_merge(request()->except('host_status'), ['status' => 1]))); ?>">
                Active
                <span class="badge badge-pill badge-primary"><?php echo e($statusCounts['active'] > 0 ? $statusCounts['active'] :
                    0); ?></span>
            </a>
            <a class="btn <?php echo e(request()->query('status') === '0' && !request()->has('host_status') ? 'btn-primary' : 'btn-inactive'); ?>"
                href="<?php echo e(route('admin.app-users.index', array_merge(request()->except('host_status'), ['status' => 0]))); ?>">
                Inactive
                <span class="badge badge-pill badge-primary"><?php echo e($statusCounts['inactive'] > 0 ?
                    $statusCounts['inactive'] : 0); ?></span>
            </a>
            <?php endif; ?>

            <?php if($userType === 'vendor'): ?>
            <a class="btn <?php echo e(request()->query('host_status') === '1' ? 'btn-primary' : 'btn-inactive'); ?>"
                href="<?php echo e(route('admin.app-vendors.index', array_merge(request()->except('status'), ['host_status' => 1]))); ?>">
                Verified
                <span class="badge badge-pill badge-primary"><?php echo e($statusCounts['verified'] > 0 ?
                    $statusCounts['verified'] : 0); ?></span>
            </a>
            <a class="btn <?php echo e(request()->query('host_status') === '2' ? 'btn-primary' : 'btn-inactive'); ?>"
                href="<?php echo e(route('admin.app-vendors.index', array_merge(request()->except('status'), ['host_status' => 2]))); ?>">
                Requested
                <span class="badge badge-pill badge-primary"><?php echo e($statusCounts['requested'] > 0 ?
                    $statusCounts['requested'] : 0); ?></span>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div id="loader" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php if($userType === 'vendor'): ?>
            <?php echo e(trans('global.vendor')); ?>

            <?php else: ?>
            <?php echo e(trans('global.appUser_title')); ?>

            <?php endif; ?> <?php echo e(trans('global.list')); ?>

        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-AppUser">
                    <thead>
                        <tr>
                            <th></th>

                            <th>
                                <?php echo e(trans('global.id')); ?>

                            </th>
                            <th>
                                <?php echo e(trans('global.first_name')); ?>

                            </th>
                            <?php if($userType === 'vendor'): ?>
                            <th>
                                <?php echo e(trans('global.vehicles')); ?>

                            </th>
                            <?php endif; ?>
                            <th>
                                <?php echo e(trans('global.email_verify')); ?>

                            </th>
                            <th>
                                <?php echo e(trans('global.phone_verify')); ?>

                            </th>

                            <th>
                                <?php echo e(trans('global.status')); ?>

                            </th>
                            <?php if($userType === 'vendor'): ?>
                            <th>
                                <?php echo e(trans('global.vendor_status')); ?>

                            </th>
                            <?php endif; ?>
                            <th>
                                <?php echo e(trans('global.date')); ?>

                            </th>
                            <th>&nbsp;

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $appUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $appUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-entry-id="<?php echo e($appUser->id); ?>">
                            <td></td>
                            <?php
                            $routeName = ($userType == 'user') ? 'admin.customer.profile' : 'admin.vendor.profile';
                            ?>
                            <td>
                                <a target="_blank" class="btn btn-xs btn-primary"
                                    href="<?php echo e(route($routeName, $appUser->id)); ?>">#<?php echo e($appUser->id ?? ''); ?></a>
                            </td>
                            <td>
                                <div class="row" style="margin: 0;">

                                    <div class="col-xs-2" style="padding-right: 5px;">
                                        <?php if($appUser->profile_image): ?>
                                        <a href="<?php echo e($appUser->profile_image->getUrl()); ?>" target="_blank"
                                            style="display: inline-block">
                                            <img src="<?php echo e($appUser->profile_image->getUrl('thumb')); ?>">
                                        </a>
                                        <?php else: ?>
                                        <img src="<?php echo e(asset('images/icon/userdefault.jpg')); ?>" alt="Default Image"
                                            style="display: inline-block;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-xs-10" style="padding-left:30px;">
                                        <a target="_blank" class="btn btn-xs"
                                            href="<?php echo e(route($routeName, $appUser->id)); ?>">
                                            <strong> <?php echo e($appUser->first_name ?? ''); ?> <?php echo e($appUser->last_name ?? ''); ?></strong>
                                        </a>
                                        <br>
                                        <small class="text-muted">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_contact_access')): ?>
                                            <?php echo e($appUser->email); ?>

                                            <?php else: ?>
                                            <?php echo e(maskEmail($appUser->email)); ?>

                                            <?php endif; ?>
                                            <br>
                                            <?php echo e($appUser->phone_country ?? ''); ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_contact_access')): ?>

                                            <?php echo e($appUser->phone ?? ''); ?>

                                            <?php else: ?>
                                            <?php echo e($appUser->phone ? substr($appUser->phone, 0, -6) . str_repeat('*', 6) :
                                            ''); ?>

                                            <?php endif; ?>

                                        </small>
                                    </div>
                                </div>



                            </td>
                            <?php if($userType === 'vendor'): ?>
                            <td>
                                <?php echo e($appUser->items ? $appUser->items->count() : 0); ?>

                            </td>
                            <?php endif; ?>
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    <input data-id="<?php echo e($appUser->id); ?>" class="check email_verify" type="checkbox"
                                        data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($appUser->email_verify ?
                                    'checked' : ''); ?>>
                                    <label for="<?php echo e('user' . $j++); ?>" class="checktoggle">checkbox</label>

                                </div>
                            </td>
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    <input data-id="<?php echo e($appUser->id); ?>" class="check phone_verify" type="checkbox"
                                        data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($appUser->phone_verify ?
                                    'checked' : ''); ?>>
                                    <label for="<?php echo e('user' . $j++); ?>" class="checktoggle">checkbox</label>
                                </div>
                            </td>
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    <input data-id="<?php echo e($appUser->id); ?>" class="check statusdata" type="checkbox"
                                        data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($appUser->status ?
                                    'checked' : ''); ?>>
                                    <label for="<?php echo e('user' . $j++); ?>" class="checktoggle">checkbox</label>
                                </div>

                            </td>
                            
                            <?php if($userType === 'vendor'): ?>
                            <td>
                                <div class="status-toggle d-flex justify-content-between align-items-center">
                                    <?php if(
                                    $appUser->metadata->contains(function ($meta) {
                                    return $meta->meta_key === 'host_form_data';
                                    })
                                    ): ?>
                                    <a target="_blank" class="btn btn-xs btn-primary"
                                    href="<?php echo e(route('admin.vendor.account', $appUser->id)); ?>">  <i class="fa fa-file view-details" data-id="<?php echo e($appUser->id); ?>"
                                        style="cursor: pointer;" title="View Details"></i></a>
                                    <?php endif; ?>
                                    <?php if($appUser->host_status == 2): ?>

                                    <span class="requested-label">Requested</span>

                                    <input data-id="<?php echo e($appUser->id); ?>" class="check hoststatusdata" type="checkbox"
                                        data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive">
                                    <?php else: ?>
                                    <input data-id="<?php echo e($appUser->id); ?>" class="check hoststatusdata" type="checkbox"
                                        data-onstyle="success" id="<?php echo e('user' . $i++); ?>" data-offstyle="danger"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($appUser->host_status ? 'checked' : ''); ?>>
                                    <?php endif; ?>
                                    <label for="<?php echo e('user' . $j++); ?>" class="checktoggle">checkbox</label>
                                </div>
                            </td>
                            <?php endif; ?>

                            <td><?php echo e($appUser->created_at ? $appUser->created_at->format('F j, Y g:i A') : ''); ?></td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_show')): ?>
                                <a class="btn btn-xs btn-primary" target="_blank"
                                    href="<?php echo e(route($routeName, $appUser->id)); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_edit')): ?>
                                <a class="btn btn-xs btn-info" target="_blank"
                                    href="<?php echo e(route($routeName, $appUser->id)); ?>">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('app_user_delete')): ?>
                                <button type="button" class="btn btn-xs btn-danger delete-new-button"
                                    data-id="<?php echo e($appUser->id); ?>">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                                <?php endif; ?>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <nav aria-label="...">
                    <ul class="pagination justify-content-end">
                        <?php if($appUsers->currentPage() > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($appUsers->previousPageUrl()); ?>" tabindex="-1"><?php echo e(trans('global.previous')); ?></a>
                        </li>
                        <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link"><?php echo e(trans('global.previous')); ?></span>
                        </li>
                        <?php endif; ?>
                        <?php for($i = 1; $i <= $appUsers->lastPage(); $i++): ?>
                            <li class="page-item <?php echo e($i == $appUsers->currentPage() ? 'active' : ''); ?>">
                                <a class="page-link" href="<?php echo e($appUsers->url($i)); ?>"><?php echo e($i); ?></a>
                            </li>
                            <?php endfor; ?>
                            <?php if($appUsers->hasMorePages()): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo e($appUsers->nextPageUrl()); ?>"><?php echo e(trans('global.next')); ?></a>
                            </li>
                            <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link"><?php echo e(trans('global.next')); ?></span>
                            </li>
                            <?php endif; ?>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Host Request Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="modal-table">
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>

    $(document).ready(function () {

        attachDeleteButtons('app-users', {
            title: '<?php echo e(trans('global.are_you_sure')); ?>',
            text: '<?php echo e(trans('global.delete_confirmation')); ?>',
            confirmButtonText: '<?php echo e(trans('global.yes_delete_it')); ?>',
            cancelButtonText: '<?php echo e(trans('global.cancel')); ?>',
        });

        let deleteRoute = "<?php echo e(route('admin.app-users.deleteAll')); ?>";

        attachBulkDeleteButton({
            datatableSelector: '.datatable-AppUser:not(.ajaxTable)',
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

        let dataType = $('#customer').attr('data-type');
        attachAjaxSelect(
            '#customer',
            '<?php echo e(route("admin.searchcustomer")); ?>',
            item => ({ id: item.id, text: item.name }),
            <?php echo json_encode(isset($searchfieldId) ? ['id' => $searchfieldId, 'text' => $searchfield] : null, 512) ?>, {
            data_type: dataType
        }
        );
    });


    handleToggleUpdate(
        '.statusdata',
        '/admin/update-appuser-status',
        'status',
        {
            title: '<?php echo e(trans("global.are_you_sure")); ?>',
            text: '<?php echo e(trans("global.change_status_confirmation")); ?>',
            confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
            cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
        }
    );

    handleToggleUpdate(
        '.identify',
        '/admin/update-appuser-identify',
        'verified',
        {
            title: '<?php echo e(trans("global.are_you_sure")); ?>',
            text: '<?php echo e(trans("global.change_status_confirmation")); ?>',
            confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
            cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
        }
    );

    handleToggleUpdate(
        '.phone_verify',
        '/admin/update-appuser-phoneverify',
        'phone_verify',
        {
            title: '<?php echo e(trans("global.are_you_sure")); ?>',
            text: '<?php echo e(trans("global.change_status_confirmation")); ?>',
            confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
            cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
        }
    );

    handleToggleUpdate(
        '.email_verify',
        '/admin/update-appuser-emailverify',
        'email_verify',
        {
            title: '<?php echo e(trans("global.are_you_sure")); ?>',
            text: '<?php echo e(trans("global.change_status_confirmation")); ?>',
            confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
            cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
        }
    );

    handleToggleUpdate(
        '.hoststatusdata',
        '/admin/update-appuser-host-status',
        'status',
        {
            title: '<?php echo e(trans("global.are_you_sure")); ?>',
            text: '<?php echo e(trans("global.change_status_confirmation")); ?>',
            confirmButtonText: '<?php echo e(trans("global.yes_continue")); ?>',
            cancelButtonText: '<?php echo e(trans("global.cancel")); ?>'
        }
    );


    attachFilterResetButton('#appusersFilterForm', ['#status',
        '#daterange-btn'
    ]);




</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\chalofytaxi\resources\views/admin/appUsers/index.blade.php ENDPATH**/ ?>