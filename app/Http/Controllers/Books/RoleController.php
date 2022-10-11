<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRole;
use App\Models\Books\Role;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\ExceptionSQL;

class RoleController extends Controller
{
    use ExceptionSQL;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $listRole = Role::all();
        return view('books.role.index', compact('listRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.role.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRole $request
     * @return RedirectResponse
     */
    public function store(StoreRole $request): RedirectResponse
    {
        try {
            Role::on()->updateOrCreate(['id' => $request->id], [
                'descr' => $request->descr,
            ]);

            return redirect()->route('role.index');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return View
     */
    public function edit(Role $role): View
    {
        return view('books.role.show', compact('role'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $role->delete();
        } catch (Exception $e) {
            return back()
                ->withErrors( $this->getMessageFilterSQLError($e) );
        }
        return redirect()->route('role.index');
    }
}
