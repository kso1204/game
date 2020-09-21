@extends('layouts.app')

@section('content')
<div class="container">
    
        <stage :user="{{Auth::user()}}"></stage>
</div>
@endsection
