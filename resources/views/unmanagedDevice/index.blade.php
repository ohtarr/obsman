@extends('layouts.app')

@section('title',$title)

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm">
            </div>
            <div class="col-lg">
                <h1 class="text-center">{{ $title }}</h1>
                
<!--                 <a class="btn btn-success btn-block" href="/family/create">Create New Family</a> -->
                <h1 class="text-center">Members</h1>
                <table class="table table-striped table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>AGE</th>
                        <th>CREATED_AT</th>
                        <th>UPDATED_AT</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->age }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <a class="btn btn-warning" href="/member/{{ $item->id }}/edit">Edit</a>
                        </td>
                        <td>
                            <form action="/member/{{ $item->id }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
                <a class="btn btn-success btn-block" href="/member/create">Create New Member</a>
            </div>
            <div class="col-sm">
            </div>
        </div>
    </div>
@endsection