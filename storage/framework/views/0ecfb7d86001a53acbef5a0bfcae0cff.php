<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="row gap-2">
        <div class="col-md-3 settings_bar_gap">
            <div class="box box-info box_info">
                <div class="">
                    <h4 class="all_settings f-18 mt-1" style="margin-left:15px;"> <?php echo e(trans('global.manage_settings')); ?></h4>
                    <?php echo $__env->make('admin.generalSettings.general-setting-links.links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <!-- Box for updating push notification key -->
            <div class="box box-info">
                <div class="box-header with-border" style="display: none;">
                    <h3 class="box-title" style="display: inline-block; margin-right: 600px;"><?php echo e(trans('global.Firebase_key')); ?></h3><span class="email_status" style="display: none;">(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
                <!-- Checkbox -->
        <div class="checkbox-container" style="display: inline-block; vertical-align: middle;">
            
            <input class="check statusdata" type="checkbox"
                   data-onstyle="success"
                   id="firebase_status"
                   data-offstyle="danger"
                   data-toggle="toggle"
                   data-on="Active"
                   data-off="Inactive"
                   data-url=""
                   <?php echo e($pushnotification_status != "" && $pushnotification_status->meta_value == 'firebase' ? 'checked' : ''); ?>>
                   <label for="firebase_status" style="margin-left: 91%; margin-top: 8px;" class="checktoggle">checkbox</label> 
                
        </div>
        <!-- End Checkbox -->
               
                </div>
                
                <form id="general_form" method="POST" action="<?php echo e(route('admin.pushnotificationupdate')); ?>" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group mt-3" style="display: none;">
                        <label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.key')); ?><span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" type="password" name="pushnotification_key" id="pushnotification_key" placeholder="key" value="<?php echo e($pushnotification_key->meta_value ?? ''); ?>">
                        </div>
                    </div>
                    <div class="box-header with-border">
                     <h3 class="box-title" style="display: inline-block; margin-right: 580px;"><?php echo e(trans('global.onesignal_key')); ?></h3><span class="email_status" style="display: none;">(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
                            <!-- Checkbox -->
                                <div class="checkbox-container" style="display: inline-block; vertical-align: middle;">
                                    
                                    <input class="check statusdata" type="checkbox"
                                        data-onstyle="success"
                                        id="onesignal_status"
                                        data-offstyle="danger"
                                        data-toggle="toggle"
                                        data-on="Active"
                                        data-off="Inactive"
                                        data-url=""
                                        <?php echo e($pushnotification_status != "" && $pushnotification_status->meta_value == 'onesignal' ? 'checked' : ''); ?> >
                                        <label for="onesignal_status" style="margin-left: 91%; margin-top: 8px;" class="checktoggle">checkbox</label>
                                        
                                </div>
                                <!-- End Checkbox -->
                    
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.app_id')); ?><span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" type="password" name="onesignal_app_id" id="onesignal_app_id" placeholder="App Id" value="<?php echo e($onesignal_app_id->meta_value ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.rest_api_key')); ?><span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <input class="form-control" type="password" name="onesignal_rest_api_key" id="onesignal_rest_api_key" placeholder="Rest Api Key" value="<?php echo e($onesignal_rest_api_key->meta_value ?? ''); ?>">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-space"><?php echo e(trans('global.save')); ?></button>
                    </div>
                </form>
            </div>
            

            <!-- Box for sending user messages -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo e(trans('global.push_notification')); ?></h3>
                </div>

                <form id="user_message_form" method="POST" action="<?php echo e(route('admin.sendusermessage')); ?>" class="form-horizontal" enctype="multipart/form-data" novalidate="novalidate">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group mt-3">
                        <label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.user')); ?><span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                        <select class="form-control select2" name="userid_id" id="userid_id" required>
                                <option value="All">All</option>
                                <?php $__currentLoopData = $userids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $namePhoneEmail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(old('userid_id') == $id ? 'selected' : ''); ?>><?php echo e($namePhoneEmail); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.subject')); ?><span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                        <input class="form-control" type="text" name="subject" id="subjectwizard_subject" placeholder="subject" value="<?php echo e(old('subject')); ?>" >
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputEmail3"><?php echo e(trans('global.message')); ?><span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="message" id="messagewizard_message" placeholder="message" rows="5"><?php echo e(old('message')); ?></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info btn-space"><?php echo e(trans('global.send_message')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
       
        $(document).ready(function() {
            $('#general_form').on('submit', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                    toastr.success(response.success, 'Success', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right"
                });
                    },
                    error: function(response) {
                        if (response.status === 403) {
                                var response = JSON.parse(response.responseText);
                                toastr.error(response.error, 'Error', {
                                    CloseButton: true,
                                    ProgressBar: true,
                                    positionClass: "toast-bottom-right"
                                });
                            } else {
                                // General error handling
                                toastr.error(response.error, 'Error', {
                                    CloseButton: true,
                                    ProgressBar: true,
                                    positionClass: "toast-bottom-right"
                                });
                            }
                    }
                });
            });

            $('#user_message_form').on('submit', function(event) {
                event.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success(response.success, 'Success', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right"
                });
                    },
                    error: function(response) {
                        if (response.status === 403) {
                                var response = JSON.parse(response.responseText);
                                toastr.error(response.error, 'Error', {
                                    CloseButton: true,
                                    ProgressBar: true,
                                    positionClass: "toast-bottom-right"
                                });
                            } else {
                                // General error handling
                                toastr.error(response.error, 'Error', {
                                    CloseButton: true,
                                    ProgressBar: true,
                                    positionClass: "toast-bottom-right"
                                });
                            }
                    }
                });
            });
          
     $('#firebase_status').change(function() {
        
        if ($(this).prop('checked')) {
            $('#onesignal_status').prop('checked', false); // Uncheck OneSignal checkbox
        }
        updateCheckboxStatus('firebase', $(this).prop('checked'));
    });

    // Handle change event for OneSignal Checkbox
    $('#onesignal_status').change(function() {
       
        if ($(this).prop('checked')) {
            $('#firebase_status').prop('checked', false); // Uncheck Firebase checkbox
        }
        updateCheckboxStatus('onesignal', $(this).prop('checked'));
    });

    // Function to update checkbox status via AJAX
    function updateCheckboxStatus(type, isChecked) {
       
        var url = "<?php echo e(route('admin.updatePushNotificationStatus')); ?>";

        // Make AJAX call to update backend
        $.ajax({
            url: url,
            type: 'POST',
            data: { type: type },
            dataType: 'json', // Ensure expected response type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token for Laravel security
            },
            success: function(response) {

                
                if (response.success) {
                    toastr.success(response.success, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-bottom-right"
                    });
                }else{
                    toastr.error(response.error, 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-bottom-right"
                    });
                }



                // Handle success response if needed
            },
            error: function(xhr, error) {
                // console.error('Error updating ' + type +' url ' +url+ ' status:', error);
                
                toastr.error(response.error, 'Error', {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-bottom-right"
            });
                    
                // Handle error response if needed
            }
        });
    }

        }); // onload end
    </script>
    <?php echo $__env->make('admin.generalSettings.toastermsgDemo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/pushnotification/pushnotification.blade.php ENDPATH**/ ?>