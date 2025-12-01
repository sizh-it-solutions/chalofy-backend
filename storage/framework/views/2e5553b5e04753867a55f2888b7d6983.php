<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.create')); ?> <?php echo e(trans('global.addCoupon_title_singular')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route("admin.add-coupons.store")); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group <?php echo e($errors->has('coupon_title') ? 'has-error' : ''); ?>">
                            <label class="required" for="coupon_title"><?php echo e(trans('global.coupon_titles')); ?></label>
                            <input class="form-control" type="text" name="coupon_title" id="coupon_title" value="<?php echo e(old('coupon_title', '')); ?>" required>
                            <?php if($errors->has('coupon_title')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('coupon_title')); ?></span>
                            <?php endif; ?>
                        
                        </div>
                      
                        <div class="form-group <?php echo e($errors->has('coupon_expiry_date') ? 'has-error' : ''); ?>">
                            <label for="coupon_expiry_date"><?php echo e(trans('global.coupon_expiry_date')); ?></label>
                            <input class="form-control date" type="date" name="coupon_expiry_date" id="coupon_expiry_date" value="<?php echo e(old('coupon_expiry_date')); ?>">
                            <?php if($errors->has('coupon_expiry_date')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('coupon_expiry_date')); ?></span>
                            <?php endif; ?>
                        
                        </div>
                        <div class="form-group <?php echo e($errors->has('coupon_code') ? 'has-error' : ''); ?>">
                              <label class="required" for="coupon_code"><?php echo e(trans('global.coupon_code')); ?> <span class="generate-icon" id="generateCouponButton">
                                  <i class="fas fa-cogs"></i> 
                              </span></label>
                              <div class="input-group"> <!-- Wrap label and input in a Bootstrap input group for button addon -->
                                  <input class="form-control" type="text" name="coupon_code" id="coupon_code" value="<?php echo e(old('coupon_code', '')); ?>" required>
                                  <br>
                                
                              </div>
                              <?php if($errors->has('coupon_code')): ?>
                                  <span class="help-block" role="alert"><?php echo e($errors->first('coupon_code')); ?></span>
                              <?php endif; ?>
                          </div>
                        <div class="form-group <?php echo e($errors->has('min_order_amount') ? 'has-error' : ''); ?>">
                            <label for="min_order_amount"><?php echo e(trans('global.min_order_amount')); ?></label>
                            <input class="form-control" type="number" name="min_order_amount" id="min_order_amount" value="<?php echo e(old('min_order_amount', '')); ?>" step="0.01">
                            <?php if($errors->has('min_order_amount')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('min_order_amount')); ?></span>
                            <?php endif; ?>
                   
                        </div>
                        <div class="form-group <?php echo e($errors->has('coupon_value') ? 'has-error' : ''); ?>">
                          <label class="required" for="coupon_value"><?php echo e(trans('global.coupon_value')); ?></label>
                          <div class="input-group">
                          <input class="form-control" type="number" name="coupon_value" id="coupon_value" value="<?php echo e(old('coupon_value', '')); ?>" step="0.01" required>
                              <select class="form-control mr-2" name="coupon_type" id="coupon_type" required>
                                  <option value="percentage" <?php echo e(old('coupon_type') == 'percentage' ? 'selected' : ''); ?> selected>Percentage</option>
                              </select>
                             
                          </div>
                          <?php if($errors->has('coupon_value')): ?>
                              <span class="help-block" role="alert"><?php echo e($errors->first('coupon_value')); ?></span>
                          <?php endif; ?>
                      </div>



                      
                        <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                            <label><?php echo e(trans('global.status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled <?php echo e(old('status', null) === null ? 'selected' : ''); ?>><?php echo e(trans('global.pleaseSelect')); ?></option>
                                <?php $__currentLoopData = App\Models\AddCoupon::STATUS_SELECT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('status', '1') === (string) $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('status')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('status')); ?></span>
                            <?php endif; ?>
                
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    // JavaScript to handle coupon code generation
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('generateCouponButton').addEventListener('click', function() {
            // Generate a new coupon code here (example)
            var generatedCoupon = generateCouponCode();

            // Set the generated coupon code to the input field
            document.getElementById('coupon_code').value = generatedCoupon;
        });

        // Function to generate a random coupon code (example)
        function generateCouponCode() {
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var length = 8;
            var coupon = '';
            for (var i = 0; i < length; i++) {
                coupon += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return coupon;
        }
    });
</script>

<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo e(route('admin.add-coupons.storeCKEditorImages')); ?>', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '<?php echo e($addCoupon->id ?? 0); ?>');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/addCoupons/create.blade.php ENDPATH**/ ?>