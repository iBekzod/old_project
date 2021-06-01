@extends('frontend.layouts.app')

@section('content')

	<div class="col-sm-12">

		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Seller Verification Form')}}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('seller_verification_form.update') }}" method="post">
					@csrf
					<div class="row">
						<div class="col-lg-8 form-horizontal" id="form">
							@foreach (json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element)
                                @if($element->type=='select')
                                <div class="form-group row" id="category">
                                    <label class="col-lg-3 col-from-label">{{translate('Category')}}</label>
                                    <div class="col-lg-8">
                                        <select class="form-control aiz-selectpicker" name="{{$element->label}}"
                                                data-selected="" data-live-search="true" required>
                                            @foreach (json_decode($element->options, true) as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @elseif ($element->type=='text')
                                    <label for="{{$element->label}}">{{$element->label}}</label>
                                    <input type="{{$element->type}}" name="{{($element->label)}}">
                                @endif
                            @endforeach
						</div>

					<div class="form-group mt-md-5 text-right">
						<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
					</div>
				</form>
			</div>
		</div>

	</div>

@endsection

@section('script')
	<script type="text/javascript">


	</script>
@endsection
