<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

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

    
    let deleteRoute = "<?php echo e(route('admin.delete.rows')); ?>"; 
    if (window.location.href.indexOf('trash') !== -1) {
        deleteRoute = "<?php echo e(route('admin.trash-delete.rows')); ?>"; 
    }

    let deleteButton = {
        text: '<?php echo e(trans("global.delete_all")); ?>',
        className: 'btn-danger',
        action: handleDeletion(deleteRoute) 
    };

    dtButtons.push(deleteButton);

    let table = $('.datatable-Property:not(.ajaxTable)').DataTable({
        buttons: dtButtons,
        orderCellsTop: true,
        select: {
            style: 'multi'
        }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

});
</script>







<?php $__env->stopSection(); ?><?php /**PATH C:\xampp\htdocs\chalofytaxi\resources\views/admin/common/addSteps/footer/footerJs.blade.php ENDPATH**/ ?>