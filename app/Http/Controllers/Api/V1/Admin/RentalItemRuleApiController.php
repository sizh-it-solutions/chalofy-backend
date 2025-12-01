<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait,MiscellaneousTrait};
use App\Models\{RentalItemRule};
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalItemRuleApiController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait;
  public function index()
    {
        $rules = RentalItemRule::all();

        return response()->json($rules);
    }

    public function getItemRules(Request $request)
    {
        try {
            $module = $this->getModuleIdOrDefault($request);
            $cancellationPolicies = RentalItemRule::where('status', 1)
            ->where('module', $module)
            ->get();
    
            return $this->addSuccessResponse(200,trans('front.Result_found'), ['booking_rules' => $cancellationPolicies]);
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.ServerError_internal_server_error'), $e->getMessage());
        }
    }

}
