@extends('layouts.app')

@section('title',$title)

@section('content')
    <h1>{{ $title }}</h1>

    <form action="/member" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name">
            <label for="age">Age</label>
            <input type="text" class="form-control" name="age">
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection