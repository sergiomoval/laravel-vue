<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Users\DestroyUserRequest;
use App\Http\Requests\Administration\Users\StoreInviteUserRequest;
use App\Http\Requests\Administration\Users\StorePostRequest;
use App\Http\Requests\Administration\Users\UpdateUserRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Invite;
use App\Notifications\Administration\Users\InviteNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Lang;

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
    public function store(StorePostRequest $request)
    {
        $user = User::create($request->all());
        $user->assignRole($request['rol']);

        return redirect()->route('administration.users.index')->with('success', Lang::get('User created successfully'));
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
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return redirect()->route('administration.users.index')->with('error', Lang::get('User specified was not found'));
        }
        $roles = Role::all();
        return Inertia::render('administration/users/Edit', ['user' => $user->load('roles'), 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        $user->syncRoles(array($request['rol']));
        return redirect()->route('administration.users.index')->with('success', Lang::get('User modified successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyUserRequest $request, string $id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            if ($request['_type'] == 'DELETE') {
                $user->delete();
            } else if ($request['_type'] == 'RESTORE') {
                $user->restore();
            }
            return redirect()->route('administration.users.index')->with('success', Lang::get('User modified successfully'));
        } else {
            return redirect()->route('administration.users.index')->with('error', Lang::get('User specified was not found'));
        }
    }

    public function invite(StoreInviteUserRequest $request)
    {
        do 
        {
            $token = Str::random(20);
        } 
        while (Invite::where('token', $token)->first());
        
        Invite::create([
            'token' => $token,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'locale' => $request->input('locale')
        ]);
        $url = URL::temporarySignedRoute('registration', now()->addMinutes(300), ['token' => $token]);

        //Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url));
        Notification::route('mail', $request->input('email'))->notify((new InviteNotification($url))->locale($request->input('locale')));

        return redirect()->route('administration.users.index')->with('success', Lang::get('Invitation sent by email'));
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

        $query->withTrashed();
        $query->with('roles:name');

        $pageSize = $request->input('pageSize', 10);
        $data = $query->paginate($pageSize);

        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
        ]);

    }
}
