<?php

namespace App\Controllers;

use App\Models\ContentModel;

class ReferensiController extends BaseController
{
    public function index()
    {
        $contentModel = new ContentModel();
        $contents = $contentModel->findAll();

        $groupedContents = [];
        foreach ($contents as $content) {
            if ($content['parent_id'] == 0) {
                $groupedContents['content' . $content['id']] = [];
            }
        }

        foreach ($contents as $content) {
            if ($content['parent_id'] != 0) {
                $groupedContents['content' . $content['parent_id']][] = $content;
            }
        }

        $data = [
            'username' => 'Guest', // atau ambil dari sesi jika ada
            'contents' => $groupedContents
        ];

        return view('referensi/referensi', $data);
    }
}
