<?php

namespace App\Http\Controllers;

use App\DB\Models\Tab;
use App\Http\Requests\TabRequest;

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

        return vueResponse(data: ['tab' => $tab]);
    }

    public function destroy(Tab $tab)
    {
        $tab->delete();

        return vueResponse('Zakładka została usunięta', 'success');
    }
}
