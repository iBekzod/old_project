@extends('backend.layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: () => ({
                option: false,
                options: '@json($options)',
                values: '@json($product->characteristicValues2)',
                data: []
            }),
            mounted () {
                this.values = JSON.parse(this.values)
                this.options = JSON.parse(this.options)
                console.log(this.options)
                this.values.filter((val) => {
                    this.data.push({
                        id: val.attr_id,
                        parent_id: val.parent_id,
                        key: val.key,
                        value: val.value
                    })
                })
            },
            template: `
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <label>Добавить готовую сетку</label>
                        <select @change="changeSelect" v-model="option" name="bla_bla_bla" id="" class="form-control">
                            <option :value="false"></option>
                            @foreach($options as $option)
                                <option disabled value="{{ $option->id }}">{{ $option->getTranslation('name') }}</option>
                                 @foreach($option->attributes as $attr)
                                    <option value="{{ $attr->id }}"> - {{ $attr->getTranslation('name') }}</option>
                                 @endforeach
                            @endforeach
                        </select>
                        <div class="mt-3 mb-3"></div>
                        <form action="{{ route('products.characteristics', $product->id) }}" method="post">
                            @csrf
                            <div class="row" v-for="(item, index) in data">
                                <input type="hidden" :name="'attr[' + index + '][id]'" :value="item.id">
                                <input type="hidden" :name="'attr[' + index + '][parent_id]'" :value="item.parent_id">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" :name="'attr[' + index + '][name]'" readonly :value="item.key" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" :name="'attr[' + index + '][value]'" :value="item.value" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="button" @click="removeItem(index)" class="btn btn-danger form-control" value="delete">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <button type="submit" class="form-control">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
`,
            methods: {
                changeSelect() {
                    this.options.filter((el) => {
                        console.log(el)
                        if (el.attributes) {
                            el.attributes.filter((val) => {
                                if (val.id === parseInt(this.option)) {
                                    this.data.push({
                                        id: val.id,
                                        parent_id: val.attribute_id,
                                        key: val.name,
                                        value: ''
                                    })
                                }
                            })
                        }
                    })
                    this.option = false
                },
                removeItem(index) {
                    this.data.splice(index, 1)
                }
            }
        })
    </script>
    <script type="text/x-template" id="form-template">
    </script>
@endsection

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
