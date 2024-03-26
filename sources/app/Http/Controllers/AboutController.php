<?php

namespace App\Http\Controllers;

use App\Http\Services\StructionService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    private $structionService;

    public function __construct(StructionService $structionService)
    {
        $this->structionService = $structionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->structionService->getStructionData('about_us', 'about_us');

        return view('about', [
            'data' => $data
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
