@php
    $vendor_system_activation = \App\BusinessSetting::where('type', 'vendor_system_activation')->first();
    $classified_product =       \App\BusinessSetting::where('type', 'classified_product')->first();
    $addons = \App\Addon::where(function ($query) {
        $query->orWhere('unique_identifier', 'african_pg');
        $query->orWhere('unique_identifier', 'pos_system');
        $query->orWhere('unique_identifier', 'refund_request');
        $query->orWhere('unique_identifier', 'otp_system');
        $query->orWhere('unique_identifier', 'affiliate_system');
        $query->orWhere('unique_identifier', 'offline_payment');
        $query->orWhere('unique_identifier', 'seller_subscription');
        $query->orWhere('unique_identifier', 'paytm');
        $query->orWhere('unique_identifier', 'club_point');
        $query->orWhere('unique_identifier', 'seller_subscription');
    })->get();
    $afr_pg =               $addons->where('unique_identifier', 'african_pg')->first();
    $pos_system =           $addons->where('unique_identifier', 'pos_system')->first();
    $refund_request =       $addons->where('unique_identifier', 'refund_request')->first();
    $otp_system =           $addons->where('unique_identifier', 'otp_system')->first();
    $affiliate_system =     $addons->where('unique_identifier', 'affiliate_system')->first();
    $offline_payment =      $addons->where('unique_identifier', 'offline_payment')->first();
    $seller_subscription =  $addons->where('unique_identifier', 'seller_subscription')->first();
    $paytm =                $addons->where('unique_identifier', 'paytm')->first();
    $club_point =           $addons->where('unique_identifier', 'club_point')->first();
@endphp

<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar bg-light">
                <div class="aiz-side-nav-logo-wrap bg-light">
                    <a href="{{ route('admin.dashboard') }}" class="text-left d-block">
                        @if(get_setting('system_logo_white') != null)
                            <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white'))??static_asset('assets/img/logo.png') }}" class="brand-icon"
                                 alt="{{ get_setting('site_name') }}">
                        @else
                            <img class="mw-100" src="{{ static_asset('assets/img/logo.png') }}" class="brand-icon"
                                 alt="{{ get_setting('site_name') }}">
                        @endif
                    </a>
                </div>
        <div class="aiz-side-nav-wrap">
            <div class="mb-3 px-20px">
                <input class="text-black border-0 form-control bg-soft-secondary form-control-sm" type="text" name=""
                       placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{route('admin.dashboard')}}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                    </a>
                </li>

                <!-- POS Addon-->
            {{--@if ($pos_system != null && $pos_system->activated)
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('1', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-tasks aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('POS System')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{route('poin-of-sales.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['poin-of-sales.index', 'poin-of-sales.create'])}}">
                                    <span class="aiz-side-nav-text">{{translate('POS Manager')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('poin-of-sales.activation')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('POS Configuration')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif--}}

            <!-- Product -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('2', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Products')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            {{--  <li class="aiz-side-nav-item">
                                <a class="aiz-side-nav-link" href="{{route('products.create')}}">
                                    <span class="aiz-side-nav-text">{{translate('Add New product')}}</span>
                                </a>
                            </li>  --}}
                             <li class="aiz-side-nav-item">
                                <a href="{{route('products.all')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>
                                </a>
                            </li>
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{route('elements.all')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('All Elements') }}</span>
                                </a>
                            </li> --}}
                            <li class="aiz-side-nav-item">
                                <a href="{{route('elements.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('All Elements') }}</span>
                                    @php
                                    $on_moderation_element = \App\Element::where('on_moderation', 1)->get();
                                    @endphp
                                    @if($on_moderation_element->count())
                                        <span class="badge badge-info">{{ $on_moderation_element->count() }}</span>
                                    @endif
                                </a>
                            </li>
                             <li class="aiz-side-nav-item">
                                <a href="{{route('products.manage')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Mange Added Products') }}</span>
                                    @php
                                     $on_moderation_product = \App\Product::where('on_moderation', 1)->get();
                                    @endphp
                                    @if($on_moderation_product->count())
                                        <span class="badge badge-info">{{ $on_moderation_product->count() }}</span>
                                    @endif
                                </a>
                            </li>
                            {{--  <li class="aiz-side-nav-item">
                                <a href="{{route('products.admin')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['products.admin', 'products.create', 'products.admin.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('In House Products') }}</span>
                                </a>
                            </li>  --}}
                            {{--  @if($vendor_system_activation->value == 1)
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('products.seller')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['products.seller', 'products.seller.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Products') }}</span>
                                    </a>
                                </li>
                            @endif  --}}
                            {{--  <li class="aiz-side-nav-item">
                                <a href="{{route('digitalproducts.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['digitalproducts.index', 'digitalproducts.create', 'digitalproducts.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Digital Products') }}</span>
                                </a>
                            </li>  --}}
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('product_bulk_upload.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Bulk Import') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('product_bulk_export.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Bulk Export')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('categories.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Category')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('brands.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Brand')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('branches.index')}}" class="aiz-side-nav-link {{ areActiveRoutes([
                                                                        'branches.index',
                                                                        'branches.create',
                                                                        'branches.edit'
                                                                    ])}}">

                                    <span class="aiz-side-nav-text">
                                        {{ translate('Branches') }}
                                    </span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('attributes.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('reviews.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Product Reviews')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            <!-- Warehouse -->
                {{-- <li class="aiz-side-nav-item">
                   <a href="#" class="aiz-side-nav-link">
                       <i class="las la-money-bill aiz-side-nav-icon"></i>
                       <span class="aiz-side-nav-text">Warehouse</span>
                       <span class="aiz-side-nav-arrow"></span>
                   </a>

                   <!--Submenu-->
                   <ul class="aiz-side-nav-list level-2">
                       <li class="aiz-side-nav-item">
                           <a href="{{ route('warehouse.index') }}"
                               class="aiz-side-nav-link">
                              {{ areActiveRoutes(['warehouse.index', 'warehouse.show'])}}
                               <span class="aiz-side-nav-text">All warehouses</span>
                           </a>
                       </li>
                   </ul>
               </li> --}}
            <!-- Sale -->
            @if (Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('3', json_decode(Auth::user()->staff->role->permissions))))

            @endif
            <li class="aiz-side-nav-item">
                @if (Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('3', json_decode(Auth::user()->staff->role->permissions))))
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-money-bill aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Sales')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
            @endif
                <!--Submenu-->
                <ul class="aiz-side-nav-list level-2">
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('3', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('all_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['all_orders.index', 'all_orders.show'])}}">
                                <span class="aiz-side-nav-text">{{translate('All Orders')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('4', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('inhouse_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['inhouse_orders.index', 'inhouse_orders.show'])}}" >
                                <span class="aiz-side-nav-text">{{translate('Inhouse orders')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('5', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('seller_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_orders.index', 'seller_orders.show'])}}">
                                <span class="aiz-side-nav-text">{{translate('Seller Orders')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('6', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('pick_up_point.order_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['pick_up_point.order_index','pick_up_point.order_show'])}}">
                                <span class="aiz-side-nav-text">{{translate('Pick-up Point Order')}}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

                <!-- Refund addon -->
                @if ($refund_request != null && $refund_request->activated)
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('7', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-backward aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Refunds') }}</span>

                                <span class="aiz-side-nav-arrow"></span>
                            </a>

                            <ul class="aiz-side-nav-list level-2">
                                @php
                                    $refund_request=\App\RefundRequest::where('admin_seen',0)->where('admin_approval',0)->get();
                                    // $refund_request=\App\RefundRequest::where('refund_status',0)->get();
                                @endphp
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('refund_requests_all')}}" class="aiz-side-nav-link {{ areActiveRoutes(['refund_requests_all', 'reason_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Refund Requests')}}</span>

                                        @if (count($refund_request) > 0)
                                           <span class="badge badge-info">{{ count($refund_request) }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('reasons_all')}}" class="aiz-side-nav-link {{ areActiveRoutes(['reasons_all', 'reason_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Reasons')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('paid_refund')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Approved Refunds')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('rejected_refund')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('rejected Refunds')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('refund_time_config')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Refund Configuration')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif


            <!-- Customers -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('8', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('customers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Customer list') }}</span>
                                </a>
                            </li>
                            @if($classified_product->value == 1)
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('classified_products')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Classified Products')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('customer_packages.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['customer_packages.index', 'customer_packages.create', 'customer_packages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Classified Packages') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            <!-- Sellers -->
                @if((Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('9', json_decode(Auth::user()->staff->role->permissions)))) && $vendor_system_activation->value == 1)
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('sellers.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history','sellers.approved','sellers.profile_modal','sellers.show_verification_request'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('All Seller') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('sellers.payment_histories') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payouts') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('withdraw_requests_all') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payout Requests') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('business_settings.vendor_commission') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Commission') }}</span>
                                </a>
                            </li>
                            @if ($seller_subscription != null && $seller_subscription->activated)
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('seller_packages.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['seller_packages.index', 'seller_packages.create', 'seller_packages.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Seller Packages') }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('seller_verification_form.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Verification Form') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="aiz-side-nav-item">
                    <a href="{{ route('uploaded-files.index') }}"
                       class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create'])}}">
                        <i class="las la-folder-open aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Uploaded Files') }}</span>
                    </a>
                </li>

                <!-- Reports -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('10', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Reports') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('in_house_sale_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['in_house_sale_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('In House Product Sale') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('seller_sale_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['seller_sale_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Seller Products Sale') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('stock_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['stock_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Products Stock') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('wish_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['wish_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Products wishlist') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('user_search_report.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['user_search_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('User Searches') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('commission-log.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Commission History') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('wallet-history.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Wallet Recharge History') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            <!-- marketing -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('11', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('2', json_decode(Auth::user()->staff->role->permissions))))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('flash_deals.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Flash deals') }}</span>
                                        @php
                                            $var = \App\Models\FlashDeal::where('on_moderation', 1)->get();
                                        @endphp
                                        @if (count($var) > 0)
                                            <span class="badge badge-info">{{ count($var) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('7', json_decode(Auth::user()->staff->role->permissions))))
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('newsletters.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                                    </a>
                                </li>
                                @if ($otp_system != null && $otp_system->activated)
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('sms.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text">{{ translate('Bulk SMS') }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('coupon.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['coupon.index','coupon.create','coupon.edit'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            <!-- Support -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('12', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-link aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Support')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('13', json_decode(Auth::user()->staff->role->permissions))))
                                @php
                                    $support_ticket = DB::table('tickets')
                                                ->where('viewed', 0)
                                                ->select('id')
                                                ->count();
                                @endphp
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('support_ticket_seller.admin_index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['support_ticket_seller.admin_index', 'support_ticket_seller.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Ticket seller')}}</span>
                                        @if($support_ticket > 0)<span
                                        class="badge badge-info">{{ $support_ticket }}</span>
                                        @endif
                                    </a>
                                </li>
                                {{-- <li class="aiz-side-nav-item">
                                    <a href="{{ route('support_ticket_user.admin_index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['support_ticket_user.admin_index', 'support_ticket.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Ticket user ')}}</span>
                                        @if($support_ticket > 0)<span
                                        class="badge badge-info">{{ $support_ticket }}</span>
                                        @endif
                                    </a>
                                </li> --}}
                            @endif

                            @php
                                // $conversation = \App\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '1')->get();
                                $conversation = \App\Conversation::where('sender_viewed', 0)->get();
                                // $conversation = \App\Conversation::where('receiver_viewed', 0)->get();


                            @endphp
                            @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('conversations.admin_index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['conversations.admin_index', 'conversations.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Product Queries')}}</span>

                                        @if (count($conversation) > 0)
                                            <span class="badge badge-info">{{ count($conversation) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                          @php
                                $found_it_cheaper=\App\FoundItCheaper::where('viewed',0)->get();
                          @endphp
                            @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('conversations.found_it_cheaper') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['conversations.found_it_cheaper', 'found_it_cheapers.admin_show'])}}">
                                          <span class="aiz-side-nav-text">{{translate('Found it cheaper')}}</span>
                                        @if (count($found_it_cheaper) > 0)
                                            <span class="badge badge-info">{{ count($found_it_cheaper) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            {{-- @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('conversation.price_reduction') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['conversation.price_reduction', 'conversations.admin_show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Frice Reduction')}}</span>
                                    @if (count($conversation) > 0)
                                        <span class="badge badge-info">{{ count($conversation) }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif --}}
                        @php
                             $report_description=\App\ReportDescription::where('viewed',0)->get();
                        @endphp
                        @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('conversation.report_description') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['conversation.report_description', 'report_description.admin_show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Report description')}}</span>
                                    @if (count($report_description) > 0)
                                        <span class="badge badge-info">{{ count($report_description) }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        @php
                          $support_service=\App\SupportService::where('viewed',0)->get();
                        @endphp
                        @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('conversation.support_service') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['conversation.support_service', 'support_service.admin_show'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Support service')}}</span>
                                    @if (count($support_service) > 0)
                                        <span class="badge badge-info">{{ count($support_service) }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        </ul>
                    </li>
                @endif

            <!-- Affiliate Addon -->
                @if ($affiliate_system && $affiliate_system->activated)
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('15', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-link aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Affiliate System')}}</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.configs')}}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Affiliate Registration Form')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.index')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.users')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['affiliate.users', 'affiliate_users.show_verification_request', 'affiliate_user.payment_history'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Affiliate Users')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('refferals.users')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Referral Users')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('affiliate.withdraw_requests')}}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Affiliate Withdraw Requests')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Offline Payment Addon-->
                @if (false && $offline_payment != null && $offline_payment->activated)
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-money-check-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Offline Payment System')}}</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('manual_payment_methods.index') }}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['manual_payment_methods.index', 'manual_payment_methods.create', 'manual_payment_methods.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Manual Payment Methods')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('offline_wallet_recharge_request.index') }}"
                                       class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Offline Wallet Recharge')}}</span>
                                    </a>
                                </li>
                                @if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('offline_customer_package_payment_request.index') }}"
                                           class="aiz-side-nav-link">
                                            <span
                                                class="aiz-side-nav-text">{{translate('Offline Customer Package Payments')}}</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($seller_subscription != null && $seller_subscription->activated)
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('offline_seller_package_payment_request.index') }}"
                                           class="aiz-side-nav-link">
                                            <span
                                                class="aiz-side-nav-text">{{translate('Offline Seller Package Payments')}}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Paytm Addon -->
                @if (false && $paytm != null && $paytm->activated)
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('17', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-mobile-alt aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Paytm Payment Gateway')}}</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('paytm.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{translate('Set Paytm Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Club Point Addon-->
                @if ($club_point != null && $club_point->activated)
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('18', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="lab la-btc aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('Club Point System')}}</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('club_points.configs') }}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Club Point Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('set_product_points')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['set_product_points', 'product_club_point.edit'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Set Product Point')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('club_points.index')}}"
                                       class="aiz-side-nav-link {{ areActiveRoutes(['club_points.index', 'club_point.details'])}}">
                                        <span class="aiz-side-nav-text">{{translate('User Points')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!--OTP addon -->
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('19', json_decode(Auth::user()->staff->role->permissions))))
                                        <li class="aiz-side-nav-item">
                                            <a href="#" class="aiz-side-nav-link">
                                                <i class="las la-phone aiz-side-nav-icon"></i>
                                                <span class="aiz-side-nav-text">{{translate('OTP System')}}</span>
                                                <span class="aiz-side-nav-arrow"></span>
                                            </a>
                                            <ul class="aiz-side-nav-list level-2">
                                                <li class="aiz-side-nav-item">
                                                    <a href="{{ route('otp.configconfiguration') }}" class="aiz-side-nav-link">
                                                        <span class="aiz-side-nav-text">{{translate('OTP Configurations')}}</span>
                                                    </a>
                                                </li>
                                                <li class="aiz-side-nav-item">
                                                    <a href="{{route('sms-templates.index')}}" class="aiz-side-nav-link">
                                                        <span class="aiz-side-nav-text">{{translate('SMS Templates')}}</span>
                                                    </a>
                                                </li>
                                                <li class="aiz-side-nav-item">
                                                    <a href="{{route('otp_credentials.index')}}" class="aiz-side-nav-link">
                                                        <span class="aiz-side-nav-text">{{translate('Set OTP Credentials')}}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                @endif



                @if($afr_pg != null && $afr_pg->activated)
                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('19', json_decode(Auth::user()->staff->role->permissions))))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{translate('African Payment Gateway Addon')}}</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('african.configuration') }}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('African PG Configurations')}}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('african_credentials.index')}}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{translate('Set African PG Credentials')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            <!-- Website Setup -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('13', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-desktop aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Website Setup')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.header') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Header')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.footer') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Footer')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.pages') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create' ,'custom-pages.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pages')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.appearance') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Appearance')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

            <!-- Translations -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('14', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-language aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Translations')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'frontends', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'frontend_translations', 'relation_id'=>'frontend_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Frontend')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'attributes', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'attribute_translations', 'relation_id'=>'attribute_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Attributes')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'branches', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'branch_translations', 'relation_id'=>'branch_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Branches')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'brands', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'brand_translations', 'relation_id'=>'brand_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Brands')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'categories', 'fields'=>['name'], 'selected_field'=>0,  'table_translations'=>'category_translations', 'relation_id'=>'category_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Categories')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'characteristics', 'fields'=>['name'], 'selected_field'=>0,  'table_translations'=>'characteristic_translations', 'relation_id'=>'characteristic_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Characteristics')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'cities', 'fields'=>['name'], 'selected_field'=>0,  'table_translations'=>'city_translations', 'relation_id'=>'city_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Cities')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'





                                ', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'country_translations', 'relation_id'=>'country_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Countries')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'colors', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'color_translations', 'relation_id'=>'color_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Colors')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'customer_packages', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'customer_package_translations', 'relation_id'=>'customer_package_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Customer Packages')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'customer_products', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'customer_product_translations', 'relation_id'=>'customer_product_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Customer Products')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'elements', 'fields'=>['name', 'unit', 'description'], 'selected_field'=>0, 'table_translations'=>'element_translations', 'relation_id'=>'element_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Elements')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'flash_deals', 'fields'=>['title'], 'selected_field'=>0, 'table_translations'=>'flash_deal_translations', 'relation_id'=>'flash_deal_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Flash deals')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'languages', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'language_translations', 'relation_id'=>'language_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Languages')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'pages', 'fields'=>['title','content'], 'selected_field'=>0, 'table_translations'=>'page_translations', 'relation_id'=>'page_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Pages')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'pickup_points', 'fields'=>['title','content'], 'selected_field'=>0, 'table_translations'=>'pickup_point_translations', 'pickup_point_id'=>'page_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Pickup Points')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'products', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'product_translations', 'relation_id'=>'product_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Products')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'roles', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'role_translations', 'relation_id'=>'role_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Roles')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'variations', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'variation_translations', 'relation_id'=>'variation_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Variations')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_translation', ['base_table'=>'reasons', 'fields'=>['name'], 'selected_field'=>0, 'table_translations'=>'reason_translations', 'relation_id'=>'reason_id', 'language_selected'=>'ru'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Reasons')}}</span>
                                </a>
                            </li>
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{route('translations.show_category_translations', ['language_selected'=>'en'])}}"
                                   class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Category translations')}}</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                @endif
                {{-- Delivery --}}
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('14', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-truck aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Delivery')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>

                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{route('countries.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['countries.index','countries.edit','countries.update'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Shipping Countries')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('cities.index')}}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['cities.index','cities.edit','cities.update'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Shipping Cities')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('deliveries.index')}}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['deliveries.index','deliveries.update','deliveries.store', 'deliveries.destroy'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Delivery distance')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('delivery_prices.index')}}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['delivery_prices.index','delivery_prices.update','delivery_prices.store', 'delivery_prices.destroy'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Delivery prices')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('delivery_tarifs.index')}}"
                                class="aiz-side-nav-link {{ areActiveRoutes(['delivery_tarifs.index','delivery_tarifs.update','delivery_tarifs.store', 'delivery_tarifs.destroy'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Delivery tarifs')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('delivery-boys.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boys.index'])}}">
                                    <span class="aiz-side-nav-text">{{translate('All Delivery Boy')}}</span>
                                </a>
                            </li>
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{route('delivery-boys.create')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boys.create'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Add Delivery Boy')}}</span>
                                </a>
                            </li> --}}
                            <li class="aiz-side-nav-item">
                                <a href="{{route('delivery-boy.cancel-request')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boy.cancel-request'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Cancel Request')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('delivery-boy-configuration')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Configuration')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            <!-- Setup & Configurations -->

                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('14', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Setup & Configurations')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{route('general_setting.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('General Settings')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('activation.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Features activation')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('languages.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Languages')}}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{route('currency.index')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Currency')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('pick_up_points.index')}}"
                                   class="aiz-side-nav-link  {{ areActiveRoutes(['pick_up_points.index','pick_up_points.create','pick_up_points.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Pickup point')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('smtp_settings.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('SMTP Settings')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('payment_method.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Payment Methods')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('file_system.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('File System Configuration')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('social_login.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Social media Logins')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('google_analytics.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Analytics Tools')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('facebook_chat.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Facebook Chat')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('google_recaptcha.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate('Google reCAPTCHA')}}</span>
                                </a>
                            </li>
                            {{-- <li class="aiz-side-nav-item">
                                <a href="{{route('shipping_configuration.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Shipping Configuration')}}</span>
                                </a>
                            </li> --}}


                        </ul>
                    </li>
                @endif


            <!-- Staffs -->
                @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('20', json_decode(Auth::user()->staff->role->permissions))))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate('Staffs')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('staffs.index') }}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('All staffs')}}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{route('roles.index')}}"
                                   class="aiz-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Staff permissions')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--                @if(!env('DISABLE_ADDONS', true))--}}
                {{--                    <li class="aiz-side-nav-item">--}}
                {{--                        <a href="#" class="aiz-side-nav-link">--}}
                {{--                            <i class="las la-user-tie aiz-side-nav-icon"></i>--}}
                {{--                            <span class="aiz-side-nav-text">{{translate('System')}}</span>--}}
                {{--                            <span class="aiz-side-nav-arrow"></span>--}}
                {{--                        </a>--}}
                {{--                        <ul class="aiz-side-nav-list level-2">--}}
                {{--                            <li class="aiz-side-nav-item">--}}
                {{--                                <a href="{{ route('system_update') }}" class="aiz-side-nav-link">--}}
                {{--                                    <span class="aiz-side-nav-text">{{translate('Update')}}</span>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="aiz-side-nav-item">--}}
                {{--                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">--}}
                {{--                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                        </ul>--}}
                {{--                    </li>--}}

{{--                    <!-- Addon Manager -->--}}
{{--                    @if(Auth::user()->user_type == 'admin' || (Auth::user()->staff && in_array('21', json_decode(Auth::user()->staff->role->permissions))))--}}
{{--                        <li class="aiz-side-nav-item">--}}
{{--                            <a href="{{route('addons.index')}}"--}}
{{--                               class="aiz-side-nav-link {{ areActiveRoutes(['addons.index', 'addons.create'])}}">--}}
{{--                                <i class="las la-wrench aiz-side-nav-icon"></i>--}}
{{--                                <span class="aiz-side-nav-text">{{translate('Addon Manager')}}</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @endif--}}
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
