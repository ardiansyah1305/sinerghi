<?php

namespace App\Controllers\Admin;

use App\Models\CardBerandaModel;
use CodeIgniter\Controller;

class CardController extends Controller
{
    protected $cardModel;

    public function __construct()
    {
        $this->cardModel = new CardBerandaModel();

    }

    public function index()
    {

        $cardModel = new CardBerandaModel();


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


        $data['cards'] = $cardModel->findAll();

        return view('admin/card/index', $data);
    }

    public function create()
    {
        return view('admin/card/create');
    }

    public function store()
    {
        $cardModel = new CardBerandaModel();
        $file = $this->request->getFile('image');

        try {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName);

            $data = [
                'title' => $this->request->getPost('title'),
                'short_description' => $this->request->getPost('short_description'),
                'description' => $this->request->getPost('description'),
                'start' => $this->request->getPost('start'),
                'end' => $this->request->getPost('end'),
                'image' => $newName,
            ];

            $cardModel->save($data);

            // Set flashdata untuk pesan success
            session()->setFlashdata('success_card', 'Pengumuman berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Set flashdata untuk pesan error
            session()->setFlashdata('error_card', 'Pengumuman gagal ditambahkan.');
        }

        return redirect()->to('/admin/card/');
    }


    public function edit($id)
    {
        // $calenderModel = new CalenderModel();
        $cardModel = new CardModel();

        $card = $cardModel->find($id);

        if ($card) {
            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'img', $newName);
                @unlink(FCPATH . 'img/' . $card['image']);
                $card['image'] = $newName;
            }
            $card['title'] = $this->request->getPost('title');
            $card['short_description'] = $this->request->getPost('short_description');
            $card['description'] = $this->request->getPost('description');
            $card['start'] = $this->request->getPost('start');
            $card['end'] = $this->request->getPost('end');
            $cardModel->update($id, $card);
        }

        $data['title'] = $cardModel->find($id);

        return view('admin/card/edit', $data);
    }

    public function update($id)
    {
        $cardModel = new CardBerandaModel();
        $card = $cardModel->find($id);

        if ($card) {
            $file = $this->request->getFile('image');

            // Jika ada file gambar baru
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();

                // Pindahkan gambar baru ke folder
                if ($file->move(FCPATH . 'img', $newName)) {
                    // Hapus gambar lama jika ada
                    if (isset($card['image']) && file_exists(FCPATH . 'img/' . $card['image'])) {
                        @unlink(FCPATH . 'img/' . $card['image']);
                    }
                    $card['image'] = $newName;
                } else {
                    session()->setFlashdata('error_card', 'Gagal mengunggah gambar baru.');
                    return redirect()->to('/admin/card/')->withInput();
                }
            }

            // Update data lainnya dari input form
            $card['title'] = $this->request->getPost('title');
            $card['short_description'] = $this->request->getPost('short_description');
            $card['description'] = $this->request->getPost('description');
            $card['start'] = $this->request->getPost('start');
            $card['end'] = $this->request->getPost('end');

            // Proses update ke database
            try {
                $cardModel->update($id, $card);
                session()->setFlashdata('success_card', 'Pengumuman berhasil diperbarui.');
            } catch (\Exception $e) {
                session()->setFlashdata('error_card', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
            }
        } else {
            session()->setFlashdata('error_card', 'Data card tidak ditemukan.');
        }

        return redirect()->to('/admin/card/');
    }

    public function delete($id)
    {
        $cardModel = new CardBerandaModel();
        $cardModel->delete($id);
        session()->setFlashdata('success_delete', 'Pengumuman berhasil dihapus.');
        return redirect()->to('/admin/card/');
    }
}
