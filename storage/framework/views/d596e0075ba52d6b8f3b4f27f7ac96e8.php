<div id="customLoader" class="loader-container">
                <div class="custom-loader"></div>
            </div>
           
                 <!-- form -->
     <div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="priceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <div class="row w-100">
                    <div class="col-md-10">
                        <h4 class="modal-title f-18"><?php echo e(trans('global.set_price_for_particular_dates')); ?></h4>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="close cls-reload f-18" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
            <form id="calanderAdd">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="item_id" value="<?php echo e($id); ?>">
                <input type="hidden" class="form-control " name="date_value" id="dtpc_datevalue" placeholder="">
                <input type="hidden" class="form-control " name="status_value" id="dtpc_statusvalue" placeholder="">
                <div class="modal-body">
                    <p class="calendar-m-msg" id="model-message"></p>
                    
                    <div class="form-group row mt-3">
                        <label for="dtpc_start_admin" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0"><?php echo e(trans('global.start_date')); ?>

                            <em class="text-danger">*</em></label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control hasDatepicker" name="start_date" id="dtpc_start_admin" value="" placeholder="Start Date" autocomplete="off">
                            <span class="text-danger" id="error-dtpc-start"></span>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <div class="form-group row mt-3">
                        <label for="dtpc_end_admin" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0"><?php echo e(trans('global.end_date')); ?>

                            <em class="text-danger">*</em></label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control hasDatepicker" name="end_date" id="dtpc_end_admin" placeholder="End Date" autocomplete="off" value="">
                            <span class="text-danger" id="error-dtpc-end"></span>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <div class="form-group row mt-3">
                        <label for="dtpc_price" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0"><?php echo e(trans('global.price')); ?>

                            <em class="text-danger">*</em></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="price" id="dtpc_price" placeholder="" value="">
                            <span class="text-danger" id="error-dtpc-price"></span>
                        </div>
                    </div>
                    <div class="form-group row mt-3" style='display:none'>
                                                    <label for="input_dob" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">
                                                    <?php echo e(trans('global.minimum_stay')); ?> </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control " name="min_stay" id="dtpc_minstay_admin" placeholder="" value="">
                                                        <span class="text-danger" id="error-dtpc-minstay"></span>
                                                    </div>
                                                </div> 
                    <div class="form-group row mt-3">
                        <label for="dtpc_status" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0"><?php echo e(trans('global.status')); ?>

                            <em class="text-danger">*</em></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="dtpc_status">
                                <option value="">--Please Select--</option>
                                <option value="Available" selected >Available</option>
                                <option value="Not available">Not Available</option>
                            </select>
                            <span class="text-danger" id="error-dtpc-status"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-info text-white" type="button" name="submit" id="submitCalanderform"><?php echo e(trans('global.submit')); ?></button>&nbsp;&nbsp;
                    <button type="button" class="btn btn-default closemodel" data-bs-dismiss="modal"><?php echo e(trans('global.close')); ?></button>
                </div>
            </form>
            </div>
        </div>
    </div>
            <!-- end -->
            <div class="outercoor">  <div class="row">
               <div class="col-xs-5 col-md-2 col-sm-2">
            <h2>
            <a id="previousButton" href="<?php echo e(route($routeIndex, ['month' => $prevMonth, 'year' => $prevYear, 'id' => $id, 'module' => $module])); ?>" class="btn btn-secondary"><?php echo e(trans('')); ?> <i class="fa fa-chevron-left fa-lg calendar-icon-style"></i></a>
            <a id="nextButton" href="<?php echo e(route($routeIndex, ['month' => $nextMonth, 'year' => $nextYear, 'id' => $id, 'module' => $module])); ?>" class="btn btn-secondary"><?php echo e(trans('')); ?> <i class="fa fa-chevron-right fa-lg calendar-icon-style"></i></a></h2>
            </div>
           <div class="col-xs-5 col-2 col-md-8 col-sm-8 clar">      
           <h2>  
         
            <select id="monthYearSelect">
        <?php for($i = 0; $i <= 48; $i++): ?>
            <?php
                $optionDate = date('Y-m', strtotime("+$i months", strtotime(date('Y-m'))));
                $optionYear = date('Y', strtotime($optionDate));
                $optionMonth = date('n', strtotime($optionDate));
            ?>
            <option value="<?php echo e(route($routeIndex, ['month' => $optionMonth, 'year' => $optionYear, 'id' => $id, 'module' => $module])); ?>"
                <?php echo e($optionMonth == $month && $optionYear == $year ? 'selected' : ''); ?>>
                <?php echo e($monthNames[$optionMonth]); ?> <?php echo e($optionYear); ?>

            </option>
        <?php endfor; ?>
    </select></h2></div>
           
    </div>       
           
           
    <div class="table-responsive"><table  class="table" border="1" style="width: 100%;">
    <tr style="border-top: 0;border-left: 0;border-right: 0;">
        <?php $__currentLoopData = $dayNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <th><?php echo e($day); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tr>
    <tr>
        <?php for($i = 0; $i < $firstDayOfWeek; $i++): ?>
            <td></td>
        <?php endfor; ?>
 
        <?php for($day = 1; $day <= $numDays; $day++): ?>
            <?php
           
        $paddedDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                    $dateKey = "$year-$month-$paddedDay";
                   
                    $price = isset($priceData[$dateKey]) ? $priceData[$dateKey] : '0';
                    $statusCondition = isset($StatusData[$dateKey]) ? $StatusData[$dateKey] : '';
                   $bookingDataCondition = isset($bookingData[$dateKey]) ? $bookingData[$dateKey] : '0';
                   
                ?>

                <?php if($bookingDataCondition != '0' ): ?>
        <td class=" bookingClass bggreen"  
          data-priceValue="<?php echo e(isset($priceData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $priceData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
          data-DateValue="<?php echo e(isset($dateData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $dateData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
          data-StatusValue="<?php echo e(isset($StatusData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $StatusData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
          data-minStayValue="<?php echo e(isset($minStayData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $minStayData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
         data-date="<?php echo e($year); ?>-<?php echo e(str_pad($month, 2, '0', STR_PAD_LEFT)); ?>-<?php echo e(str_pad($day, 2, '0', STR_PAD_LEFT)); ?>">
         <div class='dayNumber'><?php echo e($day); ?> <small>(Booked #<a href='/admin/bookings/<?php echo e($bookingDataCondition); ?>' target='_blank'><?php echo e($bookingDataCondition); ?>)</a></small></div>
        <?php
                    $paddedDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                    $dateKey = "$year-$month-$paddedDay";
                   
                    $price = isset($priceData[$dateKey]) ? $priceData[$dateKey] : '0';
                ?>
                
                <div class='dayPrice'><?php echo e($general_default_currency->meta_value); ?> <?php echo e($price); ?>  </div>
                
        </td>
                <?php elseif($statusCondition == 'Not available'): ?>
                <td class="calendar-date statusClass bgred"  
          data-priceValue="<?php echo e(isset($priceData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $priceData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
          data-DateValue="<?php echo e(isset($dateData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $dateData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
          data-StatusValue="<?php echo e(isset($StatusData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $StatusData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
          data-minStayValue="<?php echo e(isset($minStayData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)]) ? $minStayData["$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT)] : '0'); ?>"
         data-date="<?php echo e($year); ?>-<?php echo e(str_pad($month, 2, '0', STR_PAD_LEFT)); ?>-<?php echo e(str_pad($day, 2, '0', STR_PAD_LEFT)); ?>"><div class='dayNumber'><?php echo e($day); ?>

         </div> <?php
                    $paddedDay = str_pad($day, 2, '0', STR_PAD_LEFT);
                    $dateKey = "$year-$month-$paddedDay";
                   
                    $price = isset($priceData[$dateKey]) ? $priceData[$dateKey] : '0';
                ?>
                
                <div class='dayPrice'><?php echo e($general_default_currency->meta_value); ?> <?php echo e($price); ?></div>
                
        </td>
        
                <?php else: ?>
                <?php
                    $currentDate = now(); // Get the current date
                    $dateKey = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $date = \Carbon\Carbon::createFromFormat('Y-m-d', $dateKey);
                    $isPastDate = $date->isPast();
                    $price = isset($priceData[$dateKey]) ? $priceData[$dateKey] : '0';
                ?>

                <td class="calendar-date  <?php if($price==0): ?> blank <?php endif; ?> <?php if(!$isPastDate): ?> future-date <?php else: ?> past-date <?php endif; ?>"
                    data-priceValue="<?php echo e(isset($priceData[$dateKey]) ? $priceData[$dateKey] : $itemData->price); ?>"
                    data-DateValue="<?php echo e(isset($dateData[$dateKey]) ? $dateData[$dateKey] : '0'); ?>"
                    data-StatusValue="<?php echo e(isset($StatusData[$dateKey]) ? $StatusData[$dateKey] : '0'); ?>"
                    data-minStayValue="<?php echo e(isset($minStayData[$dateKey]) ? $minStayData[$dateKey] : '0'); ?>"
                    data-date="<?php echo e($year); ?>-<?php echo e(str_pad($month, 2, '0', STR_PAD_LEFT)); ?>-<?php echo e(str_pad($day, 2, '0', STR_PAD_LEFT)); ?>">
                    <div class='dayNumber'><?php echo e($day); ?></div>
                   
                    <div class='dayPrice'><?php echo e($general_default_currency->meta_value); ?> <?php echo e($price > 0 ? $price : $itemData->price); ?></div>
                </td>

                <?php endif; ?>

       


            <?php if(($firstDayOfWeek + $day) % 7 == 0): ?>
                </tr><tr>
            <?php endif; ?>
        <?php endfor; ?>

        <?php for($i = ($firstDayOfWeek + $numDays) % 7; $i < 7; $i++): ?>
            <td></td>
        <?php endfor; ?>
    </tr>
</table><div class="legend">
    <div class="legend-item">
        <div class="booked">&#9632;</div>
        <span>Booked</span>
    </div>

    <div class="legend-item">
        <div class="disabled">&#9632;</div>
        <span>Disabled (Past Dates)</span>
    </div>

    <div class="legend-item">
        <div class="open">&#9632;</div>
        <span>Open (Available)</span>
    </div>

    <div class="legend-item">
        <div class="not-selected">&#9632;</div>
        <span>Not Selected</span>
    </div>

    <div class="legend-item">
        <div class="not-available">&#9632;</div>
        <span>Not Available</span>
    </div>
</div>
</div></div>
<script>

function hideCustomLoader() {
            $('#customLoader').hide();
        }

$(document).ready(function() {
    //$('#submitCalanderform').click(function(e) {
    // $('body').on('click', '#submitCalanderform', function(e){    
        // $('body').off('click', '#submitCalanderform').on('click', '#submitCalanderform', function(e){
            $('#submitCalanderform').click(function(e) {
        e.preventDefault();
        var month = <?php echo e($month); ?>;
        var year = <?php echo e($year); ?>;
        var id = <?php echo e($id); ?>;
        // Validate price and status fields
        var priceValue = $('#dtpc_price').val();
        var statusValue = $('#dtpc_status').val();

        if (!priceValue || isNaN(priceValue) || parseFloat(priceValue) < 0) {
            $('#error-dtpc-price').text('Please enter a valid numeric price greater than or equal to 0.');
            return; // Stop the form submission if validation fails
        } else {
            $('#error-dtpc-price').text('');
        }

        if (!statusValue || statusValue.trim() === '') {
            // Show error message for status
            $('#error-dtpc-status').text('Please select a status.');
            return; // Stop the form submission if validation fails
        } else {
            // Clear error message for status if it's not empty
            $('#error-dtpc-status').text('');
        }

        // Allow price to be 0 only if status is "Not available"
        if (parseFloat(priceValue) === 0 && statusValue !== 'Not available') {
            $('#error-dtpc-price').text('Price must be greater than 0 when status is not "Not available."');
            return; // Stop the form submission if validation fails
        } else {
            $('#error-dtpc-price').text('');
        }
        $('#customLoader').show();
    
        $.ajax({
            type: 'POST',
            url: '<?php echo e(route($routeUpdate)); ?>',
            data: $('#calanderAdd').serialize(),
            success: function(data) {
                
                url = "<?php echo e(route($routeIndex,$id )); ?>"+'?month=' + month +'&year=' + year;
                //window.location.href = url;
                // window.location.reload();
                $.get(url, function(data, status){
                    $('body').removeClass('modal-open');
                    $('#priceModal').modal('hide');
                    $('#calendarID').html(data.html);
                    
                    //console.log(data.html);
                    // Hide the modal

                    // Remove the modal backdrop manually
                    $('.modal-backdrop').remove();
                    // hideCustomLoader();
                    $('#customLoader').hide();
                });
            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    var errors = response.responseJSON.errors;
                    $('.error-message').text('');
                    // hideCustomLoader();
                    // Then display new error messages
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                           
                            var errorMessage = errors[field][
                                0
                            ]; // get the first error message
                            $('#descriptionerror-' + field).text(errorMessage);
                        }
                    }
                }
            }
        });
    });
    $('.closemodel').click(function(){
    $('#priceModal').modal('hide');
    $('.modal-backdrop').remove();
    })

});
</script><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/addSteps/calendar/calendar_table.blade.php ENDPATH**/ ?>