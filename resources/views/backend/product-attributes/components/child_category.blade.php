@php
    $value = null;
    for ($i=0; $i < $child_category->level; $i++){
        $value .= '--';
    }
@endphp
<option
    @if(in_array($child_category->id, $selected_categories))
    selected
    @endif
    value="{{ $child_category->id }}">{{ $value." ".$child_category->getTranslation('name') }}</option>
@if ($child_category->categories)
    @foreach ($child_category->categories as $childCategory)
        @include('backend.product-attributes.components.child_category', ['child_category' => $childCategory, 'selected_categories' => $selected_categories])
    @endforeach
@endif
