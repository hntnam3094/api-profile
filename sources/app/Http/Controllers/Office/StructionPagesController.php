<?php

namespace App\Http\Controllers\Office;

use App\Constants\FormConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\StructionRequest;
use App\Http\Services\StructionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StructionPagesController extends Controller
{
    private $structionService;

    public function __construct(
        StructionService $structionService
        )
    {
        $this->structionService = $structionService;
    }

    public function index()
    {
        $result = $this->structionService->getStructionPagePaginations();

        return Inertia::render('Office/Struction/StructionPage', [
            'data' => $result,
            'form' => FormConstant::getForm(),
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

        $structionForm = FormConstant::getForm($page_code, $code);
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
    public function show ($id, $is_list, $page_code, $code)
    {
        if ($is_list) {
            $data = $this->structionService->getStructionDetailByStructionPageId($id);

            return Inertia::render('Office/Struction/StructionPage', [
                'data' => $data,
                'islist' => 0,
                'pageCode' => $page_code,
                'code' => $code
            ]);
        }

        $metaData = $this->structionService->getStructionMetaByStructionDetailId($id);
        $structionDetailRecord = $this->structionService->getStructionDetailById($id);

        if (empty($metaData)) {
            abort(404);
        }

        $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetailRecord);
        $structionForm = FormConstant::getForm($page_code, $code);

        return Inertia::render('Office/Struction/FormDetail', [
            'dataForm' => $data,
            'structionForm' => $structionForm,
            'pageCode' => $page_code,
            'code' => $code,
            'id' => $id,
            'structionPageId' => $structionDetailRecord->structionPageId ?? 0
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit (string $id, $page_code, $code)
    {
        $metaData = $this->structionService->getStructionMetaByStructionDetailId($id);
        $structionDetailRecord = $this->structionService->getStructionDetailById($id);
        if (empty($metaData)) {
            abort(404);
        }

        $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetailRecord);
        $structionForm = FormConstant::getForm($page_code, $code);

        return Inertia::render('Office/Struction/FormAdd', [
            'dataForm' => $data,
            'structionForm' => $structionForm,
            'id' => $id,
            'pageCode' => $page_code,
            'code' => $code,
            'structionPageId' => $structionDetailRecord->structionPageId
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StructionRequest $request, string $id)
    {
        $pageCode = $request->get('page_code');
        $code = $request->get('code');
        $structionPageId = $this->structionService->getStructionPageByPageCodeAndCode($pageCode, $code);

        $this->structionService->save($request->all(), $id);
        return redirect()->to(route('structionpages.detail', ['id' => $structionPageId, 'is_list' => 1, 'page_code' => $pageCode, 'code' => $code]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $structionDetailRecord = $this->structionService->getStructionDetailById($id);
        $structionPageRecord = $this->structionService->getStructionPageById($structionDetailRecord->structionPageId);

        $this->structionService->deleteStructionDetailById($id);
        return redirect()->to(route('structionpages.detail', ['id' => $structionPageRecord->id, 'is_list' => 1, 'page_code' => $structionPageRecord->pageCode, 'code' => $structionPageRecord->code]));
    }
}
