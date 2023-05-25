<?php

namespace App\Http\Controllers\Character;

use App\Actions\Character\CreateCharacter;
use App\Actions\Character\DeleteCharacter;
use App\Actions\Character\UpdateCharacter;
use App\Data\Character\CharacterDto;
use App\Enums\VocationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Character\StoreCharacterRequest;
use App\Http\Requests\Character\EditCharacterRequest;
use App\Http\Requests\Character\UpdateCharacterRequest;
use App\Models\Character\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CharacterController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Character/Character', [
            'characters' => $request->user()->characters,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Character/Create', [
            'vocations' => VocationEnum::getValues(),
        ]);
    }

    public function edit(EditCharacterRequest $request, Character $character): Response
    {
        return Inertia::render('Character/Edit', [
            'character' => $character,
            'vocations' => VocationEnum::getValues(),
        ]);
    }

    public function update(UpdateCharacterRequest $request, Character $character, UpdateCharacter $action): RedirectResponse
    {
        $action->handle($character, CharacterDto::from($request->validated()));
        return redirect('/characters')->with('success', 'Character updated successfully!');
    }

    public function store(StoreCharacterRequest $request, CreateCharacter $action)
    {
        $action->handle(CharacterDto::from($request->validated()), $request->user());
        return Inertia::render('Character/Character', [
            'characters' => $request->user()->characters,
            'success' => 'Character created successfully!',
        ])->with('success', 'Character created successfully!');
    }

    public function delete(Request $request, Character $character, DeleteCharacter $deleteCharacter): RedirectResponse
    {
        $deleteCharacter->handle($request->user(), $character);
        return redirect('/characters')->with('success', 'Character deleted successfully!');
    }
}
