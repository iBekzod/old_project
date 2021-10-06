@extends('backend.layouts.app')
@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Add attributes')}}</h5>
    </div>

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.all') }}">{{ translate('all_products') }}</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div id="app"></div>
        <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-3 mb-3"></div>
                        <form action="{{ route('products.characteristics', $product->id) }}" method="post">
                            @csrf
                            @foreach($options as $option)
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 h6">{{ $option->getTranslation('name') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach($option->attributes as $attr)
                                            <input type="hidden" name="attr[{{ $attr->id }}][parent_id]" value="{{ $attr->attribute_id }}">
                                            <input type="hidden" name="attr[{{ $attr->id }}][name]" value="{{ $attr->name }}">
                                            <input type="hidden" name="attr[{{ $attr->id }}][id]" value="{{ $attr->id }}">
                                            <input type="hidden" name="attr[{{ $attr->id }}][key]" value="{{ $attr->name }}">
                                            <input type="hidden" name="attr[{{ $attr->id }}][value]" value="">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label"
                                                    for="signinSrEmail">{{ $attr->getTranslation('name') }}</label>
                                                <div class="col-md-8">
                                                    <select class="form-control selection"  multiple name="attr[{{ $attr->id }}][values][]" >
                                                        @php
                                                            $values=[];
                                                            $characteristic_value=\App\Models\CharacteristicValues::where('attr_id', $attr->id)->where('product_id', $product->id)->first();
                                                            if($characteristic_value!=null && $characteristic_value->values!=null){
                                                                $values = array_map(function ($el) {
                                                                    return [
                                                                        'text' => $el,
                                                                        'selected' => true
                                                                    ];
                                                                }, explode(' / ', $characteristic_value->values));
                                                            }
                                                        @endphp
                                                            @foreach($values as $value)
                                                                <option value="{{ $value['text'] }}" @if($value['selected']) selected @endif>{{ ($value['text']) }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-primary form-control">{{translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.selection').select2({
                tags: true,
                tokenSeparators: ['#']
            });
        });
    </script>
@endsection
