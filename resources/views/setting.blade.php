@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-3">Email</div>
                        <div class="col-9">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-3">Level</div>
                        <div class="col-9">{{ Auth::user()->level }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-3">Exp</div>
                        <div class="col-9">{{ Auth::user()->exp }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
