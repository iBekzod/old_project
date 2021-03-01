@extends('frontend.layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('My Flash Deals') }}</h1>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <a href="{{ route('seller.marketing.create') }}" class="btn btn-circle btn-info">
                                    <span>{{ translate('Create New Flash Deal') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table aiz-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{translate('Title')}}</th>
                                            <th>{{ translate('Banner') }}</th>
                                            <th>{{ translate('Start Date') }}</th>
                                            <th>{{ translate('End Date') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Featured') }}</th>
                                            <th>{{ translate('Page Link') }}</th>
                                            <th class="text-right">{{translate('Options')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($flash_deals as $key => $flash_deal)
                                            <tr>
                                                <td>{{ ($key+1) + ($flash_deals->currentPage() - 1)*$flash_deals->perPage() }}</td>
                                                <td>{{ $flash_deal->getTranslation('title') }}</td>
                                                <td><img src="{{ uploaded_asset($flash_deal->banner) }}" alt="banner"
                                                         class="h-50px"></td>
                                                <td>{{ date('d-m-Y H:i:s', $flash_deal->start_date) }}</td>
                                                <td>{{ date('d-m-Y H:i:s', $flash_deal->end_date) }}</td>
                                                <td>{{ url('flash-deal/'.$flash_deal->slug) }}</td>
                                                <td class="text-right">
                                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                       href="{{route('seller.marketing.edit', ['id'=>$flash_deal->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}"
                                                       title="{{ translate('Edit') }}">
                                                        <i class="las la-edit"></i>
                                                    </a>
                                                    <a href="#"
                                                       class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                       data-href="{{route('flash_deals.destroy', $flash_deal->id)}}"
                                                       title="{{ translate('Delete') }}">
                                                        <i class="las la-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="clearfix">
                                        <div class="pull-right">
                                            {{ $flash_deals->appends(request()->input())->links() }}
                                        </div>
                                    </div>
                                </div>
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
        function update_flash_deal_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('marketing.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    location.reload();
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_flash_deal_feature(el) {
            if (el.checked) {
                var featured = 1;
            } else {
                var featured = 0;
            }
            $.post('{{ route('marketing.update_featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                featured: featured
            }, function (data) {
                if (data == 1) {
                    location.reload();
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
