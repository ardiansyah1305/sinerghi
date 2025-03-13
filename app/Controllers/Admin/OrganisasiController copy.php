<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class OrganisasiController extends BaseController
{
    public function index()
    {
        return view('admin/organisasi/index');
    }

    public function create()
    {
        return view('admin/organisasi/create');
    }

    public function store()
    {
        // Handle store logic
    }

    public function edit($id)
    {
        // Fetch data for edit
        return view('admin/organisasi/edit');
    }

    public function update($id)
    {
        // Handle update logic
    }

    public function delete($id)
    {
        // Handle delete logic
    }
}
