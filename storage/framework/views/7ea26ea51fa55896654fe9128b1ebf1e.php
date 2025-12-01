<div class="driver-header">
 <div class="title">
    <?php echo e($appUser->user_type === 'vendor' ? trans('user.user_detail') : trans('user.user_detail')); ?>

    – <?php echo e($appUser->first_name); ?> <?php echo e($appUser->last_name); ?>

</div>
    <div class="actions">
       <?php
    $navItems = [
        [
            'url' => 'admin/customer/profile/' . $appUser->id,
            'label' => trans('user.overview'),
            'class' => 'btn-green',
            'icon' => '📄', // Overview icon
        ],
       
        [
            'url' => 'admin/customer/account/' . $appUser->id,
            'label' => trans('user.account'),
            'class' => 'btn-black',
            'icon' => '📑', // Account icon
        ],
         [
            'url' => 'admin/bookings/?customer=' . $appUser->id,
            'label' => trans('user.bookings'),
            'class' => 'btn-green',
            'icon' => '🗓️', // Bookings icon
            'target_blank' => true,
        ]
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
</div><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/appUsers/user/menu.blade.php ENDPATH**/ ?>