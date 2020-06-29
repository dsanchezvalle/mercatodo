<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $clients = User::where('is_admin',false)->get();

        return response()->view('admin.client.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $client): Response
    {
        return response()->view('admin.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     */
    public function update(Request $request, User $client)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'document_type' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($client)],
            'phone_number' => ['required', 'string', 'max:255'],
        ]);

        $client->update([
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'document_type' => $validatedData['document_type'],
            'document_number' => $validatedData['document_number'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        return response()->redirectToRoute('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $client)
    {
        //
    }
}
