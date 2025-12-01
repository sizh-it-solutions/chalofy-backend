<div class="driver-header">
    <div class="title">
        {{ trans('user.vendor_detail') }}
        – {{ $appUser->first_name }} {{ $appUser->last_name }}
    </div>
    <div class="actions">
    @php
    $navItems = [
        [
            'url' => 'admin/vendor/profile/' . $appUser->id,
            'label' => trans('user.overview'),
            'class' => 'btn-green',
            'icon' => '📄',
        ],
        [
            'url' => 'admin/vendor/financial/' . $appUser->id,
            'label' => trans('user.financial'),
            'class' => 'btn-green',
            'icon' => '💰',
        ],
        [
            'url' => 'admin/payouts/?vendor=' . $appUser->id,
            'label' => trans('user.payouts'),
            'class' => 'btn-gray',
            'icon' => '🔔',
            'target_blank' => true,
        ],
        [
            'url' => 'admin/vendor/account/' . $appUser->id,
            'label' => trans('user.account_document'),
            'class' => 'btn-black',
            'icon' => '📑',
        ],
        [
            'url' => 'admin/vehicles?vendor=' . $appUser->id,
            'label' => trans('user.vehicles'),
            'class' => 'btn-blue',
            'icon' => '🚗',
            'target_blank' => true,
        ],
        [
            'url' => 'admin/bookings?host=' . $appUser->id,
            'label' => trans('user.bookings'),
            'class' => 'btn-blue',
            'icon' => '🗓️',
            'target_blank' => true,
        ],
    ];
@endphp

@foreach ($navItems as $item)
    @php
        $isActive = request()->is($item['url']) ? 'active' : '';
    @endphp
    <a href="{{ url($item['url']) }}"
       class="btn {{ $item['class'] }} {{ $isActive }}"
       @if (!empty($item['target_blank'])) target="_blank" @endif>
        @if (!empty($item['icon']))
            {{ $item['icon'] }}
        @endif
        {{ $item['label'] }}
    </a>
@endforeach



    </div>
</div>