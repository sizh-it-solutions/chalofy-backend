<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/user-profile.css')); ?>" media="screen">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid content">
        <?php echo $__env->make('admin.appUsers.user.menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="driver-profile-page">
            <div class="profile-container">
                <div class="row g-3 text-capitalize align-items-center">
                    <?php
                        $toggles = [
                            ['label' => __('user.profile_verify'), 'field' => 'status', 'value' => $appUser->status, 'class' => 'profileVerify'],
                            ['label' => __('user.email_verify'), 'field' => 'email_verify', 'value' => $appUser->email_verify, 'class' => 'emailVerify'],
                            ['label' => __('user.phone_verify'), 'field' => 'phone_verify', 'value' => $appUser->phone_verify, 'class' => 'phoneVerify']
                        ];
                    ?>

                    <?php $__currentLoopData = $toggles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toggle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 form-group">
                            <label for="<?php echo e($toggle['field']); ?>"><?php echo e($toggle['label']); ?></label>
                            <div class="custom-toggle inline-block">
                                <label class="switch">
                                    <input type="checkbox" data-id="<?php echo e($appUser->id); ?>" class="<?php echo e($toggle['class']); ?>"
                                        data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo e($toggle['value'] == 1 ? 'checked' : ''); ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <div class="row g-3">
                    <form method="POST"
                        action="<?php echo e(route('admin.app-users.update', [$appUser->id])); ?>?from_overviewprofile=true"
                        enctype="multipart/form-data">
                        <?php echo method_field('PUT'); ?>
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="user_type" value="<?php echo e($userType); ?>">

                        
                        <div class="row">
                            <div class="form-group col-md-4 <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
                                <label class="required" for="first_name"><?php echo e(trans('global.name')); ?></label>
                                <input class="form-control" type="text" name="first_name" id="first_name"
                                    value="<?php echo e(old('first_name', $appUser->first_name)); ?>" required>
                                <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-4 <?php echo e($errors->has('middle') ? 'has-error' : ''); ?>">
                                <label for="middle"><?php echo e(trans('global.middle')); ?></label>
                                <input class="form-control" type="text" name="middle" id="middle"
                                    value="<?php echo e(old('middle', $appUser->middle)); ?>">
                                <?php $__errorArgs = ['middle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-4 <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
                                <label for="last_name"><?php echo e(trans('global.last_name')); ?></label>
                                <input class="form-control" type="text" name="last_name" id="last_name"
                                    value="<?php echo e(old('last_name', $appUser->last_name)); ?>">
                                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="form-group col-md-4 <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                <label for="email"><?php echo e(trans('global.email')); ?></label>
                                <input class="form-control" type="email" name="email" id="email"
                                    value="<?php echo e(old('email', $appUser->email)); ?>">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-4 <?php echo e($errors->has('phone_country') ? 'has-error' : ''); ?>">
                                <label for="phone_country"><?php echo e(trans('global.phone_country')); ?></label>
                                <select class="form-control" name="phone_country" id="phone_country"
                                    onchange="updateDefaultCountry()">
                                    <?php $__currentLoopData = config('countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country['dial_code']); ?>" <?php echo e(old('phone_country', $appUser->phone_country) == $country['dial_code'] ? 'selected' : ''); ?>>
                                            <?php echo e($country['name']); ?> (<?php echo e($country['dial_code']); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['phone_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-4 <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
                                <label class="required" for="phone"><?php echo e(trans('global.phone')); ?></label>
                                <input class="form-control" type="text" name="phone" id="phone"
                                    value="<?php echo e(old('phone', $appUser->phone)); ?>" required>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <input type="hidden" name="default_country" id="default_country"
                            value="<?php echo e(old('default_country', $appUser->default_country)); ?>">

                        
                        <div class="row">
                            <div class="form-group col-md-4 <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                                <label class="required" for="password"><?php echo e(trans('global.password')); ?></label>
                                <input class="form-control" type="password" name="password" id="password">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-4 <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                                <label><?php echo e(trans('global.status')); ?></label>
                                <select class="form-control" name="status" id="status">
                                    <option value disabled <?php echo e(old('status', null) === null ? 'selected' : ''); ?>>
                                        <?php echo e(trans('global.pleaseSelect')); ?>

                                    </option>
                                    <?php $__currentLoopData = App\Models\AppUser::STATUS_SELECT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e(old('status', $appUser->status) === (string) $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group col-md-4 <?php echo e($errors->has('package') ? 'has-error' : ''); ?>">
                                <label for="package_id"><?php echo e(trans('global.package')); ?></label>
                                <select class="form-control select2" name="package_id" id="package_id">
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>" <?php echo e((old('package_id') ? old('package_id') : $appUser->package->id ?? '') == $id ? 'selected' : ''); ?>><?php echo e($entry); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['package'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="help-block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="form-group">
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

                            <input type="hidden" name="host_status" value="<?php echo e(old('host_status', $appUser->host_status)); ?>">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="company_name"><?php echo e(__('Company Name')); ?></label>
                                    <input class="form-control" type="text" name="company_name" id="company_name"
                                        value="<?php echo e(old('company_name', $hostFormData['company_name'] ?? '')); ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="residency_type"><?php echo e(__('Residency Type')); ?></label>
                                    <select class="form-control" name="residency_type" id="residency_type">
                                        <?php $__currentLoopData = ['Citizenship', 'Permanent Resident', 'Work Permit', 'Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type); ?>" <?php echo e(old('residency_type', $hostFormData['residency_type'] ?? '') == $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="full_address"><?php echo e(__('Full Address')); ?></label>
                                    <input type="text" class="form-control" name="full_address" id="full_address"
                                        value="<?php echo e(old('full_address', $hostFormData['full_address'] ?? '')); ?>">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="identity_type"><?php echo e(__('Identity Type')); ?></label>
                                    <select class="form-control" name="identity_type" id="identity_type">
                                        <?php $__currentLoopData = ['Passport', 'National ID', 'Driver License']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($doc); ?>" <?php echo e(old('identity_type', $hostFormData['identity_type'] ?? '') == $doc ? 'selected' : ''); ?>><?php echo e($doc); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group <?php echo e($errors->has('identity_image') ? 'has-error' : ''); ?>">
                                <label for="identity_image"><?php echo e(__('Identity Image')); ?></label>
                                <div class="needsclick dropzone" id="identity_image-dropzone"></div>
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


        Dropzone.options.identityImageDropzone = {
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
                $('form').find('input[name="identity_image"]').remove();
                $('form').append('<input type="hidden" name="identity_image" value="' + response.name + '">');
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form').find('input[name="identity_image"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1;
                }
            },

            init: function () {
                <?php if(isset($appUser) && $appUser->identity_image): ?>
                    var file = <?php echo json_encode($appUser->identity_image); ?>; // This is similar to the profile_image method
                    this.options.addedfile.call(this, file);
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url);
                    file.previewElement.classList.add('dz-complete');
                    $('form').append('<input type="hidden" name="identity_image" value="' + file.file_name + '">');
                    this.options.maxFiles = this.options.maxFiles - 1;
                <?php endif; ?>
                },

            error: function (file, response) {
                let message = $.type(response) === 'string' ? response : response.errors.file;
                file.previewElement.classList.add('dz-error');
                const errorElements = file.previewElement.querySelectorAll('[data-dz-errormessage]');
                errorElements.forEach(function (node) {
                    node.textContent = message;
                });
            }
        }


        function updateDefaultCountry() {
            var phoneCountryDialCode = document.getElementById("phone_country").value;
            var countries = <?php echo json_encode(config('countries'), 15, 512) ?>; // Get the countries data as JSON
            var selectedCountry = countries.find(function (country) {
                return country.dial_code === phoneCountryDialCode;
            });
            if (selectedCountry) {
                document.getElementById("default_country").value = selectedCountry.code;
            }
        }

        // Call the function on page load to set the default country based on the current selection
        document.addEventListener("DOMContentLoaded", function () {
            updateDefaultCountry();
        });
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($api_google_map_key->meta_value ?? ''); ?>&libraries=places&callback=initAutocomplete"></script>

    <script>
        function initAutocomplete() {
            const input = document.getElementById('full_address');
            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(["formatted_address"]);
            autocomplete.addListener('place_changed', function () {
                const place = autocomplete.getPlace();
                if (place.formatted_address) {
                    input.value = place.formatted_address;
                }
            });
        }
        handleToggleUpdate(
            '.profileVerify',
            '/admin/update-appuser-status',
            'status',
            {
                title: 'Are You Sure?',
                text: 'Are you sure you want to change the status?',
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
            }
        );

        handleToggleUpdate(
            '.emailVerify',
            '/admin/update-appuser-emailverify',
            'email_verify',
            {
                title: 'Are You Sure?',
                text: 'Are you sure you want to change the status?',
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
            }
        );

        handleToggleUpdate(
            '.documentVerify',
            '/admin/update-appuser-host-status',
            'document_verify',
            {
                title: 'Are You Sure?',
                text: 'Are you sure you want to change the status?',
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
            }
        );

        handleToggleUpdate(
            '.phoneVerify',
            '/admin/update-appuser-phoneverify',
            'phone_verify',
            {
                title: 'Are You Sure?',
                text: 'Are you sure you want to change the status?',
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'Cancel'
            }
        );

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/appUsers/user/account.blade.php ENDPATH**/ ?>