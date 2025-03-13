<?php

namespace App\Controllers\Pegawai;

use App\Models\riwayat_pendidikanModel;
use App\Models\PegawaiModel;
use CodeIgniter\Controller;


class Riwayat_pendidikanController extends Controller
{
    protected $riwayat_pendidikanModel;
    protected $PegawaiModel;

    public function __construct()
    {
        $this->riwayat_pendidikanModel = new Riwayat_pendidikanModel();
        $this->PegawaiModel = new PegawaiModel();
    }
 
    public function index()
{
    $riwayat_pendidikanModel = new Riwayat_pendidikanModel();
    $search = $this->request->getGet('search');
    $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

    if ($search) {
        $rp = $riwayat_pendidikanModel->like('pegawai.nama', $search)->findAll(); // Filter berdasarkan nama pegawai
    } else {
        $rp = $riwayat_pendidikanModel->getAllriwayat_pendidikan(); // Panggil fungsi dengan join
    }

    $data = [
        'riwayat_pendidikan' => $rp,
        'pegawai' => $this->PegawaiModel->findAll(),
        'pager' => $riwayat_pendidikanModel->pager,
        'currentPage' => $currentPage,
        'search' => $search
    ];

    return view('pegawai/riwayat_pendidikan/index', $data);
}

    public function create()
    {
        $data['riwayat_pendidikan'] = $this->riwayat_pendidikanModel->findAll();

        return view('pegawai/riwayat_pendidikan/create', $data);
    }

    public function store()
    {
        $riwayat_pendidikanModel = new Riwayat_pendidikanModel();
        
        $data = [
            'pegawai_id' => $this->request->getPost('pegawai_id'),
            'jenjang' => $this->request->getPost('jenjang'),
            'jurusan' => $this->request->getPost('jurusan'),
            'universitas' => $this->request->getPost('universitas'),
            'tahun_masuk' => $this->request->getPost('tahun_masuk'),
            'tahun_lulus' => $this->request->getPost('tahun_lulus'),
        ];

	try {
            if ($riwayat_pendidikanModel->save($data)) {
                session()->setFlashdata('success_rp', 'Data Riwayat Pendidikan berhasil ditambahkan.');
            } else {
                session()->setFlashdata('error_rp', 'Data Riwayat Pendidikan gagal ditambahkan.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // $riwayat_pendidikanModel->save($data);
    
        return redirect()->to('/pegawai/riwayat_pendidikan');
    }

    public function edit($id)
{
    $riwayat_pendidikanModel = new Riwayat_pendidikanModel();
    $pegawaiModel = new PegawaiModel(); // Pastikan model Pegawai sudah dibuat
    $eselonModel = new EselonModel();

    // Ambil data riwayat pendidikan berdasarkan ID
    $data['riwayat_pendidikan'] = $riwayat_pendidikanModel->find($id);

    // Pastikan data riwayat pendidikan ditemukan
    if (!$data['riwayat_pendidikan']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Riwayat pendidikan dengan ID $id tidak ditemukan.");
    }

    // Ambil daftar pegawai untuk dropdown
    $data['eselons'] = $eselonModel->findAll(); // Ambil semua data eselon
    $data['pegawai'] = $pegawaiModel->findAll(); // Ambil semua data pegawai

    return view('pegawai/riwayat_pendidikan/edit', $data);
}

    public function update($id)
{
    $riwayat_pendidikanModel = new Riwayat_pendidikanModel();

    // Ambil data input dari form
    $jenjang = trim($this->request->getPost('jenjang'));
    $jurusan = trim($this->request->getPost('jurusan'));
    $universitas = trim($this->request->getPost('universitas'));
    $tahun_masuk = $this->request->getPost('tahun_masuk');
    $tahun_lulus = $this->request->getPost('tahun_lulus');

    // Validasi input
    if ($jenjang === '') {
        return redirect()->back()->withInput()->with('error_rp', 'Jenjang tidak boleh kosong.');
    }

    if ($jurusan === '') {
        return redirect()->back()->withInput()->with('error_rp', 'Jurusan tidak boleh kosong.');
    }

    if ($universitas === '') {
        return redirect()->back()->withInput()->with('error_rp', 'Universitas tidak boleh kosong.');
    }

    if (!ctype_digit($tahun_masuk) || strlen($tahun_masuk) !== 4) {
        return redirect()->back()->withInput()->with('error_rp', 'Tahun Masuk harus berupa angka 4 digit.');
    }

    if (!ctype_digit($tahun_lulus) || strlen($tahun_lulus) !== 4) {
        return redirect()->back()->withInput()->with('error_rp', 'Tahun Lulus harus berupa angka 4 digit.');
    }

    if ((int)$tahun_lulus < (int)$tahun_masuk) {
        return redirect()->back()->withInput()->with('error_rp', 'Tahun Lulus tidak boleh lebih kecil dari Tahun Masuk.');
    }

    // Data siap diperbarui
    $data = [
        'pegawai_id' => $this->request->getPost('pegawai_id'),
        'jenjang' => $jenjang,
        'jurusan' => $jurusan,
        'universitas' => $universitas,
        'tahun_masuk' => $tahun_masuk,
        'tahun_lulus' => $tahun_lulus,
    ];

    if ($riwayat_pendidikanModel->update($id, $data)) {
        return redirect()->to('/pegawai/riwayat_pendidikan')->with('success_rp', 'Data berhasil diperbarui.');
    } else {
        return redirect()->back()->withInput()->with('error_rp', 'Gagal memperbarui data.');
    }
}

    public function delete($id)
    {
        $riwayat_pendidikanModel = new Riwayat_pendidikanModel();
        $riwayat_pendidikanModel->delete($id);
        return redirect()->to('/pegawai/riwayat_pendidikan');
    }

    public function uploadCsv()
    {
        $riwayat_pendidikanModel = new Riwayat_pendidikanModel();

        $file = $this->request->getFile('csv_file');

    if ($file->isValid() && !$file->hasMoved()) {
        $filePath = WRITEPATH . 'uploads/' . $file->getName();
        $file->move(WRITEPATH . 'uploads');

        // Membaca file CSV dengan pemisah titik koma
        $csvData = array_map(function($line) {
            return str_getcsv($line, ';'); // Mengubah pemisah menjadi titik koma
        }, file($filePath));

        // Menghapus header CSV
        $header = array_shift($csvData);

            // Validasi menyesuaikan kolom yang ada di database
            $expectedColumns = ['pegawai_id', 'jenjang', 'jurusan', 'universitas', 'tahun_masuk', 'tahun_lulus'];
            if ($header !== $expectedColumns) {
                return redirect()->to('/pegawai/riwayat_pendidikan')->with('error', 'Gagal mengunggah file. Kolom tidak sesuai.');
            }

            foreach ($csvData as $row) {
                $data = array_combine($header, $row);

            // Validasi Foreign Key
            $pegawai = $this->PegawaiModel->find($data['pegawai_id']);

            // Debugging: Tampilkan hasil pencarian
            if (!$pegawai) {
                log_message('error', 'Pegawai ID ' . $data['pegawai_id'] . ' tidak ditemukan.');
            }

            // Tetapkan NULL jika foreign key tidak valid
            $data['pegawai_id'] = $pegawai ? $data['pegawai_id'] : null;

                // Sesuaikan kolom data dengan kolom tabel MySQL
                $riwayat_pendidikanModel->insert([
                    'pegawai_id'  => $data['pegawai_id'],
                    'jenjang' => $data['jenjang'],
                    'jurusan' => $data['jurusan'],
                    'universitas' => $data['universitas'],
                    'tahun_masuk' => $data['tahun_masuk'],
                    'tahun_lulus' => $data['tahun_lulus'],
                ]);
            }

            return redirect()->to('/pegawai/riwayat_pendidikan')->with('success', 'Data berhasil ditambahkan.');
        } else {
            return redirect()->to('/pegawai/riwayat_pendidikan')->with('error', 'Gagal mengunggah file.');
        }
    }


    public function downloadTemplateCsv()
    {
        // Tentukan header kolom yang sesuai dengan tabel database
        $columns = [
            'pegawai_id',
            'jenjang',
            'jurusan',
            'universitas',
            'tahun_masuk',
            'tahun_lulus',
        ];

        // Nama file CSV
        $filename = "RP" . uniqid() . ".csv";

        // Membuka output untuk ditulis sebagai CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');

        $output = fopen('php://output', 'w');

        // Menuliskan header kolom dengan pemisah titik koma
        fputcsv($output, $columns, ';'); // Menentukan pemisah sebagai titik koma
        fclose($output);
        exit;
    }

}