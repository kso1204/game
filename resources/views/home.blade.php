@extends('layouts.app')

@section('content')
<div class="container">
    <profile :user="{{Auth::user()}}"></profile>
 </div>
@endsection
