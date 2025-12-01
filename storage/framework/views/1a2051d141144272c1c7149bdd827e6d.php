<?php $__env->startSection('content'); ?>
<div class="content">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('static_page_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="<?php echo e(route('admin.static-pages.create')); ?>">
                    <?php echo e(trans('global.add')); ?> <?php echo e(trans('global.staticPage_title_singular')); ?>

                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.staticPage_title_singular')); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-StaticPage">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    <?php echo e(trans('global.id')); ?>

                                </th>
                                <th>
                                    <?php echo e(trans('global.name')); ?>

                                </th>
                                <th>
                                    <?php echo e(trans('global.status')); ?>

                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>



        </div>
    </div>
</div> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButton = {
    text: '<?php echo e(trans("global.delete_all")); ?>',
    url: "<?php echo e(route('admin.static-pages.massDestroy')); ?>", // Replace with your delete route
    className: 'btn-danger',
    action: function (e, dt, node, config) {
        var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
            return entry.id;
        });
        console.log('Selected IDs:', ids);
        if (ids.length === 0) {
            Swal.fire({
                title: '<?php echo e(trans("global.no_entries_selected")); ?>',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Use SweetAlert for confirmation
        Swal.fire({
            title: '<?php echo e(trans("global.are_you_sure")); ?>',
            text: '<?php echo e(trans("global.delete_confirmation")); ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    headers: { 'x-csrf-token': csrfToken },
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }
                }).done(function () {
                    Swal.fire(
                        '<?php echo e(trans("global.deleted")); ?>',
                        '<?php echo e(trans("global.entries_deleted")); ?>',
                        'success'
                    );
                    dt.ajax.reload();
                }).fail(function (xhr, status, error) {
                    Swal.fire(
                        '<?php echo e(trans("global.error")); ?>',
                        '<?php echo e(trans("global.delete_error")); ?>',
                        'error'
                    );
                });
            }
        });
    }
};
  dtButtons.push(deleteButton)

let dtOverrideGlobals = {
  buttons: dtButtons,
  processing: true,
  serverSide: true,
  retrieve: true,
  aaSorting: [],
  ajax: "<?php echo e(route('admin.static-pages.index')); ?>",
  columns: [
    { data: 'placeholder', name: 'placeholder' },
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    {
      data: 'status',
      name: 'status',
      render: function (data, type, row) {
        return `
          <div class="status-toggle d-flex justify-content-between align-items-center">
            <input
              data-id="${row.id}"
              class="check statusdata"
              type="checkbox"
              data-onstyle="success"
              id="${'user' + row.id}"
              data-offstyle="danger"
              data-toggle="toggle"
              data-on="Active"
              data-off="InActive"
              ${data ? 'checked' : ''}
            >
            <label for="${'user' + row.id}" class="checktoggle">checkbox</label>
          </div>
        `;
      },
      createdCell: function (td, cellData, rowData, row, col) {
        // Add an event listener for the toggle change event
        $(td).on('change', '.statusdata', function () {
          var status = $(this).prop('checked') ? 1 : 0;
          var id = rowData.id;

          var requestData = {
            'status': status,
            'pid': id
          };

          var csrfToken = $('meta[name="csrf-token"]').attr('content');
          requestData['_token'] = csrfToken;

          $.ajax({
            type: "POST",
            dataType: "json",
            url: '/admin/update-staticpage-status', // Replace with your actual URL
            data: requestData,
            success: function (response) {
                if(response.status===200)
               {
              toastr.success(response.message, '<?php echo e(trans("global.success")); ?>', {
                CloseButton: true,
                ProgressBar: true,
                positionClass: "toast-bottom-right"
              });
              // Update the label's 'active' class based on the status
              var label = $(td).find('label.checktoggle');
              if (status === 1) {
                label.addClass('active');
              } else {
                label.removeClass('active');
              }
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
        });
      }
    },
    {
    data: 'actions',
    name: '<?php echo e(trans('global.actions')); ?>',
    orderable: false, // Disable sorting on the actions column
    searchable: false, // Disable searching on the actions column

}


  ],
  orderCellsTop: true,
  order: [[1, 'desc']],
  pageLength: 100
};

  let table = $('.datatable-StaticPage').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // JavaScript to handle the SweetAlert dialog
document.addEventListener('DOMContentLoaded', function() {
    // Use event delegation to target dynamically added elements
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-button')) {
            event.preventDefault();
            var deleteUrl = event.target.closest('form').action; // Get the form's action URL

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
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/staticPages/index.blade.php ENDPATH**/ ?>