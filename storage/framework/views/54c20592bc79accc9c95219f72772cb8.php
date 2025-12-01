

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">


    <div class="box">
        <div class="box-body">
            <form class="form-horizontal" enctype="multipart/form-data" action="" method="GET" accept-charset="UTF-8" id="bookingFilterForm">

                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label> <?php echo e(trans('global.host_name')); ?></label>
                            <select class="form-control select2" name="reciver" id="reciver">
                                <option value=""><?php echo e($reciverName); ?></option>
                                <!-- <option value=""></option> -->
                                <!-- Add any other options you want to display -->
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label> <?php echo e(trans('global.guest_name')); ?></label>
                            <select class="form-control select2" name="sender" id="sender">
                                <option value=""><?php echo e($senderName); ?></option>
                                <!-- <option value=""></option> -->
                                <!-- Add any other options you want to display -->
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">

                            <button type="submit" name="btn" class="btn btn-primary btn-flat"><?php echo e(trans('global.filter')); ?></button>
                            <button type="button" name="reset_btn" id="resetBtn" class="btn btn-primary btn-flat"><?php echo e(trans('global.reset')); ?></button>
                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-4 mt-5">
                            <br>

                        </div>
                    </div>
                </div>
        </div>
        </form>


        <div class="row">
            <div class="col-lg-12">
                <div class=" panel-default">
                    <div class="panel-heading">
                     <?php echo e(trans('global.Review')); ?> <?php echo e(trans('global.list')); ?>

                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Booking">
                                <thead>
                                    <tr>
                                        <th width="10">

                                        </th>
                                        <th width="10">
                                            <?php echo e(trans('global.id')); ?>

                                        </th>
                                        <th>
                                            Rider

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.host')); ?>


                                        </th>
                                        <th>
                                            <?php echo e(trans('global.bookingid')); ?>

                                        </th>
                                        <th>
                                            <?php echo e(trans('global.action')); ?>

                                        </th>

                                    </tr>
                                </thead>
                                <?php
                                // Fetch all item IDs related to the bookings in a single query
                                $itemIds = \App\Models\Modern\Item::whereIn('id', $ReviveData->pluck('item_id'))->pluck('id')->toArray();
                                $bookingIds = \App\Models\Booking::whereIn('id', $ReviveData->pluck('bookingid'))->pluck('id')->toArray();
                                $userIds = \App\Models\AppUser::whereIn('id', $ReviveData->pluck('hostid')->merge($ReviveData->pluck('guestid')))->pluck('id')->toArray();
                                //$guestIds = \App\Models\AppUser::whereIn('id', $ReviveData->pluck('guestid'))->pluck('id')->toArray();
                                ?>
                                <tbody>
                                    <?php $__currentLoopData = $ReviveData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php

                                    $itemExists = in_array($reviewData->item_id, $itemIds);
                                    $bookingExists = in_array($reviewData->bookingid, $bookingIds);
                                    $hostExists = in_array($reviewData->hostid, $userIds);
                                    $guestExists = in_array($reviewData->guestid, $userIds);
                                    ?>
                                    <tr data-entry-id="<?php echo e($reviewData->id); ?>">
                                        <td>

                                        </td>
                                        <td>
                                            <?php echo e($reviewData->id); ?>

                                        </td>
                                      

                                        <td>

                                            <?php if(!empty($guestExists)): ?>
                                            <a target="_blank" href="<?php echo e(route('admin.overview', $reviewData->guestid)); ?>">
                                                <?php echo e($reviewData->guest_name ?? ''); ?>

                                            </a>
                                            <?php else: ?>
                                               <?php echo e($reviewData->guest_name ?? ''); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                           <?php if(!empty($hostExists)): ?>
                                            <a target="_blank" href="<?php echo e(route('admin.overview', $reviewData->hostid)); ?>">
                                                <?php echo e($reviewData->host_name ?? ''); ?>

                                            </a>
                                            <?php else: ?>
                                               <?php echo e($reviewData->host_name ?? ''); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($bookingExists): ?>
                                            <a target="_blank" href="<?php echo e(route('admin.bookings.show', $reviewData->bookingid)); ?>">
                                                <?php echo e($reviewData->bookingid ?? ''); ?>

                                            </a>
                                            <?php else: ?>
                                            <?php echo e($reviewData->bookingid ?? ''); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('review_edit')): ?>
                                            <a style="margin-bottom:5px;margin-top:5px" class="btn btn-xs btn-info" href="<?php echo e(route('admin.reviews.edit', $reviewData->id)); ?>">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>

                                            <!-- <a style="margin-bottom: 5px; margin-top: 5px" class="btn btn-xs btn-danger delete-button" href="<?php echo e(route('admin.reviews.delete', $reviewData->id)); ?>">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a> -->
                                            <a class="btn btn-xs btn-danger delete-button deleteclass" data-id="<?php echo e($reviewData->id); ?>" href="<?php echo e(route('admin.reviews.delete', $reviewData->id)); ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                            <?php endif; ?>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <nav aria-label="...">
                                <ul class="pagination justify-content-end">
                                    
                                    <?php if($ReviveData->currentPage() > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($ReviveData->previousPageUrl()); ?>" tabindex="-1"> <?php echo e(trans('global.previous')); ?></a>
                                    </li>
                                    <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"> <?php echo e(trans('global.previous')); ?></span>
                                    </li>
                                    <?php endif; ?>

                                    
                                    <?php for($i = 1; $i <= $ReviveData->lastPage(); $i++): ?>
                                        <li class="page-item <?php echo e($i == $ReviveData->currentPage() ? 'active' : ''); ?>">
                                            <a class="page-link" href="<?php echo e($ReviveData->url($i)); ?>"><?php echo e($i); ?></a>
                                        </li>
                                        <?php endfor; ?>

                                        
                                        <?php if($ReviveData->hasMorePages()): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($ReviveData->nextPageUrl()); ?>"> <?php echo e(trans('global.next')); ?></a>
                                        </li>
                                        <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link"> <?php echo e(trans('global.next')); ?></span>
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
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Include Select2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: false,


        });
        let table = $('.datatable-Booking:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            //   $($.fn.dataTable.tables(true)).DataTable()
            //       .columns.adjust();
        });

    })
</script>

<script>
    $(document).ready(function() {
        $('#sender').select2({
            ajax: {
                url: "<?php echo e(route('admin.searchcustomer')); ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) { // Transform the response data into Select2 format
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.first_name,
                            };
                        })
                    };
                },
                cache: true,
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error while fetching customer data:", textStatus, errorThrown);
                    
                }
            }
        });

       var senderId = "<?php echo e($senderId); ?>"; // Get user ID from the controller adminsearch
       var senderName = "<?php echo e($senderName); ?>"; // Get user name from the controller

        if (senderId) {
            var option = new Option(senderName, senderId, true, true);
            $('#sender').append(option).trigger('change');
    }  
    });
</script>
<script>
    $(document).ready(function() {
        $('#reciver').select2({
            ajax: {
                url: "<?php echo e(route('admin.searchcustomer')); ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) { // Transform the response data into Select2 format
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.first_name,
                            };
                        })
                    };
                },
                cache: true,
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error while fetching customer data:", textStatus, errorThrown);

                    
                }
            }
        });

       var reciverId = "<?php echo e($reciverId); ?>"; // Get user ID from the controller adminsearch
       var reciverName = "<?php echo e($reciverName); ?>"; // Get user name from the controller

        if (reciverId) {
            var option = new Option(reciverName, reciverId, true, true);
            $('#reciver').append(option).trigger('change');
       } 
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize the Select2 for the customer select box

        $('#item').select2({
            ajax: {
                url: "<?php echo e(route('admin.searchItem')); ?>",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    // Transform the response data into Select2 format
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            };
                        })
                    };
                },
                cache: true, // Cache the AJAX results to avoid multiple requests for the same data
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error while fetching customer data:", textStatus, errorThrown);
                    // Optionally display an error message to the user
                    
                }
            }
        });

       var itemId = "<?php echo e($itemId); ?>"; // Get user ID from the controller adminsearch
       var itemName = "<?php echo e($itemName); ?>"; // Get user name from the controller

        if (itemId) {
            var option = new Option(itemName, itemId, true, true);
            $('#item').append(option).trigger('change');
       }
    });
</script>

<script>
    $('#resetBtn').click(function() {
        $('#bookingFilterForm')[0].reset();
        var baseUrl = '<?php echo e(route('admin.reviews.index')); ?>';
        window.history.replaceState({}, document.title, baseUrl);
        window.location.reload();
    });
</script>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/reviews/index.blade.php ENDPATH**/ ?>