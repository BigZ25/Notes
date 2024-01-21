<?php

namespace App\Http\Controllers;

use App\DB\Models\Tab;
use App\Http\Requests\TabRequest;
use Illuminate\Http\Request;

class TabController extends Controller
{
    public function index()
    {
        $tabs = auth()->user()->tabs()->get()->toArray();

        return vueResponse(data: ['tabs' => $tabs]);
    }

    public function store(TabRequest $request)
    {
        $tab = Tab::create($request->validated() + ['user_id' => auth()->user()->id]);

        return vueResponse(data: ['tab' => $tab]);
    }

    public function update(TabRequest $request, Tab $tab)
    {
        $tab->update($request->validated());

//        return successMessage("Zmiany zostały zapisane", ['id' => $tab->id]);
    }

    public function destroy(Request $request)
    {
        foreach ($request->ids as $id) {
            Tab::find($id)->delete();
        }

        return successMessage(count($request->ids) > 1 ? "Ogłoszenia zostały usunięte" : "Ogłoszenie zostało usunięte");
    }
}
