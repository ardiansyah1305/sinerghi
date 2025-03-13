<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LayananModel;
use App\Models\LayananKategoriModel;

class LayananController extends BaseController
{
    protected $layananModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
        $this->kategoriModel = new LayananKategoriModel();
    } 

    public function index()
    {
        $data = [
            'layanan' => $this->layananModel->select('layanan.*, layanan_kategori.name as kategori_name')
                ->join('layanan_kategori', 'layanan.kategori_id = layanan_kategori.id')
                ->findAll(),
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('admin/layanan/index', $data);
    }

    public function create()
    {
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('admin/layanan/create', $data);
    }

    public function store()
{
    $links = [];
    $names = $this->request->getPost('link_names');
    $urls = $this->request->getPost('link_urls');

    // Validasi manual
    $errors = [];
    if (empty($this->request->getPost('title'))) {
        $errors[] = 'Judul harus diisi.';
    }

    if ($names && $urls) {
        foreach ($urls as $key => $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $errors[] = "Link URL tidak valid.";
            }
        }
    }

    // Jika ada kesalahan validasi
    if (!empty($errors)) {
        session()->setFlashdata('error_layanan', implode('<br>', $errors));
        return redirect()->back()->withInput();
    }

    // Proses pengolahan links
    if ($names && $urls) {
        foreach ($names as $key => $name) {
            if (!empty($name) && !empty($urls[$key])) {
                $links[] = ['name' => $name, 'url' => $urls[$key]];
            }
        }
    }

    $data = [
        'kategori_id' => $this->request->getPost('kategori_id'),
        'title' => $this->request->getPost('title'),
        'links' => json_encode($links),
        'color' => $this->request->getPost('color'),
        'icon' => $this->request->getPost('icon')
    ];

    try {
        if ($this->layananModel->save($data)) {
            session()->setFlashdata('success_layanan', 'Data berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error_layanan', 'Terjadi kesalahan saat menambahkan data.');
        }
    } catch (\Exception $e) {
        session()->setFlashdata('error_layanan', 'Terjadi kesalahan: ' . $e->getMessage());
    }

    return redirect()->to('/admin/layanan');
}
    public function edit($id)
    {
        $data = [
            'layanan' => $this->layananModel->find($id),
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('admin/layanan/edit', $data);
    }

    public function update($id)
{
    $links = [];
    $names = $this->request->getPost('link_names');
    $urls = $this->request->getPost('link_urls');

    // Validasi manual
    $errors = [];
    if (empty($this->request->getPost('title'))) {
        $errors[] = 'Judul harus diisi.';
    }

    if ($names && $urls) {
        foreach ($urls as $key => $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $errors[] = "Link URL pada baris " . ($key + 1) . " tidak valid.";
            }
        }
    }

    // Jika ada kesalahan validasi
    if (!empty($errors)) {
        session()->setFlashdata('error_layanan', implode('<br>', $errors));
        return redirect()->back()->withInput();
    }

    // Proses pengolahan links
    if ($names && $urls) {
        foreach ($names as $key => $name) {
            if (!empty($name) && !empty($urls[$key])) {
                $links[] = ['name' => $name, 'url' => $urls[$key]];
            }
        }
    }

    $data = [
        'kategori_id' => $this->request->getPost('kategori_id'),
        'title' => $this->request->getPost('title'),
        'links' => json_encode($links),
        'color' => $this->request->getPost('color'),
        'icon' => $this->request->getPost('icon')
    ];

    try {
        if ($this->layananModel->update($id, $data)) {
            session()->setFlashdata('success_layanan', 'Data berhasil diperbarui.');
        } else {
            session()->setFlashdata('error_layanan', 'Terjadi kesalahan saat memperbarui data.');
        }
    } catch (\Exception $e) {
        session()->setFlashdata('error_layanan', 'Terjadi kesalahan: ' . $e->getMessage());
    }

    return redirect()->to('/admin/layanan');
}
    public function delete($id)
    {
        $this->layananModel->delete($id);
        return redirect()->to('/admin/layanan');
    }

    public function createKategori()
    {
        return view('admin/layanan/createKategori');
    }

    public function storeKategori()
    {
        $this->kategoriModel->save([
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to('/admin/layanan/kategori');
    }

    public function editKategori($id)
    {
        $data['kategori'] = $this->kategoriModel->find($id);
        return view('admin/layanan/editKategori', $data);
    }

    public function updateKategori($id)
    {
        $this->kategoriModel->update($id, [
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to('/admin/layanan/kategori');
    }

    public function deleteKategori($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('/admin/layanan/kategori');
    }
}
