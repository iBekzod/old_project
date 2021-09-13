@extends('backend.layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Reasons  All')}}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th data-breakpoints="lg">{{translate('message')}}</th>
                    <th data-breakpoints="lg">{{translate('Type')}}</th>
                    <th data-breakpoints="lg">{{translate('Responsible')}}</th>
                    <th data-breakpoints="lg">{{translate('Date')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reasons as $key => $reason)
                    <tr>
                        <td>{{ ($key+1)}}</td>
                        <td>
                          {{ $reason->name ?? ""}}
                        </td>
                        <td>
                            {{ $reason->type ?? "" }}
                        </td>
                        <td>
                            {{ $reason->responsible ?? "" }}
                        </td>
                        <td>
                            {{ $reason->created_at ?? "" }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="pull-right">
                {{ $reasons->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
{{--
@section('modal')
  <div class="modal fade reject_refund_request" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
            <form class="form-horizontal member-block" action="{{ route('reject_refund_request')}}" method="POST">
                @csrf
                <input type="hidden" name="refund_id" id="refund_id" value="">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Reject Refund Request !')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Order Code')}}</label>
                        <div class="col-md-9">
                          <input type="text" value="" id="order_id" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Reject Reason')}}</label>
                        <div class="col-md-9">
                            <textarea type="text" name="reject_reason" id="reject_reason" rows="5" class="form-control" placeholder="{{translate('Reject Reason')}}" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="submit" class="btn btn-success">{{translate('Submit')}}</button>
                </div>
            </form>
      	</div>
    	</div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function update_refund_approval(el){
            $.post('{{ route('vendor_refund_approval') }}',{_token:'{{ @csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Approval has been done successfully') }}');
                }
                else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function refund_request_money(el){
            $.post('{{ route('refund_request_money_by_admin') }}',{_token:'{{ @csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    location.reload();
                    AIZ.plugins.notify('success', '{{ translate('Refund has been sent successfully') }}');
                }
                else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function reject_refund_request(url, id, order_id){
          $.get(url, function(data){
              $('.reject_refund_request').modal('show');
              $('#refund_id').val(id);
              $('#order_id').val(order_id);
              $('#reject_reason').html(data);
          });
         }
    </script>
@endsection --}}
