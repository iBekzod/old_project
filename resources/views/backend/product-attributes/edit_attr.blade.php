@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Attribute Information')}}</h5>
    </div>

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product-attributes.edit', $attribute->parent->id) }}">{{ translate('parent') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $attribute->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill border-light">
                        @foreach (\App\Language::all() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                   href="{{ route('product-attributes.edit_attr', [$attribute->id, 'lang'=> $language->code] ) }}">
                                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11"
                                         class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <form class="p-4" action="{{ route('product-attributes.update_attr', $attribute->id) }}" method="POST">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name')}} <i
                                    class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name"
                                       class="form-control" required
                                       value="{{ $attribute->getTranslation('name', $lang) }}">
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5>{{ translate('Add new attribute values') }}</h5>
                    <form action="{{ route('product-attributes.edit_attr', $attribute->id) }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="attr_values">{{ translate('Values') }}</label>
                            <select class="form-control select2-attr" multiple name="attr_values[]" id="attr_values">
                                @foreach($attribute->values as $item)
                                    <option value="{{ $item->value }}" selected>{{ $item->value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary">{{ translate('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('.select2-attr').select2({
                tags: true,
                tokenSeparators: ['#']
            })
        })
    </script>
@endsection
