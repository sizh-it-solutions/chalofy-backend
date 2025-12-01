@extends('layouts.admin')
@section('content')
<div class="content">
    @can($permissionrealRoute.'_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route($createRoute) }}">
                    {{ trans('global.add') }} {{ $title }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
            <div class="panel-heading d-flex justify-content-between align-items-center">
                    <span>{{ $title }} {{ trans('global.list') }}</span>
                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover  datatable datatable-City">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('global.id') }}
                                </th>
                              
                                <th>
                                    {{ trans('global.city_name') }}
                                </th>
                                <th>
                                    {{ trans('global.country') }}
                                </th>
                                <th>
                                    {{ trans('global.image') }}
                                </th>
                                <th>
                                {{ trans('global.latitude') }}
                                </th>
                                <th>
                                {{ trans('global.longtitude') }}
                                </th>
                               
                                <th>
                                    {{ trans('global.status') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')
@parent
<script>
    const texts = {
        deleteAllText: '{{ trans("global.delete_all") }}',
        noEntriesText: '{{ trans("global.no_entries_selected") }}',
        areYouSureText: '{{ trans("global.are_you_sure") }}',
        deleteConfirmText: '{{ trans("global.delete_confirmation") }}',
        yesContinueText: '{{ trans("global.yes_continue") }}',
        deletedText: '{{ trans("global.deleted") }}',
        entriesDeletedText: '{{ trans("global.entries_deleted") }}',
        errorText: '{{ trans("global.error") }}',
        deleteErrorText: '{{ trans("global.delete_error") }}',
        changeStatusConfirmText: '{{ trans("global.change_status_confirmation") }}',
        successText: '{{ trans("global.success") }}',
        genericErrorText: 'Something went wrong. Please try again.'
    };

    const featureColumns = [
        { data: 'placeholder', name: 'placeholder', orderable: false, searchable: false, className: 'select-checkbox' },
        { data: 'id', name: 'id' },
        { data: 'city_name', name: 'city_name' },
        { data: 'country_code', name: 'country_code' },
        { data: 'image', name: 'image', sortable: false, searchable: false },
        { data: 'latitude', name: 'latitude' },
        { data: 'longtitude', name: 'longtitude' },
        {
            data: 'status',
            name: 'status',
            render: (data, type, row) => `
                <div class="status-toggle d-flex justify-content-between align-items-center">
                    <input
                        data-id="${row.id}"
                        class="check statusdata"
                        type="checkbox"
                        id="user${row.id}"
                        data-toggle="toggle"
                        data-on="Active"
                        data-off="InActive"
                        ${data ? 'checked' : ''}
                    >
                    <label for="user${row.id}" class="checktoggle">checkbox</label>
                </div>
            `,
            createdCell: function (td, cellData, rowData) {
                handleStatusToggle(td, cellData, rowData, {
                    ajaxUpdateRoute: "{{ $ajaxUpdate }}",
                    texts: texts
                });
            }
        },
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        }
    ];

    $(function () {
        initializeFeatureDataTable({
            tableSelector: '.datatable-City',
            ajaxUrl: "{{ route($indexRoute) }}",
            deleteUrl: "{{ route('admin.item-location.deleteAll') }}",
            columns: featureColumns,
            texts: texts
        });
    });
</script>
@endsection
