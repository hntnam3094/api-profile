<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Forms\DymanicForm\UserForm;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    private $userService;

    public function __construct (UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware(['role:system-admin|admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->userService->getData($request->all());
        return Inertia::render('Office/User/UserList', [
            'data' => $data,
            'form' => $this->userService->getForm(),
            'params' => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        list($data, $form) = $this->userService->showData($id);
        return Inertia::render('Office/User/UserDetail', [
            'dataForm' => $data,
            'form' => $form,
            'id' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        list($data, $form) = $this->userService->showData($id);
        return Inertia::render('Office/User/UserAdd', [
            'dataForm' => $data,
            'form' => $form,
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->userService->updateUser($id, $request->all());
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
