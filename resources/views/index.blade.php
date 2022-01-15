@extends('layouts.app')

@section('content')
    <div id="app">
        <p>
            <router-link to="/">Home</router-link>
            <router-link to="/about">About</router-link>
        </p>

        <router-view></router-view>
    </div>
@endsection
