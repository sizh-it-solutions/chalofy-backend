<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, MiscellaneousTrait};
use App\Http\Requests\UpdateGeneralSettingRequest;
use App\Http\Resources\Admin\GeneralSettingResource;
use App\Models\{GeneralSetting, Module, Slider};
use App\Models\Modern\{Currency};
use Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GeneralSettingApiController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait;
    public function index()
    {
        abort_if(Gate::denies('general_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GeneralSettingResource(GeneralSetting::all());
    }

    public function update(UpdateGeneralSettingRequest $request, GeneralSetting $generalSetting)
    {
        $generalSetting->update($request->all());

        return (new GeneralSettingResource($generalSetting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
public function getGeneralSettings(Request $request)
{
    $module   = $this->getModuleIdOrDefault($request);
    $cacheTtl = config('cache.settings_ttl', 60);
    $domain   = rtrim(env('APP_URL'), '/') . '/';
    $currency = $request->input('selected_currency_code');

    try {
        $metaData = Cache::remember("general_settings_{$module}", $cacheTtl, function () use ($module, $domain) {
            $baseKeys   = [
                'general_email','general_phone','app_become_lend','app_show_distance','app_item_type','app_make',
                'app_most_viewed','app_near_you','app_popular_region','general_default_phone_country',
                'general_default_country_code','general_default_currency','general_default_language',
                'general_logo','general_favicon','personalization_min_search_price',
                'personalization_max_search_price','socialnetwork_google_login','timer',
                'feedback_intro','ticket_intro','general_description','general_minimum_price',
                'general_maximum_price','onlinepayment','show_distance',
            ];
            $moduleKeys = ['title','head_title','image_text','item_setting_image'];
            $allKeys    = array_merge($baseKeys, $moduleKeys);

            $settings = GeneralSetting::whereIn('meta_key', $allKeys)
                ->where(function($q) use ($module, $moduleKeys) {
                    $q->whereNotIn('meta_key', $moduleKeys)
                      ->orWhere(function($q2) use ($module, $moduleKeys) {
                          $q2->whereIn('meta_key', $moduleKeys)
                             ->where('module', $module);
                      });
                })
                ->pluck('meta_value','meta_key')
                ->toArray();

            $settings['head_title']               = $settings['head_title']    ?? '';
            $settings['general_title']            = $settings['title']         ?? '';
      

            $modules = Module::where('status', 1)
                ->get(['id', 'name']);
            $settings['activeModules'] = $modules->map(function ($m) {
                return [
                    'id'    => $m->id,
                    'name'  => $m->name,
                    'image' => $m->getFirstMediaUrl('front_image') ?: null,
                ];
            });

            $sliders = Slider::where('status', 1)
                ->where('module', $module)
                ->get(['id', 'heading', 'subheading']);
            $settings['sliders'] = $sliders->map(function ($s) {
                return [
                    'id'         => $s->id,
                    'heading'    => $s->heading,
                    'subheading' => $s->subheading,
                    'image'      => $s->getFirstMediaUrl('image') ?: null,
                ];
            });

            return $settings;
        });

        $rate = Currency::getValueByCurrencyCode($currency);
        $metaData['general_maximum_price'] = $this->formatPriceWithConversion(
            $metaData['general_maximum_price'] ?? 0,
            $currency,
            $rate
        );

         // Add currency symbol for default currency
        $defaultCurrency = $metaData['general_default_currency'] ?? 'INR';
        $metaData['general_default_currency_symbol'] = $this->getCurrencySymbolByCode($defaultCurrency);
        
        return $this->addSuccessResponse(200, trans('front.Result_found'), [
            'metaData' => $metaData
        ]); 
        // try {
    } catch (\Exception $e) {
        return $this->addErrorResponse(500, trans('front.something_wrong'));
    }
}



}
