<?php

namespace App\Http\Controllers\Items;

use App\Actions\Items\DeleteItem;
use App\Actions\Items\UpdateItem;
use App\Data\Items\ImportItemsDto;
use App\Data\Items\UpdateItemDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Items\DeleteItemRequest;
use App\Http\Requests\Items\SyncItemsRequest;
use App\Http\Requests\Items\UpdateItemRequest;
use App\Http\Resources\Items\UserItemResource;
use App\Models\Items\UserItem;
use App\Processes\Items\ImportItemsProcess;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserItemController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Items/UserItems', [
            'items' => UserItemResource::collection($request->user()->items),
        ]);
    }

    public function sync(SyncItemsRequest $request, ImportItemsProcess $process)
    {
        $dto = ImportItemsDto::from($request->validated());
        $dto->user = $request->user();

        $process->run($dto);

        return redirect('/items')->with('success', 'Items have been synced.');
    }

    public function update(UpdateItemRequest $request, UserItem $item, UpdateItem $action)
    {
        $action->handle($item, UpdateItemDto::from($request->validated()));

        return redirect('/items')->with('success', 'Item has been updated.');
    }

    public function delete(DeleteItemRequest $request, UserItem $item, DeleteItem $action)
    {
        $action->handle($item);

        return redirect('/items')->with('success', 'Item has been deleted.');
    }
}
