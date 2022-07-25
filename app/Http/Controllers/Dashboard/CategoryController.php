<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\CategoryContract;
use App\Http\Controllers\Controller;
use Exception;
use Flobbos\Crudable\Contracts\Crud;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{

    protected CategoryContract $categories;

    public function __construct(CategoryContract $categories)
    {
        $this->categories = $categories;
    }


    public function index()
    {
        return view('dashboard.categories.index')->with(['categories' => $this->categories->getAllCategories()->get()]);
    }


    public function create()
    {
        return view('dashboard.categories.create');
    }


    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, []);

        try {
            $this->categories->create($request->all());
            return redirect()->route('dashboard.categories.index')->withMessage(trans('crud.record_created'));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage())->withInput();
        }
    }

    public function show(int $id)
    {
        return view('dashboard.categories.show')->with(['category' => $this->categories->find($id)]);
    }

    public function edit(int $id)
    {
        return view('dashboard.categories.edit')->with(
            ['category' => $this->categories->find($id)]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, []);

        try {
            $this->categories->update($id, $request->all());
            return redirect()->route('dashboard.categories.index')->withMessage(trans('crud.record_updated'));
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->categories->delete($id);
            return redirect()->route('dashboard.categories.index')->withMessage(trans('crud.record_deleted'));
        } catch (Exception $ex) {
            return redirect()->route('dashboard.categories.index')->withErrors($ex->getMessage());
        }
    }
}

