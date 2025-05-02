@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registration</h1>
    <div class="row justify-content-md-center">
        @if($errors->any())
            {!! implode('', $errors->all('<strong class="text-danger">:message</strong>')) !!}
        @endif

        <div class="col-md-6 col-offset-3">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                    <a href="{{ route('login') }}" class="btn btn-info float-right ">Login</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
