<?php

namespace App\Controllers;

use App\Models\SliderBerandaModel;
use App\Models\PopupBerandaModel;
use App\Models\CardBerandaModel;

class DashboardController extends BaseController
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

        return view('dashboard/dashboard', $data);
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
