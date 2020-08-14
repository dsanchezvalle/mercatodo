<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ClientRequest;

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
        $clients = User::where('is_admin', false)->paginate(10);

        return response()->view('admin.client.index', compact('clients'));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $client
     * @return Response
     */
    public function show(User $client): Response
    {
        Log::info('Showing user profile for user: '.$client->id);
        return response()->view('admin.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $client
     * @return Response
     */
    public function edit(User $client): Response
    {
        return response()->view('admin.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientRequest $request
     * @param  User          $client
     * @return RedirectResponse
     */
    public function update(ClientRequest $request, User $client): RedirectResponse
    {
        $client->update(
            [
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'document_type' => $request->input('document_type'),
            'document_number' => $request->input('document_number'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'is_active' => $request->input('is_active') ? true : false,
            ]
        );

        return response()->redirectToRoute('clients.index');
    }
}
