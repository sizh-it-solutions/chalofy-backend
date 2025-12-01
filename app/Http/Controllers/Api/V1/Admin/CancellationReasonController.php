<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait,MiscellaneousTrait};
use App\Models\{BookingCancellationReason};
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CancellationReasonController extends Controller
{   use MediaUploadingTrait,ResponseTrait,MiscellaneousTrait;
    public function getCancelReasons(Request $request)
    {
        try {
            $userType = $request->input('userType');
            $module = $this->getModuleIdOrDefault($request);
             $reasons = BookingCancellationReason::where('user_type', $userType)
             ->where('status', 1)
             ->where('module', $module)
             ->get();
           return $this->addSuccessResponse(200, trans('front.cancellation_reasons_retrieved_successfully'), ['reasons' => $reasons]);
        } 
         catch (\Exception $e) {
            return $this->addErrorResponse(401, trans('front.failed_to_retrieve_cancellation_reasons'));
        }
    }
}
