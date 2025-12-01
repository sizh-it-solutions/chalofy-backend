<div class="driver-header">
    <div class="title">
        <?php echo e(trans('user.vendor_detail')); ?>

        – <?php echo e($appUser->first_name); ?> <?php echo e($appUser->last_name); ?>

    </div>
    <div class="actions">
    <?php
    $navItems = [
        [
            'url' => 'admin/vendor/profile/' . $appUser->id,
            'label' => trans('user.overview'),
            'class' => 'btn-green',
            'icon' => '📄',
        ],
        [
            'url' => 'admin/vendor/financial/' . $appUser->id,
            'label' => trans('user.financial'),
            'class' => 'btn-green',
            'icon' => '💰',
        ],
        [
            'url' => 'admin/payouts/?vendor=' . $appUser->id,
            'label' => trans('user.payouts'),
            'class' => 'btn-gray',
            'icon' => '🔔',
            'target_blank' => true,
        ],
        [
            'url' => 'admin/vendor/account/' . $appUser->id,
            'label' => trans('user.account_document'),
            'class' => 'btn-black',
            'icon' => '📑',
        ],
        [
            'url' => 'admin/vehicles?vendor=' . $appUser->id,
            'label' => trans('user.vehicles'),
            'class' => 'btn-blue',
            'icon' => '🚗',
            'target_blank' => true,
        ],
        [
            'url' => 'admin/bookings?host=' . $appUser->id,
            'label' => trans('user.bookings'),
            'class' => 'btn-blue',
            'icon' => '🗓️',
            'target_blank' => true,
        ],
    ];
?>

<?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $isActive = request()->is($item['url']) ? 'active' : '';
    ?>
    <a href="<?php echo e(url($item['url'])); ?>"
       class="btn <?php echo e($item['class']); ?> <?php echo e($isActive); ?>"
       <?php if(!empty($item['target_blank'])): ?> target="_blank" <?php endif; ?>>
        <?php if(!empty($item['icon'])): ?>
            <?php echo e($item['icon']); ?>

        <?php endif; ?>
        <?php echo e($item['label']); ?>

    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



    </div>
</div><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/appUsers/vendor/menu.blade.php ENDPATH**/ ?>