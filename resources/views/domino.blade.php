@extends('layouts.app')

@section('content')
    <domino-component :players="{{ json_encode($players) }}"/>
@endsection
