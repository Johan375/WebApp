#auth/login.blade.php
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laravel fortify 2FA</h1>
    <div class="row justify-content-md-center">
        @if($errors->any())
            {!! implode('', $errors->all('<strong class="text-danger">:message</strong>')) !!}
        @endif

        <div class="col-md-6 col-offset-3">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="{{ route('register') }}" class="btn btn-info float-right ">Sign up</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
