<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.edit')); ?> <?php echo e(trans('global.staticPage_title_singular')); ?>

                </div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo e(route("admin.static-pages.update", [$staticPage->id])); ?>" enctype="multipart/form-data">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                            <label class="required" for="name"><?php echo e(trans('global.name')); ?></label>
                            <input class="form-control" type="text" name="name" id="name" value="<?php echo e(old('name', $staticPage->name)); ?>" required>
                            <?php if($errors->has('name')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('name')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php echo e($errors->has('content') ? 'has-error' : ''); ?>">
                            <label for="content"><?php echo e(trans('global.content')); ?></label>
                            <textarea class="form-control ckeditor" name="content" id="content"><?php echo old('content', $staticPage->content); ?></textarea>
                            <?php if($errors->has('content')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('content')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                            <label><?php echo e(trans('global.status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled <?php echo e(old('status', null) === null ? 'selected' : ''); ?>><?php echo e(trans('global.pleaseSelect')); ?></option>
                                <?php $__currentLoopData = App\Models\StaticPage::STATUS_SELECT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('status', $staticPage->status) === (string) $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
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
                xhr.open('POST', '<?php echo e(route('admin.static-pages.storeCKEditorImages')); ?>', true);
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
                data.append('crud_id', '<?php echo e($staticPage->id ?? 0); ?>');
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/staticPages/edit.blade.php ENDPATH**/ ?>