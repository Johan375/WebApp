@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nickname:</label>
            <input type="text" class="form-control" name="nickname" value="{{ old('nickname', $user->nickname) }}">
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="form-group">
            <label>City:</label>
            <input type="text" class="form-control" name="city" value="{{ old('city', $user->city) }}">
        </div>

        <div class="form-group">
            <label>Avatar:</label><br>
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" width="100" alt="Avatar"><br><br>
            @endif
            <input type="file" name="avatar">
        </div>

        <div class="form-group">
            <label>New Password:</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-info">Update Profile</button>
    </form>

    <hr>

    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
</div>
@endsection