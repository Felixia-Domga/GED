<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //lister tous les utilisateurs
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * affiche le formulaire de création
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create($validated);

        return redirect()->route('users.index');
    }

    /**
     * affiche un utilisateur
     */
    public function show(User $user)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * affiche le formulaire d'édition
     */
    public function edit(User $user)
    {
       return view('users.edit', compact('user'));
    }

    /**
     * met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('users.index');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
