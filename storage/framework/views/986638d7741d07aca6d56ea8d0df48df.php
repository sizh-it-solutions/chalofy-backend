<?php $__env->startSection('content'); ?>
<section class="content">
            <div class="row gap-2">
                <?php echo $__env->make('admin.vehicles.addVehicle.vehicle_left_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                
                <div class="col-md-9">
                    <form id="baseUpdate">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($id); ?>">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <!-- <p class="mb-0 f-18 mt-1"><?php echo e(trans('global.what_kinds_of_car_are_you_listing')); ?></p> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="label-large fw-bold"><?php echo e(trans('global.what_kinds_of_car_are_you_listing')); ?> <span class="text-danger">*</span></label>
                                        <select name="car_type" id="car_type" data-saving="basics1" class="form-control f-14">
                                            <option value="">Please Select </option>
                                            <?php $__currentLoopData = $vehicleTypeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleTypeData1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vehicleTypeData1->id); ?>"
                                                    <?php echo e($YoulistingData ? '' : ($vehicleTypeData1->id == $vehicleData->item_type_id ? 'selected' : '')); ?>

                                                ><?php echo e($vehicleTypeData1->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <span class="error-message text-danger" id="base-car_type"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="label-large fw-bold"><?php echo e(trans('global.make')); ?> <span class="text-danger">*</span></label>
                                        <select name="make" id="vehicleMakeSelect" data-saving="basics1" class="form-control f-14">
                                            <option value="">Please Select </option>
                                          
                                        </select>
                                        <span class="error-message text-danger" id="base-make"></span>
                                    </div>
                                 
                                    <div class="col-md-4">
                                        <label class="label-large fw-bold"><?php echo e(trans('global.model')); ?> <span class="text-danger">*</span></label>
                                        <select name="model" id="vehicleModelSelect" data-saving="basics1" class="form-control f-14">
                                        <option value="" >Please Select </option>
                                     
                                              </select>
                                              <span class="error-message text-danger" id="base-model"></span>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="label-large fw-bold mt-4"><?php echo e(trans('global.year')); ?> <span class="text-danger">*</span></label>
                                        <select name="year" id="basics-select-bathrooms" data-saving="basics1" class="form-control f-14">
                                            <option value="">Please Select </option>
                                            <?php
                                                $currentYear = date('Y');
                                            ?>

                                            <?php for($i = $currentYear; $i >= $currentYear - 30; $i--): ?>
                                            <option value="<?php echo e($i); ?>"
                                                <?php echo e(isset($itemVehicle) && (int) $i === (int) $itemVehicle->year ? 'selected' : ''); ?>

                                            ><?php echo e($i); ?></option>

                                            <?php endfor; ?>
                                        </select>
                                        <span class="error-message text-danger" id="base-year"></span>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-large fw-bold mt-4"><?php echo e(trans('global.transmission')); ?></label>
                                        <select name="transmission" id="basics-select-bathrooms" data-saving="basics1" class="form-control f-14">
                                        <option value="Automatic" <?php echo e(isset($itemVehicle) && $itemVehicle->transmission === 'Automatic' ? 'selected' : ''); ?>>Automatic</option>
                                        <option value="Mannual" <?php echo e(isset($itemVehicle) && $itemVehicle->transmission === 'Mannual' ? 'selected' : ''); ?>>Mannual</option>

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-large fw-bold mt-4"><?php echo e(trans('global.odometer')); ?></label>
                                        <select name="odometer" id="basics-select-bathrooms" data-saving="basics1" class="form-control f-14">
                                            <option value="">Please Select </option>
                                            <?php $__currentLoopData = $vehicleOdoMeterData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleOdoMeterData1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vehicleOdoMeterData1->id); ?>"
                                                <?php echo e(isset($itemVehicle) && (int) $vehicleOdoMeterData1->id === (int) $itemVehicle->odometer ? 'selected' : ''); ?>

                                            ><?php echo e($vehicleOdoMeterData1->name); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="label-large fw-bold mt-4"><?php echo e(trans('global.number_of_seats')); ?> <span class="text-danger">*</span></label>
                                        <input type="number" name="number_of_seats" 
                                        value="<?php echo e(old('number_of_seats', isset($itemVehicle) ? $itemVehicle->number_of_seats : '')); ?>" 
                                        class="form-control f-14" min="1">

                                        <span class="error-message text-danger" id="base-number_of_seats"></span>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-large fw-bold mt-4"><?php echo e(trans('global.fuel_type')); ?></label>
                                        <select name="fuel_type" class="form-control f-14">
                                            <?php $__currentLoopData = $fuelTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fuelType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fuelType->id); ?>" 
                                                <?php echo e(isset($itemVehicle) && $itemVehicle->fuel_type_id == $fuelType->id ? 'selected' : ''); ?>>
                                                <?php echo e($fuelType->name); ?>

                                            </option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <span class="error-message text-danger" id="base-fuel_type"></span>
                                    </div>

                                </div>


                                <div class="row" style=" margin-top: 16px; ">
                                        <div><div class="col-6  col-lg-6  text-left">
                                        <a data-prevent-default="" href="<?php echo e(route('admin.vehicles.index')); ?>" class="btn btn-large btn-primary f-14" ><?php echo e(trans('global.back')); ?></a>
                                        </div>
                                        <div class="col-6  col-lg-6 text-right">
                                            <button type="button" class="btn btn-large btn-primary next-section-button text-white"><?php echo e(trans('global.next')); ?></button>
                                        </div></div>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
                <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
            </div>
        </section>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
        $(document).ready(function() {
    $('.text-white').click(function() {
        var id = <?php echo e($id); ?>;
       
        $.ajax({
            type: 'POST',
            url: '<?php echo e(route('admin.vehicles.base-Update')); ?>',
            data: $('#baseUpdate').serialize(),
            success: function(data) {
                $('.error-message').text(''); 
                window.location.href = '/admin/vehicles/description/' + id;

            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    var errors = response.responseJSON.errors;
                    $('.loaderText').hide();
                    // Reset error messages first
                    $('.error-message').text('');

                    // Then display new error messages
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            var errorMessage = errors[field][
                                0
                            ]; // get the first error message
                            $('#base-' + field).text(errorMessage);
                        }
                    }
                }
            }
        });
    });


});



    // $(document).ready(function() {
    //     $('#vehicleMakeSelect').on('change', function() {
    //         var makeId = $(this).val();
    //         $.ajax({
    //             url: '<?php echo e(route('admin.vehicles.get-vehicletype')); ?>',
    //             headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //             type: 'POST',
    //             data: { make: makeId },
    //             success: function(response) {
    //                 var modelSelect = $('#vehicleModelSelect');
    //                 modelSelect.empty();
    //                 modelSelect.append('<option value="">Please Select</option>'); // Add default option
    //                     response.forEach(function(item) {
    //                         modelSelect.append('<option value="' + item.id + '">' + item.model_name + '</option>');
    //                     });
    //             },
    //             error: function(xhr, status, error) {
    //                 // Handle errors here
    //             }
    //         });
    //     });
    // });

    $(document).ready(function () {
    // Function to load vehicle models based on the selected make
    function loadVehicleMake() {
        var typeId = $('#car_type').val();
       
        if (typeId) {
            $.ajax({
                url: '<?php echo e(route('admin.vehicles.get-vehiclemake')); ?>',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: { typeId: typeId },
                success: function (response) {
                    var modelSelect = $('#vehicleMakeSelect');
                    modelSelect.empty();
                    modelSelect.append('<option value="">Please Select</option>'); // Add default option
                    response.forEach(function (item) {
                        modelSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });

                    // Check if a selected model is stored in local storage and select it
                    var selectedModel = <?php echo json_encode(intval($MakeData ?? 0)); ?>;
                    console.log(selectedModel);
                    if (selectedModel) {
                        modelSelect.val(selectedModel);
                        loadVehicleModels();
                    }
                },
                error: function (xhr, status, error) {
                    // Handle errors here
                }
            });
        } else {
            // Clear the model select if no make is selected
            $('#vehicleMakeSelect').empty();
        }
    }

    // Load models when the page loads or when the make select changes
    loadVehicleMake();

    $('#car_type').on('change', function () {
        loadVehicleMake();
       
    });

    // Store the selected model in local storage when the model select changes
    $('#vehicleMakeSelect').on('change', function () {
        var selectedModel = $(this).val();
        if (selectedModel) {
            localStorage.setItem('selectedModel', selectedModel);
        } else {
            localStorage.removeItem('selectedModel');
        }
    });
});


    // Function to load vehicle models based on the selected make
    function loadVehicleModels() {
        var makeId = $('#vehicleMakeSelect').val();
        if (makeId) {
            $.ajax({
                url: '<?php echo e(route('admin.vehicles.get-vehicletype')); ?>',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: { make: makeId },
                success: function (response) {
                    var modelSelect = $('#vehicleModelSelect');
                    modelSelect.empty();
                    modelSelect.append('<option value="">Please Select</option>'); // Add default option
                    response.forEach(function (item) {
                        modelSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });

                    // Check if a selected model is stored in local storage and select it
                    var selectedModel = <?php echo e($ModelData ?? 0); ?>;
                    if (selectedModel) {
                        modelSelect.val(selectedModel);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle errors here
                }
            });
        } else {
            // Clear the model select if no make is selected
            $('#vehicleModelSelect').empty();
        }
    }

    // Load models when the page loads or when the make select changes
    //loadVehicleModels();

    $('#vehicleMakeSelect').on('change', function () {
        loadVehicleModels();
    });

    // Store the selected model in local storage when the model select changes
    $('#vehicleModelSelect').on('change', function () {
        var selectedModel = $(this).val();
        if (selectedModel) {
            localStorage.setItem('selectedModel', selectedModel);
        } else {
            localStorage.removeItem('selectedModel');
        }
    });



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/vehicles/addVehicle/base.blade.php ENDPATH**/ ?>