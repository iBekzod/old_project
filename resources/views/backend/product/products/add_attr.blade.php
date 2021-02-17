@extends('backend.layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script>
        $(document).ready(function() {
            $('select[name=bla_bla_bla]').select2();
        });
        new Vue({
            el: '#app',
            data: () => ({
                options: {{ json_encode($options) }}
            }),
            mounted() {
                console.log(this.options)
            },
            template: `
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <label>Добавить готовую сетку</label>
                        <select name="bla_bla_bla" id="" class="form-control">
                            <option value=""></option>
                            @foreach($options as $option)
                                <option value="{{ $option->id }}">{{ $option->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            `
        })
    </script>
@endsection

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Add attributes')}}</h5>
    </div>

{{--    <div class="row">--}}
{{--        <div class="col-lg-8 mx-auto">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <label>Добавить готовую сетку</label>--}}
{{--                    <select name="bla_bla_bla" id="" class="form-control">--}}
{{--                        <option value=""></option>--}}
{{--                        @foreach($options as $option)--}}
{{--                            <option value="{{ $option->id }}">{{ $option->getTranslation('name') }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="row">--}}
{{--        <div class="col-lg-8 mx-auto">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body p-0">--}}
{{--                    <ul class="nav nav-tabs nav-fill border-light">--}}
{{--                        @foreach (\App\Language::all() as $key => $language)--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"--}}
{{--                                   href="{{ route('product-attributes.edit', [$product->id, 'lang'=> $language->code] ) }}">--}}
{{--                                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11"--}}
{{--                                         class="mr-1">--}}
{{--                                    <span>{{ $language->name }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                    <form class="p-4" action="{{ route('product-attributes.update', $product->id) }}" method="POST">--}}
{{--                        <input name="_method" type="hidden" value="PATCH">--}}
{{--                        <input type="hidden" name="lang" value="{{ $lang }}">--}}
{{--                        @csrf--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Name')}} <i--}}
{{--                                    class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>--}}
{{--                            <div class="col-sm-9">--}}
{{--                                <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name"--}}
{{--                                       class="form-control" required--}}
{{--                                       value="{{ $product->product->getTranslation('name', $lang) }}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group mb-0 text-right">--}}
{{--                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">
        <div id="app"></div>
    </div>

@endsection
