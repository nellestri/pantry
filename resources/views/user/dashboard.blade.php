@extends('layouts.user')

@section('title', 'User Dashboard')

@section('content')
<div class="container mt-4">
    <h1>Welcome, {{ Auth::user()->name }}</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Active Reservations</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $activeReservationsCount }}</h5>
                    <a href="{{ route('reservations.index') }}" class="btn btn-light btn-sm mt-2">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Upcoming Pickups</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $upcomingPickupsCount }}</h5>
                    <a href="{{ route('user.pickups') }}" class="btn btn-light btn-sm mt-2">Schedule</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Notifications</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $unreadNotificationsCount }}</h5>
                    <a href="{{ route('user.notifications') }}" class="btn btn-light btn-sm mt-2">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
