@extends('template')

@php
    $board = $allBoards->first();

$isFirstServe = '';
$isSecondServe = '';
$imageServe = '<img src="https://img.icons8.com/color/48/000000/ping-pong.png"/>';
if($board->indexServe > 1) {
    $isFirstServe= $imageServe;
}
else {
    $isSecondServe = $imageServe;
}
@endphp

@section('section')
    <div class="container narrow text-success">
        <form action="{{route('setPoint')}}" method="POST" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-sm centered">
                    <button class="btn btn-success m-2" type="submit">Set point</button>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm text-danger">
                        <div>
                            <input type="radio" id="firstPlayer" name="playerTurn" value="0"/>
                            <label for="firstPlayer">{{$firstPlayer}} point</label>
                        </div>
                        <div>
                            <img src="https://i.pravatar.cc/200?u=c{{{$firstPlayer}}}" class="img-fluid avatar0"/>
                        </div>
                        @php echo $isFirstServe @endphp
                    </div>

                    <div class="col-sm my-auto centered">
                        <h1><span class="text-danger">{{$board->firstPoints}}</span>-<span class="text-info">{{$board->secondPoints}}</span></h1>
                    </div>
                    <div class="col-sm text-info rightered">
                        <div>
                            <input type="radio" id="secondPlayer" name="playerTurn" value="1" checked/>
                            <label for="secondPlayer">{{$secondPlayer}} point</label>
                        </div>
                        <div>
                            <img src="https://i.pravatar.cc/200?u=c{{{$secondPlayer}}}" class="img-fluid avatar1"/>
                        </div>
                        @php echo $isSecondServe @endphp
                    </div>
                </div>
            </div>
        </form>
        <form action="{{route('end')}}" method="POST" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-sm centered">
                    <button class="btn btn-success m-2" type="submit">End game</button>
                    <h4>Game started at: {{$board->matchDate}}</h4>
                </div>
            </div>
        </form>
        <h4>Leaderboard</h4>
        <table class="table">
            <thead>
            <tr>
                <th></th>
                <th>Player</th>
                <th>Number of wins</th>
            </tr>
            </thead>
            <tbody>
            @foreach($winners as $win)
                <tr>
                    <td>{{$loop->index + 1}}.</td>
                    <td>{{$win[0]}}</td>
                    <td>{{$win[1]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <h4>All Matches</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>First player</th>
                <th>Second player</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allBoards as $board)
                <tr>
                    <td>{{$board->matchDate}}</td>
                    <td>{{$board->firstPlayer->name}} with {{$board->firstPoints}}</td>
                    <td>{{$board->secondPlayer->name}} with {{$board->secondPoints}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
