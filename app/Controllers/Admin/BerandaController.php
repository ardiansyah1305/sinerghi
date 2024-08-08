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

    //Slider
    public function storeSlider()
    {
        $sliderModel = new SliderBerandaModel();
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName); // Simpan di folder public/uploads
            $data = [
                'image' => $newName,
                
            ];
            $sliderModel->save($data);
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
            $file->move(FCPATH . 'img', $newName);
            @unlink(FCPATH . 'img/' . $slider['image']);
            $slider['image'] = $newName;
        }
        $sliderModel->update($id, $slider);
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
    public function storePopup()
    {
        $popupModel = new PopupBerandaModel();
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName); // Simpan di folder public/uploads
            $data = ['image' => $newName];
            $popupModel->save($data);
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
            $file->move(FCPATH . 'img', $newName);
            @unlink(FCPATH . 'img/' . $popup['image']);
            $popup['image'] = $newName;
        }
        $popupModel->update($id, $popup);
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