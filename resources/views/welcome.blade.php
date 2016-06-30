@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Welcome to Lim<sup>2</sup> Acct. System
                </div>
                <div class="panel-body">
                    Please enjoy this system. <br/>
                    Click <a href="{{ url('/home') }}">here</a> to proceed.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
