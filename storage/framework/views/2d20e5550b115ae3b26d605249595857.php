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
            <div class="box">
                <div class="box-body">
                    <form class="form-horizontal" id="propertyFilterForm" action="<?php echo e(route($indexRoute)); ?>" method="GET" accept-charset="UTF-8">
                        <div class="row">
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label><?php echo e($realRoute == 'bookable-subcategories' ? trans('global.categories') : trans('global.make')); ?></label>
                                <select class="form-control select2" name="Category" id="category">
                                    <option value=""><?php echo e(trans('global.pleaseSelect')); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('Category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">
                                <br>
                                <button type="submit" name="btn" class="btn btn-primary btn-flat filterproduct"><?php echo e(trans('global.filter')); ?></button>
                                <button type="button" id="resetBtn" class="btn btn-primary btn-flat resetproduct"><?php echo e(trans('global.reset')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e($title); ?> <?php echo e(trans('global.list')); ?>

                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-PropertyType">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <th><?php echo e(trans('global.id')); ?></th>
                                <th><?php echo e(trans('global.name')); ?></th>
                                <th><?php echo e($realRoute == 'bookable-subcategories' ? trans('global.categories') : trans('global.make')); ?></th>
                                <th><?php echo e(trans('global.image')); ?></th>
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
        { data: 'make.name', name: 'make.name' },
        { data: 'image', name: 'image', sortable: false, searchable: false },
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
                    ajaxUpdateRoute: '<?php echo e($ajaxUpdate); ?>',
                    texts: texts
                });
            }
        },
        {
            data: 'actions',
            name: '<?php echo e(trans("global.actions")); ?>',
            orderable: false,
            searchable: false
        }
    ];

    $(function () {
        initializeFeatureDataTable({
            tableSelector: '.datatable-PropertyType',
            ajaxUrl: {
                url: "<?php echo e(route($indexRoute)); ?>",
                type: 'GET',
                data: function (d) {
                    d.Category = $('#category').val();
                }
            },
            deleteUrl: "<?php echo e(route('admin.vehicle-model.deleteAll')); ?>",
            columns: featureColumns,
            texts: texts
        });

        // Filter dropdown functionality
        $('#category').on('change', function () {
            $('#propertyFilterForm').submit();
        });

        $('#resetBtn').on('click', function () {
            $('#category').val('').trigger('change');
            $('#propertyFilterForm').submit();
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/subCategory/index.blade.php ENDPATH**/ ?>