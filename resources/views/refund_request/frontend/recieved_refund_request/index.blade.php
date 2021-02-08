@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Refund Request') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ translate('Date') }}</th>
                                        <th>{{translate('Order id')}}</th>
                                        <th>{{translate('Product')}}</th>
                                        <th>{{translate('Amount')}}</th>
                                        <th>{{translate('Status')}}</th>
                                        <th>{{translate('Reason')}}</th>
                                        <th>{{translate('Approval')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($refunds as $key => $refund)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ date('d-m-Y', strtotime($refund->created_at)) }}</td>
                                            <td>
                                                @if ($refund->order != null)
                                                    {{ $refund->order->code }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($refund->orderDetail != null && $refund->orderDetail->product != null)
                                                    {{ $refund->orderDetail->product->getTranslation('name') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($refund->orderDetail != null)
                                                    {{single_price($refund->orderDetail->price)}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($refund->refund_status == 1)
                                                    <span class="badge badge-inline badge-success"><strong>{{translate('Approved')}}</strong></span>
                                                @else
                                                    <span class="badge badge-inline badge-danger"><strong>{{translate('PENDING')}}</strong></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('reason_show', $refund->id) }}"><span class="badge badge-inline badge-success">{{translate('Show')}}</span></a>
                                            </td>
                                            <td>
                                                @if ($refund->seller_approval == 1)
                                                    <label class="aiz-switch aiz-switch-success mb-0 ">
                                                        <input type="checkbox" @if ($refund->seller_approval == 1) checked  @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                @else
                                                    <label class="aiz-switch aiz-switch-success mb-0">
                                                        <input onchange="update_refund_approval('{{ $refund->id }}')" type="checkbox" @if ($refund->seller_approval == 1) checked @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                {{ $refunds->links() }}
                          	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">

        function update_refund_approval(el){
            $.post('{{ route('vendor_refund_approval') }}',{_token:'{{ @csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    showFrontendAlert('success', 'Approval has been done successfully');
                }
                else {
                    showFrontendAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
