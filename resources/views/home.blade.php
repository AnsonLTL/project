@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Main Menu
                </div>
                <div class="panel-body">
                    <a href="{{ url('/chooseCo') }}">Enter COA</a> <br/>
                    <a href="{{ url('/registerCo') }}">Register Company</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
