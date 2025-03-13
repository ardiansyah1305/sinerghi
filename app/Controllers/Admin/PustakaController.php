<?php
namespace App\Controllers\Admin;

use App\Models\ContentModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class PustakaController extends Controller
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

        return view('admin/pustaka/index', $data);
    }

    // CRUD Content

    public function create()
{
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
$contentModel = new ContentModel();
        $data['contents'] = $contentModel ->findAll();
        return view('admin/pustaka/create', $data);
    }


    public function store()
{
    $contentModel = new ContentModel();
    $file = $this->request->getFile('file_upload');
    $newName = '';

    // Validasi input
    if (empty($this->request->getPost('judul')) || empty($this->request->getPost('deskripsi'))) {
        session()->setFlashdata('error_pustaka', 'Judul dan deskripsi tidak boleh kosong.');
        return redirect()->back()->withInput();
    }

    // Validasi file upload
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/pdf', $newName);
    } else {
        session()->setFlashdata('error_pustaka', 'File yang diunggah tidak valid.');
        return redirect()->back()->withInput();
    }

    $data = [
        'judul' => $this->request->getPost('judul'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'unit_terkait' => $this->request->getPost('unit_terkait'),
        'tanggal' => $this->request->getPost('tanggal'),
        'file_upload' => $newName,
        'parent_id' => $this->request->getPost('parent_id')
    ];

    try {
        $contentModel->save($data);
        session()->setFlashdata('success_pustaka', 'Konten berhasil ditambahkan.');
    } catch (\Exception $e) {
        session()->setFlashdata('error_pustaka', 'Terjadi kesalahan saat menambahkan konten: ' . $e->getMessage());
    }

    return redirect()->to('/admin/pustaka');
}

    public function edit($id)
    {
        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();
        $data['content'] = $contentModel->find($id);
        $data['categories'] = $categoryModel->findAll();
        return view('admin/pustaka/edit', $data);
    }

    public function update($id)
{
    $contentModel = new ContentModel();
    $file = $this->request->getFile('file_upload');
    $newName = $this->request->getPost('existing_file');

    // Validasi input
    if (empty($this->request->getPost('judul')) || empty($this->request->getPost('deskripsi'))) {
        session()->setFlashdata('error_pustaka', 'Judul dan deskripsi tidak boleh kosong.');
        return redirect()->back()->withInput();
    }

    // Validasi file upload
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

    try {
        $contentModel->update($id, $data);
        session()->setFlashdata('success_pustaka', 'Konten berhasil diperbarui.');
    } catch (\Exception $e) {
        session()->setFlashdata('error_pustaka', 'Konten gagal diperbarui.' . $e->getMessage());
    }

    return redirect()->to('/admin/pustaka');
}

    public function delete($id)
    {
        $contentModel = new ContentModel();
        $contentModel->delete($id);
        return redirect()->to('/admin/pustaka');
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
