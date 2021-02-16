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
                                   href="{{ route('product-attributes.edit', [$attribute->id, 'lang'=> $language->code] ) }}">
                                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11"
                                         class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <form class="p-4" action="{{ route('product-attributes.update', $attribute->id) }}" method="POST">
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


        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add Attribute') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('product-attributes.add_attr') }}" method="POST">
                        <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
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
                                       href="{{route('product-attributes.edit', [$attribute->id, 'lang' => env('DEFAULT_LANGUAGE')] )}}"
                                       title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <form action="{{ route('product-attributes.destroy', $attribute->id) }}" method="post">
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
    </div>

@endsection
