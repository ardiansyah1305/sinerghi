<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ServiceDeskModel;
use App\Models\PegawaiModel;
use App\Models\LayananServiceDeskModel;
use App\Models\TiketModel;
use App\Models\UnitKerjaModel;
use App\Models\ChatModel;

class ServicedeskController extends BaseController
{
    protected $pegawaiModel;
    protected $serviceDeskModel;
    protected $layananServiceDeskModel;
    protected $tiketModel;
    protected $unitKerjaModel;
    protected $chatModel;

    public function __construct()
    {
        $this->pegawaiModel = new PegawaiModel();
        $this->serviceDeskModel = new ServiceDeskModel();
        $this->layananServiceDeskModel = new LayananServiceDeskModel();
        $this->tiketModel = new TiketModel();
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->chatModel = new ChatModel();
    }

    public function index($page = 1)
    {

        $limit = $this->request->getVar('limit') ?? 10;
        $offset = ($page - 1) * $limit;

        $session = session();
        $nip = $session->get('nip');
        if (!$nip) {
            return redirect()->to('/login');
        }


        $data_pegawai = $this->pegawaiModel->Pegawaidetail($nip);
        $data_layanan = $this->layananServiceDeskModel->findAll();
        $unit_kerja = $data_pegawai['id_unit'];

        $data_tiket_unit = $this->tiketModel->tiket_pegawai_unit_all($unit_kerja, $limit, $offset);
        $totalTiket = $this->tiketModel->countTiketByUnit($unit_kerja);
        $totalTiketNew = $this->tiketModel->countTiketNew($unit_kerja);
        $totalTiketProcess = $this->tiketModel->countTiketProccess($unit_kerja);
        $totalTiketDone = $this->tiketModel->countTiketDone($unit_kerja);
        $totalTiketCancel = $this->tiketModel->countTiketCancel($unit_kerja);

        $totalPages = ceil($totalTiket / $limit);

        $data = [
            'title' => 'ServiceDesk',
            'username' => $session->get('nama'),
            'pegawai' => $data_pegawai,
            'service_desk' => $this->serviceDeskModel->findAll(),
            'layanan' => $data_layanan,
            'tiketallunit' => $data_tiket_unit,
            'totalTiket' => $totalTiket,
            'totalTiketbaru' => $totalTiketNew,
            'totalTiketproses' => $totalTiketProcess,
            'totalTiketDone' => $totalTiketDone,
            'totalTiketcancel' => $totalTiketCancel,
            'unit_kerja' => $unit_kerja,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'limit' => $limit,
        ];

        return view('servicedesk/index', $data);
        //  dd($data);
    }

    public function filter()
    {
        $layanan = $this->request->getPost('layanan'); // Jenis layanan yang dipilih

        // Ambil tiket yang sesuai dengan jenis layanan yang dipilih
        $tiket = $this->tiketModel->filterByLayanan($layanan);

        // Kirim data tiket yang sudah difilter ke view
        return view('servicedesk/partial_ticket_list', ['tiketallunit' => $tiket]);
    }

    public function insert()
    {
        $validation = \Config\Services::validation();

        // Custom validation rules and messages
        $validationRules = [
            'layanan' => 'required',
            'detail_permohonan' => 'required',
            'dokumen_tambahan' => 'uploaded[dokumen_tambahan]|max_size[dokumen_tambahan,5120]|mime_in[dokumen_tambahan,application/pdf,image/jpg,image/jpeg,image/png]'
        ];

        $validationMessages = [
            'layanan' => [
                'required' => 'Jenis layanan harus dipilih.'
            ],
            'detail_permohonan' => [
                'required' => 'Detail permohonan harus diisi.'
            ],
            'dokumen_tambahan' => [
                'uploaded' => 'Dokumen tambahan harus diupload.',
                'max_size' => 'Dokumen tambahan maksimal 10MB.',
                'mime_in' => 'Dokumen tambahan harus berupa file PDF atau gambar (JPG, JPEG, PNG).'
            ]
        ];

        // Validasi form
        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $layanan = $this->request->getPost('layanan');
        $detailPermohonan = $this->request->getPost('detail_permohonan');
        $dokumenTambahan = $this->request->getFile('dokumen_tambahan');
        $unit_kerja_id = $this->request->getPost('unit_kerja_id');
        $pemohon = $this->request->getPost('nama');
        $idPegawai = $this->request->getPost('id_pegawai');
        $status = 0;

        // Proses upload dokumen jika ada
        if ($dokumenTambahan->isValid() && !$dokumenTambahan->hasMoved()) {
            $dokumenTambahan->move('uploads/tiket/');
            $dokumenPath = $dokumenTambahan->getName(); // Ambil nama file
        } else {
            $dokumenPath = null; // Jika tidak ada file
        }

        // Logika untuk membuat kode tiket
        $tiketModel = new TiketModel();

        // Ambil kode tiket terakhir berdasarkan unit kerja
        $lastTicket = $tiketModel->select('kode_tiket')
            ->where('id_unit_kerja', $unit_kerja_id)
            ->orderBy('kode_tiket', 'DESC')
            ->first();

        // Hitung nomor urut tiket
        if ($lastTicket) {
            $lastKode = $lastTicket['kode_tiket'];
            $lastNumber = (int) substr($lastKode, -4); // Ambil 4 digit terakhir
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1; // Jika belum ada tiket, mulai dari 1
        }

        // Format nomor urut menjadi 4 digit
        $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Gabungkan unit kerja dan nomor urut untuk membuat kode tiket
        $kodeTiket = $unit_kerja_id . $layanan . $formattedNumber;

        // Insert data ke database
        $data = [
            'kode_tiket' => $kodeTiket,
            'id_pegawai' => $idPegawai,
            'id_unit_kerja' => $unit_kerja_id,
            'id_layanan' => $layanan,
            'status' => $status,
            'tanggal_status_terkini' => date('Y-m-d H:i:s'),
            'lampiran' => $dokumenPath,
            'deskripsi' => $detailPermohonan,
        ];

        if ($tiketModel->save($data)) {
            session()->setFlashdata('kodeTiket', $kodeTiket);
            return redirect()->to('/servicedesk')->with('success', 'Tiket berhasil dibuat dengan kode ' . $kodeTiket);
        } else {
            return redirect()->back()->withInput()->with('errors', $tiketModel->errors());
        }
    }

    public function detail($kodeTiket)
{
    $tiketModel = new TiketModel();
    $chatModel = new ChatModel();

    $messages = $chatModel->chattiketpegawai($kodeTiket);

    // Mengambil data tiket berdasarkan kode_tiket
    $tiket = $tiketModel->where('kode_tiket', $kodeTiket)->first();
    if (!$tiket) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tiket tidak ditemukan.');
    }

    $data_pegawai_tiket = $tiketModel->detail_tiket_pegawai($kodeTiket);
    $data = [
        'tiket' => $tiket,
        'data_pegawai' => $data_pegawai_tiket,
        'messages' => $messages,
    ];
    
    return view('servicedesk/response', $data);
}

    public function updateStatus()
    {
        // Mendapatkan input status dan tiket_id
        $status = $this->request->getPost('status');
        $tiket_id = $this->request->getPost('id');

        // Validasi data
        if (empty($status) || empty($tiket_id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak lengkap.']);
        }

        // Update status tiket
        $updated = $this->tiketModel->update($tiket_id, [
            'status' => $status
        ]);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status berhasil diperbarui!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui status tiket.']);
        }
    }

    public function sendMessage()
    {
        $tiketId = $this->request->getPost('id_tiket');
        $pegawaiId = $this->request->getPost('id_pegawai');
        $kodeTiket = $this->request->getPost('kode_tiket');
        $deskripsi = $this->request->getPost('deskripsi'); // Ambil 'deskripsi' yang benar
    
        // Validasi data
        if (empty($tiketId) || empty($pegawaiId) || empty($kodeTiket) || empty($deskripsi)) {
            return $this->response->setStatusCode(400, 'Data tidak lengkap');
        }
    
        // Simpan pesan ke database
        $chatModel = new ChatModel();
        $chatModel->save([
            'id_tiket' => $tiketId, // Menggunakan 'id_tiket' sesuai dengan model
            'kode_tiket' => $kodeTiket, // Menggunakan 'kode_tiket'
            'id_pegawai' => $pegawaiId, // Menggunakan 'id_pegawai'
            'deskripsi' => $deskripsi, // Menyimpan 'deskripsi'
        ]);
    
        // Debugging (Jika diperlukan untuk cek data yang dikirim)
        // dd($tiketId, $pegawaiId, $kodeTiket, $deskripsi);
    
        // Response JSON sukses
        return $this->response->setJSON(['success' => true, 'message' => 'Pesan terkirim']);    
    }

    public function comingSoon()
    {
        return view('servicedesk/coming_soon');
    }
}
