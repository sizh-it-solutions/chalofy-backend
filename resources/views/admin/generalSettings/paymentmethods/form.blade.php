@extends('layouts.admin')

@section('content')
    @php
        $i = 0;
    @endphp

    <section class="content">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 settings_bar_gap">
                <div class="box box-info box_info">
                    <h4 class="all_settings f-18 mt-1 ms-3">{{ trans('global.manage_settings') }}</h4>
                    @include('admin.generalSettings.general-setting-links.links')
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">

                <div class="nav-tabs-custom">
                    @include('admin.generalSettings.paymentmethods.paymentlinks')

                    <div class="tab-content">
                        <div class="tab-pane active" id="banks">
                            <div class="box-body">

                                <form method="POST" action="{{ route('admin.payment-methods.update', $method) }}"
                                    class="form-horizontal">
                                    @csrf

                                    <div class="box-body">

                                        @php
                                            $modes = ['test', 'live'];
                                            $fields = $fields_per_method ?? [];
                                            $statusValue = $status->meta_value ?? 'Inactive';
                                            $checkboxId = 'status_toggle_' . $i++;
                                        @endphp

                                        {{-- Status Toggle aligned right --}}
                                        <div class="form-group">
                                            <div class="col-sm-12 text-right">

                                                <input class="check statusdata" type="checkbox" data-onstyle="success"
                                                    data-offstyle="danger" data-toggle="toggle" data-on="Active"
                                                    data-off="Inactive" id="{{ $checkboxId }}" {{ $statusValue == 'Active' ? 'checked' : '' }}>
                                                <label for="{{ $checkboxId }}" class="control-label checktoggle"
                                                    style="margin-right:10px;">
                                                    {{ __('global.status') }}
                                                </label>


                                            </div>
                                        </div>

                                        {{-- Payment Modes and Fields --}}
                                      @if($options_field !== null && isset($modes) && count($modes))
    {{-- Payment Method Modes and Fields --}}
    @foreach($modes as $mode)
        <div class="form-group">
            <div class="col-sm-12">
                <div class="radio">
                    <label>
                        <input type="radio"
                               name="{{ $options_field }}"
                               value="{{ $mode }}"
                               id="{{ $method }}_{{ $mode }}"
                               {{ (isset($$options_field) && $$options_field->meta_value == $mode) || (!isset($$options_field) && $mode == 'test') ? 'checked' : '' }}>
                        <strong>{{ ucfirst($mode) }}</strong>
                    </label>
                </div>
            </div>
        </div>

        @foreach($fields as $field)
            @php
                $key = "{$mode}_{$method}_{$field}";
                $label = $field_labels[$mode . '_' . $field] ?? ucfirst(str_replace('_', ' ', $field));
            @endphp
            <div class="form-group">
                <label for="{{ $key }}" class="col-sm-4 control-label">
                    {{ $label }} <span class="text-danger">*</span>
                </label>
                <div class="col-sm-6">
                    <input type="password"
                           class="form-control"
                           id="{{ $key }}"
                           name="{{ $key }}"
                           value="{{ $$key->meta_value ?? '' }}"
                           placeholder="{{ $label }}">
                </div>
            </div>
        @endforeach
    @endforeach
@endif


                                        {{-- Submit Button --}}
                                        <div class="box-footer">
                                          
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-save"></i> {{ __('global.save') }}
                                                </button>
                                          
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div> <!-- /.tab-pane -->
                    </div> <!-- /.tab-content -->
                </div> <!-- /.nav-tabs-custom -->
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
    </section>
@endsection

@section('scripts')
    @parent

    <script>
       handleToggleUpdate(
    '.statusdata',
    "{{ url('admin/payment-methods') }}/{{ $method }}/status",
    'status',
    {
        title: 'Are you sure?',
        text: 'Do you want to update the payment method status?',
        confirmButtonText: 'Yes, update',
        cancelButtonText: 'Cancel'
    }
);


    </script>
@endsection