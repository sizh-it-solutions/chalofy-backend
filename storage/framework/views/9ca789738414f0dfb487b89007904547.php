<ul class="nav nav-tabs" style="display: inline-block;">
    <?php
        $currentMethod = request()->route('method');
         $methodsToShow = ['paypal', 'stripe', 'razorpay', 'cash', 'transbank', 'phonepe'];
       // $methodsToShow = ['cash', 'phonepe'];
    ?>

    <?php $__currentLoopData = $methodsToShow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $methodKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php echo e($currentMethod === $methodKey ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.payment-methods.index', $methodKey)); ?>">
                <?php echo e(trans('global.' . $methodKey)); ?>

            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/paymentmethods/paymentlinks.blade.php ENDPATH**/ ?>