    public function generateExcelTemplate()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $bulan = $this->request->getPost('bulan');
        
        if (!$bulan) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter bulan tidak valid']);
        }

        try {
            // Get current user's unit_kerja_id
            $pegawaiModel = new PegawaiModel();
            $unitkerjaModel = new UnitkerjaModel();
            $pegawai_id = session()->get('pegawai_id');
            $pegawaiData = $pegawaiModel->find($pegawai_id);
            
            if (!$pegawaiData) {
                throw new \Exception('Data pegawai tidak ditemukan');
            }
            
            $unit_kerja_id = $pegawaiData['unit_kerja_id'];
            $unit_kerja = $unitkerjaModel->find($unit_kerja_id);
            
            // Get all employees from the same unit and sub-units if applicable
            $employees = [];
            
            if ($unit_kerja['parent_id'] == 2) {
                // For eselon 1, include employees from the same unit and its sub-units
                $childUnitIds = $unitkerjaModel->getAllChildUnits($unit_kerja_id);
                $allowedUnitIds = array_merge([$unit_kerja_id], $childUnitIds);
                
                $employees = $pegawaiModel
                    ->select('pegawai.id, pegawai.nip, pegawai.nama, unit_kerja.nama as unit_kerja_nama')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->whereIn('pegawai.unit_kerja_id', $allowedUnitIds)
                    ->where('pegawai.status_pegawai', 1) // Only active employees
                    ->orderBy('pegawai.nama', 'ASC')
                    ->findAll();
            } else {
                // For other units, get employees with the same parent_id
                $employees = $pegawaiModel
                    ->select('pegawai.id, pegawai.nip, pegawai.nama, unit_kerja.nama as unit_kerja_nama')
                    ->join('unit_kerja', 'pegawai.unit_kerja_id = unit_kerja.id')
                    ->where('unit_kerja.parent_id', $unit_kerja['parent_id'])
                    ->where('pegawai.status_pegawai', 1) // Only active employees
                    ->orderBy('pegawai.nama', 'ASC')
                    ->findAll();
            }
            
            if (empty($employees)) {
                throw new \Exception('Tidak ada pegawai yang ditemukan di unit kerja ini');
            }
            
            // Get working days for the selected month
            $tahun = date('Y');
            $workingDays = $this->getWorkingDaysInMonth($tahun, $bulan);
            
            // Create Excel file
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set column headers according to the requested format
            $sheet->setCellValue('A1', 'nama_pegawai');
            $sheet->setCellValue('B1', 'nip_pegawai');
            $sheet->setCellValue('C1', 'tanggal_kerja');
            $sheet->setCellValue('D1', 'jenis_alokasi');
            
            // Style the header row
            $headerStyle = [
                'font' => [
                    'bold' => true,
                ],
            ];
            $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
            
            // Add data validation for column D (jenis_alokasi)
            $validation = $sheet->getDataValidation('D2:D1000');
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(false);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"LKK,LKL,CT"');
            
            // Populate data
            $row = 2;
            
            foreach ($employees as $employee) {
                foreach ($workingDays as $day) {
                    // Alternate between LKK, LKL, CT for example purposes
                    $jenis_alokasi = 'LKK';
                    $dayIndex = ($row - 2) % 3;
                    if ($dayIndex == 1) {
                        $jenis_alokasi = 'LKL';
                    } else if ($dayIndex == 2) {
                        $jenis_alokasi = 'CT';
                    }
                    
                    $sheet->setCellValue('A' . $row, $employee['nama']);
                    $sheet->setCellValue('B' . $row, $employee['nip']);
                    $sheet->setCellValue('C' . $row, $day);
                    $sheet->setCellValue('D' . $row, $jenis_alokasi);
                    
                    $row++;
                }
            }
            
            // Auto-size columns
            foreach (range('A', 'D') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Create Excel file
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $filename = 'template_jadwal_' . date('Ymd_His') . '.xlsx';
            $filepath = WRITEPATH . 'uploads/temp/' . $filename;
            
            // Create directory if it doesn't exist
            if (!is_dir(WRITEPATH . 'uploads/temp/')) {
                mkdir(WRITEPATH . 'uploads/temp/', 0777, true);
            }
            
            $writer->save($filepath);
            
            // Return the file URL
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Template Excel berhasil dibuat',
                'file_url' => base_url('admin/penugasan/download-template/' . $filename)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
