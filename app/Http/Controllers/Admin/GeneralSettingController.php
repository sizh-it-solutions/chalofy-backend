<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGeneralSettingRequest;
use App\Models\Modern\{Item, ItemWishlist, Currency, ItemMeta, ItemType, ItemFeatures, ItemDate, ItemVehicle};
use App\Models\{AppUser, GeneralSetting, Booking, BookingExtension, Language, Payout, SupportTicket, SupportTicketReply, Transaction, Wallet, VendorWallet, Review, AppUserMeta, AppUsersBankAccount, AddCoupon, AppUserOtp, Media, CategoryTypeRelation, VehicleMake, City, RentalItemRule, VehicleOdometer, SubCategory};
use Gate;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GeneralSettingController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, EmailTrait, SMSTrait, PushNotificationTrait, NotificationTrait, UserWalletTrait, VendorWalletTrait;
    protected $paymentMethods = [
        'paypal' => [
            'meta_keys' => [
                'test_paypal_client_id',
                'test_paypal_secret_key',
                'live_paypal_client_id',
                'live_paypal_secret_key',
                'paypal_options',
                'paypal_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'paypal_options',
            'status_field' => 'paypal_status',
            'title' => 'PayPal',
            'fields' => ['client_id', 'secret_key'],
        ],
        'phonepe' => [
            'meta_keys' => [
                'test_phonepe_clientId',
                'test_phonepe_clientSecret',
                'live_phonepe_clientId',
                'live_phonepe_clientSecret',
                'phonepe_options',
                'phonepe_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'phonepe_options',
            'status_field' => 'phonepe_status',
            'title' => 'PhonePe',
            'fields' => ['clientId', 'clientSecret'],
        ],
        'stripe' => [
            'meta_keys' => [
                'test_stripe_public_key',
                'test_stripe_secret_key',
                'live_stripe_public_key',
                'live_stripe_secret_key',
                'stripe_options',
                'stripe_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'stripe_options',
            'status_field' => 'stripe_status',
            'title' => 'Stripe',
            'fields' => ['public_key', 'secret_key'],
        ],
        'razorpay' => [
            'meta_keys' => [
                'test_razorpay_key_id',
                'test_razorpay_secret_key',
                'live_razorpay_key_id',
                'live_razorpay_secret_key',
                'razorpay_options',
                'razorpay_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'razorpay_options',
            'status_field' => 'razorpay_status',
            'title' => 'Razorpay',
            'fields' => ['key_id', 'secret_key'],
        ],
        'transbank' => [
            'meta_keys' => [
                'test_transbank_client_id',
                'test_transbank_secret_key',
                'live_transbank_client_id',
                'live_transbank_secret_key',
                'transbank_options',
                'transbank_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'transbank_options',
            'status_field' => 'transbank_status',
            'title' => 'Transbank',
            'fields' => ['client_id', 'secret_key'],
        ],
        'paystack' => [
            'meta_keys' => [
                'test_paystack_public_key',
                'test_paystack_secret_key',
                'live_paystack_public_key',
                'live_paystack_secret_key',
                'paystack_options',
                'paystack_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'paystack_options',
            'status_field' => 'paystack_status',
            'title' => 'Paystack',
            'fields' => ['public_key', 'secret_key'],
        ],
        'flutterwave' => [
            'meta_keys' => [
                'test_flutterwave_public_key',
                'test_flutterwave_secret_key',
                'live_flutterwave_public_key',
                'live_flutterwave_secret_key',
                'flutterwave_options',
                'flutterwave_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'flutterwave_options',
            'status_field' => 'flutterwave_status',
            'title' => 'Flutterwave',
            'fields' => ['public_key', 'secret_key'],
        ],
        'paydunya' => [
            'meta_keys' => [
                'test_paydunya_master_key',
                'test_paydunya_private_key',
                'test_paydunya_status',
                'test_paydunya_token',
                'live_paydunya_master_key',
                'live_paydunya_private_key',
                'live_paydunya_status',
                'live_paydunya_token',
                'paydunya_options',
                'paydunya_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => 'paydunya_options',
            'status_field' => 'paydunya_status',
            'title' => 'Paydunya',
            'fields' => ['master_key', 'private_key', 'token'],
        ],
        'cash' => [
            'meta_keys' => [
                'cash_status',
                'onlinepayment',
            ],
            'view' => 'admin.generalSettings.paymentmethods.form',
            'options_field' => null,
            'status_field' => 'cash_status',
            'title' => 'Cash',
            'fields' => [],
        ],
    ];


    public function index(Request $request)
    {
        abort_if(Gate::denies('general_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = GeneralSetting::query()->select(sprintf('%s.*', (new GeneralSetting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'general_setting_show';
                $editGate = 'general_setting_edit';
                $deleteGate = 'general_setting_delete';
                $crudRoutePart = 'general-settings';

                return view(
                    'partials.datatablesActions',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('meta_key', function ($row) {
                return $row->meta_key ? $row->meta_key : '';
            });
            $table->editColumn('meta_value', function ($row) {
                return $row->meta_value ? $row->meta_value : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.generalSettings.index');
    }

    public function edit(GeneralSetting $generalSetting)
    {
        abort_if(Gate::denies('general_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.generalSettings.edit', compact('generalSetting'));
    }

    public function update(UpdateGeneralSettingRequest $request, GeneralSetting $generalSetting)
    {
        $generalSetting->update($request->all());

        return redirect()->route('admin.general-settings.index');
    }

    public function generalForm()
    {


        $metaKeys = [
            'general_name',
            'general_description',
            'general_email',
            'general_phone',
            'general_default_phone_country',
            'general_default_currency',
            'general_default_language',
            'general_favicon',
            'general_logo',
            'general_loginBackgroud',
            'general_minimum_price',
            'general_maximum_price',
            'feedback_intro',
            'ticket_intro',
            'general_captcha',
            'site_key',
            'private_key',
        ];

        $settings = GeneralSetting::whereIn('meta_key', $metaKeys)->get()->keyBy('meta_key');

        $general_name = $settings['general_name'] ?? null;
        $general_description = $settings['general_description'] ?? null;
        $general_email = $settings['general_email'] ?? null;
        $general_phone = $settings['general_phone'] ?? null;
        $general_default_phone_country = $settings['general_default_phone_country'] ?? null; //
        $general_default_currency = $settings['general_default_currency'] ?? null;
        $general_default_language = $settings['general_default_language'] ?? null;
        $general_favicon = $settings['general_favicon'] ?? null;
        $general_logo = $settings['general_logo'] ?? null;
        $general_minimum_price = $settings['general_minimum_price'] ?? null;
        $general_maximum_price = $settings['general_maximum_price'] ?? null;
        $feedback_intro = $settings['feedback_intro'] ?? null;
        $ticket_intro = $settings['ticket_intro'] ?? null;
        $general_captcha = $settings['general_captcha'] ?? null;
        $site_key = $settings['site_key'] ?? null;
        $private_key = $settings['private_key'] ?? null;
        $languagedata = Language::all();
        $allcurrency = Currency::where('status', 1)->get();
        return view('admin.generalSettings.general.BasicConfigurationForm', compact('general_name', 'general_email', 'general_phone', 'general_default_phone_country', 'general_default_currency', 'general_default_language', 'general_favicon', 'general_logo', 'languagedata', 'general_minimum_price', 'general_maximum_price', 'feedback_intro', 'ticket_intro', 'general_description', 'general_captcha', 'site_key', 'private_key', 'allcurrency'));
    }

    public function addConfigurationWizard(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }

        $formData = $request->except('_token', 'general_logo', 'general_favicon');

        if ($request->hasFile('general_logo')) {
            $file = $request->file('general_logo');
            $fileName = rand(10, 1000000) . '.' . $file->getClientOriginalName();
            $path = $file->storeAs('logo', $fileName, 'public');
            $formData['general_logo'] = $path;
        }

        if ($request->hasFile('general_favicon')) {
            $file = $request->file('general_favicon');
            $fileName = rand(10, 1000000) . '.' . $file->getClientOriginalName();
            $destinationPath = 'public/uploads/logo';
            $path = $file->storeAs('logo', $fileName, 'public');
            $formData['general_favicon'] = $path;
        }




        foreach ($formData as $metaKey => $metaValue) {
            if (!empty($metaValue)) {
                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }

        return redirect()->route('admin.settings')->with('success', 'Updated successfully.');
    }

    public function preferences()
    {
        $personalization_row_per_page = GeneralSetting::where('meta_key', 'personalization_row_per_page')->first();
        $personalization_min_search_price = GeneralSetting::where('meta_key', 'personalization_min_search_price')->first();
        $personalization_max_search_price = GeneralSetting::where('meta_key', 'personalization_max_search_price')->first();
        $personalization_date_separator = GeneralSetting::where('meta_key', 'personalization_date_separator')->first();
        $personalization_date_format = GeneralSetting::where('meta_key', 'personalization_date_format')->first();
        $personalization_timeZone = GeneralSetting::where('meta_key', 'personalization_timeZone')->first();
        $personalization_money_format = GeneralSetting::where('meta_key', 'personalization_money_format')->first();

        return view('admin.Preferences.NotificationPreferencesForm', compact('personalization_row_per_page', 'personalization_min_search_price', 'personalization_max_search_price', 'personalization_date_separator', 'personalization_date_format', 'personalization_timeZone', 'personalization_money_format'));
    }
    public function addPersonalization(Request $request)
    {
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {
            // Skip empty meta values
            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }
        return redirect()->route('admin.preferences');
    }

    public function smsSetting()
    {
        $keys = [
            'nonage_options',
            'nonage_status',
            'sms_provider_name',
            'messagewizard_sender_number',
            'auto_fill_otp'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $keys)->get()->keyBy('meta_key');

        $messagewizard_key = GeneralSetting::where('meta_key', 'messagewizard_key')->first();
        $messagewizard_secret = GeneralSetting::where('meta_key', 'messagewizard_secret')->first();
        $options = $settings->get('nonage_options') ?? null;
        $status = $settings->get('nonage_status') ?? null;
        $sms_provider_name = $settings->get('sms_provider_name') ?? null;
        $messagewizard_sender_number = $settings->get('messagewizard_sender_number') ?? null;
        $auto_fill_otp = $settings->get('auto_fill_otp') ?? null;


        $id = 1;

        return view('admin.generalSettings.smssettings.nonage', compact('messagewizard_secret', 'messagewizard_key', 'options', 'status', 'id', 'sms_provider_name', 'messagewizard_sender_number', 'auto_fill_otp'));
    }

    public function smsUpdate(Request $request)
    {


        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }
        $formData = $request->except('_token');

        if (isset($formData['messagewizard_status'])) {

            $formData['messagewizard_status'] = (int) ($formData['messagewizard_status'] === '1');


            GeneralSetting::updateOrCreate(
                ['meta_key' => 'messagewizard_status'],
                ['meta_value' => $formData['messagewizard_status']]
            );


            unset($formData['messagewizard_status']);
        }


        foreach ($formData as $metaKey => $metaValue) {
            // Skip empty meta values
            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }
        return response()->json(['message' => trans('global.data_has_been_submitted')], 200);
    }

    public function Msg91()
    {
        $keys = [

            'msg91_auth_key',
            'msg91_template_id',
            'sms_provider_name',
            'auto_fill_otp'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $keys)->get()->keyBy('meta_key');



        $msg91_auth_key = $settings->get('msg91_auth_key') ?? null;
        $msg91_template_id = $settings->get('msg91_template_id') ?? null;
        $sms_provider_name = $settings->get('sms_provider_name') ?? null;
        $auto_fill_otp = $settings->get('auto_fill_otp') ?? null;

        $id = 1;



        return view('admin.generalSettings.smssettings.msg91', compact('msg91_auth_key', 'msg91_template_id', 'id', 'sms_provider_name', 'auto_fill_otp'));
    }
    public function msg91Update(Request $request)
    {


        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }

        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            $existingSetting = GeneralSetting::where('meta_key', $metaKey)->first();

            if ($existingSetting) {

                $existingSetting->update(['meta_value' => $metaValue]);
            } else {

                GeneralSetting::create(['meta_key' => $metaKey, 'meta_value' => $metaValue]);
            }
        }

        return response()->json(['message' => trans('global.data_has_been_submitted')], 200);
    }
    public function twillioSetting()
    {
        $keys = [

            'twillio_options',
            'twillio_status',
            'sms_provider_name',
            'auto_fill_otp'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $keys)->get()->keyBy('meta_key');

        $twillio_key = GeneralSetting::where('meta_key', 'twillio_key')->first();
        $twillio_secret = GeneralSetting::where('meta_key', 'twillio_secret')->first();
        $twillio_number = GeneralSetting::where('meta_key', 'twillio_number')->first();
        $options = $settings->get('twillio_options') ?? null;
        $status = $settings->get('twillio_status') ?? null;
        $sms_provider_name = $settings->get('sms_provider_name') ?? null;
        $auto_fill_otp = $settings->get('auto_fill_otp') ?? null;

        $id = 1;

        return view('admin.generalSettings.smssettings.twillio', compact('twillio_key', 'twillio_secret', 'twillio_number', 'options', 'status', 'id', 'sms_provider_name', 'auto_fill_otp'));
    }
    public function twillioSmsUpdate(Request $request)
    {


        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }

        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            $existingSetting = GeneralSetting::where('meta_key', $metaKey)->first();

            if ($existingSetting) {

                $existingSetting->update(['meta_value' => $metaValue]);
            } else {

                GeneralSetting::create(['meta_key' => $metaKey, 'meta_value' => $metaValue]);
            }
        }

        return response()->json(['message' => trans('global.data_has_been_submitted')], 200);
    }
    public function nexmoSetting()
    {
        $nexmo_key = GeneralSetting::where('meta_key', 'nexmo_key')->first();
        $nexmo_secret = GeneralSetting::where('meta_key', 'nexmo_secret')->first();

        return view('admin.generalSettings.smssettings.nexmo', compact('nexmo_key', 'nexmo_secret'));
    }
    public function UpdateNexmoSetting(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }

        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            $existingSetting = GeneralSetting::where('meta_key', $metaKey)->first();

            if ($existingSetting) {

                $existingSetting->update(['meta_value' => $metaValue]);
            } else {

                GeneralSetting::create(['meta_key' => $metaKey, 'meta_value' => $metaValue]);
            }
        }

        return response()->json(['message' => trans('global.data_has_been_submitted')], 200);
    }

    public function sinchSetting()
    {

        $settings = GeneralSetting::whereIn('meta_key', ['sinch_service_plan_id', 'sinch_api_token', 'sinch_sender_number', 'sms_provider_name', 'auto_fill_otp'])
            ->get()
            ->keyBy('meta_key');

        $sinch_service_plan_id = $settings['sinch_service_plan_id'] ?? null;
        $sinch_api_token = $settings['sinch_api_token'] ?? null;
        $sinch_sender_number = $settings['sinch_sender_number'] ?? null;
        $sms_provider_name = $settings['sms_provider_name'] ?? null;
        $auto_fill_otp = $settings->get('auto_fill_otp') ?? null;

        $id = 1;

        return view('admin.generalSettings.smssettings.sinch', compact('sinch_service_plan_id', 'sinch_api_token', 'sinch_sender_number', 'id', 'sms_provider_name', 'auto_fill_otp'));
    }
    public function sinchSmsUpdate(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            $existingSetting = GeneralSetting::where('meta_key', $metaKey)->first();

            if ($existingSetting) {

                $existingSetting->update(['meta_value' => $metaValue]);
            } else {

                GeneralSetting::create(['meta_key' => $metaKey, 'meta_value' => $metaValue]);
            }
        }

        return response()->json(['message' => trans('global.data_has_been_submitted')], 200);
    }
    public function twoFactor()
    {
        $twofactor_key = GeneralSetting::where('meta_key', 'twofactor_key')->first();
        $twofactor_secret = GeneralSetting::where('meta_key', 'twofactor_secret')->first();
        $twofactor_merchant_id = GeneralSetting::where('meta_key', 'twofactor_merchant_id')->first();
        $twofactor_authentication_token = GeneralSetting::where('meta_key', 'twofactor_authentication_token')->first();

        return view('admin.generalSettings.smssettings.twofactor', compact('twofactor_key', 'twofactor_secret', 'twofactor_merchant_id', 'twofactor_authentication_token'));
    }
    public function UpdateTwofactor(Request $request)
    {
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            $existingSetting = GeneralSetting::where('meta_key', $metaKey)->first();

            if ($existingSetting) {

                $existingSetting->update(['meta_value' => $metaValue]);
            } else {

                GeneralSetting::create(['meta_key' => $metaKey, 'meta_value' => $metaValue]);
            }
        }

        return redirect()->route('admin.twofactor');
    }



    public function emailSetting()
    {

        // if (Gate::denies('general_setting_edit')) {
        //     return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        // }

        $settingsKeys = [
            'emailwizard_driver',
            'host',
            'port',
            'from_email',
            'encryption',
            'username',
            'password',
            'emailwizard_from_name',
            'emailwizard_email_status',
            'emailwizard_key',
            'emailwizard_secret'
        ];


        $settings = GeneralSetting::whereIn('meta_key', $settingsKeys)->get()->keyBy('meta_key');
        $viewData = [];
        foreach ($settingsKeys as $key) {
            $viewData[$key] = $settings->get($key);
        }
        return view('admin.generalSettings.emailsetting.emailsettingform', $viewData);
    }

    public function addEmailWizard(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {
            // Skip empty meta values
            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }
        return redirect()->route('admin.email')->with('success', 'Updated successfully.');
        // return redirect()->route('admin.email');
    }

    public function fees()
    {
        $feesetup_guest_service_charge = GeneralSetting::where('meta_key', 'feesetup_guest_service_charge')->first();
        $feesetup_iva_tax = GeneralSetting::where('meta_key', 'feesetup_iva_tax')->first();
        $feesetup_accomodation_tax = GeneralSetting::where('meta_key', 'feesetup_accomodation_tax')->first();
        $feesetup_admin_commission = GeneralSetting::where('meta_key', 'feesetup_admin_commission')->first();
        $feesetup_accomodation_tax_get = GeneralSetting::where('meta_key', 'feesetup_accomodation_tax_get')->first();
        $feesetup_iva_tax_get = GeneralSetting::where('meta_key', 'feesetup_iva_tax_get')->first();
        $feesetup_guest_service_charge_get = GeneralSetting::where('meta_key', 'feesetup_guest_service_charge_get')->first();

        return view('admin.generalSettings.fees.FinancialSettingsForm', compact('feesetup_guest_service_charge', 'feesetup_iva_tax', 'feesetup_accomodation_tax', 'feesetup_admin_commission', 'feesetup_iva_tax_get', 'feesetup_accomodation_tax_get', 'feesetup_guest_service_charge_get'));
    }

    public function FeesSetupAdd(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            if ($metaValue !== null) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]

                );
            }
        }
        return redirect()->route('admin.fees')->with('success', 'Updated successfully.');
        // return redirect()->route('admin.fees');

    }
    public function language()
    {
        $listdata = Language::all();
        return view('admin.language.language_form', compact('listdata'));
    }

    public function apiInformations()
    {


        $meta_keys = [
            'api_facebook_client_id',
            'api_facebook_client_secret',
            'api_google_client_id',
            'api_google_client_secret',
            'api_google_map_key',
            'general_captcha',
            'site_key',
            'private_key'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $meta_keys)->get()->keyBy('meta_key');


        $data = [];
        foreach ($meta_keys as $key) {

            $data[$key] = $settings->has($key) ? $settings->get($key) : '';
        }

        return view('admin.generalSettings.apicredentials.apikeymanagementform', $data);
    }

    public function apiAuthenticationAdd(Request $request)
    {


        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]

                );
            }
        }
        return redirect()->route('admin.api-informations')->with('success', 'Updated successfully.');
        // return redirect()->route('admin.api-informations');
    }


    public function socialLinks()
    {
        $socialmedia_facebook = GeneralSetting::where('meta_key', 'socialmedia_facebook')->first();
        $socialmedia_google_plus = GeneralSetting::where('meta_key', 'socialmedia_google_plus')->first();
        $socialmedia_twitter = GeneralSetting::where('meta_key', 'socialmedia_twitter')->first();
        $socialmedia_linkedin = GeneralSetting::where('meta_key', 'socialmedia_linkedin')->first();
        $socialmedia_pinterest = GeneralSetting::where('meta_key', 'socialmedia_pinterest')->first();
        $socialmedia_youtube = GeneralSetting::where('meta_key', 'socialmedia_youtube')->first();
        $socialmedia_instagram = GeneralSetting::where('meta_key', 'socialmedia_instagram')->first();

        return view('admin.generalSettings.SocialSetting.social_setting_form', compact('socialmedia_facebook', 'socialmedia_google_plus', 'socialmedia_twitter', 'socialmedia_linkedin', 'socialmedia_pinterest', 'socialmedia_youtube', 'socialmedia_instagram'));
    }
    public function socialMediaAdd(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]

                );
            }
        }
        return redirect()->route('admin.social-links');
    }
    public function socialLogins()
    {
        $socialnetwork_google_login = GeneralSetting::where('meta_key', 'socialnetwork_google_login')->first();
        $socialnetwork_facebook_login = GeneralSetting::where('meta_key', 'socialnetwork_facebook_login')->first();
        $socialnetwork_apple_login = GeneralSetting::where('meta_key', 'socialnetwork_apple_login')->first();

        return view('admin.generalSettings.sociallogin.login', compact('socialnetwork_google_login', 'socialnetwork_facebook_login', 'socialnetwork_apple_login'));
    }
    public function socialNetworkAdd(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $formData = $request->except('_token');

        if (isset($formData['socialnetwork_google_login'])) {

            $formData['socialnetwork_google_login'] = (int) ($formData['socialnetwork_google_login'] === '1');


            GeneralSetting::updateOrCreate(
                ['meta_key' => 'socialnetwork_google_login'],
                ['meta_value' => $formData['socialnetwork_google_login']]
            );

            unset($formData['socialnetwork_google_login']);
        }
        if (isset($formData['socialnetwork_apple_login'])) {

            $formData['socialnetwork_apple_login'] = (int) ($formData['socialnetwork_apple_login'] === '1');

            GeneralSetting::updateOrCreate(
                ['meta_key' => 'socialnetwork_apple_login'],
                ['meta_value' => $formData['socialnetwork_apple_login']]
            );

            unset($formData['socialnetwork_apple_login']);
        }

        foreach ($formData as $metaKey => $metaValue) {

            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }
        return redirect()->route('admin.social-logins')->with('success', 'Updated successfully.');
        // return redirect()->route('admin.social-logins');
    }
    // add paypal


    public function orangeMoneyAdd(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $options = $request->paydunya_options;

        if ($options == 'test') {

            $formData = $request->except('_token', 'live_paydunya_master_key', 'live_paydunya_private_key', 'live_paydunya_token', 'live_paydunya_status');

            if (isset($formData['test_paydunya_status'])) {

                $formData['test_paydunya_status'] = (int) ($formData['test_paydunya_status'] === '1');

                GeneralSetting::updateOrCreate(
                    ['meta_key' => 'test_paydunya_status'],
                    ['meta_value' => $formData['test_paydunya_status']]
                );

                unset($formData['test_paydunya_status']);
            }

            foreach ($formData as $metaKey => $metaValue) {

                if (!empty($metaValue)) {

                    GeneralSetting::updateOrCreate(
                        ['meta_key' => $metaKey],
                        ['meta_value' => $metaValue]
                    );
                }
            }
            return redirect()->route('admin.payment-methods');
        }
        if ($options == 'live') {
            $formData = $request->except('_token', 'test_paydunya_master_key', 'test_paydunya_private_key', 'test_paydunya_token', 'test_paydunya_status');

            if (isset($formData['live_paydunya_status'])) {

                $formData['live_paydunya_status'] = (int) ($formData['live_paydunya_status'] === '1');

                GeneralSetting::updateOrCreate(
                    ['meta_key' => 'live_paydunya_status'],
                    ['meta_value' => $formData['live_paydunya_status']]
                );

                unset($formData['live_paydunya_status']);
            }

            foreach ($formData as $metaKey => $metaValue) {

                if (!empty($metaValue)) {

                    GeneralSetting::updateOrCreate(
                        ['meta_key' => $metaKey],
                        ['meta_value' => $metaValue]
                    );
                }
            }
            return redirect()->route('admin.payment-methods');
        }
    }
    // public function livePaydunyaAdd(Request $request){

    //         $formData = $request->except('_token');

    //         if (isset($formData['live_paydunya_status'])) {

    //             $formData['live_paydunya_status'] = (int) ($formData['live_paydunya_status'] === '1');

    //             GeneralSetting::updateOrCreate(
    //                 ['meta_key' => 'live_paydunya_status'],
    //                 ['meta_value' => $formData['live_paydunya_status']]
    //             );

    //             unset($formData['live_paydunya_status']);
    //         }

    //         foreach ($formData as $metaKey => $metaValue) {

    //         if (!empty($metaValue)) {

    //          GeneralSetting::updateOrCreate(
    //              ['meta_key' => $metaKey],
    //              ['meta_value' => $metaValue]
    //          );
    //      }
    //  }
    //         return redirect()->route('admin.payment-methods');
    // }
    // add language
    public function addLanguage()
    {

        return view('admin.language.create');
    }
    public function addLanguageData(Request $request)
    {

        $data = [
            'name' => $request->name,
            'short_name' => $request->short_name,
            'language_status' => $request->language_status,
        ];
        Language::create($data);

        return redirect()->route('admin.language');
    }

    public function editLanguage(Request $request)
    {
        $id = $request->id;
        $editdata = Language::find($id);

        return view('admin.language.edit', compact('editdata'));
    }

    public function editLanguageData(Request $request)
    {
        $id = $request->id;
        Language::where('id', $id)->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'language_status' => $request->language_status,
        ]);

        return redirect()->route('admin.language');
    }
    public function deleteLanguage($id)
    {
        Language::where('id', $id)->delete();
        return response()->json(['message' => 'Language deleted successfully.']);
    }
    public function becomeHost()
    {
        $general_host_title_first = GeneralSetting::where('meta_key', 'general_host_title_first')->first();
        $general_host_title_second = GeneralSetting::where('meta_key', 'general_host_title_second')->first();
        $general_host_title_third = GeneralSetting::where('meta_key', 'general_host_title_third')->first();
        $general_host_title_fourth = GeneralSetting::where('meta_key', 'general_host_title_fourth')->first();
        $general_host_link = GeneralSetting::where('meta_key', 'general_host_link')->first();
        $general_becomehost_image = GeneralSetting::where('meta_key', 'general_becomehost_image')->first();

        return view('admin.generalSettings.become-host.index', compact('general_host_title_first', 'general_host_link', 'general_becomehost_image', 'general_host_title_second', 'general_host_title_third', 'general_host_title_fourth'));
    }
    public function addBecomeHost(Request $request)
    {

        $formData = $request->except('_token', 'general_becomehost_image');
        if ($request->hasFile('general_becomehost_image')) {
            $file = $request->file('general_becomehost_image');
            $fileName = rand(10, 1000000) . '.' . $file->getClientOriginalName();
            $destinationPath = public_path() . '/uploads/image';
            $file->move($destinationPath, $fileName);

            $formData['general_becomehost_image'] = $fileName;
        }
        foreach ($formData as $metaKey => $metaValue) {

            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }

        return redirect()->route('admin.become.host');
    }



    public function updateCashStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.']);
        }
        $status = $request->input('status');
        $id = $request->input('id');


        $setting = GeneralSetting::where('meta_key', 'cash_status')->first();

        if ($setting) {
            $setting->meta_value = $status;
            $setting->save();
        }

        return response()->json(['success' => "Updated Successfully."]);
    }

    // public function updateOnlineStatus(Request $request)
    // {

    //     if (Gate::denies('general_setting_edit')) {
    //         return response()->json(['error' => 'Form submission is disabled in demo mode.']);
    //     }
    //     $status = $request->input('status');

    //     GeneralSetting::updateOrCreate(
    //         ['meta_key' => 'onlinepayment'],
    //         ['meta_value' => $status]
    //     );

    //     return response()->json(['success' => "Updated Successfully"]);
    // }
    public function updateStripeStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.']);
        }
        $status = $request->input('status');
        $id = $request->input('id');


        $setting = GeneralSetting::where('meta_key', 'stripe_status')->first();

        if ($setting) {
            $setting->meta_value = $status;
            $setting->save();
        }

        return response()->json(['success' => "Updated Successfully"]);
    }


    public function updateTransbankStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.']);
        }

        $status = $request->input('status');

        GeneralSetting::updateOrCreate(
            ['meta_key' => 'transbank_status'],
            ['meta_value' => $status]
        );

        return response()->json(['success' => "Updated Successfully"]);
    }

    public function updateRazorpayStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.']);
        }
        $status = $request->input('status');
        $id = $request->input('id');

        $razorpaySetting = GeneralSetting::firstOrNew(['meta_key' => 'razorpay_status']);
        $razorpaySetting->meta_value = $status;
        $razorpaySetting->save();

        return response()->json(['success' => "Updated Successfully"]);
    }

    public function updateMethodsStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $status = $request->input('status');
        $id = $request->input('id');

        $setting = GeneralSetting::where('meta_key', 'paydunya_status')->first();

        if ($setting) {
            $setting->meta_value = $status;
            $setting->save();
        }

        return response()->json(['success' => true]);
    }



    public function updateNonageStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        error_log('Update Nonage Status called'); // Debug log

        $status = $request->input('status');
        $id = $request->input('id');
        error_log('Status: ' . $status . ', ID: ' . $id); // Log received status and id

        // Update Nonage status
        $nonageSetting = GeneralSetting::firstOrNew(['meta_key' => 'nonage_status']);
        $nonageSetting->meta_value = $status;
        $nonageSetting->save();

        // If Nonage is activated, deactivate Twillio
        if ($status === 'Active') {
            $twillioSetting = GeneralSetting::where('meta_key', 'twillio_status')->first();
            if ($twillioSetting) {
                $twillioSetting->meta_value = 'Inactive';
                $twillioSetting->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function updateTwillioeStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        error_log('Update Twillio Status called'); // Debug log

        $status = $request->input('status');
        $id = $request->input('id');
        error_log('Status: ' . $status . ', ID: ' . $id); // Log received status and id

        // Update Twillio status
        $twillioSetting = GeneralSetting::firstOrNew(['meta_key' => 'twillio_status']);
        $twillioSetting->meta_value = $status;
        $twillioSetting->save();

        // If Twillio is activated, deactivate Nonage
        if ($status === 'Active') {
            $nonageSetting = GeneralSetting::where('meta_key', 'nonage_status')->first();
            if ($nonageSetting) {
                $nonageSetting->meta_value = 'Inactive';
                $nonageSetting->save();
            }
        }

        return response()->json(['success' => true]);
    }
    public function updateSMSProviderName(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        error_log('Update Sinch Status called'); // Debug log

        $status = $request->input('status');
        $id = $request->input('id');
        $userValue = $request->input('userValue');
        error_log('Status: ' . $status . ', ID: ' . $id); // Log received status and id

        // Update sinch status
        $smsSetting = GeneralSetting::firstOrNew(['meta_key' => 'sms_provider_name']);
        $smsSetting->meta_value = $userValue;
        $smsSetting->save();


        return response()->json(['success' => true]);
    }



    // GeneralSettingController.php

    public function pushNotificaTionSetting()
    {
        $settings = GeneralSetting::whereIn('meta_key', ['pushnotification_key', 'push_notification_status', 'onesignal_app_id', 'onesignal_rest_api_key'])
            ->get()
            ->keyBy('meta_key');

        $pushnotification_key = $settings['pushnotification_key'] ?? null;
        $pushnotification_status = $settings['push_notification_status'] ?? null;
        $onesignal_app_id = $settings['onesignal_app_id'] ?? null;
        $onesignal_rest_api_key = $settings['onesignal_rest_api_key'] ?? null;


        $userids = AppUser::pluck('first_name', 'id')->map(function ($item, $key) {
            $user = AppUser::find($key);
            return $item . ' - ' . $user->phone . ' - ' . $user->email;
        })->prepend(trans('global.pleaseSelect'), '');



        return view('admin.generalSettings.pushnotification.pushnotification', compact('pushnotification_key', 'userids', 'pushnotification_status', 'onesignal_app_id', 'onesignal_rest_api_key'));
    }

    public function pushNotificationUpdate(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }
        $request->validate([
            'pushnotification_key' => 'required|string',
            'onesignal_app_id' => 'required|string',
            'onesignal_rest_api_key' => 'required|string',
        ]);


        GeneralSetting::updateOrCreate(
            ['meta_key' => 'pushnotification_key'],
            ['meta_value' => $request->pushnotification_key]
        );

        GeneralSetting::updateOrCreate(
            ['meta_key' => 'onesignal_app_id'],
            ['meta_value' => $request->onesignal_app_id]
        );

        GeneralSetting::updateOrCreate(
            ['meta_key' => 'onesignal_rest_api_key'],
            ['meta_value' => $request->onesignal_rest_api_key]
        );

        return response()->json(['success' => 'Push notification key updated successfully!']);
    }


    public function sendUserMessage(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }

        $request->validate([
            'userid_id' => 'required',
            'message' => 'required|string',
        ]);

        $message = $request->message ?? '';
        $subject = $request->subject ?? '';

        $settings = GeneralSetting::whereIn('meta_key', [
            'push_notification_status'
        ])->get()->pluck('meta_value', 'meta_key')->toArray();

        if ($request->userid_id == 'All') {
            $users = AppUser::with('metadata')->get();
        } else {
            $users = AppUser::with('metadata')->where('id', $request->userid_id)->get();
        }




        foreach ($users as $user) {
            if ($settings['push_notification_status'] == 'onesignal') {
                $playerId = $user->metadata->firstWhere('meta_key', 'player_id')->meta_value ?? null;
                if ($playerId) {
                    $this->sendPushNotification($playerId, $subject, $message);
                }
            } else {
                $this->sendPushNotification($user['fcm'], $subject, $message);
            }
        }

        return response()->json(['success' => 'Notification sent successfully!']);
    }

    private function sendPushNotification($fcm, $subject, $message)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.']);
        }
        $this->sendFcmMessage($fcm, $subject, $message);
    }

    public function updatePushNotificationStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $type = $request->input('type');

        // Update Twillio status
        $pushNotificationStatus = GeneralSetting::firstOrNew(['meta_key' => 'push_notification_status']);
        $pushNotificationStatus->meta_value = $type;
        $pushNotificationStatus->save();

        return response()->json(['success' => true]);
    }
    public function currencySetting()
    {
        $keys = [
            'currency_auth_key',
            'general_default_currency',
            'general_default_currency_symbol',
            'multicurrency_status'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $keys)->get()->keyBy('meta_key');
        $general_default_currency_main = $settings->get('general_default_currency') ?? null;
        $general_default_currency_symbol = $settings->get('general_default_currency_symbol') ?? null;
        $currency_auth_key = $settings->get('currency_auth_key') ?? null;
        $multicurrency_status = $settings->get('multicurrency_status') ?? null;
        $allcurrency = Currency::where('status', 1)->get();

        $id = 1;

        return view('admin.generalSettings.currencysettings.currency', compact('currency_auth_key', 'general_default_currency_symbol', 'general_default_currency_main', 'allcurrency', 'multicurrency_status'));
    }

    public function updateCurrencyAuthKey(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }

        $formData = $request->except('_token');
        foreach ($formData as $metaKey => $metaValue) {

            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]

                );
            }
        }
        return redirect()->route('admin.currencySetting')->with('success', 'Updated successfully.');
    }

    public function updateAutoFillOTP(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }
        $status = $request->input('status');
        if ($status == 'Active') {
            $stat = 1;
        } else {
            $stat = 0;
        }
        $id = $request->input('id');
        $setting = GeneralSetting::updateOrCreate(
            ['meta_key' => 'auto_fill_otp'],
            ['meta_value' => $stat]
        );

        return response()->json(['success' => true]);
    }

    public function bookingSetting()
    {
        $keys = [
            'total_number_of_bookings_per_day'
        ];

        $settings = GeneralSetting::whereIn('meta_key', $keys)->get()->keyBy('meta_key');

        $total_number_of_bookings_per_day = $settings->get('total_number_of_bookings_per_day') ?? null;

        return view('admin.generalSettings.bookingsettings.bookings', compact('total_number_of_bookings_per_day'));
    }

    public function updateBookingSetting(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $formData = $request->except('_token');

        foreach ($formData as $metaKey => $metaValue) {

            if (!empty($metaValue)) {

                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]

                );
            }
            return redirect()->route('admin.bookingSetting')->with('success', 'Updated successfully.');
        }
    }

    public function appScreenSetting()
    {

        $keys = [
            'app_item_type',
            'app_popular_region',
            'app_near_you',
            'app_make',
            'app_most_viewed',
            'app_become_lend',
            'app_show_distance',
        ];


        $settings = GeneralSetting::whereIn('meta_key', $keys)
            ->get()
            ->keyBy('meta_key');
        return view('admin.generalSettings.appscreensettings.appscreensettings', compact('settings'));
    }




    public function updateAppScreenSetting(Request $request)
    {

        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }
        $selectedSettings = $request->input('settings', []);

        $allSettings = [
            'item_type',
            'popular_region',
            'near_you',
            'make',
            'most_viewed',
            'become_lend',
            'show_distance',
        ];
        foreach ($allSettings as $metaKey) {

            $prefixedMetaKey = "app_" . $metaKey;
            $isChecked = in_array($metaKey, $selectedSettings);

            GeneralSetting::updateOrCreate(
                ['meta_key' => $prefixedMetaKey],
                ['meta_value' => $isChecked ? 'Active' : 'Inactive']
            );
        }

        return redirect()->route('admin.appscreensetting')->with('success', 'App screen settings updated successfully.');
    }


    public function setMulticurrency(Request $request)
    {

        $stat = $request->input('status') === 'Active' ? 1 : 0;

        $id = $request->input('id');

        // Using updateOrCreate to update or insert the setting
        $setting = GeneralSetting::updateOrCreate(
            ['meta_key' => 'multicurrency_status'],
            ['meta_value' => $stat]
        );

        return response()->json(['success' => true]);
    }

    public function projectSetup()
    {


        return view('admin.generalSettings.projectSetup.setup');
    }

    public function projectSetupAjax(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('optimize:clear');
            cache()->forget('roles_with_permissions');
            function deleteDirectory($dirPath)
            {
                if (!is_dir($dirPath)) {
                    return;
                }

                $files = scandir($dirPath);
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..')
                        continue;

                    $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
                    is_dir($filePath) ? deleteDirectory($filePath) : unlink($filePath);
                }
                rmdir($dirPath);
            }

            // Remove the storage directory if it exists
            $publicStoragePath = public_path('storage');
            if (is_link($publicStoragePath)) {
                unlink($publicStoragePath);  // If it's a symlink, remove it
            } elseif (is_dir($publicStoragePath)) {
                deleteDirectory($publicStoragePath);  // If it's a directory, delete recursively
            }
            // Create storage link if not exists
            if (!file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
            }

            return response()->json([
                'success' => true,
                'message' => 'Project setup completed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project setup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function projectCleanupAjax(Request $request)
    {
        return false;
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('optimize:clear');
            cache()->forget('roles_with_permissions');

            ItemMeta::query()->forceDelete();
            Item::all()->each(function ($item) {
                if ($item->front_image) {
                    $item->front_image->delete();
                    $item->clearMediaCollection('front_image');
                }

                if ($item->gallery) {
                    $item->gallery->each(function ($media) {
                        $media->delete();
                    });
                    $item->clearMediaCollection('gallery');
                }

                if ($item->front_image_doc) {
                    $item->front_image_doc->delete();
                    $item->clearMediaCollection('front_image_doc');
                }

                ItemMeta::where('rental_item_id', $item->id)->delete();

                $item->forceDelete();
            });
            Wallet::query()->forceDelete();
            Payout::all()->each(function ($payout) {
                $payout->clearMediaCollection();
                $payout->forceDelete();
            });
            VendorWallet::query()->forceDelete();
            ItemWishlist::query()->forceDelete();
            SupportTicketReply::query()->forceDelete();
            SupportTicket::query()->forceDelete();
            Transaction::query()->forceDelete();
            Review::query()->forceDelete();
            Booking::query()->forceDelete();
            BookingExtension::query()->forceDelete();
            ItemDate::query()->forceDelete();
            ItemVehicle::query()->forceDelete();
            AddCoupon::query()->forceDelete();
            AppUserOtp::query()->forceDelete();
            AppUsersBankAccount::query()->forceDelete();
            AppUserMeta::query()->forceDelete();

            AppUser::all()->each(function ($user) {
                if ($user->profile_image) {
                    $user->profile_image->delete();
                    $user->clearMediaCollection('profile_image');
                }

                if ($user->identity_image) {
                    $user->identity_image->delete();
                    $user->clearMediaCollection('identity_image');
                }

                $user->forceDelete();
            });



            CategoryTypeRelation::query()->forceDelete();
            ItemType::query()->forceDelete();
            ItemFeatures::query()->forceDelete();
            SubCategory::query()->forceDelete();
            VehicleMake::query()->forceDelete();
            City::query()->forceDelete();
            RentalItemRule::query()->forceDelete();
            VehicleOdometer::query()->forceDelete();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $tables = [
                'media',
                'rental_item_wishlists',
                'rental_item_meta',
                'rental_items',
                'wallets',
                'payouts',
                'vendor_wallets',
                'support_ticket_replies',
                'support_tickets',
                'transactions',
                'reviews',
                'bookings',
                'booking_extensions',
                'rental_item_dates',
                'rental_item_vehicle',
                'add_coupons',
                'app_user_otps',
                'app_users_bank_accounts',
                'app_user_meta',
                'app_users',
            ];


            foreach ($tables as $table) {
                DB::statement("TRUNCATE TABLE {$table};");
            }

            $sqlPath = storage_path('dummy_data.sql');

            if (file_exists($sqlPath)) {
                DB::unprepared(file_get_contents($sqlPath));
            }


            $settings = [
                'auto_fill_otp' => 1,
                'general_captcha' => 'no',
                'onlinepayment' => 'Inactive',
                'api_google_map_key' => 'test',
                'site_key' => 'test',
                'private_key' => 'test',
                'messagewizard_key' => 'test',
                'messagewizard_secret' => 'test',
                'messagewizard_sender_number' => 'test',
                'twillio_number' => 'test',
                'twillio_key' => 'test',
                'twillio_secret' => 'test',
                'sinch_service_plan_id' => 'test',
                'sinch_api_token' => 'test',
                'sinch_sender_number' => 'test',
                'msg91_auth_key' => 'test',
                'msg91_template_id' => 'test',
                'host' => 'test',
                'port' => '111',
                'username' => 'test',
                'password' => 'test',
                'encryption' => 'test',
                'from_email' => 'test',
                'currency_auth_key' => 'test',
                'onesignal_app_id' => 'test',
                'onesignal_rest_api_key' => 'test',
                'test_paypal_client_id' => 'test',
                'test_paypal_secret_key' => 'test',
                'live_paypal_client_id' => 'test',
                'live_paypal_secret_key' => 'test',
                'test_stripe_public_key' => 'test',
                'test_stripe_secret_key' => 'test',
                'live_stripe_public_key' => 'test',
                'live_stripe_secret_key' => 'test',
                'test_razorpay_key_id' => 'test',
                'test_razorpay_secret_key' => 'test',
                'live_razorpay_key_id' => 'test',
                'live_razorpay_secret_key' => 'test',
                'cash_status' => 'Active',
            ];

            foreach ($settings as $meta_key => $meta_value) {
                GeneralSetting::updateOrCreate(
                    ['meta_key' => $meta_key],
                    ['meta_value' => $meta_value]
                );
            }


            $filePathLoginCred = resource_path('views/admin/demo/demo-user.blade.php');
            file_put_contents($filePathLoginCred, '');

            $filePathwhatsapp = resource_path('views/admin/demo/whatsapp-chat.blade.php');
            file_put_contents($filePathwhatsapp, '');

            $storagePath = storage_path('app/public');
            $excludedFolder = 'logo';

            // Delete all folders except 'logo'
            $allFolders = File::directories($storagePath);
            foreach ($allFolders as $folder) {
                if (basename($folder) !== $excludedFolder) {
                    File::deleteDirectory($folder);
                }
            }

            $allFiles = File::files($storagePath);
            foreach ($allFiles as $file) {
                File::delete($file);
            }

            $uploadPath = storage_path('tmp/uploads');
            if (File::exists($uploadPath)) {
                File::cleanDirectory($uploadPath);
            }
            $mediaTempPath = storage_path('media-library/temp');
            if (File::exists($mediaTempPath)) {
                File::cleanDirectory($mediaTempPath);
            }
            $logsPath = storage_path('logs');
            if (File::exists($logsPath)) {
                File::cleanDirectory($logsPath);
            }

            $sessionsPath = storage_path('framework/sessions');
            if (File::exists($sessionsPath)) {
                $files = File::files($sessionsPath);
                foreach ($files as $file) {
                    @unlink($file);
                }
            }

            $viewsPath = storage_path('framework/views');
            if (File::exists($viewsPath)) {
                $files = File::files($viewsPath);
                foreach ($files as $file) {
                    @unlink($file);
                }
            }

            $testingPath = storage_path('framework/testing');
            if (File::exists($testingPath)) {
                $files = File::files($testingPath);
                foreach ($files as $file) {
                    @unlink($file);
                }
            }

            $installerPath = base_path('installer');
            if (!file_exists($installerPath)) {
                mkdir($installerPath, 0777, true);
            }

            $debugbarPath = storage_path('debugbar');
            if (File::exists($debugbarPath)) {
                File::deleteDirectory($debugbarPath);
            }
            // $connection = config('database.default');
            // $dbConfig = config("database.connections.{$connection}");

            // $dbHost = $dbConfig['host'];
            // $dbUser = $dbConfig['username'];
            // $dbPass = $dbConfig['password'];
            // $dbName = $dbConfig['database'];

            // $dumpFileName = 'unibooker_vehicle.sql';
            // $dumpFilePath = $installerPath . '/' . $dumpFileName;
            // $command = "mysqldump --user=\"{$dbUser}\" --password=\"{$dbPass}\" --host=\"{$dbHost}\" \"{$dbName}\" > \"{$dumpFilePath}\"";
            // exec($command, $output, $resultCode);

            // if ($resultCode !== 0) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Database backup failed. Ensure mysqldump is installed and accessible on the server.',
            //     ], 500);
            // }

            $privacyPolicyPath = public_path('privacy_policy.html');
            $supportPath = public_path('support.html');

            if (file_exists($privacyPolicyPath)) {
                unlink($privacyPolicyPath);
            }

            if (file_exists($supportPath)) {
                unlink($supportPath);
            }
            return response()->json([
                'success' => true,
                'message' => 'Project cleanup completed successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project cleanup failed: ' . $e->getMessage(),
            ], 500);
        }
    }






    public function paymentMethodIndex($method)
    {
        
        abort_if(Gate::denies('general_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!isset($this->paymentMethods[$method])) {
            abort(404, 'Payment method not found');
        }

        $config = $this->paymentMethods[$method];
        $settings = GeneralSetting::whereIn('meta_key', $config['meta_keys'])
            ->get()
            ->keyBy('meta_key');

        $viewData = [
            'method' => $method,
            'title' => $config['title'],
            'options_field' => $config['options_field'],
            'status_field' => $config['status_field'],
            'fields_per_method' => $config['fields'] ?? [],
        ];

        foreach ($config['meta_keys'] as $key) {
            $viewData[$key] = $settings->get($key);
        }
        $status = $settings->get($config['status_field']);
        return view($config['view'], array_merge($viewData, [
            'status' => $status, // pass explicitly
        ]));
    }

    public function paymentMethodUpdate(Request $request, $method)
    {
        if (Gate::denies('general_setting_edit')) {
            return redirect()->back()->with('error', 'Form submission is disabled in demo mode.');
        }

        if (!isset($this->paymentMethods[$method])) {
            return redirect()->back()->with('error', 'Payment method not found.');
        }

        $config = $this->paymentMethods[$method];
        $optionsField = $config['options_field'];
        $options = $optionsField ? $request->input($optionsField) : null;
        $excludedKeys = [];
        // print_r( $config );
        // exit;

        // if ($options === 'test') {
        //     $excludedKeys = array_filter($config['meta_keys'], fn($key) => str_contains($key, 'live_'));
        // } elseif ($options === 'live') {
        //     $excludedKeys = array_filter($config['meta_keys'], fn($key) => str_contains($key, 'test_'));
        // }

        $formData = $request->except(array_merge(['_token'], $excludedKeys));

        foreach ($formData as $metaKey => $metaValue) {
            if (!empty($metaValue)) {
                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }

        return redirect()->back()->with('success', 'Updated successfully');
    }

    public function updatePaymentMethodStatus(Request $request, $method)
    {

        abort_if(Gate::denies('general_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); //
        if (!isset($this->paymentMethods[$method])) {
            return response()->json([
                'status' => 400,
                'message' => trans('global.something_went_wrong')
            ]);
        }

        $statusField = $this->paymentMethods[$method]['status_field'] ?? null;

        if (!$statusField) {
            return response()->json([
                'status' => 400,
                'message' => trans('global.something_went_wrong')
            ]);


        }
        $status = strtolower($request->status) === '1' ? 'Active' : 'Inactive';
        GeneralSetting::updateOrCreate(
            ['meta_key' => $statusField],
            ['meta_value' => $status]
        );


        return response()->json([
            'status' => 200,
            'message' => trans('global.status_updated_successfully')
        ]);

    }
    public function updateOnlineStatus(Request $request)
    {
        if (Gate::denies('general_setting_edit')) {
            return response()->json(['error' => 'Form submission is disabled in demo mode.'], 403);
        }

        $status = $request->input('status');

        GeneralSetting::updateOrCreate(
            ['meta_key' => 'onlinepayment'],
            ['meta_value' => $status]
        );

        return response()->json(['success' => 'Updated Successfully']);
    }

}


