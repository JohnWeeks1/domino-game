@extends('layouts.app')

@section('content')
    <select-dominoes-component :name="{{ json_encode($name) }}"/>
@endsection
