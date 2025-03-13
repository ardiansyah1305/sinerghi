<?php

namespace App\Controllers\Admin;

use App\Models\PopupBerandaModel;
use CodeIgniter\Controller;

class PopupController extends Controller
{   
    protected $popupModel;

    public function __construct()
    {
        $this->popupModel = new PopupBerandaModel();
        
    }

    public function index()
{
    
    $popupModel = new PopupBerandaModel();
    
    
    // $search = $this->request->getGet('search');
    // $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

    // if ($search) {
    //     $calender = $calenderModel->like('title', $search)->paginate(20, 'default');
    // } else {
    //     $calender = $calenderModel->paginate(20, 'default');
    // }

    // $data = [
        
    //     'pager' => $calenderModel->pager,
    //     'currentPage' => $currentPage,
    //     'search' => $search,
    // ];

    
    $data['popups'] = $popupModel->findAll();

    return view('admin/popup/index', $data);
}

    public function create()
    {

        return view('admin/popup/create', $data);

    }

    
        // $calenderModel->save($data);
    public function store()
{
    $popupModel = new PopupBerandaModel();
    $file = $this->request->getFile('image');

    // Validasi file
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $extension = $file->getExtension();

        // Periksa apakah ekstensi file sesuai
        if (!in_array($extension, $allowedExtensions)) {
            session()->setFlashdata('error_popup', 'Hanya file dengan format jpg, jpeg, atau png yang diperbolehkan.');
            return redirect()->back();
        }

        try {
            // Generate nama file baru secara acak dan pindahkan file
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName);

            // Simpan data ke database
            $data = [
                'image' => $newName,
            ];
            $popupModel->save($data);
            session()->setFlashdata('success_popup', 'Popup berhasil ditambahkan.');
        } catch (\Exception $e) {
            session()->setFlashdata('error_popup', 'Popup gagal ditambahkan: ' . $e->getMessage());
        }
    } else {
        // Pesan jika file tidak valid atau tidak dipilih
        session()->setFlashdata('error_popup', 'Tidak ada gambar yang dipilih atau file tidak valid.');
    }

    return redirect()->to('/admin/beranda/');
}
        

    public function edit($id)
    {
        // $calenderModel = new CalenderModel();

        $popupModel = new PopupBerandaModel();
            $data['popup'] = $popupModel->find($id);

            if (!$data['popup']) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Popup with ID ' . $id . ' not found.');
            }

        return view('admin/popup/edit', $data);
    }

    public function update($id)
{
    $popupModel = new PopupBerandaModel();
    $popup = $popupModel->find($id);

    if ($popup) {
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();

            if ($file->move(FCPATH . 'img', $newName)) {
                // Hapus gambar lama jika ada
                if (isset($popup['image']) && file_exists(FCPATH . 'img/' . $popup['image'])) {
                    @unlink(FCPATH . 'img/' . $popup['image']);
                }
                $popup['image'] = $newName;
            } else {
                session()->setFlashdata('error_popup', 'Gagal mengunggah gambar baru.');
                return redirect()->to('/admin/popup/')->withInput();
            }
        }

        try {
            $popupModel->update($id, $popup);
            session()->setFlashdata('success_popup', 'Popup berhasil diperbarui.');
        } catch (\Exception $e) {
            session()->setFlashdata('error_popup', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    } else {
        session()->setFlashdata('error_popup', 'Data popup tidak ditemukan.');
    }

    return redirect()->to('/admin/beranda/');
}

    public function delete($id)
    {
        $popupModel = new PopupBerandaModel();
        $popupModel->delete($id);
        return redirect()->to('/admin/beranda/');
    }
}
