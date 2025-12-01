<?php $__env->startSection('content'); ?>
<div class="content">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('admin.permissions.create')); ?>">
                    <?php echo e(trans('global.add')); ?> <?php echo e(trans('global.permission_title_singular')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.permission_title_singular')); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.id')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.title')); ?>

                                    </th>
                                    <th>&nbsp;
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-entry-id="<?php echo e($permission->id); ?>">
                                        <td>

                                        </td>
                                        <td>
                                            <?php echo e($permission->id ?? ''); ?>

                                        </td>
                                        <td>
                                            <?php echo e($permission->title ?? ''); ?>

                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_show')): ?>
                                                <a class="btn btn-xs btn-primary" href="<?php echo e(route('admin.permissions.show', $permission->id)); ?>">
                                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_edit')): ?>
                                                <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.permissions.edit', $permission->id)); ?>">
                                                 <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_delete')): ?>
                                                <form action="<?php echo e(route('admin.permissions.destroy', $permission->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(trans('global.areYouSure')); ?>');" style="display: inline-block;">
                                                  
                                                 <?php echo csrf_field(); ?>
                                                 <button type="button" class="btn btn-xs btn-danger delete-button" data-id="<?php echo e($permission->id); ?>">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                </form>
                                            <?php endif; ?>

                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission_delete')): ?>
  let deleteButtonTrans = '<?php echo e(trans('global.delete')); ?>'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "<?php echo e(route('admin.permissions.massDestroy')); ?>",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('<?php echo e(trans('global.zero_selected')); ?>')

        return
      }

      if (confirm('<?php echo e(trans('global.are_you_sure')); ?>')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
<?php endif; ?>

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Permission:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // JavaScript to handle the SweetAlert dialog
    document.addEventListener('DOMContentLoaded', function() {
        // Add a click event listener to the "Delete" button
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function() {
                var deleteUrl = this.form.action; 

                Swal.fire({
                    title: "<?php echo e(trans('global.are_you_sure')); ?>",
                    text: "<?php echo e(trans('global.you_able_revert_this')); ?>",
                    icon: "<?php echo e(trans('global.warning')); ?>",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "<?php echo e(trans('global.yes_delete_it')); ?>",
                    cancelButtonText: "<?php echo e(trans('global.cancel')); ?>",
                }).then(function(result) {
                    if (result.isConfirmed) {
                        fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            }
                        }).then(function(response) {
                            if (response.ok) {
                              
                                location.reload();
                            } 
                        });
                        location.reload();
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/permissions/index.blade.php ENDPATH**/ ?>