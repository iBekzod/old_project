@extends('frontend.layouts.app')
@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
			@include('frontend.inc.user_side_nav')
			<div class="aiz-user-panel">
                <div class="card">
                    @include('backend.reports.partials.commission_history_section')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

