<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.create')); ?> <?php echo e($title); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route($storeRoute)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="module" value="<?php echo e($module); ?>">
                        <div class="form-group <?php echo e($errors->has('can_name') ? 'has-error' : ''); ?>">
                            <label class="required" for="can_name"><?php echo e(trans('global.name')); ?></label>
                            <input class="form-control" type="text" name="name" id="can_name" value="<?php echo e(old('can_name', '')); ?>" required>
                            <?php if($errors->has('can_name')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('can_name')); ?></span>
                            <?php endif; ?>
                            
                        </div>
                        <div class="form-group <?php echo e($errors->has('make_id') ? 'has-error' : ''); ?>">
                            <label class="required"><?php echo e(trans('global.make')); ?></label>
                            <select class="form-control" name="make_id" id="make_id" required>
                                <option value="" ><?php echo e(trans('global.pleaseSelect')); ?></option>
                                <?php $__currentLoopData = $mainCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainCategoryData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mainCategoryData->id); ?>" ><?php echo e($mainCategoryData->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('make_id')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('make_id')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
                            <label for="description"><?php echo e(trans('global.description')); ?></label>
                            <input class="form-control" type="text" name="description" id="description" value="<?php echo e(old('description', '')); ?>">
                            <?php if($errors->has('description')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('description')); ?></span>
                            <?php endif; ?>
                           
                        </div>
                       
                        <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                            <label class="required"><?php echo e(trans('global.status')); ?></label>
                            <select class="form-control" name="status" id="status" required>
                                <option value disabled <?php echo e(old('status', null) === null ? 'selected' : ''); ?>><?php echo e(trans('global.pleaseSelect')); ?></option>
                                <?php $__currentLoopData = App\Models\SubCategory::STATUS_SELECT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('status', '1') === (string) $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('status')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('status')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php echo e($errors->has('image') ? 'has-error' : ''); ?>">
                            <label for="image"><?php echo e(trans('global.image')); ?></label>
                            <div class="needsclick dropzone" id="image-dropzone">
                            </div>
                            <?php if($errors->has('image')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('image')); ?></span>
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
    Dropzone.options.imageDropzone = {
    url: '<?php echo e(route( $storeMediaRoute )); ?>',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
<?php if(isset($propertyType) && $propertyType->image): ?>
      var file = <?php echo json_encode($propertyType->image); ?>

          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
<?php endif; ?>
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/common/subCategory/create.blade.php ENDPATH**/ ?>