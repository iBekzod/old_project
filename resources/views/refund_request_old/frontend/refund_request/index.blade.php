@extends('frontend.layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Applied Refund Request') }}</h5>
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
                                                  <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                                              @else
                                                  <span class="badge badge-inline badge-info">{{translate('PENDING')}}</span>
                                              @endif
                                          </td>
                                      </tr>
                                  @endforeach
                            </tbody>
                        </table>
                        {{ $refunds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection
