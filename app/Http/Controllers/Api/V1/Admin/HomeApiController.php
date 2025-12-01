<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait, MediaUploadingTrait, MiscellaneousTrait, BookingAvailableTrait, };
use App\Models\{AppUser};
use App\Models\Modern\{Item, ItemType,Currency};
use Gate;
use Illuminate\Http\Request;
use Validator;

class HomeApiController extends Controller
{
    use MediaUploadingTrait, ResponseTrait, MiscellaneousTrait, BookingAvailableTrait;

    /**
     * Get home data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function homeData(Request $request)
    {
        try {

            $module = $this->getModuleIdOrDefault($request);

            $categoriesController = new \App\Http\Controllers\Api\V1\Admin\ItemTypeApiController();
            
            $categoryResponse = $categoriesController->getAllCategories($request);
            // Check if the response is successful
            if ($categoryResponse->getStatusCode() === 200) {
                $categoryData = $categoryResponse->getData(true);
                $itemTypes = isset($categoryData['data']['itemTypes']) ? $categoryData['data']['itemTypes'] : [];
            } else {
                return $this->addErrorResponse(500,trans('front.something_wrong'), '');
            }

            $makeController = new \App\Http\Controllers\Api\V1\Admin\MakeApiController();  
            $makeResponse = $makeController->getMakes($request);
            if ($makeResponse->getStatusCode() === 200) {
                $makeData = $makeResponse->getData(true);
                $allMakes = isset($makeData['data']['makes']) ? $makeData['data']['makes'] : [];
            } else {
                return $this->addErrorResponse(500,trans('front.something_wrong'), '');
            }

            $nearbyItemsResponse = $this->nearbyItems($request);

            $nearbyItems = [];
            if ($nearbyItemsResponse->getStatusCode() === 200) {
                $data = $nearbyItemsResponse->getData(true);

                $nearbyItems = isset($data['data']['items']) ? $data['data']['items'] : [];
            } else {
                return $this->addErrorResponse(500,trans('front.something_wrong'), '');
            }
            $featuredItemsResponse = $this->featuredItems($request);

            $featuredItems = [];
            if ($featuredItemsResponse->getStatusCode() === 200) {
                $data = $featuredItemsResponse->getData(true);

                $featuredItems = isset($data['data']['items']) ? $data['data']['items'] : [];
            } else {

                return $this->addErrorResponse(500,trans('front.something_wrong'), '');
            }

            $mostViewedItemsResponse = $this->mostViewedItems($request);

            $mostViewedItems = [];
            if ($mostViewedItemsResponse->getStatusCode() === 200) {
                $data = $mostViewedItemsResponse->getData(true);

                $mostViewedItems = isset($data['data']['items']) ? $data['data']['items'] : [];
            } else {
               
                return $this->addErrorResponse(500, 'else homdata', '');
            }

            $newArrivalItemsResponse = $this->newArrivalItems($request);

            $newArrivalItems = [];
            if ($newArrivalItemsResponse->getStatusCode() === 200) {
                $data = $newArrivalItemsResponse->getData(true);

                $newArrivalItems = isset($data['data']['items']) ? $data['data']['items'] : [];
            } else {

                return $this->addErrorResponse(500,trans('front.something_wrong'), '');
            }
            $citiesApiController = new \App\Http\Controllers\Api\V1\Admin\CitiesApiController();
            
            $locationsResponse = $citiesApiController->yourLocations($request);
            // Check if the response is successful
            if ($locationsResponse->getStatusCode() === 200) {
                $locationsData = $locationsResponse->getData(true);
                $locations = isset($locationsData['data']['Locations']) ? $locationsData['data']['Locations'] : [];
            } else {
                return $this->addErrorResponse(500,trans('front.something_wrong'), '');
            }
            return $this->addSuccessResponse(200,trans('front.Result_found'), [
                'itemTypes' => $itemTypes,
                'nearby_items' => $nearbyItems,
                'featured_items' => $featuredItems,
                'most_viewed_items' => $mostViewedItems,
                'new_arrival_items' => $newArrivalItems,
                'locations' => $locations,
                'makes' => $allMakes,
                
                
            ]);

        } catch (\Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    public function featuredItems(Request $request, $place = '')
    {
        $validator = Validator::make($request->all(), [
            'offset' => 'nullable|numeric|min:0',
            'limit' => 'nullable|numeric|min:1',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $module = $this->getModuleIdOrDefault($request);

        try {
            $user = null;
            if ($request->has('token')) {
                $user = AppUser::where('token', $request->input('token'))->first();
            }

            $query = Item::where('is_featured', 1)
                ->where('status', 1)
                ->where('module', $module)
                ->whereHas('userid', function ($query) {
                    $query->where('status', 1)
                        ->whereNull('deleted_at');  // This ensures the user isn't soft-deleted
                });

            if ($latitude !== null && $longitude !== null) {
                $query->selectRaw("*, ST_Distance_Sphere(Point(longitude, latitude), Point(?, ?)) / 1000 as distance", [$longitude, $latitude])
                    ->orderBy('distance')
                    ->orderByDesc('created_at');
            } else {
                $query->orderByDesc('created_at');
            }

            $featuredItems = $query->offset($offset)
                ->take($limit)
                ->get()
                ->map(function ($featureitem) use ($user) {
                    $formattedItem = $this->formatItemData($featureitem);
                    if ($user) {
                        $formattedItem['is_in_wishlist'] = $user->itemWishlists()
                            ->where('item_id', $featureitem->id)
                            ->exists();
                    } else {
                        $formattedItem['is_in_wishlist'] = false;
                    }

                    $itemType = ItemType::find($featureitem->item_type_id);
                    $formattedItem['item_type'] = $itemType ? $itemType->name : '';
                    $formattedItem['item_info'] = $this->getModuleInfoValues($featureitem->module, $featureitem->id);

                    if (isset($featureitem->distance)) {
                        $formattedItem['distance'] = $featureitem->distance ? number_format($featureitem->distance, 2) . " km" : null;
                    }

                    return $formattedItem;
                });

            if ($place == 'HomeModule') {
                return $featuredItems;
            }

            // Get the offset for the next page
            $nextOffset = $request->input('offset', 0) + count($featuredItems);
            if ($featuredItems->isEmpty()) {
                $nextOffset = -1;
            }

            return $this->addSuccessResponse(200,trans('front.Result_found'), [
                'items' => $featuredItems,
                'offset' => $nextOffset
            ]);
        } catch (Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    /**
     * Get Most Viewed  items with front image, pagination, and offset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mostViewedItems(Request $request, $place = '')
    {
        $validator = Validator::make($request->all(), [
            'offset' => 'nullable|numeric|min:0',
            'limit' => 'nullable|numeric|min:1',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $itemType = $request->input('item_type');
        $module = $this->getModuleIdOrDefault($request);

        try {
            $user = null;
            if ($request->has('token')) {
                $user = AppUser::where('token', $request->input('token'))->first();
            }

            $query = Item::where('status', 1)
                ->where('module', $module)
                ->whereHas('userid', function ($query) {
                    $query->where('status', 1)
                        ->whereNull('deleted_at');  
                });

            if ($latitude !== null && $longitude !== null) {
                $query->selectRaw("*, ST_Distance_Sphere(Point(longitude, latitude), Point(?, ?)) / 1000 as distance", [$longitude, $latitude])
                    ->orderBy('distance')
                    ->orderByDesc('views_count');
            } else {
                $query->orderByDesc('views_count');
            }
            if ($itemType) {
              
                $query->where('item_type_id', $itemType);
            }
            
            $mostViewedItems = $query->orderBy('id')
                ->offset($offset)
                ->take($limit)
                ->get()
                ->map(function ($items) use ($user) {
                    $formattedItem = $this->formatItemData($items);
                    if ($user) {
                        $formattedItem['is_in_wishlist'] = $user->itemWishlists()
                            ->where('item_id', $items->id)
                            ->exists();
                    } else {
                        $formattedItem['is_in_wishlist'] = false;
                    }

                    $itemType = ItemType::find($items->item_type_id);
                    $formattedItem['item_type'] = $itemType ? $itemType->name : '';
  $formattedItem['price'] = formatCurrency($formattedItem['price']);
                    if (isset($items->distance)) {

                        $formattedItem['distance'] = $items->distance ? number_format($items->distance, 2) . " km" : null;
                    }

                    return $formattedItem;
                });

            if ($place == 'HomeModule') {
                return $mostViewedItems;
            }

            // Get the offset for the next page
            $nextOffset = $request->input('offset', 0) + count($mostViewedItems);

            if (empty($mostViewedItems->toArray())) {
                $nextOffset = -1;
            }

            return $this->addSuccessResponse(200,trans('front.Result_found'), [
                'items' => $mostViewedItems,
                'offset' => $nextOffset
            ]);
        } catch (Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    public function nearbyItems(Request $request)
    {

        
         $validator = Validator::make($request->all(), [
            'offset' => 'nullable|numeric|min:0',
            'limit' => 'nullable|numeric|min:1',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'radius' => 'nullable|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }
  
        $limit = $request->input('limit', 20);
        $offset = $request->input('offset', 0);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 50000);
        $itemType = $request->input('item_type');

        $module = $this->getModuleIdOrDefault($request);

        try {
            $user = null;
            if ($request->has('token')) {
                $user = AppUser::where('token', $request->input('token'))->first();
            }
            $selectedCurrencyCode = $request->input('selected_currency_code');
            $convertionRate = Currency::getValueByCurrencyCode($selectedCurrencyCode);
            $query = Item::with(['item_type:id,name'])
            ->where('status', 1)
                ->where('module', $module)
                ->whereHas('userid', function ($query) {
                    $query->where('status', 1)
                        ->whereNull('deleted_at');
                });

            if ($latitude && $longitude) {
                $query->selectRaw("*, ST_Distance_Sphere(Point(longitude, latitude), Point(?, ?)) / 1000 as distance", [$longitude, $latitude])
                    ->whereRaw("ST_Distance_Sphere(Point(longitude, latitude), Point(?, ?)) <= ?", [$longitude, $latitude, $radius * 1000])
                    ->orderBy('distance');
            }

            if ($itemType) {
              
                    $query->where('item_type_id', $itemType);
                }
              
                $nearbyItems = $query->orderBy('id')
                ->offset($offset)
                ->take($limit)
                ->get()
                ->map(function ($item) use ($user,$convertionRate,$selectedCurrencyCode) {
                    $formattedItem = $this->formatItemData($item,$convertionRate);
                    if ($user) {
                        $formattedItem['is_in_wishlist'] = $user->itemWishlists()
                            ->where('item_id', $item->id)
                            ->exists();
                    } else {
                        $formattedItem['is_in_wishlist'] = false;
                    }
                    //$formattedItem['price'] = $this->formatPriceWithConversion($item->price,$selectedCurrencyCode,$convertionRate,1); 
                    $formattedItem['item_type'] = $item->item_Type->name ?? '';
                     $formattedItem['price'] = formatCurrency($formattedItem['price']);
                    $formattedItem['distance'] = $item->distance ? number_format($item->distance, 2) . " km" : null;

                    return $formattedItem;
                });

            $nextOffset = $request->input('offset', 0) + count($nearbyItems);

            if (empty($nearbyItems->toArray())) {
                $nextOffset = -1;
            }

            return $this->addSuccessResponse(200,trans('front.Result_found'), [
                'items' => $nearbyItems,
                'offset' => $nextOffset
            ]);
        } catch (Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }

    public function newArrivalItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offset' => 'nullable|numeric|min:0',
            'limit' => 'nullable|numeric|min:1',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return $this->errorComputing($validator);
        }

        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $module = $this->getModuleIdOrDefault($request);

        try {
            $user = null;
            if ($request->has('token')) {
                $user = AppUser::where('token', $request->input('token'))->first();
            }

            $query = Item::where('status', 1)
                ->where('module', $module)
                ->whereHas('userid', function ($query) {
                    $query->where('status', 1)
                        ->whereNull('deleted_at');
                });


            if ($latitude && $longitude) {
                $query->selectRaw("*, ST_Distance_Sphere(Point(longitude, latitude), Point(?, ?)) / 1000 as distance", [$longitude, $latitude])
                    ->orderBy('distance', 'asc');
            }

            $newArrivalItems = $query->orderBy('created_at', 'desc') // Order by creation date to get new arrivals
                ->offset($offset)
                ->take($limit)
                ->get()
                ->map(function ($item) use ($user) {
                    $formattedItem = $this->formatItemData($item);
                    if ($user) {
                        $formattedItem['is_in_wishlist'] = $user->itemWishlists()
                            ->where('item_id', $item->id)
                            ->exists();
                    } else {
                        $formattedItem['is_in_wishlist'] = false;
                    }
  $formattedItem['price'] = formatCurrency($formattedItem['price']);
                    $itemType = ItemType::find($item->item_type_id);
                    $formattedItem['item_type'] = $itemType ? $itemType->name : '';

                    $formattedItem['distance'] = isset($item->distance) ? number_format($item->distance, 2) . " km" : null;

                    return $formattedItem;
                });

            $nextOffset = $request->input('offset', 0) + count($newArrivalItems);

            if (empty($newArrivalItems->toArray())) {
                $nextOffset = -1;
            }

            return $this->addSuccessResponse(200,trans('front.Result_found'), [
                'items' => $newArrivalItems,
                'offset' => $nextOffset
            ]);
        } catch (Exception $e) {
            return $this->addErrorResponse(500,trans('front.something_wrong'), $e->getMessage());
        }
    }


}
