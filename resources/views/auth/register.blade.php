@extends('layouts.master')

@section('content')


    @php
        $user = \Illuminate\Support\Facades\Session::get('social_user');
        if(!empty($user)){
            $user = json_decode($user,true);
        }
    @endphp

    @if(isset($user))
        <h2>Continue registration with google, fill the required inputs</h2>
    @else
        <h2>Registration</h2>
    @endif

    <form method="POST" action="{{ route('user.register') }}" class="g-3 pb-5">

        {{ csrf_field() }}

        <div class="card">
            <h5 class="card-header">Basic Information</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <label for="first_name">First Name*:</label>
                        <input type="text" class="form-control @if($errors->has('first_name')){{'is-invalid'}}@endif" id="first_name" name="first_name" value="{{ old('first_name',(isset($user) && isset($user['first_name'])) ? $user['first_name']:'') }}">
                        @if($errors->has('first_name'))
                            <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="last_name">Last Name*:</label>
                        <input type="text" class="form-control @if($errors->has('last_name')){{'is-invalid'}}@endif" id="last_name" name="last_name" value="{{ old('last_name',(isset($user) && isset($user['last_name'])) ? $user['last_name']:'') }}">
                        @if($errors->has('last_name'))
                            <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                        @endif
                    </div>

                    <div class="col-sm-6 mb-2">
                        <label for="email">Email*:</label>
                        <input type="email" class="form-control @if($errors->has('email')){{'is-invalid'}}@endif" id="email" name="email" value="{{ old('email',(isset($user) && isset($user['email'])) ? $user['email']:'') }}">
                        @if($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="col-sm-6 mb-2">
                        <label for="password">Password*:</label>
                        <input type="password" class="form-control @if($errors->has('password')){{'is-invalid'}}@endif" id="password" autocomplete="off" name="password">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <div class="col-sm-6 mb-2">
                        <label for="dob">Date Of Birth*:</label>
                        <input type="text" class="form-control datepicker @if($errors->has('dob')){{'is-invalid'}}@endif" id="dob" autocomplete="off" name="dob" value="{{ old('dob') }}">
                        @if($errors->has('dob'))
                            <div class="invalid-feedback">{{ $errors->first('dob') }}</div>
                        @endif
                    </div>

                    <div class="col-sm-6 mb-2">
                        <label for="gender">Gender*:</label><br/>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="Male" id="gender-male" checked>
                            <label class="form-check-label" for="gender-male">
                                Male
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="Female" id="gender-female" >
                            <label class="form-check-label" for="gender-female">
                                Female
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <label for="annual-income">Annual Income:</label>
                        <input type="number" class="form-control @if($errors->has('annual_income')){{'is-invalid'}}@endif" id="annual-income" autocomplete="off" name="annual_income" value="{{ old('annual_income') }}">
                        @if($errors->has('annual_income'))
                            <div class="invalid-feedback">{{ $errors->first('annual_income') }}</div>
                        @endif
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="occupation">Occupation:</label>
                        <select name="occupation" class="form-control" id="occupation" value="{{ old('occupation') }}">
                            <option value="">Select Option</option>
                            <option value="Private Job">Private Job</option>
                            <option value="Government Job">Government Job</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="family-type">Family Type:</label>
                        <select name="family_type" class="form-control" id="family-type" value="{{ old('family_type') }}">
                            <option value="">Select Option</option>
                            <option value="Joint Family">Joint Family</option>
                            <option value="Nuclear Family">Nuclear Family</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="manglik">Manglik:</label>
                        <select name="manglik" class="form-control" id="manglik" value="{{ old('manglik') }}">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <h5 class="card-header">Partner Preference</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <label for="partner-expected-income">Expected Income:</label>
                        <input type="text" id="partner-expected-income" readonly style="border:0; color:#f6931f; font-weight:bold;">
                        <input type="hidden" name="partner_expected_income_min">
                        <input type="hidden" name="partner_expected_income_max">
                        <br/><br/>
                        <div id="slider-range"></div>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="partner_occupation">Occupation:</label>
                        <select name="partner_occupation[]" class="form-control select2" multiple id="partner_occupation">
                            <option value="Private Job">Private Job</option>
                            <option value="Government Job">Government Job</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="partner-family-type">Family Type:</label>
                        <select name="partner_family_type[]" class="form-control select2" multiple id="partner-family-type">
                            <option value="Joint Family">Joint Family</option>
                            <option value="Nuclear Family">Nuclear Family</option>
                        </select>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="partner_manglik">Manglik:</label>
                        <select name="partner_manglik" class="form-control" id="partner_manglik">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-3">
                @if(isset($user) && isset($user['google_id']))
                    <input type="hidden" name="google_id" value="{{ $user['google_id'] }}">
                @endif

                <button type="submit" class="btn btn-primary w-25">Submit</button>
            </div>
            <div class="col-12 mt-3">
                <a href="{{ route('user.login') }}">Already have an account click to login instead</a>
            </div>
        </div>
    </form>
@endsection

@push('js-stack')
    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });

            $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 500000,
                values: [ 10000, 30000 ],
                slide: function( event, ui ) {
                    $("#partner-expected-income").val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );

                    $("input[name='partner_expected_income_min']").val(ui.values[ 0 ]);
                    $("input[name='partner_expected_income_max']").val(ui.values[ 1 ]);
                }
            });

            $("#partner-expected-income").val( "$" + $( "#slider-range" ).slider( "values", 0) + " - $" + $( "#slider-range" ).slider( "values", 1) );

            $("input[name='partner_expected_income_min']").val($( "#slider-range" ).slider( "values", 0));
            $("input[name='partner_expected_income_max']").val($( "#slider-range" ).slider( "values", 1));
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
