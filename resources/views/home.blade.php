@extends('layouts.app')

@section('title', 'WasselM3ak - Transport de marchandises')

@section('content')
    <!-- Hero Section -->
    @include('sections.hero')
    
    <!-- Stats Bar -->
    @include('sections.stats-bar')
    
    <!-- How It Works -->
    @include('sections.how-it-works')
    
    <!-- Features for Clients -->
    @include('sections.features-client')
    
    <!-- Features for Drivers -->
    @include('sections.features-driver')
    
    <!-- Object Types -->
    @include('sections.object-types')
    
    <!-- Testimonials -->
    @include('sections.testimonials')
    
    <!-- FAQ -->
    @include('sections.faq')
    
    <!-- CTA Banner -->
    @include('sections.cta-banner')
@endsection
