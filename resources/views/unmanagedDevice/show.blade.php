@extends('layouts.app')

@section('title','Family')

@section('content')
    <h1>Family Index</h1>

    <ul>
        @forelse($items as $item)
            <li>{{ $item->description }}</li>
        @empty
            <li>No Families!</li>
        @endforelse
    </ul>

@endsection