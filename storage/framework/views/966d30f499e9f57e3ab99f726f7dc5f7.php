

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/user-profile.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <?php echo $__env->make('admin.appUsers.vendor.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
 <?php
                                $currency = Config::get('general.general_default_currency') ?? '';
                            ?>
        <!-- Wallet Section -->
        <div class="driver-profile-page">
            <div class="profile-container">
                <div class="row g-3 coenr-capitalize">
                    <div class="col-md-4">
                        <div class="cardbg-1">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                <h5><?php echo e(trans('global.walletBalance')); ?></h5>
                                <div class="d-flex align-items-center justify-content-center mt-3">
                                    <img class="sweicon" src="<?php echo e(asset('/images/icon/cash-new.png')); ?>"
                                        alt="transaction">
                                    <h2 class="cash--title text-white"><?php echo e(formatCurrency($hostspendmoney)); ?>  <?php echo e($currency); ?></h2>
                                </div>
                            </div>
                            <div>
                                <button class="btn" id="collect_cash"
                                    type="button"><?php echo e(trans('global.payout_title')); ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row g-3">
                           

                            <div class="col-sm-6">
                                <div class="caredoane cardbg-2">
                                    <h4 class="title"><?php echo e(formatCurrency($hostpendingmoney)); ?> <?php echo e($currency); ?></h4>
                                    <div class="subtitle"><?php echo e(trans('global.pendingWithdraw')); ?></div>
                                    <img class="sweicon" src="<?php echo e(asset('/images/icon/cash-withdrawal.png')); ?>"
                                        alt="transaction">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="caredoane cardbg-3">
                                    <h4 class="title"><?php echo e(formatCurrency($hostrecivemoney)); ?>  <?php echo e($currency); ?></h4>
                                    <div class="subtitle"><?php echo e(trans('global.Total_withdrawal_amount')); ?></div>
                                    <img class="sweicon" src="<?php echo e(asset('/images/icon/atm.png')); ?>" alt="transaction">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="caredoane cardbg-4">
                                    <h4 class="title"><?php echo e(formatCurrency($hostrecivemoney)); ?>  <?php echo e($currency); ?></h4>
                                    <div class="subtitle"><?php echo e(trans('global.totalEarning')); ?></div>
                                    <img class="sweicon" src="<?php echo e(asset('/images/icon/atm.png')); ?>" alt="transaction">
                                </div>
                            </div>

                            <div class="col-sm-6 mt-3">
                                <div class="caredoane cardbg-6 bg-danger">
                                    <h4 class="title"><?php echo e(formatCurrency($refunded)); ?>  <?php echo e($currency); ?></h4>
                                    <div class="subtitle"><?php echo e(trans('global.totalRefund')); ?></div>
                                    <img class="sweicon" src="<?php echo e(asset('/images/icon/earning.png')); ?>"
                                        alt="transaction">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vendor Wallet Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default shadow-sm">
                    <div class="panel-heading bg-primary text-white p-3">
                        <h4 class="panel-title m-0"><?php echo e(trans('user.vendor_wallet_transaction')); ?></h4>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-striped table-hover datatable ajaxTable datatable-Payout mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(trans('global.bookingid')); ?></th>
                                        <th class="text-right"><?php echo e(trans('global.credit')); ?></th>
                                        <th class="text-right"><?php echo e(trans('global.debit')); ?></th>
                                        <th><?php echo e(trans('global.wallet_type')); ?></th>
                                        <th><?php echo e(trans('global.description')); ?></th>
                                        <th class="text-center"><?php echo e(trans('global.date')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $vendor_wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor_wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="<?php echo e($vendor_wallet->type === 'credit' ? 'table-success' : 'table-warning'); ?>">
                                            <td><?php echo e($vendor_wallet->id); ?></td>
                                            <td>
                                                <?php if($vendor_wallet->type === 'credit'): ?>
                                                    <a target="_blank" class="badge badge-pill badge-primary live-badge"
                                                        href="<?php echo e(route('admin.bookings.show', ['booking' => $vendor_wallet->booking_id])); ?>">
                                                        <i class="fas fa-database table-icon"></i>
                                                        <?php echo e($vendor_wallet->booking->token ?? '-'); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge badge-pill badge-warning live-badge">
                                                        <i class="fas fa-money-bill-wave table-icon"></i> Payout
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            
                                            <td class="text-right">
                                                <?php if($vendor_wallet->type === 'credit'): ?>
                                                    <strong><?php echo e(formatCurrency($vendor_wallet->amount)." ".$currency); ?></strong>
                                                <?php endif; ?>
                                            </td>

                                            
                                            <td class="text-right">
                                                <?php if($vendor_wallet->type !== 'credit'): ?>
                                                    <strong><?php echo e(formatCurrency($vendor_wallet->amount) ." ".$currency); ?></strong>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-capitalize"><?php echo e($vendor_wallet->type ?? '-'); ?></td>
                                            <td>
                                                <?php if($vendor_wallet->payout_id > 0): ?>
                                                    <strong>Payout ID #<?php echo e($vendor_wallet->payout_id); ?></strong><br>
                                                <?php endif; ?>
                                                <small class="text-muted"><?php echo e($vendor_wallet->description ?? '-'); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted">
                                                    <?php echo e($vendor_wallet->created_at->format('d M Y - h:i A')); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <?php echo e(trans('global.no_data_available')); ?>

                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                        </div>

                        
                        <div class="mt-3 d-flex justify-content-end">
                            <ul class="pagination">
                                
                                <li class="page-item <?php echo e($vendor_wallets->onFirstPage() ? 'disabled' : ''); ?>">
                                    <a class="page-link" href="<?php echo e($vendor_wallets->previousPageUrl()); ?>">
                                        <?php echo e(trans('global.previous')); ?>

                                    </a>
                                </li>

                                
                                <?php for($i = 1; $i <= $vendor_wallets->lastPage(); $i++): ?>
                                    <li class="page-item <?php echo e($vendor_wallets->currentPage() == $i ? 'active' : ''); ?>">
                                        <a class="page-link" href="<?php echo e($vendor_wallets->url($i)); ?>"><?php echo e($i); ?></a>
                                    </li>
                                <?php endfor; ?>

                                
                                <li class="page-item <?php echo e(!$vendor_wallets->hasMorePages() ? 'disabled' : ''); ?>">
                                    <a class="page-link" href="<?php echo e($vendor_wallets->nextPageUrl()); ?>">
                                        <?php echo e(trans('global.next')); ?>

                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/appUsers/vendor/finance.blade.php ENDPATH**/ ?>