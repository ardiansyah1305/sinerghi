<?php

namespace App\Controllers\Admin;

use App\Models\ContentModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;
use App\Models\PegawaiModel;
use App\Models\JabatanModel;
use App\Models\UnitKerjaModel; // Pastikan model unit kerja digunakan
use App\Models\StatuspegawaiModel;
use App\Models\StatuspernikahanModel;
use App\Models\JenjangpangkatModel;
use App\Models\AgamaModel;
use App\Models\RoleModel;

class ReferensiController extends Controller
{
    protected $pegawaiModel;
    protected $jabatanModel;
    protected $unitKerjaModel;
    protected $statuspegawaiModel;
    protected $statuspernikahanModel;
    protected $jenjangpangkatModel;
    protected $agamaModel;
    protected $roleModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->jabatanModel = new JabatanModel();
        $this->statuspegawaiModel = new StatuspegawaiModel();
        $this->statuspernikahanModel = new StatuspernikahanModel();
        $this->jenjangpangkatModel = new JenjangpangkatModel();
        $this->agamaModel = new AgamaModel();
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->roleModel =  new RoleModel();
    }

    public function index()
    {
        $contentModel = new ContentModel();
        $categoryModel = new CategoryModel();
        $PegawaiModel = new PegawaiModel();
        $statuspegawaiModel = new StatuspegawaiModel();
        $statuspernikahanModel = new StatuspernikahanModel();
        $jenjangpangkatModel = new JenjangpangkatModel();
        $agamaModel = new AgamaModel();
        $roleModel = new RoleModel();
        $contents = $contentModel->findAll();
        $categories = $categoryModel->findAll();
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category['id']] = $category['judul'];
        }

        $data = [
            'contents' => $contents,
            'categories' => $categoryMap,
            'role' => $roleModel->findAll()
        ];

        $data['pegawai'] = $PegawaiModel->findAll();
        $data['statuspegawai'] = $statuspegawaiModel->findAll();
        $data['statuspernikahan'] = $statuspernikahanModel->findAll();
        $data['jenjangpangkat'] = $jenjangpangkatModel->findAll();
        $data['agama'] = $agamaModel->findAll();

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

        try {
            // Proses upload file
            $file = $this->request->getFile('file_upload');
            $newName = null;

            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/pdf', $newName);
            }

            // Data untuk disimpan
            $data = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'unit_terkait' => $this->request->getPost('unit_terkait'),
                'tanggal' => $this->request->getPost('tanggal'),
                'file_upload' => $newName,
                'parent_id' => $this->request->getPost('parent_id'),
            ];

            // Simpan data ke database
            $contentModel->save($data);

            // Flashdata untuk pesan sukses
            session()->setFlashdata('success_pustaka', 'Konten berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Flashdata untuk pesan error
            session()->setFlashdata('error_pustaka', 'Terjadi kesalahan saat menambahkan konten.');
        }

        return redirect()->to('/admin/pustaka');
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
        $newName = $this->request->getPost('existing_file'); // Nama file lama jika tidak ada upload baru

        try {
            // Proses upload file jika ada file baru yang diunggah
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

            // Proses update data
            if ($contentModel->update($id, $data)) {
                // Set flashdata success
                session()->setFlashdata('success_pustaka', 'Data konten berhasil diperbarui.');
            } else {
                // Set flashdata error jika gagal
                session()->setFlashdata('error_pustaka', 'Gagal memperbarui data konten.');
            }
        } catch (\Exception $e) {
            // Set flashdata error jika terjadi exception
            session()->setFlashdata('error_pustaka', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // Redirect kembali ke halaman pustaka
        return redirect()->to('/admin/pustaka');
    }

    public function delete($id)
    {
        $contentModel = new ContentModel();
        $contentModel->delete($id);
        return redirect()->to('/admin/pustaka');
    }

    // CRUD Category
    public function storeCategory()
    {
        $categoryModel = new CategoryModel();
        $data = [
            'judul' => $this->request->getPost('judul')
        ];

        // Validasi: pastikan judul tidak kosong
        if (empty($judul)) {
            session()->setFlashdata('error_kategori', 'Judul kategori tidak boleh kosong.');
            return redirect()->to('/admin/referensi')->withInput(); // Mengembalikan data input sebelumnya
        }

        $data = [
            'judul' => $judul
        ];

        try {
            // Simpan data ke database
            $categoryModel->save($data);

            // Flashdata untuk pesan sukses
            session()->setFlashdata('success_kategori', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Flashdata untuk pesan error
            session()->setFlashdata('error_kategori', 'Terjadi kesalahan saat menambahkan kategori.');
        }

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

        // Validasi: pastikan judul tidak kosong
        if (empty($judul)) {
            session()->setFlashdata('error_kategori', 'Judul kategori tidak boleh kosong.');
            return redirect()->to('/admin/referensi')->withInput(); // Mengembalikan data input sebelumnya
        }

        $data = [
            'judul' => $judul
        ];

        try {
            // Update data kategori
            if ($categoryModel->update($id, $data)) {
                // Set flashdata success
                session()->setFlashdata('success_kategori', 'Kategori berhasil diperbarui.');
            } else {
                // Set flashdata error jika gagal
                session()->setFlashdata('error_kategori', 'Gagal memperbarui kategori.');
            }
        } catch (\Exception $e) {
            // Set flashdata error jika terjadi exception
            session()->setFlashdata('error_kategori', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // Redirect kembali ke halaman referensi
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

    public function store_role()
    {
        $roleModel = new RoleModel();

        

        // Ambil data input
        $nama_role = $this->request->getPost('nama_role');
        

        

        // Validasi input
    	if (empty($nama_role)) {
        	session()->setFlashdata('error_role', 'Nama Role.');
        	return redirect()->back()->withInput();
    	}

    try {
        // Data untuk disimpan
        $data = [
            'nama_role' => $nama_role
        ];

        // Simpan data ke database
        $roleModel->save($data);

        // Flashdata untuk pesan sukses
        session()->setFlashdata('success_role', 'Role berhasil ditambahkan.');
    } catch (\Exception $e) {
        // Flashdata untuk pesan error
        session()->setFlashdata('error_agama', 'Terjadi kesalahan saat menambahkan Agama.');
    }
        return redirect()->to('/admin/referensi/referensi');
    }

    public function edit_role($id)
    {
        $roleModel = new RoleModel();
        $data['role'] = $roleModel->find($id);
        return view('admin/role/edit', $data);
    }

    public function update_role($id)
    {
        $roleModel = new RoleModel();
        
        $nama_role = $this->request->getPost('nama_role');
        
        if (empty($nama_role)) {
            session()->setFlashdata('error_kategori', 'Judul kategori tidak boleh kosong.');
            return redirect()->to('/admin/referensi')->withInput(); // Mengembalikan data input sebelumnya
        }

        $data = [
            'nama_role' => $nama_role
        ];

        try {
            // Update data kategori
            if ($roleModel->update($id, $data)) {
                // Set flashdata success
                session()->setFlashdata('success_role', 'Role berhasil diperbarui.');
            } else {
                // Set flashdata error jika gagal
                session()->setFlashdata('error_role', 'Gagal memperbarui Role.');
            }
        } catch (\Exception $e) {
            // Set flashdata error jika terjadi exception
            session()->setFlashdata('error_role', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // Redirect kembali ke halaman referensi
        return redirect()->to('/admin/referensi');
    }

    public function delete_role($id)
    {
        $roleModel = new RoleModel();
        $roleModel->delete($id);
        return redirect()->to('/admin/referensi');
    }
}
