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
                    <div class="row mb-3">
                        <div class=" offset-lg-1 col-lg-11 ">
                                <div class=" col-lg-5 pl-0" style="display:inline-block">
                                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                        id="country-dd" name="country_id" onchange="sort_elements()">
                                        <option value="0">{{ translate('All countries') }}</option>

                                        {{-- <option value="{{$country->id}}">{{$country->name}}</option> --}}
                                        @foreach ($countrys as $data)
                                                <option value="{{$data->id}}">
                                                    {{$data->name}}

                                                </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" col-lg-3" style="display:inline-block">
                                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                    id="state-dd" name="region_id" onchange="sort_elements()">
                                        {{-- <option value="0">{{ translate('All countries') }}</option> --}}


                                    </select>
                                </div>
                                <div class="col-lg-3" style="display:inline-block">
                                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                    id="city-dd"  name="city_id" onchange="sort_elements()">
                                        {{-- <option value="0">{{ translate('All countries') }}</option> --}}


                                    </select>
                                </div>
                        </div>
                    </div>
					<div class="row">
						<div class=" offset-lg-1 col-lg-11 form-horizontal" id="form">



							@foreach (json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element)
                                @if($element->type=='text')
                                <div class="form-group row" id="category">
                                    @if ($element->label=='Форма_собственности')

                                      <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                      <div class="col-lg-8">
                                        <select name="{{($element->label)}}" class="form-control py-2">
                                            <option value="OАО">OАО</option>
                                            <option value="ЗАО">ЗАО</option>
                                            <option value="ООО">ООО</option>
                                            <option value="Частное предприятие">Частное предприятие</option>
                                            <option value="Частный предприниматель">Частный предприниматель</option>
                                            <option value="СП">СП</option>
                                            <option value="ИП">ИП</option>
                                            <option value="ГУП">ГУП</option>
                                            <option value="Семейное предприятие">Семейное предприятие</option>
                                            <option value="Фермерское хозяйство">Фермерское хозяйство</option>
                                            <option value="Частное лицо">Частное лицо</option>
                                        </select>
                                      </div>

                                    @else
                                        <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" type="text" name="{{($element->label)}}" required>
                                        </div>
                                    @endif
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

$(document).ready(function () {
            $('#country-dd').on('change', function () {
                var idCountry = this.value;
                $("#state-dd").html('');
                $.ajax({
                    url: "{{url('api/fetch-states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#state-dd').html('<option value="">Select State</option>');
                        $.each(result.states, function (key, value) {
                            $("#state-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#city-dd').html('<option value="">Select City</option>');
                    }
                });
            });
            $('#state-dd').on('change', function () {
                var idState = this.value;
                $("#city-dd").html('');
                $.ajax({
                    url: "{{url('api/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        // alert(res.cities);
                        $('#city-dd').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });


	</script>
@endsection



