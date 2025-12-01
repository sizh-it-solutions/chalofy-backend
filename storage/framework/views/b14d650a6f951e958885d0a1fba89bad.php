<div style="margin-left: 5px;" class="row">
    <div class="col-lg-12">

        <a class="<?php echo e(!request()->has('status') || request()->query('status') === '' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
            href="<?php echo e(route('admin.ticket.index')); ?>">
            All
            <?php if($statusCounts['all'] > 0): ?>
            <span class="badge badge-light"><?php echo e($statusCounts['all']); ?></span>
            <?php else: ?>
            <span class="badge badge-light">0</span>
            <?php endif; ?>
        </a>

        <!-- Open (status = 1) -->
        <a class="<?php echo e(request()->query('status') == '1' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
            href="<?php echo e(route('admin.ticket.index', ['status' => 1])); ?>">
            Open <?php if($statusCounts['open'] > 0): ?>
            <span class="badge badge-light"><?php echo e($statusCounts['open']); ?></span>
            <?php else: ?>
            <span class="badge badge-light">0</span>
            <?php endif; ?>
        </a>

        <!-- Closed (status = 0) -->
        <a class="<?php echo e(request()->query('status') == '0' ? 'btn btn-primary' : 'btn btn-inactive'); ?>"
            href="<?php echo e(route('admin.ticket.index', ['status' => 0])); ?>">
            Closed <?php if($statusCounts['closed'] > 0): ?>
            <span class="badge badge-light"><?php echo e($statusCounts['closed']); ?></span>
            <?php else: ?>
            <span class="badge badge-light">0</span>
            <?php endif; ?>
        </a>
    </div>
</div><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/ticket/liveTrashSwitcher.blade.php ENDPATH**/ ?>