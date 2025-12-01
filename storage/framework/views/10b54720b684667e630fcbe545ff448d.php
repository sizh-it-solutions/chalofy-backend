<?php $__env->startSection('content'); ?>
<?php $i = 0; $j = 0; ?>
<style>
    
    .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody>table>tbody>tr>td:last-child {
    display: flex;
}
    .deleteclass {
    margin: 0 2px;
}
</style>
<div class="content">

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_policiess')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('admin.cancellation.policies.create')); ?>">
                <?php echo e(trans('global.add')); ?> <?php echo e(trans('global.cancellationPolicies_title_singular')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>			
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <?php echo e($moduleName); ?> <?php echo e(trans('global.cancellationPolicies_title_singular')); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Booking randum">
                            <thead>
                                <tr>
                                <th></th>
                                    <th><?php echo e(trans('global.id')); ?></th>
                                    <th><?php echo e(trans('global.name')); ?></th>
                                    <th><?php echo e(trans('global.description')); ?></th>
                                    <th><?php echo e(trans('global.cancellationPolicies_type')); ?></th>
                                    <th><?php echo e(trans('global.amount')); ?></th>
                                    <th>Cancellation Time</th>
                                    <!-- <th><?php echo e(trans('global.module')); ?></th> -->
                                    <th><?php echo e(trans('global.status')); ?></th>
                                    <th>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $policydata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-entry-id="<?php echo e($data->id); ?>">
                                    <td>   </td>
                                        <td>  <?php echo e($data->id  ?? ''); ?>  </td>
                                        <td><?php echo e($data->name ?? ''); ?> </td>
                                        <td><?php echo e($data->description ?? ''); ?></td>
                                        <td><?php echo e($data->type ?? ''); ?></td>
                                        <td><?php echo e($data->value ?? ''); ?></td>
                                        <td>
                                            <?php if($data->cancellation_time == 0): ?>
                                                Booking day
                                            <?php else: ?>
                                                <?php echo e($data->cancellation_time); ?> hours
                                            <?php endif; ?>
                                        </td>
                                        <!-- <td>
                                        <?php if($data->module == 1): ?>
                                            Cancellation policies
                                        <?php elseif($data->modul == 2): ?>
                                            Vehicle
                                        <?php elseif($data->modul == 4): ?>
                                            Boat
                                        <?php elseif($data->modul == 5): ?>
                                            Parking
                                        <?php elseif($data->modul == 6): ?>
                                            Available
                                        <?php else: ?>

                                        <?php endif; ?> -->

                                    
                                    </td>
                                        <td>
                                        <div class="status-toggle d-flex justify-content-between align-items-center">
												<input  data-id="<?php echo e($data->id); ?>" class="check statusdata" type="checkbox" data-onstyle="success" id="<?php echo e('user'. $i++); ?>" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($data->status ? 'checked' : ''); ?>	>
												<label for="<?php echo e('user'. $j++); ?>" class="checktoggle">checkbox</label>
											</div>
                                     </td>
                                        <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_policies_edit')): ?>
                                     <a class="btn btn-xs btn-info deleteclass" href="<?php echo e(route('admin.cancellation.policies.edit', $data->id)); ?>">
                                         <i class="fa fa-pencil" aria-hidden="true"></i>
                                     </a>
                                     <?php endif; ?>

                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_policies_delete')): ?>
                                     <a  class="btn btn-xs btn-danger delete-button deleteclass"  data-id="<?php echo e($data->id); ?>"  href="<?php echo e(route('admin.policies.delete', $data->id)); ?>">
                                         <i class="fa fa-trash" aria-hidden="true"></i>
												</a>
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
  function handleDeletion(route) {
        return function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                return $(entry).data('entry-id')
            });

            if (ids.length === 0) {
                Swal.fire({
                    title: '<?php echo e(trans("global.no_entries_selected")); ?>',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: '<?php echo e(trans("global.are_you_sure")); ?>',
                text: '<?php echo e(trans("global.delete_confirmation")); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        method: 'POST',
                        url: route,
                        data: { ids: ids, _method: 'DELETE' }
                    }).done(function (response) {
                        location.reload(); // Reload the page after deletion
                    }).fail(function (xhr, status, error) {
                        Swal.fire(
                            '<?php echo e(trans("global.error")); ?>',
                            '<?php echo e(trans("global.delete_error")); ?>',
                            'error'
                        );
                    });
                }
            });
        };
    }

    
    let deleteRoute = "<?php echo e(route('admin.policies.deleteAll')); ?>"; 
  

    let deleteButton = {
        text: '<?php echo e(trans("global.delete_all")); ?>',
        className: 'btn-danger',
        action: handleDeletion(deleteRoute) 
    };

    //dtButtons.push(deleteButton);

  let table = $('.datatable-Booking:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<!-- Include SweetAlert library from a CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.delete-button').on("click", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var deleteUrl = $(this).attr('href');

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
                    $.ajax({
                        url: deleteUrl, 
                        type: 'GET',
                        data: {},
                        success: function(response) {
                            Swal.fire({
                                title: "<?php echo e(trans('global.Deleted')); ?>",
                                text: "<?php echo e(trans('global.the_record_has_been_deleted')); ?>",
                                icon: "<?php echo e(trans('global.success')); ?>",
                            }).then(function() {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the record.",
                                icon: "error",
                            });
                        },
                    });
                }
            });
        });
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
	$('.statusdata').change(function() { 
			var status = $(this).prop('checked') == true ? 1 : 0;  
			var id = $(this).data('id');  
            var requestData = {
            'status': status,
            'pid': id
        };
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        requestData['_token'] = csrfToken;
			$.ajax({ 
					type: "POST", 
				dataType: "json", 
				url: '/admin/cancellation-policies-update', 
				data: requestData, 
				success: function(response){ 
                    if(response.status === 200){
                    toastr.success(response.message, '<?php echo e(trans("global.success")); ?>', {
						CloseButton: true,
						ProgressBar: true,
						positionClass: "toast-bottom-right"
					});
                }
                else{
                    toastr.error(response.message, 'Error', {
						CloseButton: true,
						ProgressBar: true,
						positionClass: "toast-bottom-right"
					});

                }
				} 
			}); 
		})
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/cancellationPolicy/index.blade.php ENDPATH**/ ?>