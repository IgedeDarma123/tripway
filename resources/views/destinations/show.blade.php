@extends('layouts.tripway')

@section('title', $destination->name . ' | TripWay')

@section('content')
<div class="container my-20">
    <h1 class="text-4xl font-bold text-center mb-16">{{ $destination->name }}</h1>
    
    <!-- Demo Pilihan Paket -->
    <x-pilihan-paket :packages="$packages" :addons="$addons" />
</div>
@endsection

