@extends('layouts.master')

@section('content')
    <h1 class="mb-5">Welcome {{ auth()->user()->first_name }} {{ auth()->user()->last_name }},</h1>

    <h5 class="mb-3">Her are users suggestions based on your partner preferences</h5>
    <table class="table table-bordered mb-3">
        <thead>
        <tr>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th scope="col">DOB</th>
            <th scope="col">Gender</th>
            <th scope="col">Annual Income</th>
            <th scope="col">Occupation</th>
            <th scope="col">Family Type</th>
            <th scope="col">Manglik</th>
            <th scope="col">Match</th>
            <th scope="col">Created On</th>
        </tr>
        </thead>
        <tbody>
        @php $count=1; @endphp
        @foreach($users as $user)
            <tr>
                <th scope="row">{{ $user->first_name." ".$user->last_name }}</th>
                <td>{{ $user->email }}</td>
                <td>{{ $user->dob }}</td>
                <td>{{ $user->gender }}</td>
                <td>{{ $user->annual_income }}</td>
                <td>{{ $user->occupation }}</td>
                <td>{{ $user->family_type }}</td>
                <td>{{ $user->manglik }}</td>
                <td>{{ $user->percent_of_total }}%</td>
                <td>{{ date("d/m/Y",strtotime($user->created_at)) }}</td>
            </tr>
            @php $count++; @endphp
        @endforeach
        </tbody>
    </table>

    <div class="row mb-5 pb-5">
        <div class="col-sm-6">{{ $users->links(("pagination::bootstrap-4")) }}</div>
        <div class="col-sm-6 text-end"><p>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}  of {{ $users->total() }} results</p></div>
    </div>

@endsection
