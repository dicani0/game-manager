<?php

namespace App\Http\Controllers\Character;

use App\Actions\Character\CreateCharacter;
use App\Actions\Character\DeleteCharacter;
use App\Actions\Character\UpdateCharacter;
use App\Data\Character\CharacterDto;
use App\Data\Character\CharacterUpdateDto;
use App\Enums\VocationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Character\DeleteCharacterRequest;
use App\Http\Requests\Character\EditCharacterRequest;
use App\Models\Character\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function update(CharacterUpdateDto $dto, Character $character, UpdateCharacter $action): RedirectResponse
    {
        $action->handle($character, $dto);
        return redirect('/characters')->with('success', 'Character updated successfully!');
    }

    public function store(CharacterDto $dto, CreateCharacter $action)
    {
        $action->handle($dto, Auth::user());
        return Inertia::render('Character/Character', [
            'characters' => Auth::user()->characters,
            'success' => 'Character created successfully!',
        ])->with('success', 'Character created successfully!');
    }

    public function delete(DeleteCharacterRequest $request, Character $character, DeleteCharacter $deleteCharacter): RedirectResponse
    {
        $deleteCharacter->handle($request->user(), $character);
        return redirect('/characters')->with('success', 'Character deleted successfully!');
    }
}
