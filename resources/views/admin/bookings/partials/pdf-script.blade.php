<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
document.getElementById('generatePDF').addEventListener('click', function () {

    const docDefinition = {
        content: [
            { text: 'Booking Receipt', style: 'header' },
            { text: 'Booking Details', style: 'subheader' },
            {
                table: {
                    widths: ['35%', '65%'],
                    body: [
                        ['Booking ID:', '{{ $Data->id }}'],
                        ['Reservation Code:', '{{ $Data->token }}'],
                        ['Booked Date:', '{{ \Carbon\Carbon::parse($Data->created_at)->format('h:i A, Y-m-d') }}'],
                        ['Item:', '{{ $Data->item->title }}'],
                        ['Check In:', '{{ $Data->start_time }}, {{ $Data->check_in }}'],
                        ['Check Out:', '{{ $Data->end_time }}, {{ $Data->check_out }}'],
                        ['Address:', '{{ $Data->item->address }}'],
                        ['Status:', '{{ $Data->status }}'],
                        @if($Data->status === 'Cancelled')
                        ['Cancellation Reason:', '{{ $Data->cancellation_reasion }}'],
                        @endif
                    ]
                },
                layout: 'lightHorizontalLines',
                margin: [0, 0, 0, 10]
            },

            { text: 'Customer Details', style: 'subheader' },
            {
                table: {
                    widths: ['35%', '65%'],
                    body: [
                        ['Name:', '{{ $Data->user->first_name ?? "" }} {{ $Data->user->last_name ?? "" }}'],
                        ['Email:', '{{ $Data->user->email ?? "" }}'],
                        ['Phone:', '{{ $Data->user->phone_country ?? "" }} {{ $Data->user->phone ?? "" }}'],
                    ]
                },
                layout: 'lightHorizontalLines',
                margin: [0, 0, 0, 10]
            },

            { text: 'Payment Details', style: 'subheader' },
            {
                table: {
                    widths: ['35%', '65%'],
                    body: [
                        ['Payment Method:', '{{ $Data->payment_method }}'],
                        ['Payment Status:', '{{ $Data->payment_status }}'],
                        ['Price / Day:', '{{ $general_default_currency->meta_value ?? "" }} {{ $Data->per_night }}'],
                        ['Duration:', '{{ $Data->total_night }} Days'],
                        ['Base Price:', '{{ $general_default_currency->meta_value ?? "" }} {{ $Data->base_price }}'],
                        @if(isset($Data->extension->doorStep_price) && $Data->extension->doorStep_price > 0)
                        ['Doorstep Delivery Price:', '+ {{ $general_default_currency->meta_value ?? "" }} {{ $Data->extension->doorStep_price }}'],
                        @endif
                        @if($Data->discount_price > 0)
                        ['Discount:', '- {{ $general_default_currency->meta_value ?? "" }} {{ $Data->discount_price }}'],
                        @endif
                        @if($Data->coupon_discount > 0)
                        ['Coupon Discount:', '- {{ $general_default_currency->meta_value ?? "" }} {{ $Data->coupon_discount }}'],
                        @endif
                        @if($Data->iva_tax > 0)
                        ['IVA Tax:', '+ {{ $general_default_currency->meta_value ?? "" }} {{ $Data->iva_tax }}'],
                        @endif
                        @if($Data->security_money > 0)
                        ['Security Money:', '+ {{ $general_default_currency->meta_value ?? "" }} {{ $Data->security_money }}'],
                        @endif
                        @if($Data->wall_amt > 0)
                        ['Wallet Amount:', '{{ $general_default_currency->meta_value ?? "" }} {{ $Data->wall_amt }}'],
                        @endif
                        ['Total:', '{{ $general_default_currency->meta_value ?? "" }} {{ $Data->total }}'],
                    ]
                },
                layout: 'lightHorizontalLines'
            }
        ],
        styles: {
            header: {
                fontSize: 18,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 15]
            },
            subheader: {
                fontSize: 14,
                bold: true,
                color: '#2c3e50',
                margin: [0, 10, 0, 5]
            }
        },
        defaultStyle: {
            fontSize: 10
        }
    };

    pdfMake.createPdf(docDefinition).download('booking-{{ $Data->token }}.pdf');
});
</script>
