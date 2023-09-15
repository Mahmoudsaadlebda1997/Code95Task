<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SplQueue;

class GameTurnsController extends Controller
{

    // Array Soullion
    public function getGameTurns(Request $request)
    {
        $players = $request->playersNumber;
        $turns = $request->turns;
        $startingPlayer = $request->startingPlayer;

        $playersArray = range('A', 'Z'); // Array of players from A to Z

        // Find the index of the startingPlayer in the playersArray
        $startingIndex = array_search($startingPlayer, $playersArray);

        $turnsArray = [];
        for ($i = 0; $i < $turns; $i++) {
            $turn = [];
            $playerIndex = $startingIndex;

            for ($j = 0; $j < $players; $j++) {
                $player = $playersArray[$playerIndex];
                $turn[] = $player;
                $playerIndex = ($playerIndex + 1) % $players;
            }

            // Rotate the playersArray to the left
            $firstPlayer = array_shift($playersArray);
            array_push($playersArray, $firstPlayer);

            $turnsArray[] = $turn;
        }

        return response()->json($turnsArray);
    }
//    //Queye sollution
//    public function getGameTurns(Request $request)
//    {
//        $players = $request->playersNumber;
//        $turns = $request->turns;
//        $startingPlayer = $request->startingPlayer;
//
//        $turnsArray = [];
//        $playersQueue = new SplQueue();
//
//        // Initialize the queue with players
//        for ($i = 0; $i < $players; $i++) {
//            $playersQueue->enqueue(chr(ord($startingPlayer) + $i));
//        }
//
//        for ($i = 0; $i < $turns; $i++) {
//            $turn = [];
//            $queueSize = $playersQueue->count();
//
//            for ($j = 0; $j < $queueSize; $j++) {
//                $player = $playersQueue->dequeue();
//                $turn[] = $player;
//                $playersQueue->enqueue($player);
//            }
//
//            $startingPlayer = $playersQueue->dequeue();
//            $playersQueue->enqueue($startingPlayer);
//
//            $turnsArray[] = $turn;
//        }
//
//        return response()->json($turnsArray);
//    }
}
