<?php $__env->startSection('content'); ?>
<div class="content">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($permissionrealRoute.'_create')): ?>
        <div style="margin-bottom: 10px;" class="row">
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
            <div class="panel-heading d-flex justify-content-between align-items-center">
                    <span><?php echo e($title); ?> <?php echo e(trans('global.list')); ?></span>
                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover  datatable datatable-City">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    <?php echo e(trans('global.id')); ?>

                                </th>
                              
                                <th>
                                    <?php echo e(trans('global.city_name')); ?>

                                </th>
                                <th>
                                    <?php echo e(trans('global.country')); ?>

                                </th>
                                <th>
                                    <?php echo e(trans('global.image')); ?>

                                </th>
                                <th>
                                <?php echo e(trans('global.latitude')); ?>

                                </th>
                                <th>
                                <?php echo e(trans('global.longtitude')); ?>

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
        { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false, className: 'select-checkbox' },
        { data: 'id', name: 'id' },
        { data: 'city_name', name: 'city_name' },
        { data: 'country_code', name: 'country_code' },
        { data: 'image', name: 'image', sortable: false, searchable: false },
        { data: 'latitude', name: 'latitude' },
        { data: 'longtitude', name: 'longtitude' },
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
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        }
    ];

    $(function () {
        initializeFeatureDataTable({
            tableSelector: '.datatable-City',
            ajaxUrl: "<?php echo e(route($indexRoute)); ?>",
            deleteUrl: "<?php echo e(route('admin.item-location.deleteAll')); ?>",
            columns: featureColumns,
            texts: texts
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/location/index.blade.php ENDPATH**/ ?>