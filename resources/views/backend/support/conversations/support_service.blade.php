@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Conversations')}}</h5>
    </div>
    <div class="card-body pr-0 mr-0">
        <table class=" text-center pr-0 mr-0" cellspacing="0"  width="100%" border="1px">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Type') }}</th>
                    <th>{{translate('Sender')}}</th>
                    <th>{{translate('Receiver')}}</th>
                    <th>{{translate('Title')}}</th>
                    <th>{{ translate('Date') }}</th>
                    {{-- <th>{{translate('Receiver')}}</th>
                    <th width="10%">{{translate('Options')}}</th> --}}
                </tr>
            </thead>

            <tbody>

            </tbody>

<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>


        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
