<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App;

class PageController extends Controller
{
    public function pingpong()
    {
        $allBoards = $this->getLeaderboards();
        $allPlayers = App\Player::all();

        //Populating with player objects
        foreach ($allBoards as $item) {
            $item->firstPlayer = $this->getPlayerById($allPlayers, $item->firstPlayerId);
            $item->secondPlayer = $this->getPlayerById($allPlayers, $item->secondPlayerId);
        }

        $winners = [];

        //Order data by winners
        $i = 0;
        foreach ($allBoards as $item) {
            if ($i > 0) {
                if ($item->firstPoints > $item->secondPoints) {
                    $index = $item->firstPlayer->name;
                    if (!array_key_exists($index, $winners)) {
                        $winners[$index] = [$index, 1];
                    } else {
                        $newWin = $winners[$index][1] + 1;
                        $winners[$index] = [$index, $newWin];
                    }
                } else if ($item->firstPoints < $item->secondPoints) {
                    $index = $item->secondPlayer->name;
                    if (!array_key_exists($index, $winners)) {
                        $winners[$index] = [$index, 1];
                    } else {
                        $newWin = $winners[$index][1] + 1;
                        $winners[$index] = [$index, $newWin];
                    }
                }
            }
            $i++;
        }

        usort($winners, function($first, $second) {return $first[1] < $second[1];});

        $board = $allBoards->first();
        $firstPlayer = App\Player::findOrFail($board->firstPlayerId)->name;
        $secondPlayer = App\Player::findOrFail($board->secondPlayerId)->name;
        return view('pingpong', compact('allBoards', 'firstPlayer', 'secondPlayer', 'winners'));
    }

    public function setPoint(Request $request)
    {
        $board = $this->getLeaderboards()->first();

        if ($request->playerTurn == '1') {
            $board->secondPoints = $board->secondPoints + 1;
        } else {
            $board->firstPoints = $board->firstPoints + 1;
        }
        if($board->indexServe == 3) {
            $board->indexServe = 0;
        }
        else {
            $board->indexServe = $board->indexServe + 1;
        }

        $board->save();

        //Checking if it has >= of 2 points when they have more than 10
        if ($board->firstPoints > 10 && $board->firstPoints - 2 == $board->secondPoints ||
            $board->firstPoints == 10 && $board->firstPoints - 1 > $board->secondPoints) {
            $player = App\Player::findOrFail($board->firstPlayerId);
            return redirect()->route('registration')->with('message', 'Winner: ' . $player->name);
        }

        if ($board->secondPoints > 10 && $board->secondPoints - 2 == $board->firstPoints ||
            $board->secondPoints == 10 && $board->secondPoints - 1 > $board->firstPoints) {
            $player = App\Player::findOrFail($board->secondPlayerId);
            return redirect()->route('registration')->with('message', 'Winner: ' . $player->name);
        }

        return redirect()->route('pingpong');
    }

    public function registration()
    {
        $players = App\Player::all();
        return view('registration', compact('players'));
    }

    public function savePlayers(Request $request)
    {
        //Check if player exists, because you can duplicate a name from the firstName input
        $playerValue = $request->firstPlayer;
        if (is_null($playerValue)) {
            if (is_null($request->firstName)) {
                throw new Exception('No player name selected.');
            }

            $playerValue = $request->firstName;
        }

        $players = App\Player::where(['name' => $playerValue])->get();
        if ($players->count() > 0) {
            $searchedPlayer = $players->first();
        } else {
            $player = new App\Player;
            $player->name = $request->firstName;
            $player->save();
            $searchedPlayer = $player;
        }

        //For second player. Check if player exists, because you can duplicate a name from the firstName input
        $secondPlayerValue = $request->secondPlayer;
        if (is_null($secondPlayerValue)) {
            if (is_null($request->secondName)) {
                throw new Exception('No player name selected.');
            }

            $secondPlayerValue = $request->secondName;
        }
        $allPlayers = App\Player::where(['name' => $secondPlayerValue])->get();
        if ($allPlayers->count() > 0) {
            $searchedSecondPlayer = $allPlayers->first();
        } else {
            $player = new App\Player;
            $player->name = $request->secondName;
            $player->save();
            $searchedSecondPlayer = $player;
        }

        $leaderboard = new App\Leaderboard;
        $leaderboard->firstPlayerId = $searchedPlayer->id;
        $leaderboard->secondPlayerId = $searchedSecondPlayer->id;
        $leaderboard->indexServe = 0;
        $leaderboard->firstPoints = 0;
        $leaderboard->secondPoints = 0;
        $leaderboard->matchDate = now();
        $leaderboard->save();

        return redirect()->route('pingpong');
    }

    public function end()
    {
        return redirect()->route('registration')->with('message', 'Game ended.');
    }

    function getLeaderboards()
    {
        return App\leaderboard::all()->sortByDesc('matchDate');
    }

    function getPlayerById($allBoards, $id)
    {
        foreach ($allBoards as $item) {
            if ($item->id == $id) {
                return $item;
            }
        }
    }
}
