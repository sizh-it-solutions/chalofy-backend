<?php $__env->startSection('content'); ?>
    <?php
        $i = 0;
        $j = 0;
    ?>
    <div class="content">
        <div class="row">

            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <form class="form-horizontal" enctype="multipart/form-data" action="" method="GET"
                            accept-charset="UTF-8" id="bookingFilterForm">

                            <div class="col-md-12 d-none">
                                <input class="form-control" type="hidden" id="startDate" name="from" value="">
                                <input class="form-control" type="hidden" id="endDate" name="to" value="">
                            </div>


                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label><?php echo e(trans('global.date_range')); ?></label>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control" id="daterange-btn" autocomplete="off">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label><?php echo e($currentModule->name); ?> Name</label>
                                    <select class="form-control select2" name="item" id="item">
                                        <option value=""><?php echo e($searchfieldItem); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label> <?php echo e(trans('global.customer')); ?> </label>
                                    <select class="form-control select2" name="customer" id="customer">
                                        <option value=""><?php echo e($searchCustomer); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label> <?php echo e(trans('global.host')); ?> </label>
                                    <select class="form-control select2" name="host" id="host">
                                        <option value=""><?php echo e($vendorName); ?></option>
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label><?php echo e(trans('global.status')); ?></label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">Please Select Status </option>
                                        <option value="pending" <?php echo e(request()->input('status') === 'pending' ? 'selected' : ''); ?>>Pending
                                        </option>
                                        <option value="confirmed"
                                            <?php echo e(request()->input('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmed
                                        </option>
                                        <option value="cancelled"
                                            <?php echo e(request()->input('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled
                                        </option>
                                        <option value="declined"
                                            <?php echo e(request()->input('status') === 'declined' ? 'selected' : ''); ?>>Declined
                                        </option>
                                        <option value="completed"
                                            <?php echo e(request()->input('status') === 'completed' ? 'selected' : ''); ?>>Completed
                                        </option>
                                        <option value="refunded"
                                            <?php echo e(request()->input('status') === 'refunded' ? 'selected' : ''); ?>>Refunded
                                        </option>
                                        <option value="live"
                                            <?php echo e(request()->input('status') === 'live' ? 'selected' : ''); ?>>Live
                                        </option>
                                        <option value="paymentFailed"
                                            <?php echo e(request()->input('status') === 'paymentFailed' ? 'selected' : ''); ?>>PaymentFailed
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">

                                    <button type="submit" name="btn"
                                        class="btn btn-primary btn-flat"><?php echo e(trans('global.filter')); ?></button>
                                    <button type="button" name="reset_btn" id="resetBtn"
                                        class="btn btn-primary btn-flat"><?php echo e(trans('global.reset')); ?></button>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span class="text-20"> <?php echo e($totalBookings); ?></span><br>
                                        <span
                                            class="font-weight-bold total-book"><?php echo e(trans('global.total_bookings')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span class="text-20"><?php echo e($totalCustomers); ?></span><br>
                                        <span
                                            class="font-weight-bold total-customer"><?php echo e(trans('global.total_customers')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span
                                            class="text-20"><?php echo e(formatCurrency($totalEarnings) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?></span><br>
                                        <span class="font-weight-bold total-amount"><?php echo e(trans('global.totalEarning')); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panelnone panel-primary">
                                    <div class="panel-body text-center">
                                        <span
                                            class="text-20"><?php echo e(formatCurrency($totalRefunded) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?></span><br>
                                        <span class="font-weight-bold total-amount"><?php echo e(trans('global.totalRefund')); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row" style="margin-left: 5px; margin-bottom: 6px;">
                <div class="col-lg-12">
                    <a class="<?php echo e(request()->routeIs('admin.bookings.index') && !request()->query('status') ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.index')); ?>">
                        <?php echo e(trans('global.live')); ?>

                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['live'] > 0 ? $statusCounts['live'] : 0); ?></span>
                    </a>

                    <a class="<?php echo e(request()->query('status') === 'pending' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.index', ['status' => 'pending'])); ?>">
                        Pending
                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['pending'] > 0 ? $statusCounts['pending'] : 0); ?></span>
                    </a>

                    <a class="<?php echo e(request()->query('status') === 'confirmed' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.index', ['status' => 'confirmed'])); ?>">
                        Confirmed
                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['confirmed'] > 0 ? $statusCounts['confirmed'] : 0); ?></span>
                    </a>

                    <a class="<?php echo e(request()->query('status') === 'cancelled' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.index', ['status' => 'cancelled'])); ?>">
                        Cancelled
                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['cancelled'] > 0 ? $statusCounts['cancelled'] : 0); ?></span>
                    </a>

                    <a class="<?php echo e(request()->query('status') === 'declined' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.index', ['status' => 'declined'])); ?>">
                        Declined
                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['declined'] > 0 ? $statusCounts['declined'] : 0); ?></span>
                    </a>

                    <a class="<?php echo e(request()->query('status') === 'completed' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.index', ['status' => 'completed'])); ?>">
                        Completed
                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['completed'] > 0 ? $statusCounts['completed'] : 0); ?></span>
                    </a>

                    <a class="<?php echo e(request()->query('status') === 'refunded' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.index', ['status' => 'refunded'])); ?>">
                        Refunded
                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['refunded'] > 0 ? $statusCounts['refunded'] : 0); ?></span>
                    </a>


                    <a class="<?php echo e(request()->routeIs('admin.bookings.trash') ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
                        href="<?php echo e(route('admin.bookings.trash')); ?>">
                        <?php echo e(trans('global.trash')); ?>

                        <span
                            class="badge badge-pill badge-primary"><?php echo e($statusCounts['trash'] > 0 ? $statusCounts['trash'] : 0); ?></span>
                    </a>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo e(trans('global.booking_title_singular_list')); ?>

                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Booking">
                                <thead>
                                    <tr>
                                        <th width="10">

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.id')); ?>

                                        </th>
                                        <th>
                                            <?php echo e($currentModule->name); ?> <?php echo e(trans('global.name')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.host')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.user_title_singular')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.payment_method')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.total')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.booking_date')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.status')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.payment_status')); ?>

                                        </th>
                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-entry-id="<?php echo e($booking->id); ?>">
                                            <td>

                                            </td>
                                            <td>
                                                
                                                    <a target="_blank" class="btn btn-xs btn-primary"
                                                        href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>">
                                                        <?php echo e($booking->token); ?></a>
                                               
                                            </td>
                                            <td>

                                                <?php
                                                    $itemData = json_decode($booking->item_data, true);
                                                    $itemName = $itemData[0]['name'] ?? ($booking->item_title ?? '');
                                                ?>

                                                <?php if($booking->item && $booking->module == 2): ?>
                                                    <a target="_blank"
                                                        href="<?php echo e(route('admin.vehicles.base', $booking->itemid)); ?>">
                                                        <?php echo e($itemName); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <?php echo e($itemName); ?>

                                                <?php endif; ?>


                                            </td>
                                           

                                            <td>
                                                <?php if($booking->host): ?>
                                                    <a target="_blank"
                                                        href="<?php echo e(route('admin.vendor.profile', $booking->host->id)); ?>">
                                                        <?php echo e($booking->host->first_name); ?> <?php echo e($booking->host->last_name); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <span>--</span>
                                                <?php endif; ?>
                                            </td>


                                            <td>
                                                <?php if($booking->user): ?>
                                                    <a target="_blank"
                                                        href="<?php echo e(route('admin.customer.profile', $booking->user->id)); ?>">
                                                        <?php echo e($booking->user->first_name ?? ''); ?>

                                                        <?php echo e($booking->user->last_name ?? ''); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <span>--</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($booking->payment_method ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e((formatCurrency($booking->total) ?? '') . ' ' . (Config::get('general.general_default_currency')?? '')); ?>

                                            </td>
                                            <td>
                                                <?php echo e($booking->created_at ? $booking->created_at->format('Y-m-d') : ''); ?>

                                            </td>

                                            <td>
                                                <?php if($booking->status === 'Pending'): ?>
                                                    <span class="badge badge-pill label-secondary">Pending</span>
                                                <?php elseif($booking->status === 'Cancelled'): ?>
                                                    <span class="badge badge-pill label-danger">Cancelled</span>
                                                <?php elseif($booking->status === 'Approved'): ?>
                                                    <span class="badge badge-pill label-success">Approved</span>
                                                <?php elseif($booking->status === 'Declined'): ?>
                                                    <span class="badge badge-pill label-warning">Declined</span>
                                                <?php elseif($booking->status === 'Completed'): ?>
                                                    <span class="badge badge-pill label-info">Completed</span>
                                                <?php elseif($booking->status === 'Refunded'): ?>
                                                    <span class="badge badge-pill label-primary">Refunded</span>
                                                <?php elseif($booking->status === 'Confirmed'): ?>
                                                    <span class="badge badge-pill label-success">Confirmed</span>
                                                <?php elseif($booking->status === 'PaymentFailed'): ?>
                                                <span class="badge badge-pill label-danger">PaymentFailed</span>
                                                <?php elseif($booking->status === 'Live'): ?>
                                                <span class="badge badge-pill label-info">Live</span>
                                                <?php else: ?>
                                                    <?php echo e($booking->status); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($booking->payment_status === 'paid'): ?>
                                                    <span class="badge badge-pill label-success">paid</span>
                                                <?php elseif($booking->payment_status === 'notpaid'): ?>
                                                    <span class="badge badge-pill label-danger">notpaid</span>
                                                <?php elseif($booking->payment_status === 'failed'): ?>
                                                    <span class="badge badge-pill label-danger">Failed</span>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <?php if($booking->trashed()): ?>
                                                    
                                                    <form id="restore-form-<?php echo e($booking->id); ?>"
                                                        action="<?php echo e(route('admin.bookings.restore', $booking->id)); ?>"
                                                        method="POST" style="display: inline-block;">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="button" class="btn btn-xs btn-success restore-btn"
                                                            data-id="<?php echo e($booking->id); ?>">
                                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                                        </button>
                                                    </form>

                                                    
                                                    <form id="delete-form-<?php echo e($booking->id); ?>"
                                                        action="<?php echo e(route('admin.bookings.permanentDelete', $booking->id)); ?>"
                                                        method="POST" style="display: inline-block;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('POST'); ?>
                                                        <button type="button"
                                                            class="btn btn-xs btn-danger permanent-delete"
                                                            data-id="<?php echo e($booking->id); ?>">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booking_delete')): ?>
                                                        <button type="button" class="btn btn-xs btn-danger delete-new-button"
                                                            data-id="<?php echo e($booking->id); ?>">
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
                                    
                                    <?php if($bookings->currentPage() > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($bookings->previousPageUrl()); ?>"
                                                tabindex="-1"><?php echo e(trans('global.previous')); ?></a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link"><?php echo e(trans('global.previous')); ?></span>
                                        </li>
                                    <?php endif; ?>

                                    
                                    <?php for($i = 1; $i <= $bookings->lastPage(); $i++): ?>
                                        <li class="page-item <?php echo e($i == $bookings->currentPage() ? 'active' : ''); ?>">
                                            <a class="page-link" href="<?php echo e($bookings->url($i)); ?>"><?php echo e($i); ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    
                                    <?php if($bookings->hasMorePages()): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="<?php echo e($bookings->nextPageUrl()); ?>"><?php echo e(trans('global.next')); ?></a>
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
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            attachFilterResetButton('#bookingFilterForm', ['#customer', '#host', '#item', '#status',
                '#daterange-btn'
            ]);
            attachDeleteButtons('bookings', {
                title: '<?php echo e(trans('global.are_you_sure')); ?>',
                text: '<?php echo e(trans('global.delete_confirmation')); ?>',
                confirmButtonText: '<?php echo e(trans('global.yes_delete_it')); ?>',
                cancelButtonText: '<?php echo e(trans('global.cancel')); ?>',
            });

        });

        $(document).ready(function() {
            attachRestoreOrDeleteButtons('.restore-btn', {
                title: "Restore Booking",
                text: "Are you sure you want to restore this booking?",
                confirmButtonText: "Yes, restore it!",
                processingTitle: "Restoring",
                processingText: "Please wait while restoring...",
                successMessage: "Booking restored successfully!",
                errorMessage: "An error occurred while restoring the booking."
            });

            attachRestoreOrDeleteButtons('.permanent-delete', {
                title: "Delete Booking Permanently",
                text: "Are you sure you want to permanently delete this booking?",
                confirmButtonText: "Yes, delete it!",
                processingTitle: "Deleting",
                processingText: "Please wait while deleting...",
                successMessage: "Booking permanently deleted!",
                errorMessage: "An error occurred while deleting the booking."
            });

            let deleteRoute = "<?php echo e(route('admin.bookings.deleteAll')); ?>";
        if (window.location.href.indexOf('trash') !== -1) {
            deleteRoute = "<?php echo e(route('admin.bookings.deleteTrashAll')); ?>";
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


            attachAjaxSelect(
                '#host',
                '<?php echo e(route('admin.searchcustomer')); ?>',
                item => ({
                    id: item.id,
                    text: item.first_name
                }),
                <?php echo json_encode(isset($vendorId) ? ['id' => $vendorId, 'text' => $vendorName] : null, 512) ?>, {
                    data_type: 'vendor'
                }
            );

            attachAjaxSelect(
                '#customer',
                '<?php echo e(route('admin.searchcustomer')); ?>',
                item => ({
                    id: item.id,
                    text: item.first_name
                }),
                <?php echo json_encode(isset($vendorId) ? ['id' => $searchCustomerId, 'text' => $searchCustomer] : null, 512) ?>, {
                    data_type: 'user'
                }
            );

            attachAjaxSelect(
                '#item',
                '<?php echo e(route('admin.searchItem')); ?>',
                item => ({
                    id: item.id,
                    text: item.first_name
                }),
                <?php echo json_encode(isset($vendorId) ? ['id' => $searchfieldItemId, 'text' => $searchfieldItem] : null, 512) ?>, {
                    data_type: 'user'
                }
            );
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/bookings/index.blade.php ENDPATH**/ ?>