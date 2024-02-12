@extends('layout')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Welcome {{ Auth::user()->name }} !</h4>
            </div>
        </div>
    </section>
@endsection
