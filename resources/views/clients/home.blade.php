@extends('layouts.clients.client_layout')
@section('header')
    @include('blocks.clients.header')
@endsection

@section('content')    
    @include('blocks.clients.vehicle.list_vehicle')
   
   @include('blocks.clients.home.list_comment')
@endsection