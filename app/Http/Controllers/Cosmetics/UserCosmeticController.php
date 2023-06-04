<?php

namespace App\Http\Controllers\Cosmetics;

use App\Actions\Items\DeleteItem;
use App\Actions\Items\UpdateItem;
use App\Data\Items\ImportItemsDto;
use App\Data\Items\UpdateItemDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Items\DeleteItemRequest;
use App\Http\Requests\Items\SyncItemsRequest;
use App\Http\Requests\Items\UpdateItemRequest;
use App\Http\Resources\Cosmetics\UserCosmeticResource;
use App\Models\Cosmetics\UserCosmetic;
use App\Processes\Items\ImportItemsProcess;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserCosmeticController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Items/Item', [
            'items' => UserCosmeticResource::collection($request->user()->cosmetics),
        ]);
    }

    public function sync(SyncItemsRequest $request, ImportItemsProcess $process)
    {
        $dto = ImportItemsDto::from($request->validated());
        $dto->user = $request->user();

        $process->run($dto);

        return redirect('/items')->with('success', 'Items have been synced.');
    }

    public function update(UpdateItemRequest $request, UserCosmetic $item, UpdateItem $action)
    {
        $action->handle($item, UpdateItemDto::from($request->validated()));

        return redirect('/items')->with('success', 'Item has been updated.');
    }

    public function delete(DeleteItemRequest $request, UserCosmetic $item, DeleteItem $action)
    {
        $action->handle($item);

        return redirect('/items')->with('success', 'Item has been deleted.');
    }
}
