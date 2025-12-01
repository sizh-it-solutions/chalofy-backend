@extends('layouts.admin')
@section('content')
<section class="content">
            <div class="row">
                <div class="col-md-3 settings_bar_gap">
                    <div class="box box-info box_info">
	<div class="">
    <h4 class="all_settings f-18 mt-1" style="margin-left:15px;">{{ trans('global.manage_settings') }}</h4>
        @include('admin.generalSettings.general-setting-links.links')
	</div>
</div>
                </div>
                <!-- right column -->
                <div class="col-md-9">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ trans('global.socialLogins_title_singular') }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form id="socialiteform" method="post" action="{{ route('admin.socialnetworkadd') }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="" class="control-label col-sm-3">{{ trans('global.socialLogins_google') }}</label>
                                    <div class="col-sm-6">
                                        <select name="socialnetwork_google_login" class="form-control">
                                            <option value="0" @if(($socialnetwork_google_login->meta->value ?? '' ) == 0) selected @endif>Inactive</option>
                                            <option value="1" @if(( $socialnetwork_google_login->meta_value ?? '' ) ==1) selected @endif>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-sm-3">{{ trans('global.apple_login') }}</label>
                                    <div class="col-sm-6">
                                        <select name="socialnetwork_apple_login" class="form-control">
                                            <option value="0" @if(( $socialnetwork_apple_login->meta_value ?? '' ) == 0) selected @endif>Inactive</option>
                                            <option value="1" @if(( $socialnetwork_apple_login->meta_value ?? '' ) == 1) selected @endif>Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                                                    <button type="submit" class="btn btn-info ">{{ trans('global.save') }}</button>
                                                                    <a class="btn btn-danger" href="{{ route('admin.settings') }}">{{ trans('global.cancel') }}</a>
                                
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
       
@endsection
