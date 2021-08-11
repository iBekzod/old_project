@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('City Information') }}</h5>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-fill border-light">
                    @foreach (\App\Language::all() as $key => $language)
                        <li class="nav-item">
                            <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                href="{{ route('cities.edit', ['id' => $city->id, 'lang' => $language->code]) }}">
                                <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}" height="11"
                                    class="mr-1">
                                <span>{{ $language->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <form class="p-4"  action="{{ route('cities.update', $city->id) }}"  method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    <div class="form-group">
                        <label for="country">{{ translate('Country') }}</label>
                        <select class="select2 form-control aiz-selectpicker" name="country_id" data-toggle="select2"
                            data-placeholder="Choose ..." data-live-search="true">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if ($country->id == $city->country_id) selected @endif>
                                    {{ $country->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country">{{ translate('Parent Region') }}</label>
                        <select class="select2 form-control aiz-selectpicker" name="region_id" data-toggle="select2"
                            data-placeholder="Choose ..." data-live-search="true">
                            <option selected value="0">{{ translate('Country') }}</option>
                            @foreach ($all_cities as $select_city)
                                <option value="{{ $select_city->id }}" @if ($select_city->id == $city->region_id) selected @endif>
                                    {{ $select_city->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country">{{ translate('Type') }}</label>
                        <select class="select2 form-control aiz-selectpicker" name="type" data-toggle="select2"
                            data-placeholder="Choose ..." data-live-search="true">
                            <option value="region" @if ('region' == $city->type) selected @endif>{{ translate('region') }}</option>
                            <option value="city" @if ('city' == $city->type) selected @endif>{{ translate('city') }}</option>
                            <option value="district" @if ('district' == $city->type) selected @endif>{{ translate('district') }}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">{{ translate('Name') }}</label>
                        <input type="text" placeholder="{{ translate('Name') }}" name="name"
                            value="{{ $city->getTranslation('name', $lang) }}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">{{ translate('Distance (km)') }}</label>
                        <input type="number" min="0" step="0.01" placeholder="{{ translate('Distance (km)') }}"
                            name="distance" class="form-control" required value="{{ $city->distance }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">{{ translate('Inside price (som)') }}</label>
                        <input type="number" min="0" step="0.01"
                            name="inside_price" class="form-control"  value="{{ $city->inside_price }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">{{ translate('Has Express') }}</label>
                        <br>
                        <label class="mb-0 aiz-switch aiz-switch-success">
                            <input type="checkbox" name="has_express" @if($city->has_express) checked @endif>
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
