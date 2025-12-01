<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\{ResponseTrait,MediaUploadingTrait, MiscellaneousTrait};
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Http\Resources\Admin\FeatureResource;
use App\Models\Modern\{ItemFeatures};
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class FeaturesApiController extends Controller
{
     
    use MediaUploadingTrait,ResponseTrait, MiscellaneousTrait;

    public function index()
    {
        abort_if(Gate::denies('feature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeatureResource(ItemFeatures::all());
    }

    public function store(StoreFeatureRequest $request)
    {
        $feature = ItemFeatures::create($request->all());

        if ($request->input('icon', false)) {
            $feature->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        return (new FeatureResource($feature))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ItemFeatures $feature)
    {
        abort_if(Gate::denies('feature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeatureResource($feature);
    }

    public function update(UpdateFeatureRequest $request, ItemFeatures $feature)
    {
        $feature->update($request->all());

        if ($request->input('icon', false)) {
            if (! $feature->icon || $request->input('icon') !== $feature->icon->file_name) {
                if ($feature->icon) {
                    $feature->icon->delete();
                }
                $feature->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($feature->icon) {
            $feature->icon->delete();
        }

        return (new FeatureResource($feature))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
      //////// API//////////

      public function features(Request $request)
      {
          $module = $this->getModuleIdOrDefault($request);
          $type = $request->input('type');
      
          $featuresQuery = ItemFeatures::where('status', '1')
              ->where('module', $module);
      
          if ($type) {
              $featuresQuery->where('type', $type);
          }
      
      
          $features = $featuresQuery->get()->map(function ($features) {
              return [
                  'id'    => $features->id,
                  'name'  => $features->name,
                  'image' => $features->icon->url ?? '',
                  'type'  => $features->type,
              ];
          })->toArray();
      
          return $this->addSuccessResponse(200,trans('front.ItemType_found'),['amenities'=> $features ]);
      }
      
      }

