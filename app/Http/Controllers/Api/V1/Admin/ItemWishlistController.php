<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, MiscellaneousTrait};
use App\Models\{AppUser};
use App\Models\Modern\{Item, ItemType, ItemWishlist};
use Illuminate\Http\Request;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class ItemWishlistController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait;

    public function addToWishlist(Request $request)
    {
        // try {
        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:app_users,token',
            'item_id' => 'required|exists:rental_items,id',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }

        $user_id = $user->id;
        $item_id = $request->input('item_id');
        $module = $this->getModuleIdOrDefault($request);
        $isAlreadyInWishlist = ItemWishlist::where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->exists();

        if ($isAlreadyInWishlist) {
            return $this->addErrorResponse(422,trans('front.already_exist'), '');
        }

        ItemWishlist::create([
            'user_id' => $user_id,
            'item_id' => $item_id,
            'module' => $module,
        ]);

        return $this->addSuccessResponse(200,trans('front.Added_successfully'), $item_id);
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    public function removeFromWishlist(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required|exists:app_users,token',
                'item_id' => 'required|exists:rental_items,id',
            ]);

            if ($validator->fails()) {
                return $this->errorComputing($validator);
            }

            $user = AppUser::where('token', $request->input('token'))->first();

            if (!$user) {
                return $this->addErrorResponse(404,trans('front.user_not_found'), '');
            }

            $item_id = $request->input('item_id');

            $wishlistItem = ItemWishlist::where('user_id', $user->id)
                ->where('item_id', $item_id)
                ->first();

            if (!$wishlistItem) {
                return $this->addErrorResponse(422,trans('front.item_not_found_in_wishlist'), '');
            }

            $wishlistItem->delete();

            return $this->addSuccessResponse(200,trans('front.removed_from_wishlist_successfully'), '');
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    public function getWishlist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:app_users,token',
        ]);
        // echo "yes";
        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
        $module = $this->getModuleIdOrDefault($request);
        $user = AppUser::where('token', $request->input('token'))->first();

        if (!$user) {
            return $this->addErrorResponse(404,trans('front.user_not_found'), '');
        }


        $wishlist = ItemWishlist::where('user_id', $user->id)
            ->with(['item' => function ($query) use ($module) {
                $query->where('status', 1)
                    ->where('module', $module);
            }])
            ->get()
            ->map(function ($wishlistItem) use ($user) {
                $item = $wishlistItem->item;

                if (!$item) {
                    return null; 
                }

                $itemModel = Item::find($item->id);
                if ($itemModel) {
                    $frontImage = $itemModel->getFirstMediaUrl('front_image', 'thumbnail');
                } else {
                    $frontImage = null; 
                }

                $formattedItem = $this->formatItemData($item);
                $formattedItem['image'] = $frontImage;

                $formattedItem['is_in_wishlist'] = $user
                    ? $user->itemWishlists()->where('item_id', $item->id)->exists()
                    : false;

                $itemType = ItemType::find($item->item_type_id);
                $formattedItem['item_type'] = $itemType ? $itemType->name : null;

                $formattedItem['latitude'] = strval($item->latitude);
                $formattedItem['longitude'] = strval($item->longitude);

                return $formattedItem;
            })
            ->filter(); 

        return $this->addSuccessResponse(200,trans('front.wishlist_items_fetched_successfully'), ['items' => $wishlist]);
        try {
        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }
}
