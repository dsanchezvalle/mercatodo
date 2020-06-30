<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * ClientController constructor.
     */
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
        $clients = User::where('is_admin',false)->paginate(10);

        return response()->view('admin.client.index',compact('clients'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $client
     * @return Response
     */
    public function show(User $client): Response
    {
        return response()->view('admin.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $client
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
     * @param User $client
     * @return RedirectResponse
     */
    public function update(Request $request, User $client): RedirectResponse
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
            'is_active' => $request->is_active ? true : false,
        ]);

        return response()->redirectToRoute('clients.index');
    }

}
