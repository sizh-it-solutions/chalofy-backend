<?php $__env->startSection('content'); ?>
<style>
    .dataTables_info {
        display: none;
    }

    .paging_simple_numbers {
        display: none;
    }

    .pagination.justify-content-end {
        float: right;
    }

    .main-footer {
        overflow: hidden;
        margin-left: 0;
    }

    .dataTables_length {
        display: none;
    }
</style>
<div class="content">
    <div class="box">
        <div class="box-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="" method="GET" accept-charset="UTF-8"
                id="ticketFilterForm">
                <div class="col-md-12">
                    <div class="row">


                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label> <?php echo e(trans('global.status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="" <?php echo e(!request()->input('status') ? 'selected' : ''); ?>>All</option>
                                <option value="1" <?php echo e(request()->input('status') === '1' ? 'selected' : ''); ?>>Open
                                </option>
                                <option value="0" <?php echo e(request()->input('status') === '0' ? 'selected' : ''); ?>>Close
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-2 col-xs-4 mt-5">
                            <br>
                            <button type="submit" name="btn" class="btn btn-primary btn-flat">
                                <?php echo e(trans('global.filter')); ?></button>
                            <button type="button" id='resetBtn' class="btn btn-primary btn-flat">
                                <?php echo e(trans('global.reset')); ?></button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php echo $__env->make('admin.ticket.liveTrashSwitcher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.tickets_title')); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table
                            class=" table table-bordered table-striped table-hover datatable datatable-Booking randum">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <?php echo e(trans('global.id')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.user')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.tickets_thread')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.title')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.status')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.description')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('global.action')); ?>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-entry-id="<?php echo e($ticket->id); ?>">
                                    <td></td>

                                    <td><?php echo e($ticket->id); ?></td>

                                    <?php
                                    $userType = $ticket->appUser->user_type ?? 'user';
                                    $routeName = $userType === 'vendor'
                                    ? 'admin.vendor.profile'
                                    : 'admin.customer.profile';
                                    ?>

                                    <td>
                                        <?php if($ticket->appUser): ?>
                                        <a target="_blank" href="<?php echo e(route($routeName, $ticket->appUser->id)); ?>">
                                            <?php echo e($ticket->appUser->first_name ?? ''); ?>

                                            <?php echo e($ticket->appUser->last_name ?? ''); ?>

                                        </a>
                                        <?php else: ?>
                                        <span>—</span>
                                        <?php endif; ?>
                                    </td>



                                    <td>
                                        <a href="<?php echo e(route('admin.ticket.thread', $ticket->id)); ?>">
                                            <?php echo e($ticket->thread_id ?? ''); ?>

                                        </a>
                                    </td>

                                    <td><?php echo e($ticket->title ?? ''); ?></td>

                                    <td>
                                        <?php if($ticket->thread_status == 1): ?>
                                        Open
                                        <?php else: ?>
                                        Close
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo e($ticket->description ?? ''); ?></td>

                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ticket_delete')): ?>
                                        <button type="button" class="btn btn-xs btn-danger delete-button"
                                            data-id="<?php echo e($ticket->id); ?>">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>

                        </table>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end">
                                
                                <?php if($data->currentPage() > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($data->previousPageUrl()); ?>"
                                        tabindex="-1"><?php echo e(trans('global.previous')); ?></a>
                                </li>
                                <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link"><?php echo e(trans('global.previous')); ?></span>
                                </li>
                                <?php endif; ?>

                                
                                <?php for($i = 1; $i <= $data->lastPage(); $i++): ?>
                                    <li class="page-item <?php echo e($i == $data->currentPage() ? 'active' : ''); ?>">
                                        <a class="page-link" href="<?php echo e($data->url($i)); ?>"><?php echo e($i); ?></a>
                                    </li>
                                    <?php endfor; ?>

                                    
                                    <?php if($data->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="<?php echo e($data->nextPageUrl()); ?>"><?php echo e(trans('global.next')); ?></a>
                                    </li>
                                    <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><?php echo e(trans('global.next')); ?></span>
                                    </li>
                                    <?php endif; ?>
                            </ul>
                        </nav>
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
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const ticketId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        deleteTicket(ticketId);
                    }
                });
            });
        });

        function deleteTicket(ticketId) {
            const url = `<?php echo e(route('admin.ticket.destroy', ':id')); ?>`.replace(':id', ticketId);

            $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                success: function (response) {
                    Swal.close();
                    toastr.success('Ticket deleted successfully.', 'Success', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-bottom-right"
                    });
                    location.reload(); // Optionally, refresh the page or update UI as needed
                },
                error: function (xhr, status, error) {
                    Swal.close();
                    toastr.error('Error deleting ticket.', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-bottom-right"
                    });
                    console.error(error);
                }
            });
        }
    });
</script>

<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        function handleDeletion(route) {
            return function (e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function (entry) {
                    return $(entry).data('entry-id');
                });

                if (ids.length === 0) {
                    Swal.fire({
                        title: 'No entries selected',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            method: 'POST',
                            url: route,
                            data: {
                                ids: ids
                            }
                        }).done(function (response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Messages have been deleted.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });

                            // Remove the rows from DataTables
                            location.reload();
                        }).fail(function (xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the messages.',
                                'error'
                            );
                        });
                    }
                });
            };
        }

        let deleteRoute = "<?php echo e(route('admin.ticket.deleteAll')); ?>";

        let deleteButton = {
            text: 'Delete all',
            className: 'btn-danger',
            action: handleDeletion(deleteRoute)
        };

        dtButtons.push(deleteButton);

        let table = $('.datatable-Booking:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })
</script>
<script>
    $(document).ready(function () {
        // Fetch the selected status from local storage
        const selectedStatus = localStorage.getItem('selectedStatus');

        // Check if the selected status is not null or empty
        if (selectedStatus) {
            // Set the selected status in the dropdown
            $('#status').val(selectedStatus);
        }

        // Event handler when the status value changes
        $('#status').on('change', function () {
            // Store the selected status in local storage
            const selectedValue = $(this).val();
            localStorage.setItem('selectedStatus', selectedValue);
        });

        // Check if the URL parameters for status, from, and to are empty
        const urlStatus = "<?php echo e(request()->input('status')); ?>";
        const urlFrom = "<?php echo e(request()->input('from')); ?>";
        const urlTo = "<?php echo e(request()->input('to')); ?>";

        if (!urlStatus) {
            // If all URL parameters are empty, remove the stored status value from local storage
            localStorage.removeItem('selectedStatus');
        }
    });
</script>

<script>
    $('#resetBtn').click(function () {
        $('#ticketFilterForm')[0].reset();
        var baseUrl = '<?php echo e(route('admin.ticket.index')); ?>';
        window.history.replaceState({}, document.title, baseUrl);
        window.location.reload();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/ticket/index.blade.php ENDPATH**/ ?>