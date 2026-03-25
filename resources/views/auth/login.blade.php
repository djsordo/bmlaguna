@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="col s2">
            <img src="/images/escudo.png" alt="Balonmano Laguna" class="responsive-img">
        </div>

        <div class="col s6">
            @include('auth.login_form')
        </div>
    </div>
@endsection
