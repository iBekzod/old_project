@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Attribute Information')}}</h5>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill border-light">
                        @foreach (\App\Language::all() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                   href="{{ route('product-attributes.edit', [$attr->id, 'lang'=> $language->code] ) }}">
                                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11"
                                         class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <form class="p-4" action="{{ route('product-attributes.update', $attr->id) }}" method="POST">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name')}} <i
                                    class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name"
                                       class="form-control" required
                                       value="{{ $attr->getTranslation('name', $lang) }}">
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add Attribute') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('product-attributes.add_attr') }}" method="POST">
                        <input type="hidden" name="attribute_id" value="{{ $attr->id }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Name') }}</label>
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                   class="form-control" required>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Attributes')}}</h5>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Name')}}</th>
                            <th class="text-right">{{ translate('Options')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attributes as $key => $attribute)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$attribute->getTranslation('name')}}</td>
                                <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                       href="{{route('product-attributes.edit_attr', [$attribute->id, 'lang' => env('DEFAULT_LANGUAGE')] )}}"
                                       title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <form action="{{ route('product-attributes.destroy_attr', $attribute->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                                onclick="return confirm('{{ translate('Are you sure?') }}')"
                                                title="{{ translate('Delete') }}"
                                        >
                                            <i class="las la-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Change categories') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('product-attributes.change_categories', $attr->id) }}" method="POST">
                        <input type="hidden" name="attribute_id" value="{{ $attr->id }}">
                        @csrf
                        <div class="form-group" id="category">
                            <label>{{translate('Category')}}</label>

                            <select multiple="multiple" class="form-control js-example-basic-multiple" name="category_id[]"
                                    id="category_id"
                                    data-live-search="true" required>
                            {{-- <select multiple class="form-control aiz-selectpicker" name="category_id[]"
                                    id="category_id"
                                    data-live-search="true" required> --}}
                                @foreach ($categories as $category)

                                    {{-- <option disabled
                                        @if(in_array($category->id, $selected_categories))
                                        selected
                                        @endif
                                        value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option> --}}
                                    @foreach ($category->children as $childCategory)
                                        @include('backend.product-attributes.components.child_category', ['child_category' => $childCategory,'selected_categories' => $selected_categories])
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
