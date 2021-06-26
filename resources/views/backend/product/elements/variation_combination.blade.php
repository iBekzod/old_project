<div style="overflow-y: scroll; ">
    <table class="table table-bordered" >
        <thead>
        <tr>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('#') }}</label>
            </td>
            <td class="text-center">
                <label class="col-form-label" for="signinSrEmails">{{ translate('Variation Image') }}
                        <small>{{ translate('(290x300)') }}</small></label>
            </td>
            <td class="text-center">
                <label class="col-form-label" for="signinSrEmails">{{ translate('Gallery Images') }}
                        <small>{{ translate('(600x600)') }}</small></label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Name') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Artikul') }}</label>
            </td>
            {{-- <td class="text-center">
                <label for="" class="control-label">{{ translate('Delete') }}</label>
            </td> --}}

        </tr>
        </thead>
        <tbody>

        @foreach($combinations as $index=>$combination)
            @php
                $combination->edit=true;
            @endphp
            @include('backend.product.elements.single_variation_combination', ['combination'=>$combination, 'index'=>$index])
        @endforeach
    </tbody>
    </table>
</div>
