<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo e(trans('global.create')); ?> <?php echo e($userType == 'user' ? trans('global.customer') : trans('global.vendor')); ?>

                </div>
                <div class="panel-body">
                <form method="POST" action="<?php echo e(route('admin.app-users.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="user_type" value="<?php echo e($userType); ?>">
                    <div class="row">
                        <div class="form-group col-md-4 <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
                            <label class="required" for="first_name"><?php echo e(trans('global.first_name')); ?></label>
                            <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo e(old('first_name', '')); ?>" required>
                            <?php if($errors->has('first_name')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('first_name')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php echo e($errors->has('middle') ? 'has-error' : ''); ?>">
                            <label for="middle"><?php echo e(trans('global.middle')); ?></label>
                            <input class="form-control" type="text" name="middle" id="middle" value="<?php echo e(old('middle', '')); ?>">
                            <?php if($errors->has('middle')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('middle')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
                            <label for="last_name"><?php echo e(trans('global.last_name')); ?></label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo e(old('last_name', '')); ?>">
                            <?php if($errors->has('last_name')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('last_name')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="form-group col-md-4 <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                            <label class="required" for="email"><?php echo e(trans('global.email')); ?></label>
                            <input class="form-control" type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required>
                            <?php if($errors->has('email')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('email')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php echo e($errors->has('phone_country') ? 'has-error' : ''); ?>">
                            <label for="phone_country"><?php echo e(trans('global.phone_country')); ?></label>
                            <select class="form-control" name="phone_country" id="phone_country" onchange="updateDefaultCountry()">
                                <?php $__currentLoopData = config('countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country['dial_code']); ?>" data-country-code="<?php echo e($country['code']); ?>">
                                        <?php echo e($country['name']); ?> (<?php echo e($country['dial_code']); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('phone_country')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('phone_country')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
                            <label class="required" for="phone"><?php echo e(trans('global.phone')); ?></label>
                            <input class="form-control" type="text" name="phone" id="phone" value="<?php echo e(old('phone', '')); ?>" required>
                            <?php if($errors->has('phone')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('phone')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="form-group <?php echo e($errors->has('default_country') ? 'has-error' : ''); ?>" style="display:none;">
                        <label for="default_country"><?php echo e(trans('global.default_country')); ?></label>
                        <input class="form-control" type="text" name="default_country" id="default_country" value="<?php echo e(old('default_country', '')); ?>">
                        <?php if($errors->has('default_country')): ?>
                            <span class="help-block" role="alert"><?php echo e($errors->first('default_country')); ?></span>
                        <?php endif; ?>
                    </div>

                    
                    <div class="row">
                        <div class="form-group col-md-4 <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                            <label class="required" for="password"><?php echo e(trans('global.password')); ?></label>
                            <input class="form-control" type="password" name="password" id="password" required>
                            <?php if($errors->has('password')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('password')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                            <label><?php echo e(trans('global.status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled <?php echo e(old('status', null) === null ? 'selected' : ''); ?>><?php echo e(trans('global.pleaseSelect')); ?></option>
                                <?php $__currentLoopData = App\Models\AppUser::STATUS_SELECT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(old('status', '1') === (string) $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('status')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('status')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-4 <?php echo e($errors->has('package') ? 'has-error' : ''); ?>">
                            <label for="package_id"><?php echo e(trans('global.package')); ?></label>
                            <select class="form-control select2" name="package_id" id="package_id">
                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(old('package_id') == $id ? 'selected' : ''); ?>><?php echo e($entry); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('package')): ?>
                                <span class="help-block" role="alert"><?php echo e($errors->first('package')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="form-group <?php echo e($errors->has('profile_image') ? 'has-error' : ''); ?>">
                        <label for="profile_image"><?php echo e(trans('global.profile_image')); ?></label>
                        <div class="needsclick dropzone" id="profile_image-dropzone">
                        </div>
                        <?php if($errors->has('profile_image')): ?>
                            <span class="help-block" role="alert"><?php echo e($errors->first('profile_image')); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if($userType === 'vendor'): ?>
    <hr>
    <h4><?php echo e(__('Vendor Additional Information')); ?></h4>

    <input type="hidden" name="host_status" value="2">

    <div class="row">
        <div class="form-group col-md-6">
            <label for="company_name"><?php echo e(__('Company Name')); ?></label>
            <input class="form-control" type="text" name="company_name" id="company_name" value="<?php echo e(old('company_name')); ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="residency_type"><?php echo e(__('Residency Type')); ?></label>
            <select class="form-control" name="residency_type" id="residency_type">
                <option value="Citizenship" <?php echo e(old('residency_type') == 'Citizenship' ? 'selected' : ''); ?>>Citizenship</option>
                <option value="Residence" <?php echo e(old('residency_type') == 'Residence' ? 'selected' : ''); ?>>Residence</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label for="full_address"><?php echo e(__('Full Address')); ?></label>
            <input type="text" class="form-control" name="full_address" id="full_address" value="<?php echo e(old('full_address')); ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="identity_type"><?php echo e(__('Identity Type')); ?></label>
            <select class="form-control" name="identity_type" id="identity_type">
                <option value="Passport" <?php echo e(old('identity_type') == 'Passport' ? 'selected' : ''); ?>>Passport</option>
                <option value="Driving License" <?php echo e(old('identity_type') == 'Driving License' ? 'selected' : ''); ?>>Driver License</option>
            </select>
        </div>
    </div>

    <div class="form-group <?php echo e($errors->has('identity_image') ? 'has-error' : ''); ?>">
        <label for="identity_image"><?php echo e(__('Upload Identity Image')); ?></label>
        <div class="needsclick dropzone" id="identity_image-dropzone"></div>
        <?php if($errors->has('identity_image')): ?>
            <span class="help-block" role="alert"><?php echo e($errors->first('identity_image')); ?></span>
        <?php endif; ?>
    </div>
<?php endif; ?>




                    
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
    Dropzone.options.profileImageDropzone = {
    url: '<?php echo e(route('admin.app-users.storeMedia')); ?>',
    maxFilesize: 1, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
    },
    params: {
      size: 1,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="profile_image"]').remove()
      $('form').append('<input type="hidden" name="profile_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="profile_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
<?php if(isset($appUser) && $appUser->profile_image): ?>
      var file = <?php echo json_encode($appUser->profile_image); ?>

          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="profile_image" value="' + file.file_name + '">')
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
<script>
Dropzone.options.identityImageDropzone = {
    url: '<?php echo e(route('admin.app-users.storeMedia')); ?>',
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
        $('form').find('input[name="identity_image"]').remove()
        $('form').append('<input type="hidden" name="identity_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
        file.previewElement.remove()
        if (file.status !== 'error') {
            $('form').find('input[name="identity_image"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        }
    },
    init: function () {
    <?php if(isset($appUser) && $appUser->getFirstMedia('identity_image')): ?>
        var file = <?php echo json_encode($appUser->getFirstMedia('identity_image')); ?>

        this.options.addedfile.call(this, file)
        this.options.thumbnail.call(this, file, file.preview_url ?? file.original_url)
        file.previewElement.classList.add('dz-complete')
        $('form').append('<input type="hidden" name="identity_image" value="' + file.file_name + '">')
        this.options.maxFiles = this.options.maxFiles - 1
    <?php endif; ?>
    },
    error: function (file, response) {
        var message = $.type(response) === 'string' ? response : response.errors.file;
        file.previewElement.classList.add('dz-error');
        let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
        for (let i = 0; i < _ref.length; i++) {
            _ref[i].textContent = message;
        }
    }
}
</script>

<script>
    function updateDefaultCountry() {
        const phoneCountryDropdown = document.getElementById('phone_country');
        const defaultCountryField = document.getElementById('default_country');
        const selectedDialCode = phoneCountryDropdown.value;

        // Find the selected option's country code using the data attribute
        const selectedOption = phoneCountryDropdown.querySelector(`option[value="${selectedDialCode}"]`);
        const countryCode = selectedOption ? selectedOption.getAttribute('data-country-code') : '';

        // Update the default country field with the country code (IN, US, etc.)
        defaultCountryField.value = countryCode;
    }

    // Call the function on page load to set the default country based on the current selection
    document.addEventListener("DOMContentLoaded", function() {
        updateDefaultCountry();
    });
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($api_google_map_key->meta_value ?? ''); ?>&libraries=places&callback=initAutocomplete"></script>

<script>
function initAutocomplete() {
    const input = document.getElementById('full_address');
    const autocomplete = new google.maps.places.Autocomplete(input);

    // Optionally restrict results (e.g., country)
    // autocomplete.setComponentRestrictions({ country: ["in"] });

    // Only get address components
    autocomplete.setFields(["formatted_address"]);

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (place.formatted_address) {
            input.value = place.formatted_address;
        }
    });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/appUsers/create.blade.php ENDPATH**/ ?>