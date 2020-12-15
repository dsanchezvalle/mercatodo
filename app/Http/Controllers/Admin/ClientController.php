<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
     * Display a listing of Clients.
     *
     * @return Response
     */
    public function index(): Response
    {
        $clients = User::query()
            ->addSelect([
                'role_name' => Role::select('name')
                ->whereColumn('users.role_id', 'id')
                ->limit(1)
            ])
            ->paginate(10);

        return response()->view('admin.client.index', compact('clients'));
    }

    /**
     * Display the specified Client.
     *
     * @param  User $client
     * @return Response
     */
    public function show(User $client): Response
    {
        Log::info('Showing user profile for user: ' . $client->id);
        return response()->view('admin.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified Client.
     *
     * @param  User $client
     * @return Response
     */
    public function edit(User $client): Response
    {
        $roles = Role::all();
        return response()->view('admin.client.edit', compact('client', 'roles'));
    }

    /**
     * Update the specified Client in storage.
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
            'role_id' => $request->input('role_id'),
            'is_active' => $request->input('is_active') ? true : false,
            ]
        );
        return response()->redirectToRoute('clients.index');
    }
}
