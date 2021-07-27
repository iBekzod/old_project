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
                        <div class="ml-auto col-md-4">
                            <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                id="category_id" name="category_id" onchange="sort_elements()">
                                <option value="0" @if($category_id == 0) selected @endif>{{ translate('All categories') }}</option>
                                @foreach ($categories as $key => $category)
                                        <option value="{{ $category->id }}" @if ($category->id == $category_id) selected @endif>
                                            {{ $category->getTranslation('name', $lang) }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ml-auto col-md-4">
                            <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                id="sub_category_id" name="sub_category_id" onchange="sort_elements()">
                                <option value="0"  @if($sub_category_id == 0) selected @endif>{{ translate('All sub categories') }}</option>
                                @foreach ($sub_categories as $key => $category)
                                        <option value="{{ $category->id }}" @if ($category->id == $sub_category_id) selected @endif>
                                            {{ $category->getTranslation('name', $lang) }}
                                        </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ml-auto col-md-4">
                            <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                id="sub_sub_category_id" name="sub_sub_category_id" onchange="sort_elements()">
                                <option value="0"  @if($sub_sub_category_id == 0) selected @endif>{{ translate('All sub sub categories') }}</option>
                                @foreach ($sub_sub_categories as $key => $category)
                                        <option value="{{ $category->id }}" @if ($category->id == $sub_sub_category_id) selected @endif>
                                            {{ $category->getTranslation('name', $lang) }}
                                        </option>
                                @endforeach
                            </select>
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
