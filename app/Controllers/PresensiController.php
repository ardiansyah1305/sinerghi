<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

class PresensiController extends BaseController
{
    public function index()
    {
        helper(['curl']);

        $request = \Config\Services::request();

        $m = $request->getPost("m");

        if (!isset($m)) $m = date("n");
        if ($m < 10) $m = "0".$m;

        $y = $request->getPost("y");

        if (!isset($y)) $y = date("Y");

        $q = $request->getPost("q");

        if ($q == "") $q = session()->get('nip');

        // $rest_api_base_url = 'http://localhost/2024/siapp_pmk/rest_ci/index.php';
        $rest_api_base_url = '192.168.10.16/siapp/rest_ci/index.php';

        $pegawai_endpoint = '/api/pegawai/all?key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $pegawai_by_nip_endpoint = '/api/pegawai/by_nip?nip='.$q.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $presensi_endpoint = '/api/presensi/by_nip_bulan?nip='.$q.'&m='.$m.'&y='.$y.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $rekapitulasi_endpoint = '/api/rekapitulasi/by_nip_bulan?nip='.$q.'&m='.$m.'&y='.$y.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        // $total_kekurangan_endpoint = '/api/rekapitulasi/total_kekurangan_by_nip_bulan?nip='.$q.'&bulan='.$y.'-'.$m.'&key=key=3ec067e85d0d9a8ed2df88dab64ae3c2';

        $pegawai = json_decode(perform_http_request('GET', $rest_api_base_url . $pegawai_endpoint), true);
        $pegawai_by_nip = json_decode(perform_http_request('GET', $rest_api_base_url . $pegawai_by_nip_endpoint), true);
        $presensi = json_decode(perform_http_request('GET', $rest_api_base_url . $presensi_endpoint), true);
        $rekapitulasi = json_decode(perform_http_request('GET', $rest_api_base_url . $rekapitulasi_endpoint), true);

		
        if (array_key_exists("nip", $pegawai_by_nip)) $badgenumber = $pegawai_by_nip['nip'];
        else $badgenumber = "";

        $realtime_endpoint = '/api/realtime/by_badgenumber_bulan?badgenumber='.$badgenumber.'&m='.$m.'&y='.$y.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $realtime = json_decode(perform_http_request('GET', $rest_api_base_url . $realtime_endpoint), true);

        $data = [
            'nip' => $this->userData['nip'],
            'm' => $m,
            'y' => $y,
            'q' => $q,
            'pegawai_by_nip' => $pegawai_by_nip,
            'pegawai' => $pegawai,
            'col' => $presensi,
            'Rekapitulasi' => $rekapitulasi,
            'realtime' => $realtime,
            'xusername' => session()->get('nip')
        ];

        return view('presensi/presensi', $data);
    }

    public function ed($m, $y, $q, $x, $z)
    {
        helper(['curl']);

        $request = \Config\Services::request();

        // $rest_api_base_url = 'http://localhost/2024/siapp_pmk/rest_ci/index.php';
        $rest_api_base_url = 'http://siapp.kemenkopmk.go.id/rest_ci/index.php';

        $presensi_by_id_endpoint = '/api/presensi/by_id?id='.$q.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $presensi_by_id = json_decode(perform_http_request('GET', $rest_api_base_url . $presensi_by_id_endpoint), true);
        $nip = $presensi_by_id['nip'];

        $pegawai_by_nip_endpoint = '/api/pegawai/by_nip?nip='.$nip.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $pegawai_by_nip = json_decode(perform_http_request('GET', $rest_api_base_url . $pegawai_by_nip_endpoint), true);

        $data = [
            'm' => $m,
            'y' => $y,
            'q' => $q,
            'x' => $x,
            'z' => $z,
            'presensi_by_id' => $presensi_by_id,
            'pegawai_by_nip' => $pegawai_by_nip,
            'xusername' => session()->get('nip')
        ];

        return view('presensi/presensi_ed', $data);
    }

    public function store()
    {
        $status_verifikasi = $this->request->getPost('status_verifikasi');
        $q = $this->request->getPost('q');
        $keterangan = $this->request->getPost('keterangan');
        $xusername = $this->request->getPost('xusername');

        if ($status_verifikasi != "1")
        {
            $validationRule = [
                'file_bukti' => [
                    'label' => 'File Bukti',
                    'rules' => [
                        'uploaded[file_bukti]',
                        'mime_in[file_bukti,image/jpg,image/jpeg,image/gif,image/png,application/pdf]',
                        'max_size[file_bukti,100]',
                    ],
                ],
            ];

            $file = $this->request->getFile('file_bukti');

            if ($file->isValid() && !$file->hasMoved())
            {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/temp_file_bukti', $newName);

                // $base_url = "http://localhost/2024/siapp_pmk/rest_ci/index.php/api/presensi/upload_file_bukti";
                $base_url = 'http://siapp.kemenkopmk.go.id/rest_ci/index.php/api/presensi/upload_file_bukti';

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $base_url);
                curl_setopt($curl, CURLOPT_VERBOSE, 1);
                //curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0');
                //curl_setopt($curl, CURLOPT_ENCODING, '');
                //curl_setopt($curl, CURLOPT_REFERER, 'http://www.noelshack.com/api.php');
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

                // download image to temp file for upload
                $tmp = tempnam(sys_get_temp_dir(), 'php');
                file_put_contents($tmp, file_get_contents(WRITEPATH . 'uploads/temp_file_bukti/' . $newName));

                //The JSON data

                $jsonData = array(
                    "id" => $q,
                    "keterangan" => $keterangan,
                    "upload_oleh" => $xusername,
                    "key" => '3ec067e85d0d9a8ed2df88dab64ae3c2',
                    "file_bukti" => new \CURLFile($tmp),
                    "nama_file" => $newName
                );

                // send a file
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);

                // output the response
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($curl);
                // var_dump($result, curl_error($curl));

                unlink($tmp); // remove temp file

                curl_close($curl);
            }
        }

        return redirect()->to('presensi');
    }

    function download_file_bukti($q)
	{
        helper(['curl']);

        // $rest_api_base_url = 'http://localhost/2024/siapp_pmk/rest_ci/index.php';
        $rest_api_base_url = 'http://siapp.kemenkopmk.go.id/rest_ci/index.php';

        $presensi_by_id_endpoint = '/api/presensi/by_id?id='.$q.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $presensi_by_id = json_decode(perform_http_request('GET', $rest_api_base_url . $presensi_by_id_endpoint), true);

		return $this->response->download(WRITEPATH . 'uploads/temp_file_bukti/' . $presensi_by_id['file_bukti'], null);
	}

    public function infografis_kehadiran($q, $y, $m)
    {
        helper(['curl']);

        if ($m < 10) $m = "0".$m;

        // $rest_api_base_url = 'http://localhost/2024/siapp_pmk/rest_ci/index.php';
        $rest_api_base_url = 'http://siapp.kemenkopmk.go.id/rest_ci/index.php';

        $presensi_endpoint = '/api/presensi/by_nip_bulan?nip='.$q.'&m='.$m.'&y='.$y.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $rekapitulasi_endpoint = '/api/rekapitulasi/by_nip_bulan?nip='.$q.'&m='.$m.'&y='.$y.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';

        $presensi = json_decode(perform_http_request('GET', $rest_api_base_url . $presensi_endpoint), true);
        $Rekapitulasi = json_decode(perform_http_request('GET', $rest_api_base_url . $rekapitulasi_endpoint), true);

        $bulan_ini = date("Y-m");

        $bulan = $y."-".$m;
        $bulan_ini = date("Y-m");

        if ($bulan != $bulan_ini) $hari_kerja = $presensi['data']['hari_kerja'];
        else
        {
            $hari_ini = date("d");
            $hari_terakhir = date("t");

            $hari_kerja = $presensi['data']['hari_kerja'] + $hari_ini - $hari_terakhir;
        }

        $kehadiran = $Rekapitulasi['hadir'] / $hari_kerja * 100;

        $data[] = array('name' => 'Kehadiran', "sliced" => true, "selected" => true, 'y' => $kehadiran, 'color' => "#00CC00");

        $TL = ($Rekapitulasi['TL1'] + $Rekapitulasi['TL2'] + $Rekapitulasi['TL3'] + $Rekapitulasi['TL4'] + $Rekapitulasi['TL5']) / $hari_kerja * 100;
        $PSW = ($Rekapitulasi['PSW1'] + $Rekapitulasi['PSW2'] + $Rekapitulasi['PSW3'] + $Rekapitulasi['PSW4'] + $Rekapitulasi['PSW5']) / $hari_kerja * 100;
        $DL = $Rekapitulasi['dl_non_sppd'] / $hari_kerja * 100;
        $TB = $Rekapitulasi['TBplus'] / $hari_kerja * 100;
        $CT = ($Rekapitulasi['CT'] + $Rekapitulasi['CB'] + $Rekapitulasi['CSRJ'] + $Rekapitulasi['CM'] + $Rekapitulasi['CP']) / $hari_kerja * 100;
        $TK = $Rekapitulasi['TK'] / $hari_kerja * 100;
        $TGL = $Rekapitulasi['TGLuar'] / $hari_kerja * 100;
        $TGP = $Rekapitulasi['TGP'] / $hari_kerja * 100;

        if ($TL > 0) $data[] = array('name' => 'Terlambat (TL)', 'y' => $TL, 'color' => "#FF9900");
        if ($PSW > 0) $data[] = array('name' => 'Pulang Sebelum Waktu (PSW)', 'y' => $PSW, 'color' => "#FFCC00");
        if ($DL > 0) $data[] = array('name' => 'Dinas Luar (DL)', 'y' => $DL, 'color' => "#0000FF");
        if ($TB > 0) $data[] = array('name' => 'Tugas Belajar (TB0', 'y' => $TB, 'color' => "#0066FF");
        if ($CT > 0) $data[] = array('name' => 'Cuti (CT)', 'y' => $CT, 'color' => "#6600FF");
        if ($TK > 0) $data[] = array('name' => 'Tanpa Keterangan (A)', 'y' => $TK, 'color' => "#FF0000");
        if ($TGL > 0) $data[] = array('name' => 'TGL', 'y' => $TGL, 'color' => "#0000FF");
        if ($TGP > 0) $data[] = array('name' => 'TGP', 'y' => $TGP, 'color' => "#0000FF");

		echo json_encode($data);
	}

    public function infografis_kekurangan($q, $y, $m)
    {
        helper(['curl']);

        if ($m < 10) $m = "0".$m;

        // $rest_api_base_url = 'http://localhost/2024/siapp_pmk/rest_ci/index.php';
        $rest_api_base_url = 'http://siapp.kemenkopmk.go.id/rest_ci/index.php';

        $presensi_endpoint = '/api/presensi/by_nip_bulan?nip='.$q.'&m='.$m.'&y='.$y.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';
        $rekapitulasi_endpoint = '/api/rekapitulasi/by_nip_bulan?nip='.$q.'&m='.$m.'&y='.$y.'&key=3ec067e85d0d9a8ed2df88dab64ae3c2';

        $presensi = json_decode(perform_http_request('GET', $rest_api_base_url . $presensi_endpoint), true);
        $Rekapitulasi = json_decode(perform_http_request('GET', $rest_api_base_url . $rekapitulasi_endpoint), true);

        $bulan_ini = date("Y-m");

        $bulan = $y."-".$m;
        $bulan_ini = date("Y-m");

        if ($bulan != $bulan_ini) $hari_kerja = $presensi['data']['hari_kerja'];
        else
        {
            $hari_ini = date("d");
            $hari_terakhir = date("t");

            $hari_kerja = $presensi['data']['hari_kerja'] + $hari_ini - $hari_terakhir;
        }

        $total_jam_kerja = $hari_kerja * 450;
        $kekurangan = $Rekapitulasi['kekurangan'] / $total_jam_kerja * 100;
        $jam_kerja = ($total_jam_kerja - $kekurangan) / $total_jam_kerja * 100;;

        $data[] = array('name' => 'Jam Kerja Terpenuhi', 'y' => $jam_kerja, 'color' => "#00CC00");
        if ($kekurangan > 0) $data[] = array('name' => 'Kekurangan Jam Kerja', "sliced" => true, "selected" => true, 'y' => $kekurangan, 'color' => "#FF0000");

		echo json_encode($data);
	}

    public function checkin()
    {
        $data = [
            'nip' => $this->userData['nip'],
            'xusername' => session()->get('nip')
        ];
        return view('presensi/checkin', $data);
    }

    public function recordCheckIn()
    {
        helper(['curl']);
        $nip = session()->get('nip');
        $time = date('Y-m-d H:i:s');
        
        // Add your API endpoint for recording check-in
        $rest_api_base_url = '192.168.10.16/siapp/rest_ci/index.php';
        $checkin_endpoint = '/api/presensi/checkin';
        
        $data = [
            'nip' => $nip,
            'check_in_time' => $time
        ];
        
        $response = json_decode(perform_http_request('POST', $rest_api_base_url . $checkin_endpoint, $data), true);
        
        return $this->response->setJSON($response);
    }

    public function recordCheckOut()
    {
        helper(['curl']);
        $nip = session()->get('nip');
        $time = date('Y-m-d H:i:s');
        
        // Add your API endpoint for recording check-out
        $rest_api_base_url = '192.168.10.16/siapp/rest_ci/index.php';
        $checkout_endpoint = '/api/presensi/checkout';
        
        $data = [
            'nip' => $nip,
            'check_out_time' => $time
        ];
        
        $response = json_decode(perform_http_request('POST', $rest_api_base_url . $checkout_endpoint, $data), true);
        
        return $this->response->setJSON($response);
    }
}
