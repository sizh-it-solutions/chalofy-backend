<?php $__env->startSection('content'); ?>
<?php $i = 0; $j = 0; ?>

<div class="content">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('admin.cancellation.create')); ?>">
                <?php echo e(trans('global.add')); ?> <?php echo e(trans('global.cancellationReason_title')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>			
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <?php echo e($moduleName); ?> <?php echo e(trans('global.cancellationReason_title_singular')); ?>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Booking randum">
                            <thead>
                                <tr>
                                <th></th>
                                    <th><?php echo e(trans('global.id')); ?></th>
                                    <th><?php echo e(trans('global.reason')); ?></th>
                                    <th><?php echo e(trans('global.user_type')); ?></th>
                                    <th><?php echo e(trans('global.status')); ?></th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $contactdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-entry-id="<?php echo e($data->order_cancellation_id); ?>">
                                    <td>  </td>
                                        <td>  <?php echo e($data->order_cancellation_id  ?? ''); ?>  </td>
                                      
                                        <td><?php echo e($data->reason ?? ''); ?> </td>
                                        <td><?php echo e($data->user_type ?? ''); ?></td>
                                       
                                        <td>
                                        <div class="status-toggle d-flex justify-content-between align-items-center">
												<input data-id="<?php echo e($data->order_cancellation_id); ?>" class="check statusdata" type="checkbox" data-onstyle="success" id="<?php echo e('user'. $i++); ?>" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($data->status ? 'checked' : ''); ?>	>
												<label for="<?php echo e('user'. $j++); ?>" class="checktoggle">checkbox</label>
											</div>
                                        </td>
                                     </td>
                                        <td>
                                               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_reason_edit')): ?>
                                                <a class="btn btn-xs btn-info" href="<?php echo e(route('admin.cancellation.edit', $data->order_cancellation_id)); ?>" style="display: inline-block;">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancellation_reason_delete')): ?>
                                                <button type="button" class="btn btn-xs btn-danger delete-cancellation" data-id="<?php echo e($data->order_cancellation_id); ?>"  style="display: inline-block;">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
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
<?php echo $__env->make('admin.common.addSteps.footer.footerJs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

        function handleDeletion(route) {
            return function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id');
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
                        // Show loader
                        Swal.fire({
                            title: '<?php echo e(trans("global.deleting")); ?>',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            method: 'DELETE',
                            url: route,
                            data: { ids: ids }
                        }).done(function (response) {
                            Swal.close(); // Close the loader
                            location.reload();
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

        let deleteRoute = "<?php echo e(route('admin.cancellation.deleteCancellationAll')); ?>";

        let deleteButton = {
            text: '<?php echo e(trans("global.delete_all")); ?>',
            className: 'btn-danger',
            action: handleDeletion(deleteRoute)
        };

        dtButtons.push(deleteButton);

        // Ensure the table is not re-initialized
        if (!$.fn.dataTable.isDataTable('.datatable-Booking:not(.ajaxTable)')) {
            let table = $('.datatable-Booking:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            });
        }

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Attach click event to delete buttons
        document.querySelectorAll('.delete-cancellation').forEach(button => {
            button.addEventListener('click', function () {
                var orderId = this.getAttribute('data-id');
                
                Swal.fire({
                title: '<?php echo e(trans('global.are_you_sure')); ?>',
                text: '<?php echo e(trans('global.delete_items')); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?php echo e(trans('global.yes_delete_it')); ?>',
                cancelButtonText: '<?php echo e(trans('global.cancel')); ?>',
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteCancellation(orderId);
                    } 
                });
            });
        });

        function deleteCancellation(orderId) {
            // Show loader before making the request
            Swal.fire({
                title: '<?php echo e(trans('global.deleting')); ?>',
                text: '<?php echo e(trans('global.please_cancellation_wait')); ?>',
                // title: 'Deleting...',
                // text: 'Please wait while the cancellation reason is being deleted.',
                didOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false,
            });

            fetch(`/admin/cancellation/delete/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                Swal.close(); 
                if (data.status === 200) {
                    toastr.success('<?php echo e(trans('global.delete_success')); ?>', '', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-bottom-right'
                    });
                    location.reload();
                } else {
                    Swal.fire(
                        'Error!',
                        'Error: ' + data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                Swal.close(); 
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'An error occurred. Please try again.',
                    'error'
                );
            });
        }
    });
</script>



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
				url: '/admin/update-cancellation-status', 
				data: requestData, 
				success: function(response){ 
                    if(response.status===200)
                  {
                    toastr.success(response.message, '<?php echo e(trans("global.success")); ?>', {
						CloseButton: true,
						ProgressBar: true,
						positionClass: "toast-bottom-right"
					});
                  }
                  else
                  {
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/cancellation/index.blade.php ENDPATH**/ ?>