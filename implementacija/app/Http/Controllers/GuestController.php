<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    //------------------GOST - NATALIJINO-------------------
    public function show()
    {
        return view("home.welcome");
    }

    public function pokedex()
    {
        // $content = file_get_contents("https://pokeapi.co/api/v2/pokemon/?limit=" . env('MAX_POKEMONS'));
        // $result  = json_decode($content);
        // $data = $result->results;
        // $pokeCnt = count($data);
        // $pokemons = [];
        // $pokeId = 0;

        // for ($i = 0; $i < $pokeCnt; $i++) {
        //     $pokeId++;
        //     array_push($pokemons, [
        //         'name' => strtoupper($data[$i]->name[0]) . substr($data[$i]->name, 1),
        //         'id' => $pokeId,
        //         'img' => "https://pokeres.bastionbot.org/images/pokemon/" . ($pokeId) . ".png" //"https://img.pokemondb.net/artwork/" . $data[$i]->name . ".jpg"
        //     ]);
        // }
       
        return view("home.pokedex");//, ["pokemons" => $pokemons]);
    }

    public function pokemon($id)
    {
        if ($id > env("MAX_POKEMONS"))
            abort(404);

        return view("home.pokemon", [
            'id' => $id,
            'name' => "Bulbasaur"
        ]);
    }

    public function quiz()
    {
        $pokeId =  random_int(1, 251);
        $content = file_get_contents("https://pokeapi.co/api/v2/pokemon/{$pokeId}");
        $result  = json_decode($content);
        session(['quizAnswer' => $result->name]);

        $pokeImg = "https://pokeres.bastionbot.org/images/pokemon/{$pokeId}.png";
        session(['quizAnswerImg' => $pokeImg]);

        return view("home.quiz", ["pokeImg" => $pokeImg]);
    }

    public function quizGuess(Request $request)
    {

        if ($request->has('refresh'))
            return redirect()->route('home.quiz');

        $quizAnswer = strtolower($request->session()->pull('quizAnswer'));


        if ($quizAnswer == strtolower($request->input("quizGuess"))) {
            //ako je ulogovan
            if (auth()->user()) {
                auth()->user()->addPokeCash();
            }
            return redirect()->route('home.quiz')->with('right', ['Correct answer!', session()->pull('quizAnswerImg')]);
        } else
            return redirect()->route('home.quiz')->with('wrong', 'Wrong answer!');
    }

    //------------------KRAJ NATALIJINOG-----------------------
}
