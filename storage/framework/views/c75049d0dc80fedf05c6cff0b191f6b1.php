<?php $__env->startSection('content'); ?>
<div class="content"><div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-2">  <?php echo e(trans('global.tickets_title')); ?> :</div>
    <div class="col-lg-4"><?php echo e($supportTicketData->title ?? ''); ?></div>
    <div class="col-lg-2">    <?php echo e(trans('global.description')); ?>  :</div>
    <div class="col-lg-4"><?php echo e($supportTicketData->description ?? ''); ?></div>
</div>

  <div class="accordion1-option">
    <a href="javascript:void(0)" class="toggle-accordion1 active" accordion1-id="#accordion1"></a>
  </div>
  <div class="clearfix"></div>
  <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="true"                           aria-controls="collapseOne1">
            <i class="fa fa-pencil" aria-hidden="true"></i> <?php echo e(trans('global.reply')); ?>

            <i class="fa fa-plus float-right" aria-hidden="true"></i>
        </a>

      </h4>
      </div>
      <div id="collapseOne1" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
        <form method="POST" action="<?php echo e(route("admin.ticket.thread.create", [$id])); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group <?php echo e($errors->has('reason') ? 'has-error' : ''); ?>">
                            <label class="required" for="reason"><?php echo e(trans('global.reply')); ?> </label>
                            <textarea class="form-control" name="message" id="reply" rows="4" required><?php echo e(old('message')); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                            <?php echo e(trans('global.save')); ?>

                            </button>
                        </div>
                    </form>
        </div>
      </div>
    </div>
 
 
<!--  -->


  <div class="accordion-option">
    <h3 class="title"></h3>
    <a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
  </div>
  <div class="clearfix"></div>
  <?php $__currentLoopData = $supportTicketReplies->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?php echo e($reply->id); ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo e($reply->id); ?>" aria-expanded="true" aria-controls="collapse<?php echo e($reply->id); ?>">
                        <?php if($reply->user_id == $adminedata->id): ?>
                            <?php echo e($adminedata->name); ?>

                        <?php else: ?>
                        <?php echo e(optional($reply->appUser)->first_name); ?> <?php echo e(optional($reply->appUser)->last_name); ?>

                        <?php endif; ?>
                    </a>
                    <p style="float:right"><?php echo e($reply->created_at->format('d-m-Y')); ?></p>
                </h4>
            </div>
            <div id="collapse<?php echo e($reply->id); ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo e($reply->id); ?>">
                <div class="panel-body">
                    <?php echo e($reply->message); ?>

                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/ticket/thread.blade.php ENDPATH**/ ?>