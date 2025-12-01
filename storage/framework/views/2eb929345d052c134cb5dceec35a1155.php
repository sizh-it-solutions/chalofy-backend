<?php $__env->startSection('content'); ?>
<?php
        $i = 0;
        $j = 0;
    ?>
<section class="content">
      <div class="row">
        <div class="col-md-3 settings_bar_gap">
          <div class="box box-info box_info">
	<div class="">
  <h4 class="all_settings f-18 mt-1" style="margin-left:15px;">  <?php echo e(trans('global.manage_settings')); ?></h4>
		<?php echo $__env->make('admin.generalSettings.general-setting-links.links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	
	</div>
</div>
        </div>
        <!-- right column -->
       
          <?php echo $__env->make('admin.generalSettings.smssettings.smsnavicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
           
    <input class="check statusdata" type="checkbox"
    data-onstyle="success"
    id="user<?php echo e($i); ?>"
    data-offstyle="danger"
    data-toggle="toggle"
    data-on="Active"
    data-off="Inactive"
    data-url="<?php echo e(route('admin.update-sms-provider-name')); ?>"
    data-user-value="twillio"
    <?php echo e($sms_provider_name != "" && $sms_provider_name->meta_value == 'twillio' ? 'checked' : ''); ?>>
<label for="user<?php echo e($i); ?>" style="margin-left: 91%; margin-top: 8px;" class="checktoggle">checkbox</label>

            <form method="post" action="<?php echo e(route('admin.updatetwillio')); ?>" class="form-horizontal smssettingform" enctype="multipart/form-data" novalidate="novalidate">
			<?php echo e(csrf_field()); ?>

              <div class="box-body">
             
              <div class="form-group">
              		<label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.number')); ?><span class="text-danger">*</span></label>
              		<div class="col-sm-6">
              			<input class="form-control" type="password" name="twillio_number" id="sid" placeholder="Twillio Number" value="<?php echo e($twillio_number->meta_value ?? ''); ?>">
              		</div>
              	</div>
              	<div class="form-group">
              		<label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.sid')); ?><span class="text-danger">*</span></label>
              		<div class="col-sm-6">
              			<input class="form-control" type="password" name="twillio_key" id="sid" placeholder="key" value="<?php echo e($twillio_key->meta_value ?? ''); ?>">
              		</div>
              	</div>
              	<div class="form-group">
              		<label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.token')); ?><span class="text-danger">*</span></label>
              		<div class="col-sm-6">
              			<input class="form-control" type="password" name="twillio_secret" id="token" placeholder="secret" value="<?php echo e($twillio_secret->meta_value ?? ''); ?>">
              		</div>
              	</div>
                  
              
              

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                                <button type="submit" class="btn btn-info " id="submitBtn"><?php echo e(trans('global.save')); ?></button>
								<a class="btn btn-danger" href="<?php echo e(route('admin.settings')); ?>"><?php echo e(trans('global.cancel')); ?></a>

                              
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>

  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php echo $__env->make('admin.generalSettings.smssettings.toastrmsg', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>

$(document).ready(function() {
    $('.statusdata').change(function() {
        var status = $(this).prop('checked') ? 'Active' : 'Inactive';
        var userValue = $(this).data('user-value');
      
        var id = $(this).data('id');
        var url = $(this).data('url');
        
            if(status == 'Inactive'){
               
                toastr.error("You have to enable one of the sms service", 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-bottom-right"
                    });
                    $(this).prop('checked', true);
            }

     else{
       
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                status: status,
                userValue: userValue,
                id: id,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
               
                if (response.success) {
                    toastr.success('Status updated successfully', 'Success', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-bottom-right"
                    });

                  
                } else {
                    toastr.error(response.message, 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-bottom-right"
                    });

                    // Revert the checkbox state
                    $(this).prop('checked', !status);
                }
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
     }


    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/smssettings/twillio.blade.php ENDPATH**/ ?>