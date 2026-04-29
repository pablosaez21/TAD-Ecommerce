@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<section style="padding:80px;">
    <div class="container">
        <h1>Dashboard</h1>

        <p>Bienvenido {{ auth()->user()->name }}</p>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>
    </div>
</section>

@endsection