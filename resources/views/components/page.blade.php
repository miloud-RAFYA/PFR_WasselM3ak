@props(['name'])

@if($name)
    @include($name)
@else
    <p>Page not found</p>
@endif