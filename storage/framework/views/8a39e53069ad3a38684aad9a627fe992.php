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
                                        <option value="pending" <?php echo e(request()->input('status') === 'pending' ? 'selected' :
        ''); ?>>Pending
                                        </option>
                                        <option value="confirmed" <?php echo e(request()->input('status') === 'confirmed' ? 'selected'
        : ''); ?>>Confirmed
                                        </option>
                                        <option value="cancelled" <?php echo e(request()->input('status') === 'cancelled' ? 'selected'
        : ''); ?>>Cancelled
                                        </option>
                                        <option value="declined" <?php echo e(request()->input('status') === 'declined' ? 'selected' :
        ''); ?>>Declined
                                        </option>
                                        <option value="completed" <?php echo e(request()->input('status') === 'completed' ? 'selected'
        : ''); ?>>Completed
                                        </option>
                                        <option value="refunded" <?php echo e(request()->input('status') === 'refunded' ? 'selected' :
        ''); ?>>Refunded
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">

                                    <button type="submit" name="btn" class="btn btn-primary btn-flat"><?php echo e(trans('global.filter')); ?></button>
                                    <button type="button" name="reset_btn" id="resetBtn" class="btn btn-primary btn-flat"><?php echo e(trans('global.reset')); ?></button>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <?php
                            $currency = (Config::get('general.general_default_currency') ?? '');
                        ?>
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin"><?php echo e($totalBookings ?? 0); ?></h2>
                                        <p class="text-muted"><?php echo e(trans('global.total_bookings')); ?></p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin"><?php echo e(formatCurrency($totalEarnings) . ' ' . $currency); ?></h2>
                                        <p class="text-muted"><?php echo e(trans('global.totalEarning')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin"><?php echo e(formatCurrency($totalAdminCommission) . ' ' . $currency); ?>

                                        </h2>
                                        <p class="text-muted"><?php echo e(trans('global.admin_commission')); ?></p>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="clearfix visible-md-block visible-lg-block" style="margin-bottom: 15px;"></div>

                            
                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin"><?php echo e(formatCurrency($totalVendorCommission) . ' ' . $currency); ?>

                                        </h2>
                                        <p class="text-muted"><?php echo e(trans('global.vendor_commission')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin"><?php echo e(formatCurrency($totalRefunded) . ' ' . $currency); ?></h2>
                                        <p class="text-muted"><?php echo e(trans('global.refunded')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel panel-primary text-center">
                                    <div class="panel-body">
                                        <h2 class="no-margin"><?php echo e(formatCurrency($total_security_money) . ' ' . $currency); ?>

                                        </h2>
                                        <p class="text-muted"><?php echo e(trans('global.total_security')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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
                                            <?php echo e(trans('global.admin_commission')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.vendor_commission')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.iva_tax')); ?>

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
                                            <?php echo e(trans('global.action')); ?>

                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr data-entry-id="<?php echo e($booking->id); ?>">
                                                                    <td>

                                                                    </td>
                                                                    <td>
                                                                        <?php if($booking->item): ?>
                                                                            <a target="_blank" class="btn btn-xs btn-primary"
                                                                                href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>">
                                                                                <?php echo e($booking->token); ?></a>
                                                                        <?php else: ?>
                                                                            <?php echo e($booking->token); ?>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>

                                                                        <?php
                                                                            $itemData = json_decode($booking->item_data, true);
                                                                            $itemName = $itemData[0]['name'] ?? ($booking->item_title ?? '');
                                                                        ?>

                                                                        <?php if($booking->item && $booking->module == 2): ?>
                                                                            <a target="_blank" href="<?php echo e(route('admin.vehicles.base', $booking->itemid)); ?>">
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
                                                                        <?php if(($booking->payment_method ?? '') === 'offline'): ?>
                                                                            💵 Cash
                                                                        <?php else: ?>
                                                                            💳 Card/Online
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo e((formatCurrency($booking->total) ?? '') . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>

                                                                    </td>

                                                                    <td>
                                                          <?php echo e((formatCurrency(optional($booking->bookingFinance)->admin_commission) ?? '0') . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>



                                                                    </td>


                                                                    <td>
                                                                  <?php echo e(formatCurrency(optional($booking->bookingFinance)->vendor_commission ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>


                                                                    </td>

                                                                    <td>
                                                                      <?php echo e(formatCurrency(optional($booking->bookingFinance)->iva_tax ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>

<br />

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
                                                                        <?php else: ?>
                                                                            <?php echo e($booking->status); ?>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if($booking->payment_status === 'paid'): ?>
                                                                            <span class="badge badge-pill label-success">paid</span>
                                                                        <?php elseif($booking->payment_status === 'notpaid'): ?>
                                                                            <span class="badge badge-pill label-danger">notpaid</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-xs btn-primary btn-flat view-details-btn"
    data-token="<?php echo e($booking->token ?? ''); ?>"
    data-token_url="<?php echo e(route('admin.bookings.show', $booking->id)); ?>"
    data-item="<?php echo e($itemName ?? ''); ?>"
    data-item_url="<?php if($booking->item && $booking->module == 2): ?><?php echo e(route('admin.vehicles.base', $booking->itemid)); ?><?php endif; ?>"
    data-host="<?php echo e($booking->host ? $booking->host->first_name . ' ' . $booking->host->last_name : '--'); ?>"
    data-host_url="<?php echo e($booking->host ? route('admin.vendor.profile', $booking->host->id) : ''); ?>"
    data-user="<?php echo e($booking->user ? $booking->user->first_name . ' ' . $booking->user->last_name : '--'); ?>"
    data-user_url="<?php echo e($booking->user ? route('admin.customer.profile', $booking->user->id) : ''); ?>"
    data-payment_method="<?php echo e(($booking->payment_method ?? '') === 'offline' ? 'Cash' : 'Card/Online'); ?>"
    data-total="<?php echo e(formatCurrency($booking->total ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-admin_commission="<?php echo e(formatCurrency(optional($booking->bookingFinance)->admin_commission ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-vendor_commission="<?php echo e(formatCurrency(optional($booking->bookingFinance)->vendor_commission ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-ivat="<?php echo e(formatCurrency(optional($booking->bookingFinance)->iva_tax ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-doorstep="<?php echo e(formatCurrency(optional($booking->bookingFinance)->doorstep_price ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-security="<?php echo e(formatCurrency(optional($booking->bookingFinance)->security_money ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-refundableAmount="<?php echo e(formatCurrency(optional($booking->bookingFinance)->refundableAmount ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-deductedAmount="<?php echo e(formatCurrency(optional($booking->bookingFinance)->deductedAmount ?? 0) . ' ' . (Config::get('general.general_default_currency') ?? '')); ?>"
    data-booking_date="<?php echo e($booking->created_at ? $booking->created_at->format('Y-m-d') : ''); ?>"
    data-status="<?php echo e(strtoupper($booking->status) ?? ''); ?>"
    data-payment_status="<?php echo e(strtoupper($booking->payment_status) ?? ''); ?>">
    View
</button>

                                                                    </td>


                                                                </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <nav aria-label="...">
                                <ul class="pagination justify-content-end">
                                    
                                    <?php if($bookings->currentPage() > 1): ?>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="<?php echo e($bookings->previousPageUrl()); ?>" tabindex="-1"><?php echo e(trans('global.previous')); ?></a>
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
                                                                    <a class="page-link" href="<?php echo e($bookings->nextPageUrl()); ?>"><?php echo e(trans('global.next')); ?></a>
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
    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="detailsModalLabel">Booking Financial Details</h4>
                </div>
                <div class="modal-body" id="detailsModalBody">
                    <!-- Details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            attachFilterResetButton('#bookingFilterForm', ['#customer', '#host', '#item', '#status',
                '#daterange-btn'
            ]);


        });

        $(document).ready(function () {



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
    <script>
        $(document).ready(function () {
            $('.view-details-btn').click(function () {
                var data = $(this).data();

                function linkedField(name, value, url) {
                    if (url) {
                        return `<tr><td><strong>${name}</strong></td><td><a href="${url}" target="_blank">${value}</a></td></tr>`;
                    } else {
                        return `<tr><td><strong>${name}</strong></td><td>${value}</td></tr>`;
                    }
                }

                var html = `
                            <div class="table-responsive">
                            <table class="table table-striped table-hover">

                                <tbody>
                                    ${linkedField('Booking ID', data.token ?? '-', data.token_url ?? '')}
                                    ${linkedField('Item Name', data.item ?? '-', data.item_url ?? '')}
                                    ${linkedField('Host', data.host ?? '-', data.host_url ?? '')}
                                    ${linkedField('User', data.user ?? '-', data.user_url ?? '')}
                                    <tr><td><strong>Payment Method</strong></td><td>${data.payment_method ?? '-'}</td></tr>
                                    <tr><td><strong>Total</strong></td><td>${data.total ?? '-'}</td></tr>
                                    <tr><td><strong>Admin Commission</strong></td><td>${data.admin_commission ?? '-'}</td></tr>
                                    <tr><td><strong>Vendor Commission</strong></td><td>${data.vendor_commission ?? '-'}</td></tr>
                                    <tr><td><strong>IVA Tax</strong></td><td>${data.ivat ?? '-'}</td></tr>
                                    <tr><td><strong>Doorstep Price</strong></td><td>${data.doorstep ?? '-'}</td></tr>
                                    <tr><td><strong>Security Money</strong></td><td>${data.security ?? '-'}</td></tr>
                                    <tr><td><strong>Booking Date</strong></td><td>${data.booking_date ?? '-'}</td></tr>
                                    <tr><td><strong>Status</strong></td><td>${data.status ?? '-'}</td></tr>
                                    <tr><td><strong>Payment Status</strong></td><td>${data.payment_status ?? '-'}</td></tr>
                                     <tr><td><strong>refundableamount</strong></td><td>${data.refundableamount ?? '-'}</td></tr>
                                      <tr><td><strong>deductedAmount</strong></td><td>${data.deductedAmount ?? '-'}</td></tr>
                                      </tbody>
                            </table>
                            </div>
                        `;

                $('#detailsModalBody').html(html);
                $('#detailsModal').modal('show');
            });
        });
    </script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/finance/index.blade.php ENDPATH**/ ?>