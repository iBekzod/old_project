@extends('frontend.layouts.app')

@section('content')

	<div class=" offset-sm-2 col-sm-8">

		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Seller Verification Form')}}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('seller_verification_form.update') }}" method="post">
					@csrf
					<div class="row">
						<div class=" offset-lg-1 col-lg-10 form-horizontal" id="form">
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
                                <div class="form-group row" id="category">
                                    <label class="col-lg-3 col-from-label">{{$element->label}}</label>
                                    <div class="col-lg-8">
                                    <input class="form-control" type="{{$element->type}}" name="{{($element->label)}}">

                                    </div>
                                </div> @endif
                            @endforeach

                            <div class="form-group text-right  mr-5 mb-2">
                                <button type="submit" class="btn btn-primary ">{{translate('Save')}}</button>
                            </div>
						</div>

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

