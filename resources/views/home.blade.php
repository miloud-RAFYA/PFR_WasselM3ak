@extends('layouts.app')

@section('title', 'WasselM3ak - Marketplace logistique')

@section('content')
    @include('sections.hero')
    @include('sections.object-types')
    @include('sections.features-client')
    @include('sections.how-it-works')
    @include('sections.features-driver')
    @include('sections.stats-bar')
    @include('sections.testimonials')
    @include('sections.faq')
    @include('sections.cta-banner')
@endsection
