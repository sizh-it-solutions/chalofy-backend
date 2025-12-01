<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payout_create')): ?>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="<?php echo e(route('admin.payouts.create')); ?>">
                        <?php echo e(trans('payout.add')); ?> <?php echo e(trans('payout.payout_title_singular')); ?>

                    </a>
                </div>
            </div>
        <?php endif; ?> <?php
            $currency = Config::get('general.general_default_currency');
        ?>
        <div class="box">
            <div class="box-body">
                <form class="form-horizontal" enctype="multipart/form-data" action="" method="GET" accept-charset="UTF-8"
                    id="filterForm">

                    <div class="col-md-12 d-none">
                        <input class="form-control" type="hidden" id="startDate" name="from" value="">
                        <input class="form-control" type="hidden" id="endDate" name="to" value="">
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label> <?php echo e(trans('payout.date_range')); ?></label>
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control" autocomplete="off" id="daterange-btn">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label> <?php echo e(trans('payout.status')); ?> </label>
                                <select class="form-control" name="status" id="status">
                                    <option value=""><?php echo e(trans('payout.all')); ?></option>
                                    <?php $__currentLoopData = ['Success' => 'Success', 'Pending' => 'Requested', 'Rejected' => 'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e(request('status') == $key ? 'selected' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label><?php echo e(trans('payout.vendor_name')); ?></label>
                                <select class="form-control select2" name="vendor" data-vendor-id="<?php echo e($vendorId); ?>"
                                    data-vendor-name="<?php echo e($vendorName); ?>" id="payoutDriver">
                                    <option value=""><?php echo e($vendorName); ?></option>
                                </select>
                            </div>

                            <div class="col-md-2 col-sm-2 col-xs-4 mt-5">
                                <br>
                                <button type="button" name="btn" class="btn btn-primary btn-flat"
                                    id="filterBtn"><?php echo e(trans('payout.filter')); ?></button>

                                <button type="button" id='resetBtn'
                                    class="btn btn-primary btn-flat"><?php echo e(trans('payout.reset')); ?></button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-info">
                            <div class="panel-body text-center">
                                <h4><?php echo e(trans('payout.total_payouts')); ?></h4>
                                <span class="text-20"><?php echo e($summary['total_payouts']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-success">
                            <div class="panel-body text-center">
                                <h4><?php echo e(trans('payout.total_amount')); ?></h4>
                                <span class="text-20"><?php echo e(formatCurrency($summary['total_amount']) . ' ' . $currency); ?>

                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-warning">
                            <div class="panel-body text-center">
                                <h4><?php echo e(trans('payout.pending_amount')); ?></h4>
                                <span
                                    class="text-20"><?php echo e(formatCurrency($summary['pending_amount']) . ' ' . $currency); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-primary">
                            <div class="panel-body text-center">
                                <h4><?php echo e(trans('payout.success_amount')); ?></h4>
                                <span class="text-20"><?php echo e(formatCurrency($summary['success_amount']) . ' ' . $currency); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 6px;" class="row">
            <div class="col-lg-12">
                <?php $statuses = ['' => 'all', 'Success' => 'Success', 'Pending' => 'Requested', 'Rejected' => 'Rejected']; ?>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="btn <?php echo e(request('status') === $value || ($value === '' && !request()->has('status')) ? 'btn-primary' : 'btn-inactive'); ?>"
                        href="<?php echo e(route('admin.payouts.index', array_merge(request()->except('btn', 'page'), ['status' => $value ?: null]))); ?>">
                        <?php echo e(trans("payout." . strtolower($label))); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo e(trans('payout.payout_title_singular')); ?> <?php echo e(trans('payout.list')); ?>

                    </div>
                    <div class="panel-body">
                        <table
                            class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Payout table-responsive">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('payout.id')); ?></th>
                                    <th><?php echo e(trans('payout.vendor_name')); ?></th>
                                    <th><?php echo e(trans('payout.amount')); ?></th>
                                    <th><?php echo e(trans('payout.payment_method')); ?></th>
                                    <th><?php echo e(trans('payout.payout_status')); ?></th>
                                    <th><?php echo e(trans('payout.request_status')); ?></th>
                                    <th><?php echo e(trans('payout.proof')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $payouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-entry-id="<?php echo e($payout->id); ?>">
                                            <td><?php echo e($payout->id); ?></td>
                                            <td>
                                                <?php if($payout->vendor): ?>
                                                    <a href="<?php echo e(route('admin.vendor.profile', $payout->vendor->id)); ?>" target="_blank">
                                                        <?php echo e($payout->vendor->first_name ?? ''); ?> <?php echo e($payout->vendor->last_name ?? ''); ?>

                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e(formatCurrency($payout->amount)); ?> <?php echo e($currency); ?> </td>
                                            <td>
                                                <?php if(!empty($payout->payment_method)): ?>
                                                    <span class="badge badge-info">
                                                        <?php echo e($payout->payment_method); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">
                                                        <?php echo e(trans('payout.manual_payment')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </td>


                                            <td>
                                    <?php
                                        $status = $payout->payout_status;
                                        $badgeClass = match ($status) {
                                            'Pending' => 'label-danger',
                                            'Rejected' => 'label-rejected',
                                            'Success' => 'label-success',
                                            default => 'label-default',
                                        };

                                        $icon = match ($status) {
                                            'Pending' => 'fa-clock',      // pending
                                            'Rejected' => 'fa-times-circle', // rejected
                                            'Success' => 'fa-check-circle',  // success
                                            default => 'fa-info-circle',
                                        };
                                    ?>

                                                <span class="badge badge-pill <?php echo e($badgeClass); ?>">
                                                    <i class="fa <?php echo e($icon); ?>"></i> <?php echo e($status); ?>

                                                </span>
                                            </td>


                                            <td>
                                                <?php if($payout->payout_status === 'Pending'): ?>
                                                    <div class="mb-1">
                                                        <a class="badge badge-pill label-success open-payout-modal animate__animated animate__pulse animate__infinite animate__slow d-inline-block w-100"
                                                            href="#" data-payout-id="<?php echo e($payout->id); ?>"
                                                            data-amount="<?php echo e($payout->amount); ?>"
                                                            data-vendor="<?php echo e($payout->vendor->first_name ?? ''); ?> <?php echo e($payout->vendor->last_name ?? ''); ?>">
                                                            <i class="fas fa-check"></i> <?php echo e(trans('payout.approve')); ?>

                                                        </a>
                                                        &nbsp; &nbsp;
                                                        <a class="badge badge-pill label-rejected payout-reject animate__animated animate__pulse animate__infinite animate__slow d-inline-block w-100"
                                                            href="#" data-payout-id="<?php echo e($payout->id); ?>"
                                                            data-amount="<?php echo e($payout->amount); ?>"
                                                            data-vendor="<?php echo e($payout->vendor->first_name ?? ''); ?> <?php echo e($payout->vendor->last_name ?? ''); ?>">
                                                            <i class="fas fa-times"></i> <?php echo e(trans('payout.reject')); ?>

                                                        </a>
                                                    </div>
                                                <?php elseif($payout->payout_status === 'Success'): ?>
                                                    <span class="badge badge-pill label-success disabled-span d-inline-block w-100">
                                                        <i class="fas fa-check-circle"></i> <?php echo e(trans('payout.success')); ?>

                                                    </span>
                                                <?php elseif($payout->payout_status === 'Rejected'): ?>
                                                    <span class="badge badge-pill label-rejected disabled-span d-inline-block w-100">
                                                        <i class="fas fa-times-circle"></i> <?php echo e(trans('payout.rejected')); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-pill label-default disabled-span d-inline-block w-100">
                                                        <i class="fas fa-info-circle"></i> <?php echo e(trans('global.done')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if($payout->payout_proof): ?>
                                                    <a href="<?php echo e($payout->payout_proof->url); ?>" target="_blank">
                                                        <i class="fas fa-file-alt text-success"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <i class="fas fa-times-circle text-danger" title="No Proof"></i>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                <?php if($payouts->currentPage() > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($payouts->previousPageUrl()); ?>"
                                            tabindex="-1"><?php echo e(trans('payout.previous')); ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><?php echo e(trans('payout.previous')); ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php for($i = 1; $i <= $payouts->lastPage(); $i++): ?>
                                    <li class="page-item <?php echo e($i == $payouts->currentPage() ? 'active' : ''); ?>">
                                        <a class="page-link" href="<?php echo e($payouts->url($i)); ?>"><?php echo e($i); ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if($payouts->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($payouts->nextPageUrl()); ?>"><?php echo e(trans('payout.next')); ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><?php echo e(trans('payout.next')); ?></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="rejectForm" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="payout_id" id="modalPayoutId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Payout</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Vendor:</strong> <span id="vendorName"></span></p>
                        <p><strong>Amount:</strong> <span id="vendorAmount"></span></p>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea name="reason" class="form-control" id="rejectReason" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="payoutModal" tabindex="-1" role="dialog" aria-labelledby="payoutModalLabel">
        <div class="modal-dialog" role="document">
            <form id="payoutForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="payout_id" id="modalPayoutId">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="payoutModalLabel">Release Funds</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>Vendor:</strong></label>
                            <p class="form-control-static" id="modalVendor"></p>
                        </div>

                        <div class="form-group">
                            <label><strong>Amount:</strong></label>
                            <p class="form-control-static" id="modalAmount"></p>
                        </div>

                        <div class="form-group">
                            <label for="payoutProof">Upload Payout Proof <span class="text-danger">*</span></label>
                            <input type="file" name="payout_proof" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="payoutNote">Notes</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit & Release</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div id="loader"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; text-align:center;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%)">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>

    <script>$(document).ready(function () {
            attachAjaxSelect(
                '#payoutDriver',
                '<?php echo e(route('admin.searchcustomer')); ?>',
                item => ({
                    id: item.id,
                    text: item.first_name
                }),
                <?php echo json_encode(isset($vendorId) ? ['id' => $vendorId, 'text' => $vendorName] : null, 512) ?>, {
                data_type: 'vendor'
            }
            );

        });

        var payoutUpdateStatus = "<?php echo e(route("admin.payouts.updateStatus", ":payoutId")); ?>";
        var payoutReject = "<?php echo e(route('admin.payout.reject')); ?>";



    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/payouts/index.blade.php ENDPATH**/ ?>