@php
    $value = null;
    for ($i=0; $i < $child_category->level; $i++){
        $value .= '--';
    }
@endphp
<option value="{{ $child_category->id }}">{{ $value." ".$child_category->name }}</option>
@if ($child_category->children)
    @foreach ($child_category->children as $childCategory)
        @include('categories.child_category', ['child_category' => $childCategory])
    @endforeach
@endif
