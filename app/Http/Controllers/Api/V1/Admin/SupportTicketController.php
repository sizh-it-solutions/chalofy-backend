<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, VendorWalletTrait};
use App\Models\{AppUser, SupportTicket, SupportTicketReply};
use Illuminate\Http\Request;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class SupportTicketController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, VendorWalletTrait;
    public function createSupportTicket(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->errorResponse(401,trans('front.user_not_found'));
        }
        $threadId = $this->generateUniqueThreadId();

        $thread = SupportTicket::create([
            'user_id' => $user->id,
            'thread_id' => $threadId,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
        $templateId = 41;
        $this->sendNotificationOnTicketReply($threadId, $user->id, $request->input('title'), $templateId);
        return $this->successResponse(200,trans('front.Support_ticket_thread_created_successfully'), ['thread' => $thread]);
        try {
        } catch (\Exception $e) {
            return $this->errorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }


    public function replyToSupportTicket(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'thread_id' => 'required|string', 
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->errorResponse(401,trans('front.user_not_found'));
        }

        $thread = SupportTicket::where('thread_id', $request->input('thread_id'))->first();

        if (!$thread) {
            return $this->errorResponse(404,trans('front.Support_ticket_thread_not_found'));
        }

        if ($thread->user_id != $user->id) {
            return $this->errorResponse(403,trans('front.not_have_permission'));
        }
        $thread_status = 1;
        $thread->update([
            'thread_status' => $thread_status,
        ]);

        $is_admin_reply = '0';
        $reply = SupportTicketReply::create([
            'thread_id' => "$thread->id",
            'user_id' => "$user->id",
            'message' => $request->input('message'),
            'is_admin_reply' => $is_admin_reply,
        ]);
        $templateId = 41;
        $this->sendNotificationOnTicketReply($thread->id, $user->id, $thread->title, $templateId);
        return $this->successResponse(200,trans('front.Support_ticket_reply_created_successfully'), ['reply' => $reply]);
        try {
        } catch (\Exception $e) {
            return $this->errorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    public function getUserThreads(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'offset' => 'nullable|numeric|min:0',
            'limit' => 'nullable|numeric|min:1',
        ]);
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        try {

            $user = AppUser::where('token', $request->input('token'))->first();

            if (!$user) {
                return $this->errorResponse(401,trans('front.user_not_found'));
            }

            $thread_status = $request->input('thread_status', 1);

            $threads = SupportTicket::where('user_id', $user->id)
                ->where('thread_status', $thread_status)
                ->orderByDesc('created_at')
                ->offset($offset)
                ->take($limit)
                ->get();
            $nextOffset = $offset + count($threads);
            if ($threads->isEmpty()) {
                $nextOffset = -1;
            }

            return $this->successResponse(200,trans('front.User_threads_retrieved_successfully'), ['threads' => $threads, 'offset' => $nextOffset]);
        } catch (\Exception $e) {
            return $this->errorResponse(500, trans('front.something_wrong'), $e->getMessage());
        }
    }


    public function getReplyThreads(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'thread_id' => 'required|string',
                'offset' => 'nullable|numeric|min:0',
                'limit' => 'nullable|numeric|min:1',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(400,trans('front.Validation_error'), $validator->errors());
            }

            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $user = AppUser::where('token', $request->input('token'))->first();

            if (!$user) {
                return $this->errorResponse(401,trans('front.user_not_found'));
            }

            $threadId = $request->input('thread_id');
            $thread = SupportTicket::where('thread_id', $threadId)->first();

            if (!$thread) {
                return $this->errorResponse(404,trans('front.Support_ticket_thread_not_found'));
            }

            if (trim($thread->user_id) === trim($user->id)) {
                $replyThreads = SupportTicketReply::where('thread_id', $thread->id)
                    ->orderByDesc('created_at')
                    ->offset($offset)
                    ->take($limit)
                    ->get();

                // Get the offset for the next page
                $nextOffset = $offset + count($replyThreads);
                if ($replyThreads->isEmpty()) {
                    $nextOffset = -1;
                }

                return $this->successResponse(200, trans('front.Reply_threads_retrieved_successfully'), [
                    'replyThreads' => $replyThreads,
                    'offset' => $nextOffset
                ]);
            } else {
                return $this->errorResponse(403,trans('front.You_do_not_have_permission_view_this_thread'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse(500, trans('front.something_wrong'), $e->getMessage());
        }
    }

    private function generateUniqueThreadId()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $threadId = '';

        do {
            for ($i = 0; $i < 5; $i++) {
                $threadId .= $characters[rand(0, strlen($characters) - 1)];
            }
            $exists = SupportTicket::where('thread_id', $threadId)->exists();
        } while ($exists);

        return $threadId;
    }


    public function closeSupportTicket(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'thread_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }


            $user = AppUser::where('token', $request->input('token'))->first();

            if (!$user) {
                return $this->errorResponse(401,trans('front.user_not_found'));
            }


            $thread = SupportTicket::where('thread_id', $request->input('thread_id'))->first();

            if (!$thread) {
                return $this->errorResponse(404,trans('front.Support_ticket_thread_not_found'));
            }

            if ($thread->user_id != $user->id) {
                return $this->errorResponse(403, trans('front.You_do_not_have_permission_close_this_thread'));
            }

            $thread->thread_status = 0;
            $thread->save();

            return $this->successResponse(200,trans('front.support_ticket_closed_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(500, trans('front.something_wrong'), $e->getMessage());
        }
    }
}
