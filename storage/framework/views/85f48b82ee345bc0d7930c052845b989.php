<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($viewGate)): ?>
    <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.' . $crudRoutePart . '.show', $row->id)); ?>">
    <i class="fa fa-eye" aria-hidden="true"></i>
    </a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($editGate)): ?>
    <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.' . $crudRoutePart . '.edit', $row->id)); ?>">
    <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($deleteGate)): ?>
<button type="button" class="btn btn-xs btn-danger" title="<?php echo e(trans('global.delete')); ?>" onclick="confirmDelete(<?php echo e($row->id); ?>)">
    <i class="fa fa-trash"></i>
</button>

<form id="delete-form-<?php echo e($row->id); ?>" action="<?php echo e(route('admin.' . $crudRoutePart . '.destroy', $row->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');" style="display: inline-block;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>

</form>

<?php endif; ?>


<?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/partials/datatablesActions.blade.php ENDPATH**/ ?>