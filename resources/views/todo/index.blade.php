@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your To-Do Lists</h1>

    {{-- Show "New List" button only if user has Create permission --}}
    @if(in_array('Create', $permissions))
        <a href="{{ route('todo.create') }}" class="btn btn-primary mb-3">New List</a>
    @endif

    <ul class="list-group">
        @foreach($todos as $todo)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $todo->title }}

                <div>
                    {{-- Show Edit button only if user has Update permission --}}
                    @if(in_array('Update', $permissions))
                        <a href="{{ route('todo.edit', $todo) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endif

                    {{-- Show Delete button only if user has Delete permission --}}
                    @if(in_array('Delete', $permissions))
                        <form action="{{ route('todo.destroy', $todo) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection