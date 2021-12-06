@extends('layouts.app')

@section('title',$title)

@section('content')
<h1>{{ $title }}</h1>

<form action="/member/{{ $object->id }}" method="post">
    @method('PATCH')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="{{ $object->name }}">
        <label for="age">Age</label>
        <input type="text" class="form-control" name="age" value="{{ $object->age }}">
    </div>
    @csrf
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection