   $(document).ready(function () {


    $('.open-payout-modal').off("click").on("click", function (e) {
        e.preventDefault();
        const payoutId = $(this).data('payout-id');
        const amount = $(this).data('amount');
        const vendor = $(this).data('vendor');
        $('#payoutModal #modalPayoutId').val(payoutId);
        $('#payoutModal #modalAmount').text(amount);
        $('#payoutModal #modalVendor').text(vendor);
        $('#payoutModal').modal('show');
    });


    $('#payoutForm').off("submit").on("submit", function (e) {
        e.preventDefault();
        const payoutId = $('#payoutModal #modalPayoutId').val();
        const formData = new FormData(this);
        $.ajax({
            url: payoutUpdateStatus.replace(':payoutId', payoutId),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                $('#payoutModal').modal('hide');
                Swal.fire("Success", "Payout released successfully!", "success").then(() => {
                    window.location.reload();
                });
            },
            error: function () {
                Swal.fire("Error", "Something went wrong.", "error");
            }
        });
    });


    $('.payout-reject').off('click').on('click', function (e) {
        e.preventDefault();
        $('#rejectModal #modalPayoutId').val($(this).data('payout-id'));
        $('#rejectModal #vendorName').text($(this).data('vendor'));
        $('#rejectModal #vendorAmount').text($(this).data('amount'));
        $('#rejectModal #rejectReason').val('');
        $('#rejectModal').modal('show');
    });

    $('#rejectForm').off('submit').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $('#loader').show();
        $.post(payoutReject, formData, function () {
            $('#rejectModal').modal('hide');
            location.reload();
        }).fail(function (xhr) {
            alert('Failed: ' + xhr.responseJSON.message);
        }).always(function () {
            $('#loader').hide();
        });
    });

    $('#resetBtn').off("click").on("click", function () {
        const form = $('#filterForm')[0];
        if (form) {
            form.reset();
        }
        $('#filterForm select').val(null).trigger('change');
        window.location.href = window.location.pathname; // reload without parameters
    });


    $('#filterForm').off("submit").on('submit', function () {
        return true;
    });
    $('#filterBtn').off('click').on('click', function () {
    $('#filterForm')[0].submit(); // native submit, no AJAX
});
});