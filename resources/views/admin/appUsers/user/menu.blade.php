<div class="driver-header">
 <div class="title">
    {{ $appUser->user_type === 'vendor' ? trans('user.user_detail') : trans('user.user_detail') }}
    – {{ $appUser->first_name }} {{ $appUser->last_name }}
</div>
    <div class="actions">
       @php
    $navItems = [
        [
            'url' => 'admin/customer/profile/' . $appUser->id,
            'label' => trans('user.overview'),
            'class' => 'btn-green',
            'icon' => '📄', // Overview icon
        ],
       
        [
            'url' => 'admin/customer/account/' . $appUser->id,
            'label' => trans('user.account'),
            'class' => 'btn-black',
            'icon' => '📑', // Account icon
        ],
         [
            'url' => 'admin/bookings/?customer=' . $appUser->id,
            'label' => trans('user.bookings'),
            'class' => 'btn-green',
            'icon' => '🗓️', // Bookings icon
            'target_blank' => true,
        ]
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