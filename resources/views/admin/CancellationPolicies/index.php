@extends('layouts.admin')
@section('content')

<div class="content">
    @can('cancellation_policies')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.cancellation.policies.create') }}">
                 Add Cancellation Policies
                </a>
            </div>
        </div>
    @endcan			
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                 Cancellation List
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Booking randum">
                            <thead>
                                <tr>
                                <th></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($policydata as $data)
                                    <tr >
                                    <td>   </td>
                                        <td>  {{ $data->order_cancellation_id  ?? '' }}  </td>
                                      
                                        <td>{{ $data->reason ?? '' }} </td>
                                        <td>{{ $data->user_type ?? '' }}</td>
                                       
                                        <td>
                                        @if($data->status == 1)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                     </td>
                                        <td>
                                           
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.cancellation.edit', $data->order_cancellation_id) }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                         

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Booking:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>

@endsection