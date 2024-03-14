<?php

namespace App\Http\Controllers\Office;

use App\Constants\FormConstant;
use App\Http\Controllers\Controller;
use App\Http\Forms\StructionPage\StructionForm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SampleFormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:system-admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $structionForm = new StructionForm();
        $form = $structionForm->getForm(FormConstant::SAMPLE);
        return Inertia::render('Office/Sample/SamplePage', [
            'form' => $form
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
