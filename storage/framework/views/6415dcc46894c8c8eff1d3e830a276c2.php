<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box">
                <div class="box-body no-padding d-block">
                    <ul class="nav nav-pills nav-stacked d-flex flex-column">

                        <?php
                        $currentRoute = request()->path();
                        ?>



                        <?php $__currentLoopData = $AllEmailRecord; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php

                        $userRoute = 'user/email-templates/'.$data->id;
                        $vendorRoute = 'vendor/email-templates/'.$data->id;
                        $adminRoute = 'admin/email-templates/'.$data->id;
                        $cls = ($currentRoute === $userRoute || $currentRoute === $vendorRoute || $currentRoute ===
                        $adminRoute ) ? 'active' : '';
                        ?>



                        <li class=" <?php echo e($cls); ?> ">
                            <a href="<?php echo e(route('user.email-templates', ['id' => $data->id])); ?>"><?php echo e(trans('global.' . strtolower(str_replace(' ', '_', $data->temp_name ?? 'default_value')))); ?>

                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

            </div>
        </div>



        <div class="col-md-9">
            <?php
            $roles = ['user', 'vendor', 'admin'];
            $userRoles = explode('#', $emaildata->role); $userRoles = isset($emaildata) && !is_null($emaildata->role) ? explode('#', $emaildata->role) : [];
            ?>

            <?php $__currentLoopData = $userRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $userRole): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($roles[$index])): ?>
            <?php if($userRole == 'user'): ?>
            <a href="<?php echo e(route('user.email-templates', ['id' => $emaildata->id])); ?>" class="btn btn-primary formtag"
                id="2"> <?php echo e(trans('global.user')); ?></a>
            <?php elseif($userRole == 'vendor'): ?>
            <a href="<?php echo e(route('vendor.email-templates', ['id' => $emaildata->id])); ?>" class="btn btn-primary formtag"
                id="3"> <?php echo e(trans('global.vendor')); ?></a>
            <?php elseif($userRole == 'admin'): ?>
            <a href="<?php echo e(route('admin.email-templates', ['id' => $emaildata->id])); ?>" class="btn btn-primary formtag"
                id="1" active> <?php echo e(trans('global.admin')); ?></a>
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            <div class="box" style=" margin-top: 4px; ">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo e(trans('global.emailTemplate_title_singular')); ?>


                    </h3>

                    <button class="pull-right btn btn-success" id="available">
                        <?php echo e(trans('global.availableVariable')); ?></button>
                </div>
                <div class="box-header d-none" id="variable" style="display: none;">
                    <div class="row ">
                        <div class="col-md-6">
                          
                        <?php if(in_array($emaildata->id, [1, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 18, 22, 26, 34, 35, 37, 38, 39, 40, 41, 42, 43, 44, 45])): ?>
                            <p><?php echo e(trans('global.first_name')); ?> : {{ first_name }}</p>
                            <p><?php echo e(trans('global.last_name')); ?> : {{ last_name }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [1, 34, 35, 38, 39, 40, 41, 42])): ?>
                            <p><?php echo e(trans('global.email')); ?> : {{ email }}</p>
                            <p><?php echo e(trans('global.phone')); ?> : {{ phone }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [10])): ?>
                            <p><?php echo e(trans('global.guests')); ?> : {{ guests }}</p>
                            <p><?php echo e(trans('global.beds')); ?> : {{ beds }}</p>
                            <p><?php echo e(trans('global.payment_method')); ?> : {{ payment_method }}</p>
                            <p><?php echo e(trans('global.payment_status')); ?> : {{ payment_status }}</p>
                            <p><?php echo e(trans('global.phone_country')); ?> : {{ phone_country }}</p>
                            <p><?php echo e(trans('global.vendor_phone')); ?> : {{ vendor_phone }}</p>
                            <p><?php echo e(trans('global.vendor_email')); ?> : {{ vendor_email }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [22, 26])): ?>
                            <p><?php echo e(trans('global.support_phone')); ?> : {{support_phone}}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [14])): ?>
                            <p><?php echo e(trans('global.payment_status')); ?> : {{ payment_status }}</p>
                            <p><?php echo e(trans('global.phone_country')); ?> : {{ phone_country }}</p>
                            <p><?php echo e(trans('global.vendor_phone')); ?> : {{ vendor_phone }}</p>
                            <p><?php echo e(trans('global.vendor_email')); ?> : {{ vendor_email }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [2, 3, 36, 37, 38])): ?>
                            <p><?php echo e(trans('global.otp')); ?> : {{ OTP }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [7])): ?>
                            <p><?php echo e(trans('global.transaction_type')); ?> : {{transaction_type}}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [1, 14, 22, 34, 35])): ?>
                            <p><?php echo e(trans('global.support_email')); ?> : {{ support_email }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [7, 6])): ?>
                            <p><?php echo e(trans('global.payout_amount')); ?> : {{ payout_amount }}</p>
                            <p><?php echo e(trans('global.payout_date')); ?> : {{ payout_date }}</p>
                            <p><?php echo e(trans('global.currency_code')); ?> : {{ currency_code }}</p>
                            
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [4])): ?>
                            <p><?php echo e(trans('global.payout_amount')); ?> : {{ payout_amount }}</p>
                            <p><?php echo e(trans('global.payout_bank')); ?> : {{ payout_bank }}</p>
                            <p><?php echo e(trans('global.payout_date')); ?> : {{ payout_date }}</p>
                            <p><?php echo e(trans('global.support_email')); ?> : {{ support_email }}</p>
                            <p><?php echo e(trans('global.currency_code')); ?> : {{ currency_code }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [5, 9, 10, 11, 12, 13])): ?>
                            <p><?php echo e(trans('global.booking_id')); ?> : {{ booking_id }}</p>
                            <p><?php echo e(trans('global.item_name')); ?> : {{ item_name }}</p>
                            <p><?php echo e(trans('global.check_in')); ?> : {{ check_in }}</p>
                            <p><?php echo e(trans('global.check_out')); ?> : {{ check_out }}</p>
                            <p><?php echo e(trans('global.currency_code')); ?> : {{ currency_code }}</p>
                            <p><?php echo e(trans('global.amount')); ?> : {{ amount }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [14, 18, 22, 26])): ?>
                            <p><?php echo e(trans('global.booking_id')); ?> : {{ bookingid }}</p>
                            <p><?php echo e(trans('global.item_name')); ?> : {{ item_name }}</p>
                            <p><?php echo e(trans('global.check_in')); ?> : {{ check_in }}</p>
                            <p><?php echo e(trans('global.start_time')); ?> : {{start_time}}</p>
                            <p><?php echo e(trans('global.check_out')); ?> : {{ check_out }}</p>
                            <p><?php echo e(trans('global.end_time')); ?> : {{end_time}}</p>
                            <p><?php echo e(trans('global.currency_code')); ?> : {{ currency_code }}</p>
                            <p><?php echo e(trans('global.amount')); ?> : {{ amount }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [12, 45])): ?>
                            <p><?php echo e(trans('global.vendor_name')); ?> : {{vendor_name}}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [1, 2, 3, 7, 14, 18, 22, 26, 34, 37, 40, 41, 42, 44])): ?>
                            <p><?php echo e(trans('global.website_name')); ?> : {{ website_name }}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [39, 40])): ?>
                            <p><?php echo e(trans('global.title')); ?> : {{title}}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [41, 42])): ?>
                            <p><?php echo e(trans('global.ticket_id')); ?> : {{ticket_id}}</p>
                            <p><?php echo e(trans('global.subject')); ?> : {{subject}}</p>
                            <p><?php echo e(trans('global.update_date')); ?> : {{update_date}}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [43, 44, 45])): ?>
                            <p><?php echo e(trans('global.booking_id')); ?> : {{ bookingid }}</p>
                            <p><?php echo e(trans('global.item_name')); ?> : {{ item_name }}</p>
                            <p><?php echo e(trans('global.current_date')); ?> : {{current_date}}</p>
                            <?php endif; ?>

                            <?php if(in_array($emaildata->id, [4, 5, 9, 10, 11, 12, 13, 35, 36, 38, 39, 43, 45])): ?>
                            <p><?php echo e(trans('global.website_name')); ?> : {{ website_name }}</p>
                            <?php endif; ?>



                        </div>
                    </div>
                </div>
            </div>


            <?php if(request()->is("user/email-templates/*")): ?>

            <form action="<?php echo e(route('user.email-template.create',['id' => $emaildata->id])); ?>" method="POST"
                class="myform" data-id="2" id="user-form">
                <?php echo csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.subject')); ?></label>
                        <input class="form-control f-14" name="subject" type="text"
                            value="<?php echo e($emaildata->subject ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.email_enable')); ?> </label>
                        <input type="checkbox" name="emailsent" value="1"
                            <?php echo e($emaildata && $emaildata->emailsent == 1 ? ' checked' : ''); ?>>
                    </div>
                    <div class="form-group">
                        <textarea name="body" class="editor"><?php echo e($emaildata->body); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.sms_enable')); ?> </label>
                        <input type="checkbox" name="smssent" value="1"
                            <?php echo e($emaildata && $emaildata->smssent == 1 ? ' checked' : ''); ?>>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.message')); ?></label>
                        <textarea class="form-control" name="sms" id="message"><?php echo e($emaildata->sms ?? ''); ?></textarea>

                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2"
                            for="exampleInputEmail1"><?php echo e(trans('global.push_notification')); ?> <?php echo e(trans('global.enable')); ?></label>
                        <input type="checkbox" name="pushsent" value="1"
                            <?php echo e($emaildata && $emaildata->pushsent == 1 ? ' checked' : ''); ?>>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.push_notification')); ?></label>
                        <textarea class="form-control" name="push_notification"
                            id="message"><?php echo e($emaildata->push_notification ?? ''); ?></textarea>

                    </div>
                    <div class="pull-right">
                    
                    <button type="submit"
                            class="btn btn-primary btn-flat f-14"><?php echo e(trans('global.update')); ?></button>
                    
                    </div>

                </div>
            </form>
            <?php elseif(request()->is("vendor/email-templates/*")): ?>

            <form action="<?php echo e(route('vendor.email-template.create',['id' => $emaildata->id])); ?>" method="POST"
                class="myform" data-id="3" id="vendor-form">
                <?php echo csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.vendor')); ?>

                            <?php echo e(trans('global.subject')); ?></label>
                        <input type="hidden" name="type" value="vendor">
                        <input class="form-control f-14" name="vendorsubject" type="text"
                            value="<?php echo e($emaildata->vendorsubject ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.email_enable')); ?></label>
                        <input type="checkbox" name="vendoremailsent" value="1"
                            <?php echo e($emaildata && $emaildata->vendoremailsent == 1 ? ' checked' : ''); ?>>
                    </div>
                    <div class="form-group">
                        <textarea name="vendorbody" id="editor2"><?php echo e($emaildata->vendorbody); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.vendor')); ?>

                            <?php echo e(trans('global.sms_enable')); ?></label>
                        <input type="checkbox" name="vendorsmssent" value="1"
                            <?php echo e($emaildata && $emaildata->vendorsmssent == 1 ? ' checked' : ''); ?>>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.vendor')); ?>

                            <?php echo e(trans('global.message')); ?></label>
                        <textarea class="form-control" name="vendorsms"
                            id="message"><?php echo e($emaildata->vendorsms ?? ''); ?></textarea>

                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.vendor')); ?>

                            <?php echo e(trans('global.push_notification')); ?> <?php echo e(trans('global.enable')); ?></label>
                        <input type="checkbox" name="vendorpushsent" value="1"
                            <?php echo e($emaildata && $emaildata->vendorpushsent == 1 ? ' checked' : ''); ?>>
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.vendor')); ?>

                            <?php echo e(trans('global.push_notification')); ?> </label>
                        <textarea class="form-control" name="vendorpush_notification"
                            id="message"><?php echo e($emaildata->vendorpush_notification ?? ''); ?></textarea>

                    </div>
                    <div class="pull-right">
                    
                    <button type="submit"
                            class="btn btn-primary btn-flat f-14"><?php echo e(trans('global.update')); ?></button>
                    </div>
                    
                </div>
            </form>
            <?php else: ?>
            <form action="<?php echo e(route('admin.email-template.create',['id' => $emaildata->id])); ?>" method="POST"
                class="myform" data-id="1" id="admin-form">
                <?php echo csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <input type="hidden" name="type" value="admin">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"><?php echo e(trans('global.admin')); ?>

                            <?php echo e(trans('global.subject')); ?></label>
                        <input class="form-control f-14" name="adminsubject" type="text"
                            value="<?php echo e($emaildata->adminsubject ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label class="fw-bold mb-2" for="exampleInputEmail1"> <?php echo e(trans('global.email_enable')); ?></label>
                        <input type="checkbox" name="adminemailsent" value="1"
                            <?php echo e($emaildata && $emaildata->adminemailsent == 1 ? ' checked' : ''); ?>>
                    </div>
                    <div class="form-group">
                        <textarea name="adminbody" id="editor3"><?php echo e($emaildata->adminbody); ?></textarea>
                    </div>

                    <div class="pull-right">
                    
                    <button type="submit"
                            class="btn btn-primary btn-flat f-14"><?php echo e(trans('global.update')); ?></button>
                    </div>
                    

                </div>
            </form>
            <?php endif; ?>
        </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Correct CKEditor script URL -->
<script src="https://cdn.ckeditor.com/ckeditor5/45.2.0/classic/ckeditor.js"></script>
<script>
$(document).ready(function() {
    $('#available').click(function() {
        $('#variable').toggle();
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    ClassicEditor
        .create(document.querySelector('.editor'))

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    ClassicEditor
        .create(document.querySelector('#editor2'))

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    ClassicEditor
        .create(document.querySelector('#editor3'))
   
});
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/email/index.blade.php ENDPATH**/ ?>