<?php $__env->startSection('content'); ?>
<section class="content">
<div class="row gap-2">
        <style>
          .input-addon-new{
            display: block!important;
          }
        </style>
          <?php echo $__env->make('admin.vehicles.addVehicle.vehicle_left_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="col-md-9">
                <form id="priceAddForm">
                  <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($id); ?>">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="f-18"><?php echo e(trans('global.set_pricing')); ?></h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 form-group">
                                    <label for="listing_price_native" class="label-large fw-bold">  <?php echo e(trans('global.price')); ?> /<?php echo e(trans('global.day')); ?> <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-prefix pay-currency"><?php echo e($general_default_currency->meta_value); ?></span>
                                        <input type="text" data-suggested="" id="price-night" value="<?php echo e($night_price ?? '0'); ?>" name="night_price" class="money-input form-control f-14">
                                   
                                    <select name="service_type" id="service_type" class="form-control"  style="margin-left: 7px;font-size: small;">
                                        <option value="booking" <?php echo e(old('service_type', $serviceType) == 'booking' ? 'selected' : ''); ?>>Booking</option>
                                        <option value="sale" <?php echo e(old('service_type', $serviceType) == 'sale' ? 'selected' : ''); ?>>Sale</option>
                                        <option value="rent" <?php echo e(old('service_type', $serviceType) == 'rent' ? 'selected' : ''); ?>>Rent</option>
                                      </select>
                                      </div>
                                    <span class="text-danger" id="priceserror-night_price"></span>
                                </div>


                            </div>

                            <div class="row display-off" id="long-term-div">
                                <div class="col-md-12">
                                </div>
                                <div class="col-md-8">
      
      
        <label for="listing_price_native" class="label-large fw-bold mb-1"><?php echo e(trans('global.weekly_discount_percent')); ?></label>
        <span>
            ( <input type="radio" id="percentage-week" name="weekly_discount_type" value="percent" <?php echo e($weeklyDiscountType == 'percent' ? 'checked' : ''); ?>>
            <label for="percentage-week"><?php echo e(trans('global.percent')); ?></label>
            <input type="radio" id="fixed-week" name="weekly_discount_type" value="fixed" <?php echo e($weeklyDiscountType == 'fixed' ? 'checked' : ''); ?>>
            <label for="fixed-week"><?php echo e(trans('global.fixed')); ?></label> )
        </span>
        <div class="input-addon input-addon-new">
            <span class="input-prefix pay-currency"><?php echo e($general_default_currency->meta_value); ?></span>
            <input type="text" id="price-week" name="weekly_discount" value="<?php echo e($weeklyDiscount ?? ''); ?>" class="money-input form-control f-14">
          

        </div>

    </div>
    <div class="col-md-8">
        <label for="listing_price_native" class="label-large fw-bold mb-1"><?php echo e(trans('global.monthly_discount_percent')); ?></label>
        <span>
            ( <input type="radio" id="percentage-month" name="monthly_discount_type" value="percent" <?php echo e($monthlyDiscountType == 'percent' ? 'checked' : ''); ?>>
            <label for="percentage-month"><?php echo e(trans('global.percent')); ?></label>
            <input type="radio" id="fixed-month" name="monthly_discount_type" value="fixed" <?php echo e($monthlyDiscountType == 'fixed' ? 'checked' : ''); ?>>
            <label for="fixed-month"><?php echo e(trans('global.fixed')); ?></label> )
        </span>
        <div class="input-addon input-addon-new">
            <span class="input-prefix pay-currency"><?php echo e($general_default_currency->meta_value); ?></span>
            <input type="text" id="price-month" name="monthly_discount" value="<?php echo e($monthlyDiscount ?? ''); ?>" class="money-input form-control f-14">
        </div>
    </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                              <!-- <h3 class="mb-0 f-18"><?php echo e(trans('global.base_price')); ?></h3> -->
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12" style="display:none">
                                <label for="listing_cleaning_fee_native_checkbox" class="label-large label-inline fw-bold">
                                  <input type="checkbox" data-extras="true" id="show"	class="pricing_checkbox" data-rel="cleaning">&nbsp;
                                  <?php echo e(trans('global.base_price')); ?>

                                </label>
                              </div>
                              <div id="cleaning" class="display-off">
                                <div class="col-md-12">
                                  <div class="col-md-4 l-pad-none">
                                    <div class="input-addon" id="box">
                                      <span class="input-prefix pay-currency"><?php echo e($general_default_currency->meta_value); ?></span>
                                      <input type="text" id="price-cleaning"  name="base_price" class="money-input"  value="<?php echo e($basePrice->meta_value ?? ''); ?>">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- </div> -->
                              <div class="col-md-12">
                                <label for="DoorStepDelivery" class="label-large label-inline fw-bold">
                                  <input type="checkbox" id="DoorStepDelivery" name="show" <?php echo e(!empty($doorStep->meta_value) ? 'checked' : ''); ?> class="security_checkbox">
                                  &nbsp;
                                  <?php echo e(trans('global.doorstep_delivery_price')); ?>

                                </label>
                              </div>
                              <div id="doorstep" class="display-off">
                              <div class="col-md-12">
                                  <div class="col-md-4 l-pad-none">

                                  <?php if(!empty($doorStep->meta_value)): ?>
                                    <div class="input-addon" id="doorstepbox" style="display: block;">
                                <?php else: ?>
                                <div class="input-addon" id="doorstepbox">
                                <?php endif; ?>

                                   
                                      <span class="input-prefix pay-currency"><?php echo e($general_default_currency->meta_value); ?></span>
                                      <input type="text" class="money-input" name="doorstep_delivery_price" value="<?php echo e($doorStep->meta_value ?? ''); ?>">
                                    </div>
                                  </div>
                                </div>
                              </div> 
                              
                              
                              </div>
<div class="row">
                               <div class="col-md-12 ">
                                <label for="SecurityDeposit" class="label-large label-inline fw-bold">
                                  <input type="checkbox" id="SecurityDeposit" name="show" <?php echo e(!empty($securityFee->meta_value) ? 'checked' : ''); ?>  class="security_checkbox">
                                  &nbsp;
                                  <?php echo e(trans('global.security_deposit')); ?>

                                </label>
                              </div>
                              <div id="security" class="display-off">
                                <div class="col-md-12">
                                  <div class="col-md-4 l-pad-none">

                                  <?php if(!empty($securityFee->meta_value)): ?>
                                    <div class="input-addon" id="securitybox" style="display: block;">
                                <?php else: ?>
                                <div class="input-addon" id="securitybox">
                                <?php endif; ?>

                                   
                                      <span class="input-prefix pay-currency"><?php echo e($general_default_currency->meta_value); ?></span>
                                      <input type="text" class="money-input" name="security_fee" value="<?php echo e($securityFee->meta_value ?? ''); ?>">
                                    </div>
                                  </div>
                                </div>
                              </div> 
                              </div>
                            <div class="row ">
                                        <div class="mt-4 col-lg-12 col-md-12"><div class="col-6  col-lg-6  text-left">
                                            <a data-prevent-default="" href="<?php echo e(route('admin.vehicles.photos',[$id])); ?>" class="btn btn-large btn-primary f-14"><?php echo e(trans('global.back')); ?></a>
                                        </div>
                                        <div class="col-6  col-lg-6 text-right">
                                            <button type="button" class="btn btn-large btn-primary next-section-button nextStep "><?php echo e(trans('global.next')); ?></button>
                                        </div></div>
                                    </div>
                          </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('scripts'); ?>
    <script>
$(document).ready(function() {
    $('.nextStep').click(function() {
        var id = <?php echo e($id); ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo e(route('admin.vehicles.prices-Update')); ?>',
            data: $('#priceAddForm').serialize(),
            success: function(data) {
                $('.error-message').text(''); 
                   window.location.href = '/admin/vehicles/cancellation-policies/' + id;
            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    var errors = response.responseJSON.errors;
                    $('.error-message').text('');

                    // Then display new error messages
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            var errorMessage = errors[field][
                                0
                            ]; // get the first error message
                            $('#priceserror-' + field).text(errorMessage);
                        }
                    }
                }
            }
        });
    });


});

</script>

      <script>

      const checkbox = document.getElementById('show');

      const box = document.getElementById('box');

      checkbox.addEventListener('click', function handleClick() {
        if (checkbox.checked) {
          box.style.display = 'block';
        } else {
          box.style.display = 'none';
        }
      });

      $(document).ready(function () {
          $('#DoorStepDelivery').click(function () {
              if (this.checked) {
                $('#doorstepbox').show();
              } else {
                $('#doorstepbox').hide();
              }
          });
      });
      $(document).ready(function() {
        $('#SecurityDeposit').click(function() {
          
          if (this.checked) {
            $('#securitybox').show(); 
          } else {
            $('#securitybox').hide(); 
          }
        });
      });
$(document).ready(function () {
    $('#weekendPrice').click(function () {
      console.log('iotuy');
        if (this.checked) {
          $('#weekendbox').show();
        } else {
          $('#weekendbox').hide();
        }
    });
});

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/vehicles/addVehicle/pricing.blade.php ENDPATH**/ ?>