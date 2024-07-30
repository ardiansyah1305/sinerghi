<?php

namespace App\Controllers\Admin;

use App\Models\SliderBerandaModel;
use App\Models\PopupBerandaModel;
use App\Models\CardBerandaModel;
use CodeIgniter\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        $sliderModel = new SliderBerandaModel();
        $popupModel = new PopupBerandaModel();
        $cardModel = new CardBerandaModel();

        $data = [
            'sliders' => $sliderModel->findAll(),
            'popups' => $popupModel->findAll(),
            'cards' => $cardModel->findAll(),
        ];

        return view('admin/beranda/index', $data);
    }

    public function storeSlider()
    {
        $sliderModel = new SliderBerandaModel();
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img', $newName); // Simpan di folder public/uploads
            $data = [
                'image' => $newName,
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
            ];
            $sliderModel->save($data);
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
}