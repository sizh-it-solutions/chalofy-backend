<?php $__env->startSection('content'); ?>
<div class="content">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permissionrealRoute.'_create')): ?>
    <div class="row mb-2">
        <div class="col-lg-12">
            <a class="btn btn-success" href="<?php echo e(route($createRoute)); ?>">
                <?php echo e(trans('global.add')); ?> <?php echo e($title); ?>

            </a>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e($title); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-feature">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <th><?php echo e(trans('global.id')); ?></th>
                                <th><?php echo e(trans('global.name')); ?></th>
                                <th><?php echo e(trans('global.description')); ?></th>
                                <th><?php echo e(trans('global.icon')); ?></th>
                                <th><?php echo e(trans('global.status')); ?></th>
                                <th>&nbsp;</th>
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
        changeStatusConfirmText: '<?php echo e(trans("global.change_status_confirmation")); ?>',
        successText: '<?php echo e(trans("global.success")); ?>',
        genericErrorText: 'Something went wrong. Please try again.'
    };

    const featureColumns = [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'icon', name: 'icon', sortable: false, searchable: false },
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
                    ajaxUpdateRoute: "<?php echo e($ajaxUpdate); ?>",
                    texts: texts
                });
            }
        },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ];

    $(function () {
        initializeFeatureDataTable({
            tableSelector: '.datatable-feature',
            ajaxUrl: "<?php echo e(route($indexRoute)); ?>",
            deleteUrl: "<?php echo e(route('admin.features.deleteAll')); ?>",
            columns: featureColumns,
            texts: texts
        });
    });
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\chalofytaxi\resources\views/admin/common/features/index.blade.php ENDPATH**/ ?>