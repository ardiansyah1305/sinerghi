<?php
namespace App\Controllers\Admin;

use App\Models\ContentModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class ReferensiController extends Controller
{
    public function index()
    {
        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();
        $contents = $contentModel->findAll();
        $categories = $categoryModel->findAll();
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category['id']] = $category['judul'];
        }

        $data = [
            'contents' => $contents,
            'categories' => $categoryMap
        ];

        return view('admin/referensi/referensi', $data);
    }

    // CRUD Content

    public function create()
{
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        return view('admin/referensi/create', $data);
    }


    public function store()
    {
        $contentModel = new ContentModel();
        $file = $this->request->getFile('file_upload');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/pdf', $newName);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'unit_terkait' => $this->request->getPost('unit_terkait'),
            'tanggal' => $this->request->getPost('tanggal'),
            'file_upload' => $newName,
            'parent_id' => $this->request->getPost('parent_id')
        ];
        $contentModel->save($data);
        return redirect()->to('/admin/referensi');
    }

    public function edit($id)
    {
        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();
        $data['content'] = $contentModel->find($id);
        $data['categories'] = $categoryModel->findAll();
        return view('admin/referensi/edit', $data);
    }

    public function update($id)
    {
        $contentModel = new ContentModel();
        $file = $this->request->getFile('file_upload');
        $newName = $this->request->getPost('existing_file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/pdf', $newName);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'unit_terkait' => $this->request->getPost('unit_terkait'),
            'tanggal' => $this->request->getPost('tanggal'),
            'file_upload' => $newName,
            'parent_id' => $this->request->getPost('parent_id')
        ];
        $contentModel->update($id, $data);
        return redirect()->to('/admin/referensi');
    }

    public function delete($id)
    {
        $contentModel = new ContentModel();
        $contentModel->delete($id);
        return redirect()->to('/admin/referensi');
    }

    // CRUD Category
    public function storeCategory()
    {
        $categoryModel = new CategoryModel();
        $data = [
            'judul' => $this->request->getPost('judul')
        ];
        $categoryModel->save($data);
        return redirect()->to('/admin/referensi');
    }

    public function editCategory($id)
    {
        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->find($id);
        return view('admin/referensi/edit_category', $data);
    }

    public function updateCategory($id)
    {
        $categoryModel = new CategoryModel();
        $data = [
            'judul' => $this->request->getPost('judul')
        ];
        $categoryModel->update($id, $data);
        return redirect()->to('/admin/referensi');
    }

    public function deleteCategory($id)
    {
        $categoryModel = new CategoryModel();
        $categoryModel->delete($id);
        return redirect()->to('/admin/referensi');
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
}
