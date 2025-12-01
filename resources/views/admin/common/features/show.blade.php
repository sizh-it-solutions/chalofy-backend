@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                {{ $title }}   {{ trans('global.show') }}  
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route($indexRoute) }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('global.id') }}
                                    </th>
                                    <td>
                                        {{ $itemFeatures->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('global.name') }}
                                    </th>
                                    <td>
                                        {{ $itemFeatures->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('global.description') }}
                                    </th>
                                    <td>
                                        {{ $itemFeatures->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('global.icon') }}
                                    </th>
                                    <td>
                                        @if($itemFeatures->icon)
                                            <a href="{{ $itemFeatures->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $itemFeatures->icon->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('global.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Modern\ItemFeatures::STATUS_SELECT[$itemFeatures->status] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route($indexRoute) }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection