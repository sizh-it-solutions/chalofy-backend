@extends('layouts.admin')

@section('styles')
    <style>
        .dataTables_info {
            display: none;
        }
        .paging_simple_numbers {
            display: none;
        }
        .pagination.justify-content-end {
            float: right;
        }
        .main-footer {
            overflow: hidden;
            margin-left: 0;
        }
        .dataTables_length {
            display: none;
        }
    </style>
@endsection

@section('content')

<div class="content">
    <!-- Profile Edit Section Start -->
    <div class="box">
        <div class="panel-body">
  
            <div class="nav-tabs-custom">
                @include('admin.overviewcustomer.overviewtabs')
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Edit User Profile Form -->
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Detail</h3>
    </div>
    <div class="box-body">
    <form method="POST" action="{{ route('admin.app-users.update', [$appUser->id]) }}?from_overviewprofile=true" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="user_type" value="{{ request()->input('user_type') }}">

        {{-- Row 1: First, Middle, Last Name --}}
        <div class="row">
            <div class="form-group col-md-4 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                <label class="required" for="first_name">{{ trans('global.name') }}</label>
                <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name', $appUser->first_name) }}" required>
                @error('first_name') <span class="help-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 {{ $errors->has('middle') ? 'has-error' : '' }}">
                <label for="middle">{{ trans('global.middle') }}</label>
                <input class="form-control" type="text" name="middle" id="middle" value="{{ old('middle', $appUser->middle) }}">
                @error('middle') <span class="help-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 {{ $errors->has('last_name') ? 'has-error' : '' }}">
                <label for="last_name">{{ trans('global.last_name') }}</label>
                <input class="form-control" type="text" name="last_name" id="last_name" value="{{ old('last_name', $appUser->last_name) }}">
                @error('last_name') <span class="help-block">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Row 2: Email, Phone Country, Phone --}}
        <div class="row">
            <div class="form-group col-md-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('global.email') }}</label>
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email', $appUser->email) }}">
                @error('email') <span class="help-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 {{ $errors->has('phone_country') ? 'has-error' : '' }}">
                <label for="phone_country">{{ trans('global.phone_country') }}</label>
                <select class="form-control" name="phone_country" id="phone_country" onchange="updateDefaultCountry()">
                    @foreach (config('countries') as $country)
                        <option value="{{ $country['dial_code'] }}" {{ old('phone_country', $appUser->phone_country) == $country['dial_code'] ? 'selected' : '' }}>
                            {{ $country['name'] }} ({{ $country['dial_code'] }})
                        </option>
                    @endforeach
                </select>
                @error('phone_country') <span class="help-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 {{ $errors->has('phone') ? 'has-error' : '' }}">
                <label class="required" for="phone">{{ trans('global.phone') }}</label>
                <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', $appUser->phone) }}" required>
                @error('phone') <span class="help-block">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Hidden Default Country --}}
        <input type="hidden" name="default_country" id="default_country" value="{{ old('default_country', $appUser->default_country) }}">

        {{-- Row 3: Password, Status, Package --}}
        <div class="row">
            <div class="form-group col-md-4 {{ $errors->has('password') ? 'has-error' : '' }}">
                <label class="required" for="password">{{ trans('global.password') }}</label>
                <input class="form-control" type="password" name="password" id="password">
                @error('password') <span class="help-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 {{ $errors->has('status') ? 'has-error' : '' }}">
                <label>{{ trans('global.status') }}</label>
                <select class="form-control" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\AppUser::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $appUser->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status') <span class="help-block">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-4 {{ $errors->has('package') ? 'has-error' : '' }}">
                <label for="package_id">{{ trans('global.package') }}</label>
                <select class="form-control select2" name="package_id" id="package_id">
                    @foreach($packages as $id => $entry)
                        <option value="{{ $id }}" {{ (old('package_id') ? old('package_id') : $appUser->package->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @error('package') <span class="help-block">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Row 4: Image Upload --}}
        <div class="form-group">
        <label for="profile_image">{{ trans('global.profile_image') }}</label>
                            <div class="needsclick dropzone" id="profile_image-dropzone">
                            </div>
                            @if($errors->has('profile_image'))
                                <span class="help-block" role="alert">{{ $errors->first('profile_image') }}</span>
                            @endif
        </div>

        @if(request()->input('user_type') === 'vendor')
    <hr>
    <h4>{{ __('Vendor Additional Information') }}</h4>

    {{-- Preserve existing host_status from DB or request --}}
    <input type="hidden" name="host_status" value="{{ old('host_status', $appUser->host_status) }}">

    <div class="row">
        <div class="form-group col-md-6">
            <label for="company_name">{{ __('Company Name') }}</label>
            <input class="form-control" type="text" name="company_name" id="company_name"
                   value="{{ old('company_name', $hostFormData['company_name'] ?? '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="residency_type">{{ __('Residency Type') }}</label>
            <select class="form-control" name="residency_type" id="residency_type">
                @foreach(['Citizenship', 'Permanent Resident', 'Work Permit', 'Other'] as $type)
                    <option value="{{ $type }}" {{ old('residency_type', $hostFormData['residency_type'] ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label for="full_address">{{ __('Full Address') }}</label>
            <input type="text" class="form-control" name="full_address" id="full_address"
                   value="{{ old('full_address', $hostFormData['full_address'] ?? '') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="identity_type">{{ __('Identity Type') }}</label>
            <select class="form-control" name="identity_type" id="identity_type">
                @foreach(['Passport', 'National ID', 'Driver License'] as $doc)
                    <option value="{{ $doc }}" {{ old('identity_type', $hostFormData['identity_type'] ?? '') == $doc ? 'selected' : '' }}>{{ $doc }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{ $errors->has('identity_image') ? 'has-error' : '' }}">
        <label for="identity_image">{{ __('Identity Image') }}</label>
        <div class="needsclick dropzone" id="identity_image-dropzone"></div>
        @error('identity_image') <span class="help-block" role="alert">{{ $message }}</span> @enderror
    </div>
@endif



        <div class="form-group">
            <button class="btn btn-danger" type="submit">
                {{ trans('global.save') }}
            </button>
        </div>
    </form>
</div>

    </div>
    <!-- Profile Edit Section End -->
</div>

@endsection

@section('scripts')
<script>
    Dropzone.options.profileImageDropzone = {
    url: '{{ route('admin.app-users.storeMedia') }}',
    maxFilesize: 1, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
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
@if(isset($appUser) && $appUser->profile_image)
      var file = {!! json_encode($appUser->profile_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="profile_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
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
        url: '{{ route('admin.app-users.storeMedia') }}',
        maxFilesize: 1, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
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
            @if(isset($appUser) && $appUser->identity_image)
                var file = {!! json_encode($appUser->identity_image) !!}; // This is similar to the profile_image method
                this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url);
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="identity_image" value="' + file.file_name + '">');
                this.options.maxFiles = this.options.maxFiles - 1;
            @endif
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
</script>





<script>
    // Update the default_country field based on the phone_country selection
    function updateDefaultCountry() {
        var phoneCountryDialCode = document.getElementById("phone_country").value;
        var countries = @json(config('countries')); // Get the countries data as JSON
        var selectedCountry = countries.find(function(country) {
            return country.dial_code === phoneCountryDialCode;
        });

        // Update the default country input with the selected country code
        if (selectedCountry) {
            document.getElementById("default_country").value = selectedCountry.code;
        }
    }

    // Call the function on page load to set the default country based on the current selection
    document.addEventListener("DOMContentLoaded", function() {
        updateDefaultCountry();
    });
</script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $api_google_map_key->meta_value ?? '' }}&libraries=places&callback=initAutocomplete"></script>

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
@endsection