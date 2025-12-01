

<div style="margin-left: 5px;" class="row">
    <div class="col-lg-12">
    <a class="<?php echo e((request()->query('status') === 'live' && !request()->routeIs($trashRoute)) || (request()->routeIs($indexRoute) && !in_array(request()->query('status'), ['active', 'inactive', 'verified', 'featured'])) ? 'btn btn-primary' : 'btn btn-inactive'); ?>" 
           href="<?php echo e(route($indexRoute, ['status' => 'live'])); ?>">
           <?php echo e(trans('global.live')); ?> <?php if((request()->query('status') !== 'trash') && ($statusCounts['live'] > 0)): ?> <span class="badge badge-light"><?php echo e($statusCounts['live']); ?></span> <?php else: ?> <span class="badge badge-light">0</span> <?php endif; ?>
        </a>
        <a class="<?php echo e(request()->query('status') === 'active' ? 'btn btn-primary' : 'btn btn-inactive'); ?>" 
           href="<?php echo e(route($indexRoute, ['status' => 'active'])); ?>">
            Active <?php if((request()->query('status') !== 'trash') && ($statusCounts['active'] > 0)): ?> <span class="badge badge-light"><?php echo e($statusCounts['active']); ?></span> <?php else: ?> <span class="badge badge-light">0</span> <?php endif; ?>
        </a>
        <a class="<?php echo e(request()->query('status') === 'inactive' ? 'btn btn-primary' : 'btn btn-inactive'); ?>" 
           href="<?php echo e(route($indexRoute, ['status' => 'inactive'])); ?>">
            Inactive <?php if((request()->query('status') !== 'trash') && ($statusCounts['inactive'] > 0)): ?> <span class="badge badge-light"><?php echo e($statusCounts['inactive']); ?></span> <?php else: ?> <span class="badge badge-light">0</span> <?php endif; ?>
        </a>

        <a class="<?php echo e(request()->query('status') === 'verified' ? 'btn btn-primary' : 'btn btn-inactive'); ?>" 
           href="<?php echo e(route($indexRoute, ['status' => 'verified'])); ?>">
            Verified <?php if((request()->query('status') !== 'trash') && ($statusCounts['verified'] > 0)): ?> <span class="badge badge-light"><?php echo e($statusCounts['verified']); ?></span> <?php else: ?> <span class="badge badge-light">0</span> <?php endif; ?>
        </a>

        <a class="<?php echo e(request()->query('status') === 'featured' ? 'btn btn-primary' : 'btn btn-inactive'); ?>" 
           href="<?php echo e(route($indexRoute, ['status' => 'featured'])); ?>">
            Featured <?php if((request()->query('status') !== 'trash') && ($statusCounts['featured'] > 0)): ?> <span class="badge badge-light"><?php echo e($statusCounts['featured']); ?></span> <?php else: ?> <span class="badge badge-light">0</span> <?php endif; ?>
        </a>

        <a class="<?php echo e(request()->routeIs($trashRoute) ? 'btn btn-primary' : 'btn btn-inactive'); ?>" 
           href="<?php echo e(route($trashRoute)); ?>">
            Trash <?php if($statusCounts['trash'] > 0): ?> <span class="badge badge-light"><?php echo e($statusCounts['trash']); ?></span> <?php else: ?> <span class="badge badge-light">0</span> <?php endif; ?>
        </a>

    </div>
</div>
<?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/liveTrashSwitcher.blade.php ENDPATH**/ ?>