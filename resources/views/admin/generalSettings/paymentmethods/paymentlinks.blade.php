<ul class="nav nav-tabs" style="display: inline-block;">
    @php
        $currentMethod = request()->route('method');
         $methodsToShow = ['paypal', 'stripe', 'razorpay', 'cash', 'transbank', 'phonepe'];
       // $methodsToShow = ['cash', 'phonepe'];
    @endphp

    @foreach($methodsToShow as $methodKey)
        <li class="{{ $currentMethod === $methodKey ? 'active' : '' }}">
            <a href="{{ route('admin.payment-methods.index', $methodKey) }}">
                {{ trans('global.' . $methodKey) }}
            </a>
        </li>
    @endforeach
</ul>
