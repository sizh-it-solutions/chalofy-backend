<ul class="nav navbar-pills nav-tabs nav-stacked no-margin" role="tablist">
    <li class="<?php echo e(request()->routeIs('admin.settings') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.settings')); ?>" data-group="profile"><?php echo e(trans('global.general_title')); ?></a>
    </li>
    <li class="<?php echo e(request()->routeIs('admin.projectsetup') ? 'active' : ''); ?>" style="display: none;">
        <a href="<?php echo e(route('admin.projectsetup')); ?>" data-group="profile"><?php echo e(trans('global.project_setup')); ?></a>
    </li>

    <li class="<?php echo e(request()->routeIs('admin.bookingSetting') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.bookingSetting')); ?>" data-group="booking">Bookings</a>
    </li>
    <li class="<?php echo e(request()->routeIs('admin.appscreensetting') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.appscreensetting')); ?>" data-group="booking">App Screen Settings</a>
    </li>
    <li
        class="<?php echo e(request()->routeIs('admin.smssetting') || request()->routeIs('admin.msg91') || request()->routeIs('admin.twilliosetting') || request()->routeIs('admin.nexmosetting') || request()->routeIs('admin.twofactor') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.smssetting')); ?>" data-group="sms"><?php echo e(trans('global.smssettings_title')); ?></a>
    </li>

    <li class="<?php echo e(request()->routeIs('admin.email') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.email')); ?>" data-group="sms"><?php echo e(trans('global.emailSettings_title')); ?></a>
    </li>
    <li class="<?php echo e(request()->routeIs('admin.currencySetting') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.currencySetting')); ?>" data-group="sms">Currency Settings</a>
    </li>
    <li class="<?php echo e(request()->routeIs('admin.pushnotification') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.pushnotification')); ?>" data-group="sms"><?php echo e(trans('global.push_notification_setting')); ?></a>
    </li>

    <li class="<?php echo e(request()->routeIs('admin.fees') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.fees')); ?>" data-group="sms"><?php echo e(trans('global.fees_title')); ?></a>
    </li>

    <li class="<?php echo e(request()->routeIs('admin.api-informations') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.api-informations')); ?>" data-group="sms"><?php echo e(trans('global.apiCredentials_title')); ?> </a>
    </li>


    <li class="
    <?php echo e(request()->routeIs('admin.payment-methods.index') ? 'active' : ''); ?>

">
        <a href="<?php echo e(route('admin.payment-methods.index', 'cash')); ?>" data-group="sms">
            <?php echo e(trans('global.paymentMethods_title')); ?>

        </a>
    </li>


    <li class="<?php echo e(request()->routeIs('admin.social-links') ? 'active' : ''); ?>" style="display:block">
        <a href="<?php echo e(route('admin.social-links')); ?>" data-group="sms"><?php echo e(trans('global.socialLinks_title')); ?> </a>
    </li>

    <li class="<?php echo e(request()->routeIs('admin.social-logins') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('admin.social-logins')); ?>" data-group="sms"><?php echo e(trans('global.socialLogins_title')); ?></a>
    </li>


</ul><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/admin/generalSettings/general-setting-links/links.blade.php ENDPATH**/ ?>