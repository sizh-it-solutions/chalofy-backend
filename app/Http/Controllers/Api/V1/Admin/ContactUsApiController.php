<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait,MiscellaneousTrait};
use App\Models\{AppUser,Contact};
use Gate;
use Illuminate\Http\Request;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class ContactUsApiController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait;

    /**
     * Get featured items with front image, pagination, and offset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactUs(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
               
                'token' => 'required',
                'tittle' => 'required',
                'description' => 'required',
               
    
            ]);
          
            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            $user_id = $this->checkUserByToken($request->token);
    
            if (!$user_id) {
                return $this->addErrorResponse(419, trans('front.token_not_match'), '');
            }
          
            if ($user_id) {
                $contact = new Contact();
                $contact->tittle = $request->tittle;
                $contact->description = $request->description;
                $contact->user = $user_id;
                $contact->status = 1;
                $contact->save();
                return $this->addSuccessResponse(200,trans('front.feedback_added'), ['ContactUs' => $contact]);
            }
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }
    
}