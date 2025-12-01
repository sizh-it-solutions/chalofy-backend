@extends('layouts.admin')
@section('content')
<div class="content">

    @can($permissionrealRoute.'_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route($createRoute) }}">
                {{ trans('global.add') }} {{$title}}
            </a>
        </div>
    </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-horizontal" id="propertyFilterForm" action="{{ route($indexRoute) }}" method="GET"
                        accept-charset="UTF-8">
                        <div class="row">
                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>Type</label>
                                <select class="form-control select2" name="typeId" id="typeId">
                                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ request('typeId')==$type->id ? 'selected' : '' }}
                                        >{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2 mt-4 col-sm-2 col-xs-4 mt-5">
                                <br>
                                <button type="submit" name="btn" class="btn btn-primary btn-flat filterproduct">{{
                                    trans('global.filter') }}</button>
                                <button type="button" id="resetBtn" class="btn btn-primary btn-flat resetproduct">{{
                                    trans('global.reset') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $title }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <table
                        class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-vehicleMake">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('global.id') }}
                                </th>
                                <th>
                                    {{ trans('global.name') }}
                                </th>
                                <th>
                                    {{ trans('global.description') }}
                                </th>

                                <th>
                                    {{ trans('global.type') }}
                                </th>
                                <th>
                                    {{ trans('global.image') }}
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
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        { data: 'typeName', name: 'typeName', orderable: false, searchable: false },
        { data: 'image', name: 'image', sortable: false, searchable: false },
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
                    ajaxUpdateRoute: '{{ $ajaxUpdate }}',
                    texts: texts
                });
            }
        },
        {
            data: 'actions',
            name: '{{ trans('global.actions') }}',
            orderable: false,
            searchable: false
        }
    ];

    $(function () {
        initializeFeatureDataTable({
            tableSelector: '.datatable-vehicleMake',
            ajaxUrl: {
                url: "{{ route($indexRoute) }}",
                type: 'GET',
                data: function (d) {
                    d.typeId = $('#typeId').val();
                }
            },
            deleteUrl: "{{ route('admin.vehicle-makes.deleteAll') }}",
            columns: featureColumns,
            texts: texts
        });

        $('#typeId').on('change', function () {
            $('#propertyFilterForm').submit();
        });

        $('#resetBtn').on('click', function () {
            $('#typeId').val('').trigger('change');
            $('#propertyFilterForm').submit();
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
        });
    });
</script>
@endsection
