@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('payout.edit') }} {{ trans('payout.payout_title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.payouts.update', [$payout->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        {{-- Vendor Selector --}}
                        <div class="form-group {{ $errors->has('vendorid') ? 'has-error' : '' }}">
                            <label class="required" for="drivers">{{ trans('menu.driver') }}</label>
                            <select class="form-control select2" name="vendorid" id="drivers" required>
                                @if($payout->vendor)
                                    <option value="{{ $payout->vendor->id }}" selected>{{ $payout->vendor->name }}</option>
                                @endif
                            </select>
                            @if($errors->has('vendorid'))
                                <span class="help-block" role="alert">{{ $errors->first('vendorid') }}</span>
                            @endif
                        </div>

                        {{-- Amount --}}
                        <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
                            <label class="required" for="amount">{{ trans('payout.amount') }}</label>
                            <input class="form-control" type="number" name="amount" id="amount"
                                value="{{ old('amount', $payout->amount) }}" step="0.01" required>
                            <small id="wallet_balance_display" class="form-text text-muted"></small>
                            @if($errors->has('amount'))
                                <span class="help-block" role="alert">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>

                        {{-- Payment Method --}}
                        <div class="form-group {{ $errors->has('payment_method') ? 'has-error' : '' }}">
                            <label class="required" for="payment_method">{{ trans('payout.payment_method') }}</label>
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value="">{{ trans('payout.please_select') }}</option>
                                @foreach(['bank_transfer', 'paypal', 'stripe', 'cash', 'upi'] as $method)
                                    <option value="{{ $method }}" {{ old('payment_method', $payout->payment_method) == $method ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $method)) }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('payment_method'))
                                <span class="help-block" role="alert">{{ $errors->first('payment_method') }}</span>
                            @endif
                        </div>

                        {{-- Account Number --}}
                        <div class="form-group {{ $errors->has('account_number') ? 'has-error' : '' }}">
                            <label for="account_number">{{ trans('payout.account_number') }}</label>
                            <input class="form-control" type="text" name="account_number" id="account_number" value="{{ old('account_number', $payout->account_number) }}">
                            @if($errors->has('account_number'))
                                <span class="help-block" role="alert">{{ $errors->first('account_number') }}</span>
                            @endif
                        </div>

                        {{-- Payout Proof --}}
                        <div class="form-group {{ $errors->has('payout_proof') ? 'has-error' : '' }}">
                            <label for="payout_proof">{{ trans('payout.payout_proof') }}</label>
                            <div class="needsclick dropzone" id="payout_proof-dropzone"></div>
                            @if($errors->has('payout_proof'))
                                <span class="help-block" role="alert">{{ $errors->first('payout_proof') }}</span>
                            @endif
                        </div>

                        {{-- Payout Status --}}
                        <div class="form-group {{ $errors->has('payout_status') ? 'has-error' : '' }}">
                            <label class="required" for="payout_status">{{ trans('payout.payout_status') }}</label>
                            <select class="form-control" name="payout_status" id="payout_status" required>
                                <option value="">{{ trans('payout.pleaseSelect') }}</option>
                                <option value="Success" {{ old('payout_status', $payout->payout_status) === 'Success' ? 'selected' : '' }}>Success</option>
                            </select>
                            @if($errors->has('payout_status'))
                                <span class="help-block" role="alert">{{ $errors->first('payout_status') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('payout.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.payoutProofDropzone = {
        url: '{{ route('admin.payouts.storeMedia') }}',
        maxFilesize: 10,
        acceptedFiles: '.jpeg,.jpg,.png,.gif,.pdf',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').find('input[name="payout_proof"]').remove()
            $('form').append('<input type="hidden" name="payout_proof" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            $('form').find('input[name="payout_proof"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
        },
        init: function () {
            @if(isset($payout) && $payout->payout_proof)
                var file = {!! json_encode(['name' => $payout->payout_proof, 'preview' => $payout->payout_proof_url]) !!};
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="payout_proof" value="' + file.name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            let message = $.type(response) === 'string' ? response : response.errors.file;
            file.previewElement.classList.add('dz-error');
            let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
            _ref.forEach(node => node.textContent = message);
        }
    }

    $(document).ready(function () {
        $('#drivers').select2({
            minimumInputLength: 3,
            ajax: {
                url: "{{ route('admin.payoutVendorSearch') }}",
                dataType: 'json',
                delay: 250,
                processResults: data => ({
                    results: data.map(d => ({ id: d.id, text: d.name }))
                }),
                cache: true
            },
            placeholder: "{{ trans('payout.please_select') }}"
        });

        $('#drivers').on('select2:select', function (e) {
            const vendorId = e.params.data.id;
            $.ajax({
                url: "{{ url('admin/driver/vendor-wallet') }}/" + vendorId,
                method: 'GET',
                success: function (res) {
                    const bal = parseFloat(res.wallet_balance) || 0;
                    $('#wallet_balance_display').text('Wallet balance: ' + bal.toFixed(2));
                    $('#amount')
                        .attr('max', bal)
                        .off('input.walletcheck')
                        .on('input.walletcheck', function () {
                            const val = parseFloat(this.value) || 0;
                            this.setCustomValidity(val > bal ? 'Amount cannot exceed wallet balance!' : '');
                        });
                },
                error: function () {
                    alert('Could not fetch wallet balance. Please try again.');
                }
            });
        });

        $('#drivers').on('select2:clear', function () {
            $('#wallet_balance_display').text('');
            $('#amount').removeAttr('max').off('input.walletcheck').get(0).setCustomValidity('');
        });
    });
</script>
@endsection
