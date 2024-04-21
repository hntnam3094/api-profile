<?php
namespace App\Facades;

use App\Constants\CommonConstant;
use App\Constants\PostTypeConstant;
use App\Http\Forms\PostType\PostTypeForm;
use App\Http\Repositories\PostType\PostMetaRepository;
use App\Http\Repositories\PostType\PostTypeRepository;
use App\Http\Services\PostTypeService;
use Illuminate\Support\Facades\Storage;

class PostType
{
    private $postTypeService;

    public function __construct()
    {
        $this->postTypeService = app()->make(PostTypeService::class);
    }

    public function getAll ($posttype) {
        return $this->postTypeService->getDataByPostType($posttype);
    }
}
