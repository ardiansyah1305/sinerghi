<?php

namespace App\Controllers;

use App\Models\ContentModel;
use App\Models\CategoryModel;

class ReferensiController extends BaseController
{
    public function index()
    {
        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();

        $contents = $contentModel->findAll();
        $categories = $categoryModel->findAll();

        $groupedContents = [];
        foreach ($contents as $content) {
            if (!isset($groupedContents[$content['parent_id']])) {
                $groupedContents[$content['parent_id']] = [];
            }
            $groupedContents[$content['parent_id']][] = $content;
        }

        $data = [
            'nip' => $this->userData['nip'],
            'categories' => $categories,
            'groupedContents' => $groupedContents
        ];

        return view('referensi/referensi', $data);
    }
}
