<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="row mb-2">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<?php echo e(route('admin.vehicle-fuel-type.create')); ?>">
                <?php echo e(trans('global.add')); ?> <?php echo e(trans('global.fuel_type')); ?>

            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.fuel_type')); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-vehicle-fuel-type">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <th><?php echo e(trans('global.id')); ?></th>
                                <th><?php echo e(trans('global.name')); ?></th>
                                <th><?php echo e(trans('global.status')); ?></th>
                                <th width="120">&nbsp;</th>
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

<script>
const texts = {
    deleteAllText: '<?php echo e(trans("global.delete_all")); ?>',
    noEntriesText: '<?php echo e(trans("global.no_entries_selected")); ?>',
    areYouSureText: '<?php echo e(trans("global.are_you_sure")); ?>',
    deleteConfirmText: '<?php echo e(trans("global.delete_confirmation")); ?>',
    yesContinueText: '<?php echo e(trans("global.yes_continue")); ?>',
    deletedText: '<?php echo e(trans("global.deleted")); ?>',
    entriesDeletedText: '<?php echo e(trans("global.entries_deleted")); ?>',
    errorText: '<?php echo e(trans("global.error")); ?>',
    deleteErrorText: '<?php echo e(trans("global.delete_error")); ?>',
    successText: '<?php echo e(trans("global.success")); ?>',
    genericErrorText: 'Something went wrong. Please try again.'
};

const fuelTypeColumns = [
    { data: 'placeholder', name: 'placeholder', searchable: false, orderable: false },
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    {
        data: 'status',
        name: 'status',
        render: (data, type, row) => `
            <div class="status-toggle d-flex justify-content-between align-items-center">
                <input
                    data-id="${row.id}"
                    class="check statusdata"
                    type="checkbox"
                    id="user${row.id}"
                    data-toggle="toggle"
                    data-on="Active"
                    data-off="InActive"
                    ${data ? 'checked' : ''}
                >
                <label for="user${row.id}" class="checktoggle">checkbox</label>
            </div>
        `,
        createdCell: function (td, cellData, rowData) {
            handleStatusToggle(td, cellData, rowData, {
                ajaxUpdateRoute: "<?php echo e(url('admin/update-fuel-type-status')); ?>",
                texts: texts
            });
        }
    },
    { data: 'actions', name: 'actions', orderable: false, searchable: false }
];

$(function () {
    initializeFeatureDataTable({
        tableSelector: '.datatable-vehicle-fuel-type',
        ajaxUrl: "<?php echo e(route('admin.vehicle-fuel-type.index')); ?>",
        deleteUrl: "<?php echo e(route('admin.vehicle-fuel-type.deleteAll')); ?>",
        columns: fuelTypeColumns,
        texts: texts
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\chalofytaxi\resources\views/admin/vehicles/vehicle-fuel-type/index.blade.php ENDPATH**/ ?>