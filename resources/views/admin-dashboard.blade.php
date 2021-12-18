@extends('layouts.master')

@section('content')
    <h1 class="mb-5">Welcome {{ auth()->guard('admin')->user()->first_name }} {{ auth()->guard('admin')->user()->last_name }},</h1>

    <h5 class="mb-3">Registered users</h5>

    <div class="card mt-3 mb-3">
        <h5 class="card-header">Advanced Filter</h5>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.dashboard') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label for="income-range">Income Range:</label>
                        <input type="text" id="income-range" readonly style="border:0; color:#f6931f; font-weight:bold;">
                        <input type="hidden" name="income_min" value="@if(isset($filter['income_min'])){{ $filter['income_min'] }}@endif">
                        <input type="hidden" name="income_max" value="@if(isset($filter['income_min'])){{ $filter['income_min'] }}@endif">
                        <div class="mt-2" id="slider-range"></div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <label for="age">Agent (in year):</label>
                        <input type="number" name="age" id="age" class="form-control" value="@if(isset($filter['age'])){{ $filter['age'] }}@endif">
                    </div>
                    <div class="col-sm-3 mb-2">
                        <label for="manglik">Manglik:</label>
                        <select name="manglik[]" class="form-control select2" multiple id="manglik">
                            <option value="No" @if(isset($filter['manglik']) && in_array("No",$filter['manglik'])){{ 'selected' }}@endif>No</option>
                            <option value="Yes" @if(isset($filter['manglik']) && in_array("Yes",$filter['manglik'])){{ 'selected' }}@endif>Yes</option>
                        </select>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <label for="gender">Gender:</label>
                        <select name="gender[]" class="form-control select2" multiple id="gender">
                            <option value="Male" @if(isset($filter['gender']) && in_array('Male',$filter['gender'])){{ 'selected' }}@endif>Male</option>
                            <option value="Female" @if(isset($filter['gender']) && in_array('Female',$filter['gender'])){{ 'selected' }}@endif>Female</option>
                        </select>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <label for="family-type">Family Type:</label>
                        <select name="family_type[]" class="form-control select2" multiple id="family-type">
                            <option value="Joint Family" @if(isset($filter['family_type']) && in_array('Joint Family',$filter['family_type'])){{ 'selected' }}@endif>Joint Family</option>
                            <option value="Nuclear Family" @if(isset($filter['family_type']) && in_array('Nuclear Family',$filter['family_type'])){{ 'selected' }}@endif>Nuclear Family</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-info">Clear Filter</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <table class="table table-bordered mb-3 ">
        <thead>
        <tr>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th scope="col">DOB</th>
            <th scope="col">Age</th>
            <th scope="col">Gender</th>
            <th scope="col">Annual Income</th>
            <th scope="col">Occupation</th>
            <th scope="col">Family Type</th>
            <th scope="col">Manglik</th>
            <th scope="col">Created On</th>
        </tr>
        </thead>
        <tbody>
        @if(count($users) > 0)
            @php $count=1; @endphp
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->first_name." ".$user->last_name }}</th>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->dob }}</td>
                    <td>{{ $user->age }} Years</td>
                    <td>{{ $user->gender }}</td>
                    <td>{{ $user->annual_income }}</td>
                    <td>{{ $user->occupation }}</td>
                    <td>{{ $user->family_type }}</td>
                    <td>{{ $user->manglik }}</td>
                    <td>{{ date("d/m/Y",strtotime($user->created_at)) }}</td>
                </tr>
                @php $count++; @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10" align="center">
                    <strong>No records found</strong>
                </td>
            </tr>
        @endif
        </tbody>
    </table>

    @if(request()->method() == 'GET')
        <div class="row mb-5 pb-5">
            <div class="col-sm-6">{{ $users->links(("pagination::bootstrap-4")) }}</div>
            <div class="col-sm-6 text-end"><p>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}  of {{ $users->total() }} results</p></div>
        </div>
    @endif

@endsection

@push('js-stack')
    <script>
        $(function() {

            var minDefVal = 0;
            var maxDefVal = 500000;

            @if(isset($filter['income_min']))
                minDefVal = {{ $filter['income_min'] }};
            @endif

            @if(isset($filter['income_max']))
                maxDefVal = {{ $filter['income_max'] }};
            @endif

            $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 500000,
                values: [ minDefVal, maxDefVal ],
                slide: function( event, ui ) {
                    $("#income-range").val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );

                    $("input[name='income_min']").val(ui.values[ 0 ]);
                    $("input[name='income_max']").val(ui.values[ 1 ]);
                }
            });

            $("#income-range").val( "$" + $( "#slider-range" ).slider( "values", 0) + " - $" + $( "#slider-range" ).slider( "values", 1) );

            $("input[name='income_min']").val($( "#slider-range" ).slider( "values", 0));
            $("input[name='income_max']").val($( "#slider-range" ).slider( "values", 1));
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
