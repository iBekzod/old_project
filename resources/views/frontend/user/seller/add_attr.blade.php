@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">

                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Characteristics') }}</h1>
                            </div>
                        </div>
                    </div>

                    <div id="app"></div>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script type="text/x-template" id="select2-template">
        <select class="form-control">
            <slot></slot>
        </select>
    </script>
    <script>
        Vue.component("select2", {
            props: ["options", "value"],
            template: "#select2-template",
            mounted: function() {
                var vm = this;
                $(this.$el)
                    // init select22
                    .select2({
                        data: this.options,
                        tags: true,
                        tokenSeparators: [',', ' ']
                    })
                    .trigger("change")
                    // emit event on change.
                    .on("change", function() {
                        vm.$emit("input", this.value);
                    });

                // if(this.options) {
                //     this.options.map(el => {
                //         $(this.$el).val(el.text)
                //     })
                // }
            },
            watch: {
                value: function(value) {
                    // update value
                    $(this.$el)
                        .val(value)
                        .trigger("change");
                },
                options: function(options) {
                    // update options
                    $(this.$el)
                        .empty()
                        .select2({ data: options });
                }
            },
            destroyed: function() {
                $(this.$el)
                    .off()
                    .select2("destroy");
            }
        });

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
                // console.log(this.values)
                this.options = JSON.parse(this.options)
                this.values.filter((val) => {
                    this.data.push({
                        id: val.attr_id,
                        parent_id: val.parent_id,
                        key: val.key,
                        value: val.value,
                        values: val.values,
                    })
                })
                console.log(this.data)
            },
            template: `
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <label>Добавить готовую сетку</label>
                        <select multiple @change="selectOnChange" v-model="option" name="bla_bla_bla" id="" class="form-control select2">
                            <option :value="false"></option>
                            @foreach($options as $option)
            <option disabled value="{{ $option->id }}">{{ $option->getTranslation('name') }}</option>
                                 @foreach($option->attributes as $attr)
            <option value="{{ $attr->id }}"> - {{ $attr->getTranslation('name') }}</option>
                                 @endforeach
            @endforeach
            </select>
            <div class="mt-3 mb-3"></div>
            <form action="{{ route('seller.products.characteristics', $product->id) }}" method="post">
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
                        <select2 multiple="multiple" :name="'attr[' + index + '][values][]'"
                        :options="item.values"></select2>
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
                selectOnChange() {
                    this.options.filter((el) => {
                        if (el.attributes) {
                            el.attributes.filter((val) => {
                                if (val.id === parseInt(this.option)) {
                                    var item = {
                                        id: val.id,
                                        parent_id: val.attribute_id,
                                        key: val.name,
                                        values: val.values,
                                        value: ''
                                    }
                                    item.values = item.values.map(el => ({id: el.value, text: el.value}))
                                    this.data.push(item)
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
