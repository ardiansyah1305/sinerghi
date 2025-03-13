<?php

namespace App\Controllers;

use App\Models\ContentModel;
use App\Models\CategoryModel;
use App\Models\RoleModel;

class ReferensiController extends BaseController
{
    public function index()
    {
        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();
        $roleModel = new RoleModel();

        $contents = $contentModel->findAll();
        $categories = $categoryModel->findAll();
        $role = $roleModel->findAll();

        $groupedContents = [];
        foreach ($contents as $content) {
            if (!isset($groupedContents[$content['parent_id']])) {
                $groupedContents[$content['parent_id']] = [];
            }
            $groupedContents[$content['parent_id']][] = $content;
        }

        $data = [
            'categories' => $categories,
            'groupedContents' => $groupedContents,
            'role' => $role
        ];

        return view('referensi/referensi', $data);
    }

    public function viewFile($filename)
    {
        $filePath = WRITEPATH . 'uploads/pdf/' . $filename;
        if (file_exists($filePath)) {
            return $this->response->setHeader('Content-Type', 'application/pdf')
                                  ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
                                  ->setBody(file_get_contents($filePath));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("File $filename not found");
        }
    }

    public function downloadFile($filename)
    {
        $filePath = WRITEPATH . 'uploads/pdf/' . $filename;
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("File $filename not found");
        }
    }
}
