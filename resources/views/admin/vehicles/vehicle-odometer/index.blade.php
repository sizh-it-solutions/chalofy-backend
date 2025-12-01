@extends('layouts.admin')
@section('content')
<div class="content">
  
    <div class="row mb-2">
        <div class="col-lg-12">
           <a class="btn btn-success" href="{{ route('admin.vehicle-odometer.create') }}">
                {{ trans('global.add') }} {{ trans('global.vehicle_odometer') }}
            </a>
        </div>
    </div>
   

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $title }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-vehicle-odometer">
                        <thead>
                            <tr>
                                <th width="10"></th>
                                <th>{{ trans('global.id') }}</th>
                                <th>{{ trans('global.name') }}</th>
                                <th>{{ trans('global.date') }}</th>
                                <th>{{ trans('global.status') }}</th>
                                <th>&nbsp;</th>
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

const odometerColumns = [
    { data: 'placeholder', name: 'placeholder', searchable: false, orderable: false },
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'date', name: 'created_at' },
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
    { data: 'actions', name: 'actions', orderable: false, searchable: false }
];

$(function () {
    initializeFeatureDataTable({
        tableSelector: '.datatable-vehicle-odometer',
        ajaxUrl: "{{ route($indexRoute) }}",
        deleteUrl: "{{ route('admin.vehicle-odometer.deleteAll') }}",
        columns: odometerColumns,
        texts: texts
    });
});
</script>
@endsection