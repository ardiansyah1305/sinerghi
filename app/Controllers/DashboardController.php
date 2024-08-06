<?php

namespace App\Controllers;

use App\Models\SliderBerandaModel;
use App\Models\PopupBerandaModel;
use App\Models\CardBerandaModel;
use App\Models\CalenderModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $sliderModel = new SliderBerandaModel();
        $popupModel = new PopupBerandaModel();
        $cardModel = new CardBerandaModel();
        $calenderModel = new CalenderModel();

        $calenders = $calenderModel->findAll();

        // Format data calenders untuk FullCalendar
        $calenders = array_map(function($calender) {
            return [
                'title' => $calender['title'],
                'start' => $calender['start'],
                'end' => $calender['end'],
                'description' => $calender['description'],
            ];
        }, $calenders);

        $data = [
            'sliders' => $sliderModel->findAll(),
            'popups' => $popupModel->findAll(),
            'cards' => $cardModel->findAll(),
            'calenders' => $calenders, 
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
