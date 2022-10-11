<?php

namespace App\Http\Controllers;

use App\Models\Books\Role;
use App\Models\User;
use App\Http\Requests\StoreUser;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\ExceptionSQL;

class UserController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the user
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $listUser = User::all();
        return view('user.index', compact('listUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $listRole = Role::all();
        return view('user.show', compact('listRole'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser $request
     * @return RedirectResponse
     */
    public function store(StoreUser $request): RedirectResponse
    {
        try {
            User::on()->updateOrCreate(['id' => $request->id], [
                'surname' => $request->surname,
                'name' => $request->name,
                'patronymic' => $request->patronymic,
                'birthday' => $request->birthday,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'work' => $request->work,
                'role_id' => $request->role_id,
            ]);

            return redirect()->route('user.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $listRole = Role::all();
        return view('user.show', compact('user', 'listRole'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
        return redirect()->route('user.index');
    }
}
