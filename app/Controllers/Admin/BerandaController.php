<?php

namespace App\Controllers\Admin;

use App\Models\SliderBerandaModel;
use App\Models\PopupBerandaModel;
use App\Models\CardBerandaModel;
use App\Models\CalenderModel;
use CodeIgniter\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        $sliderModel = new SliderBerandaModel();
        $popupModel = new PopupBerandaModel();
        $cardModel = new CardBerandaModel();
        $calenderModel = new CalenderModel();

        $data = [
            'sliders' => $sliderModel->findAll(),
            'popups' => $popupModel->findAll(),
            'cards' => $cardModel->findAll(),
            'calenders' => $calenderModel->findAll(),
        ];

        return view('admin/beranda/index', $data);
    }


    public function create_slider()
    {
        return view('admin/beranda/create_slider');
    }

    //Slider
    public function storeSlider()
    {
        $sliderModel = new SliderBerandaModel();
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = $file->getExtension();

            // Periksa apakah ekstensi file sesuai
            if (!in_array($extension, $allowedExtensions)) {
                session()->setFlashdata('error_slider', 'Hanya file dengan format jpg, jpeg, atau png yang diperbolehkan.');
                return redirect()->back();
            }
            $newName = $file->getRandomName();

            if ($file->move(FCPATH . 'img', $newName)) {
                // Data yang akan disimpan
                $data = [
                    'image' => $newName,
                ];

                try {
                    $sliderModel->save($data);
                    session()->setFlashdata('success_slider', 'Slider berhasil ditambahkan.');
                } catch (\Exception $e) {
                    session()->setFlashdata('error_slider', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
                }
            } else {
                session()->setFlashdata('error_slider', 'Gagal mengunggah gambar.');
            }
        } else {
            // pesan jika tidak memasukan foto/gambar
            session()->setFlashdata('error_slider', 'Tidak ada gambar yang dipilih.');
        }

        return redirect()->to('/admin/beranda');
    }
    // Edit Slider
    public function editSlider($id)
    {
        $sliderModel = new SliderBerandaModel();
        $data['slider'] = $sliderModel->find($id);

        if (!$data['slider']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Slider with ID ' . $id . ' not found.');
        }

        return view('admin/beranda/edit_slider', $data);
    }

    // Update Slider
    public function updateSlider($id)
    {
        $sliderModel = new SliderBerandaModel();
        $slider = $sliderModel->find($id);

        if ($slider) {
            $file = $this->request->getFile('image');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();

                if ($file->move(FCPATH . 'img', $newName)) {
                    // Hapus gambar lama jika ada
                    if (isset($slider['image']) && file_exists(FCPATH . 'img/' . $slider['image'])) {
                        @unlink(FCPATH . 'img/' . $slider['image']);
                    }

                    $slider['image'] = $newName;
                } else {
                    session()->setFlashdata('error_slider', 'Gagal mengunggah gambar baru.');
                    return redirect()->to('/admin/beranda');
                }
            }

            try {
                $sliderModel->update($id, $slider);
                session()->setFlashdata('success_slider', 'Slider berhasil diperbarui.');
            } catch (\Exception $e) {
                session()->setFlashdata('error_slider', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
            }
        } else {
            session()->setFlashdata('error_slider', 'Data slider tidak ditemukan.');
        }

        return redirect()->to('/admin/beranda');
    }
    public function deleteSlider($id)
    {
        $sliderModel = new SliderBerandaModel();
        $slider = $sliderModel->find($id);
        if ($slider) {
            @unlink(FCPATH . 'img/' . $slider['image']);
            $sliderModel->delete($id);
        }
        return redirect()->to('/admin/beranda');
    }

    //Modal/Popup

    public function create_popup()
    {
        return view('admin/beranda/create_popup');
    }


    public function storePopup()
    {
        $popupModel = new PopupBerandaModel();
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = $file->getExtension();

            // Periksa apakah ekstensi file sesuai
            if (!in_array($extension, $allowedExtensions)) {
                session()->setFlashdata('error_popup', 'Hanya file dengan format jpg, jpeg, atau png yang diperbolehkan.');
                return redirect()->back();
            }
            $newName = $file->getRandomName();

            if ($file->move(FCPATH . 'img', $newName)) {
                $data = ['image' => $newName];
                try {
                    $popupModel->save($data);
                    session()->setFlashdata('success_popup', 'Popup berhasil ditambahkan.');
                } catch (\Exception $e) {
                    session()->setFlashdata('error_popup', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
                }
            } else {
                session()->setFlashdata('error_popup', 'Gagal mengunggah gambar.');
            }
        } else {
            session()->setFlashdata('error_popup', 'File gambar tidak valid atau sudah dipindahkan.');
        }

        return redirect()->to('/admin/beranda');
    }
    // Edit Popup
    public function editPopup($id)
    {
        $popupModel = new PopupBerandaModel();
        $data['popup'] = $popupModel->find($id);

        if (!$data['popup']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Popup with ID ' . $id . ' not found.');
        }

        return view('admin/beranda/edit_popup', $data);
    }

    // Update Popup
    public function updatePopup($id)
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
                    return redirect()->to('/admin/beranda')->withInput();
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

        return redirect()->to('/admin/beranda');
    }

    public function deletePopup($id)
    {
        $popupModel = new PopupBerandaModel();
        $popup = $popupModel->find($id);
        if ($popup) {
            @unlink(FCPATH . 'img/' . $popup['image']);
            $popupModel->delete($id);
        }
        return redirect()->to('/admin/beranda');
    }

    //Card/Pengumuman Penting
    public function storeCard()
    {
        $cardModel = new CardBerandaModel();
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName);
            $data = [
                'title' => $this->request->getPost('title'),
                'short_description' => $this->request->getPost('short_description'),
                'description' => $this->request->getPost('description'),
                'image' => $newName,
            ];
            $cardModel->save($data);
        }

        return redirect()->to('/admin/beranda');
    }
    // Edit Card
    public function editCard($id)
    {
        $cardModel = new CardBerandaModel();
        $data['card'] = $cardModel->find($id);

        if (!$data['card']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Card with ID ' . $id . ' not found.');
        }

        return view('admin/beranda/edit_card', $data);
    }

    // Update Card
    public function updateCard($id)
    {
        $cardModel = new CardBerandaModel();
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
            $cardModel->update($id, $card);
        }

        return redirect()->to('/admin/beranda');
    }

    public function deleteCard($id)
    {
        $cardModel = new CardBerandaModel();
        $cardModel->delete($id);
        return redirect()->to('/admin/beranda');
    }


    public function detail_pengumuman($id)
    {
        $cardModel = new CardBerandaModel();
        $data['announcement'] = $cardModel->find($id);

        if (!$data['announcement']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Announcement with ID ' . $id . ' not found.');
        }

        return view('dashboard/detail_pengumuman', $data);
    }

    //Kalender
    public function createKalender()
    {
        $model = new CalenderModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'start' => $this->request->getPost('start'),
            'end' => $this->request->getPost('end')
        ];
        $model->insert($data);
        return redirect()->to('/admin/beranda');
    }

    public function deleteKalender($id)
    {
        $model = new CalenderModel();
        $model->delete($id);
        return redirect()->to('/admin/beranda');
    }
}