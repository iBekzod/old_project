@if(count($combinations[0]) > 0)
<div style="overflow-y: scroll; ">
    <table class="table table-bordered" style="width:1800px">
        <thead>
        <tr>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Slug') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Price') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('crwd') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Quantity') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Discount') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Discount Type') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Delivery') }}</label>
            </td>

            <td class="text-center">
                <label for="" class="control-label">{{ translate('Tax') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Tax type') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Todays deels') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Published') }}</label>
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach ($combinations as $index=>$combination)
        <tr class="variant">
            <td> <label for="" class="control-label">{{implode ("-", $combination)}}</label>
                <input type="hidden" name="slug_{{$index}}" value="{{implode ("-", $combination)}}" class="form-control"></td>
            <td>


            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="select1" id="select1">
                    <option value="1">Erkaklar Kiyimi</option>
                    <option value="2">Ayolar Kiyimi</option>
                    <option value="2">Bollalar Kiyimi</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" id="exampleInputEmail1">
            </td>
            <td>
                <input type="text" class="form-control" id="exampleInputEmail1">
            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="select1" id="select1">
                    <option value="1">Erkaklar Kiyimi</option>
                    <option value="2">Ayolar Kiyimi</option>
                    <option value="2">Bollalar Kiyimi</option>
                </select>
            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="select1" id="select1">
                    <option value="1">Erkaklar Kiyimi</option>
                    <option value="2">Ayolar Kiyimi</option>
                    <option value="2">Bollalar Kiyimi</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" id="exampleInputEmail1">
            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="select1" id="select1">
                    <option value="1">Erkaklar Kiyimi</option>
                    <option value="2">Ayolar Kiyimi</option>
                    <option value="2">Bollalar Kiyimi</option>
                </select>
            </td>
            <td>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </td>
            <td>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </td>
            <td>
                <button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variant(tdis)"><i class="las la-trash"></i></button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@endif
