<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SplQueue;

class GameTurnsController extends Controller
{
//    public function getGameTurns(Request $request)
//    {
//        $players = $request->playersNumber;
//        $turns = $request->turns;
//        $startingPlayer = $request->startingPlayer;
//
//        $turnsArray = [];
//        for ($i = 0; $i < $turns; $i++) {
//            $turnsArray[] = $this->getTurn($players, $startingPlayer);
//            $startingPlayer = $this->getNextPlayer($startingPlayer);
//        }
//
//        return response()->json($turnsArray);
//    }
    public function getGameTurns(Request $request)
    {
        $players = $request->playersNumber;
        $turns = $request->turns;
        $startingPlayer = $request->startingPlayer;

        $turnsArray = [];
        $playersQueue = new SplQueue();

        // Initialize the queue with players
        for ($i = 0; $i < $players; $i++) {
            $playersQueue->enqueue(chr(ord($startingPlayer) + $i));
        }

        for ($i = 0; $i < $turns; $i++) {
            $turn = [];
            $queueSize = $playersQueue->count();

            for ($j = 0; $j < $queueSize; $j++) {
                $player = $playersQueue->dequeue();
                $turn[] = $player;
                $playersQueue->enqueue($player);
            }

            $startingPlayer = $playersQueue->dequeue();
            $playersQueue->enqueue($startingPlayer);

            $turnsArray[] = $turn;
        }

        return response()->json($turnsArray);
    }
// To Get The Turns Number
    private function getTurn($players, $startingPlayer)
    {
        $turn = [];
        $alphabet = range('A', 'Z');
        $startingPlayerIndex = array_search($startingPlayer, $alphabet);

        for ($i = 0; $i < $players; $i++) {
            $playerIndex = ($startingPlayerIndex + $i) % $players;
            $turn[] = $alphabet[$playerIndex];
        }

        return $turn;
    }
//
//    private function getNextPlayer($player)
//    {
//        $alphabet = range('A', 'Z');
//        $playerIndex = array_search($player, $alphabet);
//        $nextPlayerIndex = ($playerIndex + 1) % count($alphabet);
//        return $alphabet[$nextPlayerIndex];
//    }
}
