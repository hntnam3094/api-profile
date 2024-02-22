<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Forms\StructionPage\StructionForm;
use App\Http\Requests\StructionRequest;
use App\Http\Services\StructionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StructionPagesController extends Controller
{
    private $structionService;
    private $structionForm;

    public function __construct(
        StructionService $structionService,
        StructionForm $structionForm
        )
    {
        $this->structionService = $structionService;
        $this->structionForm = $structionForm;
    }

    public function index()
    {
        $result = $this->structionService->getStructionPagePaginations();
        return Inertia::render('Office/Struction/StructionPage', [
            'data' => $result,
            'form' => $this->structionForm->getForm(),
            'islist' => 1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_code = $request->get('page_code');
        $code = $request->get('code');
        $structionPageId = $this->structionService->getStructionPageByPageCodeAndCode($page_code, $code);

        $structionForm = $this->structionForm->getForm($page_code, $code);
        return Inertia::render('Office/Struction/FormAdd', [
            'dataForm' => $this->structionService->getStructionValue($structionForm),
            'structionForm' => $structionForm,
            'pageCode' => $page_code,
            'code' => $code,
            'structionPageId' => $structionPageId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StructionRequest $request)
    {
        $pageCode = $request->get('page_code');
        $code = $request->get('code');
        $structionPageId = $this->structionService->getStructionPageByPageCodeAndCode($pageCode, $code);

        $this->structionService->save($request->all());

        return redirect()->to(route('structionpages.detail', ['id' => $structionPageId, 'is_list' => 1, 'page_code' => $pageCode, 'code' => $code]));
    }

    /**
     * Display the specified resource.
     */
    public function show (Request $request, $id)
    {
        $is_list = $request->get('is_list');
        if ($is_list) {
            list($data, $code, $page_code) = $this->structionService->getStructionDetailByStructionPageId($id);

            return Inertia::render('Office/Struction/StructionPage', [
                'data' => $data,
                'islist' => 0,
                'pageCode' => $page_code,
                'code' => $code,
            ]);
        }

        $metaData = $this->structionService->getStructionMetaByStructionDetailId($id);
        list($structionDetailRecord, $code, $page_code) = $this->structionService->getStructionDetailAndCodeAndPageCodeByStructionDetailId($id);

        if (empty($metaData)) {
            abort(404);
        }

        $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetailRecord);
        $structionForm = $this->structionForm->getForm($page_code, $code);

        return Inertia::render('Office/Struction/FormDetail', [
            'dataForm' => $data,
            'structionForm' => $structionForm,
            'id' => $id,
            'structionPageId' => $structionDetailRecord->structionPageId ?? 0
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit (string $id)
    {
        $metaData = $this->structionService->getStructionMetaByStructionDetailId($id);
        list($structionDetailRecord, $code, $page_code) = $this->structionService->getStructionDetailAndCodeAndPageCodeByStructionDetailId($id);
        if (empty($metaData)) {
            abort(404);
        }

        $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetailRecord);
        $structionForm = $this->structionForm->getForm($page_code, $code);

        return Inertia::render('Office/Struction/FormAdd', [
            'dataForm' => $data,
            'structionForm' => $structionForm,
            'id' => $id,
            'structionPageId' => $structionDetailRecord->structionPageId
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StructionRequest $request, string $id)
    {
        $structionPageId = $this->structionService->getStructionPageIdByStructionDetailId($id);

        $this->structionService->save($request->all(), $id);
        return redirect()->to(route('structionpages.detail', ['id' => $structionPageId, 'is_list' => 1]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $structionDetailRecord = $this->structionService->getStructionDetailById($id);
        $structionPageRecord = $this->structionService->getStructionPageById($structionDetailRecord->structionPageId);

        $this->structionService->deleteStructionDetailById($id);
        return redirect()->to(route('structionpages.detail', ['id' => $structionPageRecord->id, 'is_list' => 1]));
    }
}
