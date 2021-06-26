@extends('frontend.layouts.app')

@section('content')
{{-- @dd($user_id); --}}
	<div class=" offset-sm-1 col-sm-10">

		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Seller Verification Form')}}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('seller.autoidentification') }}" method="post">
					@csrf
					<div class="row">
						<div class=" offset-lg-1 col-lg-11 form-horizontal" id="form">

							@foreach (json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element)
                                {{-- @if($element->type=='select')
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
                                </div> --}}

                                @if($element->type=='text')
                                <div class="form-group row" id="category">
                                    <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                    <div class="col-lg-8">
                                    <input class="form-control" type="text" name="{{($element->label)}}" required>
                                    </div>
                                </div>
                                @elseif($element->type=='number')
                                <div class="form-group row" id="category">
                                    <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                    <div class="col-lg-8">
                                    <input class="form-control" type="number" name="{{($element->label)}}" required>
                                    </div>
                                </div>
                                @elseif($element->type=='email')
                                <div class="form-group row" id="category">
                                    <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                    <div class="col-lg-8">
                                    <input class="form-control" type="email" name="{{($element->label)}}" required>
                                    </div>
                                </div>
                                @endif


                            @endforeach

                            <div class="form-group text-right  mr-4 mt-3 ">
                                <button type="submit" class="btn btn-primary py-2">{{translate('Save')}}</button>
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




{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html> --}}
