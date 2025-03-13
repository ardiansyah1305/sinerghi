<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrganisasiModel;
use App\Models\kdJabatanModel;

class OrganisasiController extends BaseController
{
    protected $organisasiModel;
    protected $kdJabatanModel;

    public function __construct()
    {
        $this->organisasiModel = new OrganisasiModel();
        $this->kdJabatanModel = new kdJabatanModel();
    }

    public function index()
    {

        $data = [
            // 'organisasi' => $this->organisasiModel->select('users.*, kd_jabatan.nmjabatan')
            //     ->join('kd_jabatan', 'kd_jabatan.id = users.id', 'left')
            //     ->findAll(),
            // 'kdjabatan' => $this->kdJabatanModel->findAll()
            'organisasi' => $this->organisasiModel->select('layanan.*, layanan_kategori.name as kategori_name')
                ->join('layanan_kategori', 'layanan.kategori_id = layanan_kategori.id')
                ->findAll(),
            'kategori' => $this->kategoriModel->findAll()
        ];


        return view('admin/organisasi/index', $data);
    }

    // public function create()
    // {
    //     $data['kategori'] = $this->kategoriModel->findAll();
    //     return view('admin/layanan/create', $data);
    // }

    // public function store()
    // {
    //     $links = [];
    //     $names = $this->request->getPost('link_names');
    //     $urls = $this->request->getPost('link_urls');

    //     if ($names && $urls) {
    //         foreach ($names as $key => $name) {
    //             $links[] = ['name' => $name, 'url' => $urls[$key]];
    //         }
    //     }

    //     $this->layananModel->save([
    //         'kategori_id' => $this->request->getPost('kategori_id'),
    //         'title' => $this->request->getPost('title'),
    //         'links' => json_encode($links),
    //         'color' => $this->request->getPost('color'),
    //         'icon' => $this->request->getPost('icon')
    //     ]);

    //     return redirect()->to('/admin/layanan');
    // }

    // public function edit($id)
    // {
    //     $data = [
    //         'layanan' => $this->layananModel->find($id),
    //         'kategori' => $this->kategoriModel->findAll()
    //     ];

    //     return view('admin/layanan/edit', $data);
    // }

    // public function update($id)
    // {
    //     $links = [];
    //     $names = $this->request->getPost('link_names');
    //     $urls = $this->request->getPost('link_urls');

    //     if ($names && $urls) {
    //         foreach ($names as $key => $name) {
    //             $links[] = ['name' => $name, 'url' => $urls[$key]];
    //         }
    //     }

    //     $this->layananModel->update($id, [
    //         'kategori_id' => $this->request->getPost('kategori_id'),
    //         'title' => $this->request->getPost('title'),
    //         'links' => json_encode($links),
    //         'color' => $this->request->getPost('color'),
    //         'icon' => $this->request->getPost('icon')
    //     ]);

    //     return redirect()->to('/admin/layanan');
    // }

    // public function delete($id)
    // {
    //     $this->layananModel->delete($id);
    //     return redirect()->to('/admin/layanan');
    // }

    // public function createKategori()
    // {
    //     return view('admin/layanan/createKategori');
    // }

    // public function storeKategori()
    // {
    //     $this->kategoriModel->save([
    //         'name' => $this->request->getPost('name')
    //     ]);

    //     return redirect()->to('/admin/layanan/kategori');
    // }

    // public function editKategori($id)
    // {
    //     $data['kategori'] = $this->kategoriModel->find($id);
    //     return view('admin/layanan/editKategori', $data);
    // }

    // public function updateKategori($id)
    // {
    //     $this->kategoriModel->update($id, [
    //         'name' => $this->request->getPost('name')
    //     ]);

    //     return redirect()->to('/admin/layanan/kategori');
    // }

    // public function deleteKategori($id)
    // {
    //     $this->kategoriModel->delete($id);
    //     return redirect()->to('/admin/layanan/kategori');
    // }
}
