@extends('layouts.app')

@section('content')
    <select-dominoes-component
        :used-dominoes="{{ json_encode($used_dominoes) }}"
        :player-in-session="{{ json_encode($player_in_session) }}"/>
@endsection
