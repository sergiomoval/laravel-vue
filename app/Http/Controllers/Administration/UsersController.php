<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('administration/users/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return Inertia::render('administration/users/Create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function dataTable(Request $request){

        $query = User::query();

        if ($request->has('filters')) {
            foreach ($request->filters as $filter) {
                $query->where($filter['id'], 'like', '%' . $filter['value'] . '%');
            }
        }
        if ($request->has('sorting')) {
            foreach ($request->sorting as $sort) {
                $query->orderBy($sort['id'], $sort['desc'] ? 'desc' : 'asc');
            }
        }

        $query->with('roles:name');

        $pageSize = $request->input('pageSize', 10);
        $data = $query->paginate($pageSize);

        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
        ]);

    }
}
