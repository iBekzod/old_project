@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Categories')}}
        : {{ $attribute->getTranslation('name') }}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-body p-0">
          <form action="{{ route('attributes.update.categories', $attribute->id) }}" method="POST">
              {{-- <input name="_method" type="hidden" value="PATCH">
              <input type="hidden" name="lang" value="{{ $lang }}"> --}}
              @csrf
              <div class="form-group row">
                  {{-- <label class="col-sm-3 col-from-label" for="name">{{ translate('Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                  <div class="col-sm-9"> --}}
                      <select
                          class="form-control js-example-basic-multiple"
                          multiple name="category_id[]"
                          id="category_id">
                          @foreach ($categories as $key => $category)
                              <option value="{{ $category->id }}"
                                      @if($category->attribute_id==$attribute->id) selected @endif>{{ $category->getTranslation('name') }}</option>
                          @endforeach
                      </select>
                  {{-- </div> --}}
              </div>
              <div class="form-group mb-0 text-right">
                  <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
              </div>
            </form>
        </div>
    </div>
</div>

@endsection
