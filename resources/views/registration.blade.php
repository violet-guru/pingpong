@extends('template')

@section('section')
    <div class="container narrow">
        @if(!is_null(session('message')))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif
        <form action="{{route('savePlayers')}}" method="POST" autocomplete="off">
            @csrf
            <h4>Register players</h4>
            @if($errors->any())
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-sm text-danger alert-danger">
                        <div class="form-group">
                            <label for="firstPlayer">First player name</label>
                            <select class="form-control text-danger" id="firstPlayer" name="firstPlayer">
                                <option value="">Select...</option>
                                @foreach($players as $player)
                                    <option value="{{$player->name}}">{{$player->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control text-danger" type="text" id="firstName" name="firstName"
                                   placeholder="Create new player name" value=""/>
                        </div>
                    </div>
                    <div class="col-sm text-info alert-info">
                        <div class="form-group">
                            <label for="secondPlayer">Second player name</label>
                            <select class="form-control text-info" id="secondPlayer" name="secondPlayer">
                                <option value="">Select...</option>
                                @foreach($players as $player)
                                    <option value="{{$player->name}}">{{$player->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control text-info" type="text" id="secondName" name="secondName"
                                   placeholder="Create new player name" value=""/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm centered">
                        <button class="btn btn-success m-2" type="submit">New Game</button>
                    </div>
                </div>
            </div>


        </form>
    </div>
@endsection
