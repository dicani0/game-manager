<?php

namespace App\Http\Controllers\Character;

use App\Actions\Character\CreateCharacter;
use App\Actions\Character\DeleteCharacter;
use App\Data\Character\CharacterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Character\CharacterRequest;
use App\Models\Character\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function store(CharacterRequest $request, CreateCharacter $action): RedirectResponse
    {
        $action->handle(CharacterDto::from($request->validated()), $request->user());
        return redirect('/characters')->with('success', 'Character created successfully!');
    }

    public function delete(Request $request, Character $character, DeleteCharacter $deleteCharacter): RedirectResponse
    {
        $deleteCharacter->handle($request->user(), $character);
        return redirect('/characters')->with('success', 'Character deleted successfully!');
    }
}
