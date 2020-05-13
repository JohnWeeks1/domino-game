@extends('layouts.app')

@section('content')
    <domino-component :player-names="{{ json_encode($player_names) }}"/>
@endsection
