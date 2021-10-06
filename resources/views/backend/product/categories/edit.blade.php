@extends('backend.layouts.app')

@section('content')

<div class="mt-2 mb-3 text-left aiz-titlebar">
    <h5 class="mb-0 h6">{{translate('Category Information')}}</h5>
</div>

<div class="mx-auto col-lg-12">
    <div class="card">
        <div class="p-0 card-body">
  			<ul class="nav nav-tabs nav-fill border-light">
  				@foreach (\App\Language::all() as $key => $language)
  					<li class="nav-item">
  						<a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('categories.edit', ['id'=>$mainCategory->id, 'lang'=> $language->code] ) }}">
  							<img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
  							<span>{{$language->name}}</span>
  						</a>
  					</li>
  		        @endforeach
  			</ul>
            <form class="p-4" action="{{ route('categories.update', $mainCategory->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
	            <input type="hidden" name="lang" value="{{ $lang }}">
            	@csrf
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                    <div class="col-md-9">
                        <input type="text" name="name" value="{{ $mainCategory->getTranslation('name', $lang) }}" class="form-control" id="name" placeholder="{{translate('Name')}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Parent Category')}}</label>
                    <div class="col-md-9">
                        <select class="select2 form-control aiz-selectpicker" name="parent_id" data-toggle="select2" data-placeholder="Choose ..."data-live-search="true" data-selected="{{ $mainCategory->parent_id ? $mainCategory->parent_id : 0 }}">
                            <option value="0" @if($mainCategory->level == 0) selected @endif>{{ translate('No Parent') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                @foreach ($category->children as $childCategory)
                                    @include('categories.child_category', ['child_category' => $childCategory])
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Type')}}</label>
                    <div class="col-md-9">
                        <select name="digital" required class="mb-2 form-control aiz-selectpicker mb-md-0">
                            <option value="0" @if ($mainCategory->digital == '0') selected @endif>{{translate('Physical')}}</option>
                            <option value="1" @if ($mainCategory->digital == '1') selected @endif>{{translate('Digital')}}</option>
                        </select>
                    </div>
                </div>
	              <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Banner')}} <small>({{ translate('200x200') }})</small></label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            {{-- @if($mainCategory->banner !== null) --}}
                                <input type="hidden" name="banner" class="selected-files" value="{{ $mainCategory->banner??'' }}">
                            {{-- @endif --}}
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Icon')}} <small>({{ translate('32x32') }})</small></label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            {{-- @if($mainCategory->icon != null) --}}
                                <input type="hidden" name="icon" class="selected-files" value="{{ $mainCategory->icon??'' }}">
                            {{-- @endif --}}
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Meta Title')}}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="meta_title" value="{{ $mainCategory->meta_title }}" placeholder="{{translate('Meta Title')}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('Meta Description')}}</label>
                    <div class="col-md-9">
                        <textarea name="meta_description" rows="5" class="form-control">{{ $mainCategory->meta_description }}</textarea>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-md-3 col-form-label">{{translate('Slug')}}</label>
                    <div class="col-md-9">
                        <input type="text" placeholder="{{translate('Slug')}}" id="slug" name="slug" value="{{ $mainCategory->slug }}" class="form-control">
                    </div>
                </div>
                @if (\App\BusinessSetting::where('type', 'category_wise_commission')->first()->value == 1)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Commission Rate')}}</label>
                        <div class="col-md-9 input-group">
                            <input type="number" lang="en" min="0" step="0.01" id="commision_rate" name="commision_rate" value="{{ $mainCategory->commision_rate }}" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{ translate('Attributes')}} </label>
                    <div class="col-sm-9">
                        <select
                            class="form-control js-example-basic-multiple"
                            multiple name="attribute_ids[]"
                            id="attribute_ids">
                            @foreach (\App\Attribute::all() as $attribute)
                                <option value="{{ $attribute->id }}"
                                        @if(in_array($attribute->id, $category_attribute_ids)) selected @endif
                                >{{ $attribute->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-0 text-right form-group">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
