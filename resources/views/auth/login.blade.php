@extends('layouts.master')

@section('content')

    <div class="d-flex justify-content-center">
        <div class="justify-content-center">
            <div class="card" style="max-width: 500px;">
                <h5 class="card-header">Welcome back! Log In</h5>
                <div class="card-body">

                    {!! $errors->first('message', '<div class="alert alert-danger">:message</div>') !!}

                    <form method="POST" action="{{ route('user.login') }}" class="row g-3">
                        {{ csrf_field() }}
                        <div class="col-12">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="col-12">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-50">Login</button>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('user.register') }}">Don't have an account register now</a>
                        </div>
                        <div class="col-12 text-center">
                            <hr/>
                            <p>OR</p>
                            <a class="mt-3" href="{{ route('user.social.redirect') }}"><img src="{{ asset('images/google-login.png') }}" style="" alt=""></a>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
