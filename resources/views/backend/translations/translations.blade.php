@extends('backend.layouts.app')

@section('content')

    <div class="card">
        <div class="card-header row gutters-5">
         <div class="col text-md-right">
            {{-- @php
                $language_selected = $language_selected;
            @endphp --}}
            <div class="ml-2 aiz-topbar-item">
                <div class="align-items-stretch d-flex dropdown " id="trans-lang-changes">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon">
                            @if($language_selected=='all')<img src="{{ static_asset('assets/img/placeholder.jpg') }}" height="11">
                            @else<img src="{{ static_asset('assets/img/flags/'.$language_selected.'.png') }}" height="11">
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xs">
                        {{-- <li>
                            <a href="{{route('translations.show_translation', ['base_table'=>$base_table, 'table_translations'=>$table_translations, 'relation_id'=>$relation_id, 'language_selected'=>'all'])}}" data-flag="all" class="dropdown-item @if($language_selected == 'all') active @endif">
                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}" height="11" class="mr-2">
                                <span class="language">{{translate('All')}}</span>
                            </a>
                        </li> --}}
                        @foreach (\App\Language::all() as $key => $language)
                            <li>
                                <a href="{{route('translations.show_translation', ['base_table'=>$base_table, 'table_translations'=>$table_translations, 'relation_id'=>$relation_id, 'language_selected'=>$language->code])}}" data-flag="{{ $language->code }}" class="dropdown-item @if($language_selected == $language->code) active @endif">
                                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-2">
                                    <span class="language">{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
           {{-- <h5 class="mb-md-0 h6">{{ $language_selected }}</h5> --}}
         </div>
         <div class="col-md-4">
           <form class="" id="sort_keys" action="" method="GET">
             <div class="input-group input-group-sm">
                 <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type key & Enter') }}">
             </div>
           </form>
         </div>
       </div>
        <form class="form-horizontal" action="{{ route('translations.key_value_store_translations') }}" method="POST">
            @csrf
            <input type="hidden" id="language_selected" name="language_selected" value="{{ $language_selected }}">
            <input type="hidden" id="base_table" name="base_table" value="{{ $base_table }}">
            <input type="hidden" id="table_translations" name="table_translations" value="{{ $table_translations }}">
            <input type="hidden" id="relation_id" name="relation_id" value="{{ $relation_id }}">
            <div class="card-body">


                <table class="table table-striped table-bordered demo-dt-basic" id="tranlation-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="45%">{{translate('Key')}}</th>
                            <th width="45%">{{translate('Value')}}</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach ($translations as $key => $translation)
                            @if($translation->lang==$language_selected)
                            <tr>
                                <td>{{ ($key+1) + ($translations->currentPage() - 1)*$translations->perPage() }} @if($language_selected=='all') - {{ $translation->lang }} @endif</td>
                                <td class="key"> {{$translation->key}} </td>
                                <td>
                                    <input type="text" class="form-control value" style="width:100%" name="values[{{ $translation->id }}]"
                                        value="{{ $translation->value }}"
                                    >
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                   {{ $translations->appends(request()->input())->links() }}
                </div>

                <div class="mb-0 text-right form-group">
                    <button type="button" class="btn btn-primary" onclick="copyTranslation()">{{ translate('Copy Translations') }}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        //translate in one click
        function copyTranslation() {
            $('#tranlation-table > tbody  > tr').each(function (index, tr) {
                $(tr).find('.value').val($(tr).find('.key').text());
            });
        }

        function sort_keys(el){
            $('#sort_keys').submit();
        }

        if ($('#trans-lang-change').length > 0) {
            $('#trans-lang-change .dropdown-menu a').each(function() {
                $(this).on('click', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    var language_selected=$this.data('flag');
                    var base_table=$("#base_table").val();
                    var table_translations=$("#table_translations").val();
                    var relation_id=$("#relation_id").val();
                    $.post('{{ route('translations.show_translation') }}',
                        {_token:'{{ csrf_token() }}',
                        language_selected:language_selected,
                        base_table:base_table,
                        table_translations:table_translations,
                        relation_id:relation_id
                    }, function(data){
                            // alert(data);
                            //location.reload();
                        });

                    });
            });
        }
    </script>
@endsection
