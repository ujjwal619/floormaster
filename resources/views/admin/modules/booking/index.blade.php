@extends('admin.layouts.main')

@section('title', 'Booking')

@section('content')
    <bookings inline-template
    >
        @include('admin.modules.booking.partials.list')
    </bookings>
@endsection
