<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="container mt-4">
    <ul class="nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#infografis">Infografis</a></li>
        <li><a data-toggle="pill" href="#info_presensi">Info Presensi</a></li>
        <li><a data-toggle="pill" href="#realtime">Presensi <i>Realtime</i></a></li>
    </ul>

    <div class="tab-content">
        <div id="infografis" class="tab-pane fade in active">
            <div class="container mt-3">
                <div class="row">
                    <!-- Konten Utama -->
                    <div class="col-12">
                        <div class="row">
                            <hr>
                            <form action="<?php echo base_url("presensi"); ?>" method="post">
                                <div class="form-group row">
                                    <label for="m" class="col-sm-2 col-form-label">Bulan</label>
                                    <div class="col-sm-2">
                                        <select class="form-control form-control-sm" name="bulan" id="bulan">
                                            <option></option><?php

                                            $nama_bulan = array(
                                                "0" => "",
                                                "1" => "Januari",
                                                "2" => "Februari",
                                                "3" => "Maret",
                                                "4" => "April",
                                                "5" => "Mei",
                                                "6" => "Juni",
                                                "7" => "Juli",
                                                "8" => "Agustus",
                                                "9" => "September",
                                                "10" => "Oktober",
                                                "11" => "Nopember",
                                                "12" => "Desember",
                                            );

                							for ($month = 1; $month <= 12; $month++)
                							{ ?>

                								<option value="<?php echo $month; ?>" <?php if ($month == $m) echo "selected"; ?>><?php
                									echo $nama_bulan[$month]; ?>
                								</option><?php

                							} ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select class="form-control form-control-sm" name="tahun" id="tahun">
                							<option></option><?php

                							for ($year = date("Y") - 5; $year <= date("Y") + 1; $year++)
                							{ ?>

                								<option value="<?php echo $year; ?>" <?php if ($year == $y) echo "selected"; ?>><?php
                									echo $year ?>
                								</option><?php

                							} ?>

                						</select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="q" class="col-sm-2 col-form-label">Nama Pegawai</label>
                                    <div class="col-sm-5">
                                        <select class="cariPegawai form-control form-control-sm select2" name="nip" id="nip">
                							<option></option><?php

                                                foreach ($pegawai as $k=>$val)
                                                {
                                                    if ($val['nip_baru'] == $xusername)
                                                    { ?>
                                                        <option value="<?php echo $val['nip_baru']; ?>" <?php if ($val['nip_baru'] == $q) echo "selected"; ?>><?php echo $val['nama']; ?></option><?php
                                                    }
                                                } ?>

                						</select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-5">
                                <div id="container"></div>
                            </div>
                            <div class="col-sm-5">
                                <div id="container2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="info_presensi" class="tab-pane fade">
            <div class="container mt-3">
                <div class="row">
                    <!-- Konten Utama -->
                    <div class="col-12">
                        <div class="row">
                            <hr>
                            <form action="<?php echo base_url("presensi"); ?>" method="post">
                                <div class="form-group row">
                                    <label for="m" class="col-sm-2 col-form-label">Bulan</label>
                                    <div class="col-sm-2">
                                        <select class="form-control form-control-sm" name="m">
                                            <option></option><?php

                                            $nama_bulan = array(
                                                "0" => "",
                                                "1" => "Januari",
                                                "2" => "Februari",
                                                "3" => "Maret",
                                                "4" => "April",
                                                "5" => "Mei",
                                                "6" => "Juni",
                                                "7" => "Juli",
                                                "8" => "Agustus",
                                                "9" => "September",
                                                "10" => "Oktober",
                                                "11" => "Nopember",
                                                "12" => "Desember",
                                            );

                							for ($month = 1; $month <= 12; $month++)
                							{ ?>

                								<option value="<?php echo $month; ?>" <?php if ($month == $m) echo "selected"; ?>><?php
                									echo $nama_bulan[$month]; ?>
                								</option><?php

                							} ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select class="form-control form-control-sm" name="y">
                							<option></option><?php

                							for ($year = date("Y") - 5; $year <= date("Y") + 1; $year++)
                							{ ?>

                								<option value="<?php echo $year; ?>" <?php if ($year == $y) echo "selected"; ?>><?php
                									echo $year ?>
                								</option><?php

                							} ?>

                						</select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="q" class="col-sm-2 col-form-label">Nama Pegawai</label>
                                    <div class="col-sm-5">
                                        <select class="cariPegawai form-control form-control-sm select2" name="q">
                							<option></option><?php

                                                foreach ($pegawai as $k=>$val)
                                                {
                                                    if ($val['nip_baru'] == $xusername)
                                                    { ?>
                                                        <option value="<?php echo $val['nip_baru']; ?>" <?php if ($val['nip_baru'] == $q) echo "selected"; ?>><?php echo $val['nama']; ?></option><?php
                                                    }
                                                } ?>

                						</select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ok" class="col-sm-2 col-form-label">&nbsp;</label>
                                    <div class="col-sm-5">
                                        <button type="submit" class="btn btn-primary">OK</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <br>
                        <div class="row">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                        				<th width="3%">#</th>
                        				<th width="8%">Tanggal</th>
                        				<th width="12%">Status</th>
                        				<th width="8%">Jam</th>
                        				<th width="8%">Kekurangan<br />(menit)</th>
                        				<th width="8%">Alasan</th>
                        				<th width="8%">Potongan<br />Tunjangan Kinerja</th>
                        				<th width="8%">Flexi Time</th>
                        				<th>Keterangan</th>
                        				<th width="8%">File Bukti</th>
                        				<th width="10%">Aksi</th>
                        			</tr>
                                </thead>
                                <tbody><?php

                                    if ($col['n_data'] == 0)
                                    { ?>
                                        <tr>
                                            <td align="center" colspan="11">Tidak ada data!</td>
                                        </tr><?php
                                    }
                                    else
                                    {
                                        $l = 0;
                        				$tanggal = "";
                        				$tot_potongan = 0;
                        				$tlpay = 0;
                                        $mon = $m;

                        				foreach ($col['data']['id'] as $k=>$val)
                        				{
                        					$x = 0; ?>

                        					<tr><?php

                        						if ($tanggal != $col['data']['tanggal'][$k])
                        						{
                        							$l++; ?>

                        							<td align="center" rowspan="<?php echo $col['data']['rowspan'][$k]; ?>"><?php echo $l; ?></td>
                        							<td align="center" rowspan="<?php echo $col['data']['rowspan'][$k]; ?>"><?php echo $col['data']['tanggal'][$k]; ?></td><?php

                        							$x = 1;
                        						} ?>

                        						<td align="center" nowrap="nowrap"><?php

                        							if ($col['data']['status'][$k] == "-") $status = "LIBUR";
                        							else if ($col['data']['status'][$k] == "") $status = "";
                        							else if ($col['data']['status'][$k] == 0)
                        							{
                        								if ($col['data']['hadir'][$k] == 0) $status = "TIDAK HADIR";
                        								else $status = "HADIR";
                        							}
                        							else if ($col['data']['status'][$k] == 1) $status = "DATANG";
                        							else if ($col['data']['status'][$k] > 1 and $col['data']['status'][$k] < 9) $status = "KELUAR SEMENTARA";
                        							else if ($col['data']['status'][$k] == 9) $status = "PULANG";
                        							else $status = "";

                        							echo $status; ?>

                        						</td>
                        						<td align="center"><?php

                        							if ($col['data']['status'][$k] > 1 and $col['data']['status'][$k] < 9)
                        							{
                        								$jam = substr($col['data']['jam'][$k],0,5)." s/d ".substr($col['data']['jam2'][$k],0,5);
                        							}
                        							else $jam = substr($col['data']['jam'][$k],0,5);

                        							echo $jam; ?>

                        						</td>
                        						<td align="right"><?php

                        							if ($col['data']['kekurangan'][$k] > 0)
                        							{ ?>

                        								<font color="#f00"><?php echo $col['data']['kekurangan'][$k] ?></font><?php

                        							}
                        							else echo $col['data']['kekurangan'][$k]; ?>

                        						</td><?php

                        						if ($col['data']['dl_non_sppd'][$k] == 1) $title = "Dinas Luar";
                        						else if ($col['data']['dl_non_sppd2'][$k] == 1) $title = "Dinas Luar";
                        						else if ($col['data']['sakit'][$k] == 1) $title = "Cuti Sakit";
                        						else if ($col['data']['sakit2'][$k] == 1) $title = "Cuti Sakit";
                        						else if ($col['data']['izin'][$k] == 1) $title = "Izin Penting";
                        						else if ($col['data']['izin2'][$k] == 1) $title = "Izin Penting";
                        						else if ($col['data']['tanpa_keterangan'][$k] == 1) $title = "Tidak Hadir";
                        						else if ($col['data']['tugas_belajar'][$k] == 1) $title = "Tugas Belajar";
                        						else if ($col['data']['CT'][$k] == 1) $title = "Cuti Tahunan";
                        						else if ($col['data']['CM'][$k] == 1) $title = "Cuti Hamil";
                        						else if ($col['data']['CP'][$k] == 1) $title = "Cuti Alasan Penting";
                        						else if ($col['data']['CB'][$k] == 1) $title = "Cuti Besar";
                        						else if ($col['data']['TGLuar'][$k] == 1) $title = "Tugas Luar";
                        						else if ($col['data']['TGP'][$k] == 1) $title = "Tugas Pengawasan";
                        						else if ($col['data']['LA'][$k] == 1) $title = "Lupa Absen";
                        						else $title = ""; ?>

                        						<td align="center" title="<?php echo $title; ?>"><?php

                        							if ($col['data']['dl_non_sppd'][$k] == 1) $alasan = "DL";
                        							else if ($col['data']['dl_non_sppd2'][$k] == 1) $alasan = "DL";
                        							else if ($col['data']['sakit'][$k] == 1) $alasan = "CS";
                        							else if ($col['data']['sakit2'][$k] == 1) $alasan = "CS";
                        							else if ($col['data']['izin'][$k] == 1) $alasan = "IP";
                        							else if ($col['data']['izin2'][$k] == 1) $alasan = "IP";
                        							else if ($col['data']['tanpa_keterangan'][$k] == 1) $alasan = "A";
                        							else if ($col['data']['tugas_belajar'][$k] == 1) $alasan = "TB";
                        							else if ($col['data']['CT'][$k] == 1) $alasan = "CT";
                        							else if ($col['data']['CM'][$k] == 1) $alasan = "CH";
                        							else if ($col['data']['CP'][$k] == 1) $alasan = "CP";
                        							else if ($col['data']['CB'][$k] == 1) $alasan = "CB";
                        							else if ($col['data']['TGLuar'][$k] == 1) $alasan = "TGL";
                        							else if ($col['data']['TGP'][$k] == 1) $alasan = "TGP";
                        							else if ($col['data']['LA'][$k] == 1) $alasan = "LA";
                        							else $alasan = "";

                        							echo $alasan; ?>

                        						</td><?php

                        						if ($col['data']['TL1'][$k] == 1) $title = "Terlambat 1 s/d 30 menit";
                        						else if ($col['data']['TL2'][$k] == 1) $title = "Terlambat 31 s/d 60 menit";
                        						else if ($col['data']['TL3'][$k] == 1) $title = "Terlambat 61 s/d 90 menit";
                        						else if ($col['data']['TL4'][$k] == 1) $title = "Terlambat 91 s/d 240 menit";
                        						else if ($col['data']['TL5'][$k] == 1) $title = "Terlambat lebih dari 240 menit";
                        						else if ($col['data']['PSW1'][$k] == 1) $title = "Pulang Sebelum Waktu 1 s/d 30 menit";
                        						else if ($col['data']['PSW2'][$k] == 1) $title = "Pulang Sebelum Waktu 31 s/d 60 menit";
                        						else if ($col['data']['PSW3'][$k] == 1) $title = "Pulang Sebelum Waktu 61 s/d 90 menit";
                        						else if ($col['data']['PSW4'][$k] == 1) $title = "Pulang Sebelum Waktu 91 s/d 240 menit";
                        						else if ($col['data']['PSW5'][$k] == 1) $title = "Pulang Sebelum Waktu lebih dari 240 menit";
                        						else if ($col['data']['DK'][$k] == 1) $title = "Izin Penting";
                        						else if ($col['data']['TK'][$k] == 1) $title = "Tidak Hadir";
                        						else if ($col['data']['TBplus'][$k] == 1) $title = "Tugas Belajar";
                        						else $title = ""; ?>

                        						<td align="center" title="<?php echo $title; ?>"><?php

                        							if ($col['data']['TL1'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">0.5%</font>";
                        								$tot_potongan += 0.5;
                        							}
                        							else if ($col['data']['TL2'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">1%</font>";
                        								$tot_potongan += 1;
                        							}
                        							else if ($col['data']['TL3'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">1.25%</font>";
                        								$tot_potongan += 1.25;
                        							}
                        							else if ($col['data']['TL4'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">2.5%</font>";
                        								$tot_potongan += 2.5;
                        							}
                        							else if ($col['data']['TL5'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">5%</font>";
                        								$tot_potongan += 5;
                        							}
                        							else if ($col['data']['PSW1'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">0.5%</font>";
                        								$tot_potongan += 0.5;
                        							}
                        							else if ($col['data']['PSW2'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">1%</font>";
                        								$tot_potongan += 1;
                        							}
                        							else if ($col['data']['PSW3'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">1.25%</font>";
                        								$tot_potongan += 1.25;
                        							}
                        							else if ($col['data']['PSW4'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">2.5%</font>";
                        								$tot_potongan += 2.5;
                        							}
                        							else if ($col['data']['PSW5'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">5%</font>";
                        								$tot_potongan += 5;
                        							}
                        							else if ($col['data']['DK'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">5%</font>";
                        								$tot_potongan += 5;
                        							}
                        							else if ($col['data']['TK'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">5%</font>";
                        								$tot_potongan += 5;
                        							}
                        							else if ($col['data']['TBplus'][$k] == 1)
                        							{
                        								$potongan = "<font color=\"#f00\">5%</font>";
                        								$tot_potongan += 5;
                        							}
                        							else $potongan = "";

                        							echo $potongan; ?>

                        						</td>
                        						<td align="center"><?php

                        							if ($col['data']['TLPay'][$k] > 0)
                        							{
                        								$tlpay++;

                        								echo $tlpay."x";

                        							} ?>

                        						</td>
                        						<td><?php echo strtoupper($col['data']['keterangan'][$k]); ?></td>
                        						<td><?php

                        							if ($col['data']['file_bukti'][$k] != "-" and $col['data']['file_bukti'][$k] != "")
                        							{ ?>
                        								<a href="<?php echo base_url('presensi/download_file_bukti/'.$col['data']['id'][$k]); ?>"  class="btn btn-primary me-2">File Bukti</a><?php
                        							} ?>

                        						</td>
                        						<td align="center" nowrap="nowrap"><?php

                        							if ($col['data']['ed'][$k] == "#") echo "&nbsp;";
                        							else
                        							{
                        								if ($col['data']['status'][$k] == 0) $z = 1;
                        								else $z = 0; ?>

                        								<a class="thickbox" href="<?php echo base_url()."presensi/ed".$col['data']['ed'][$k] ?>/<?php echo $x; ?>/<?php echo $z; ?>" title="Upload File">
                        									<img src="<?= base_url('images/edit_f2.png'); ?>" border="0" width="16" height="16">&nbsp;Upload File
                        								</a><?php

                        							} ?>

                        						</td>
                        					</tr><?php

                        					$tanggal = $col['data']['tanggal'][$k];
                        				}

                        				$bulan = $y."-".$mon;
                                        $bulan_ini = date("Y-m");

                                        if ($bulan != $bulan_ini) $hari_kerja = $col['data']['hari_kerja'];
                                        else
                                        {
                                            $hari_ini = date("d");
                                            $hari_terakhir = date("t");

                                            $hari_kerja = $col['data']['hari_kerja'] + $hari_ini - $hari_terakhir;
                                        }

                        				$Ket = "Hari Kerja: <font color=\"#f00\">".$hari_kerja."</font><BR>";
                        				$Ket .= "Kehadiran (Uang Makan): <font color=\"#f00\">".$Rekapitulasi['hadir']."</font><br>";

                        				if ($Rekapitulasi['TL1'] != 0) $Ket .= "TL1: <font color=\"#f00\">".$Rekapitulasi['TL1']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TL2'] != 0) $Ket .= "TL2: <font color=\"#f00\">".$Rekapitulasi['TL2']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TL3'] != 0) $Ket .= "TL3: <font color=\"#f00\">".$Rekapitulasi['TL3']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TL4'] != 0) $Ket .= "TL4: <font color=\"#f00\">".$Rekapitulasi['TL4']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TL5'] != 0) $Ket .= "TL5: <font color=\"#f00\">".$Rekapitulasi['TL5']."</font>  &nbsp;";
                        				if ($Rekapitulasi['PSW1'] != 0) $Ket .= "PSW1: <font color=\"#f00\">".$Rekapitulasi['PSW1']."</font>  &nbsp;";
                        				if ($Rekapitulasi['PSW2'] != 0) $Ket .= "PSW2: <font color=\"#f00\">".$Rekapitulasi['PSW2']."</font>  &nbsp;";
                        				if ($Rekapitulasi['PSW3'] != 0) $Ket .= "PSW3: <font color=\"#f00\">".$Rekapitulasi['PSW3']."</font>  &nbsp;";
                        				if ($Rekapitulasi['PSW4'] != 0) $Ket .= "PSW4: <font color=\"#f00\">".$Rekapitulasi['PSW4']."</font>  &nbsp;";
                        				if ($Rekapitulasi['PSW5'] != 0) $Ket .= "PSW5: <font color=\"#f00\">".$Rekapitulasi['PSW5']."</font>  &nbsp;";

                        				//$Ket .= "]<BR>";
                        				$Ket .= "Tidak Hadir: <font color=\"#f00\">".($hari_kerja - $Rekapitulasi['hadir'])."</font> &nbsp;[&nbsp;";

                        				if ($Rekapitulasi['dl_non_sppd'] != 0) $Ket .= "DL: <font color=\"#f00\">".$Rekapitulasi['dl_non_sppd']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TBplus'] != 0) $Ket .= "TB: <font color=\"#f00\">".$Rekapitulasi['TBplus']."</font>  &nbsp;";
                        				if ($Rekapitulasi['CT'] != 0) $Ket .= "CT: <font color=\"#f00\">".$Rekapitulasi['CT']."</font>  &nbsp;";
                        				if ($Rekapitulasi['CB'] != 0) $Ket .= "CB: <font color=\"#f00\">".$Rekapitulasi['CB']."</font>  &nbsp;";
                        				if ($Rekapitulasi['CSRJ'] != 0) $Ket .= "CS: <font color=\"#f00\">".$Rekapitulasi['CSRJ']."</font>  &nbsp;";
                        				if ($Rekapitulasi['CM'] != 0) $Ket .= "CH: <font color=\"#f00\">".$Rekapitulasi['CM']."</font>  &nbsp;";
                        				if ($Rekapitulasi['CP'] != 0) $Ket .= "CP: <font color=\"#f00\">".$Rekapitulasi['CP']."</font>  &nbsp;";
                        				if ($Rekapitulasi['DK'] != 0) $Ket .= "IP: <font color=\"#f00\">".$Rekapitulasi['DK']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TK'] != 0) $Ket .= "A: <font color=\"#f00\">".$Rekapitulasi['TK']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TGLuar'] != 0) $Ket .= "TGL: <font color=\"#f00\">".$Rekapitulasi['TGLuar']."</font>  &nbsp;";
                        				if ($Rekapitulasi['TGP'] != 0) $Ket .= "TGP: <font color=\"#f00\">".$Rekapitulasi['TGP']."</font>  &nbsp;";
                        				// if ($Rekapitulasi['LA'] != 0) $Ket .= "LA: <font color=\"#f00\">".$Rekapitulasi['LA']."</font>  &nbsp;";

                        				$Ket .= "]<BR>";

                        				$Ket .= "Total Potongan: <font color=\"#f00\">".$tot_potongan."%</font><BR>";

                        				// $rekapitulasi_total = rekapitulasi_total($q,$u,$bulan); //echo $q." - ".$u." - ".$bulan;
                        				//$Ket.= "Akumulasi Kekurangan: <font color=\"#f00\">".$rekapitulasi_total."</font><BR>";

                        				#$sanksi = get_sanksi($rekapitulasi_total);
                        				#if ($sanksi != "") $Ket .= "Sanksi: <font color=\"#f00\">".$sanksi."</font><BR>"; ?>

                        				<tr class="row0">
                        					<td colspan="4" align="right"><b><?php echo $pegawai_by_nip['nama']; ?></b></td>
                        					<td align="right"><font color="#f00"><b><?php echo $Rekapitulasi['kekurangan']; ?></b></font></td>
                        					<td colspan="6"><b><?php echo $Ket; ?></b></td>
                        				</tr><?php
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="realtime" class="tab-pane fade">
            <div class="container mt-3">
                <div class="row">
                    <!-- Konten Utama -->
                    <div class="col-8">
                        <div class="row">
                            <hr>
                            <form action="<?php echo base_url("presensi"); ?>" method="post">
                                <div class="form-group row">
                                    <label for="m" class="col-sm-2 col-form-label">Bulan</label>
                                    <div class="col-sm-2">
                                        <select class="form-control form-control-sm" name="m">
                                            <option></option><?php

                                            $nama_bulan = array(
                                                "0" => "",
                                                "1" => "Januari",
                                                "2" => "Februari",
                                                "3" => "Maret",
                                                "4" => "April",
                                                "5" => "Mei",
                                                "6" => "Juni",
                                                "7" => "Juli",
                                                "8" => "Agustus",
                                                "9" => "September",
                                                "10" => "Oktober",
                                                "11" => "Nopember",
                                                "12" => "Desember",
                                            );

                							for ($month = 1; $month <= 12; $month++)
                							{ ?>

                								<option value="<?php echo $month; ?>" <?php if ($month == $m) echo "selected"; ?>><?php
                									echo $nama_bulan[$month]; ?>
                								</option><?php

                							} ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select class="form-control form-control-sm" name="y">
                							<option></option><?php

                							for ($year = date("Y") - 5; $year <= date("Y") + 1; $year++)
                							{ ?>

                								<option value="<?php echo $year; ?>" <?php if ($year == $y) echo "selected"; ?>><?php
                									echo $year ?>
                								</option><?php

                							} ?>

                						</select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="q" class="col-sm-2 col-form-label">Nama Pegawai</label>
                                    <div class="col-sm-5">
                                        <select class="cariPegawai form-control form-control-sm select2" name="q">
                							<option></option><?php

                                                foreach ($pegawai as $k=>$val)
                                                {
                                                    if ($val['nip_baru'] == $xusername)
                                                    { ?>
                                                        <option value="<?php echo $val['nip_baru']; ?>" <?php if ($val['nip_baru'] == $q) echo "selected"; ?>><?php echo $val['nama']; ?></option><?php
                                                    }
                                                } ?>

                						</select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ok" class="col-sm-2 col-form-label">&nbsp;</label>
                                    <div class="col-sm-5">
                                        <button type="submit" class="btn btn-primary">OK</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="3%">No.</th>
                                        <th width="8%">Tanggal</th>
                                        <th width="8%">Jam</th>
                                    </tr>
                                </thead>
                                <tbody><?php

                                    if (array_key_exists('checktime', $realtime))
                                    {
                                        $r = 1;

                                        foreach ($realtime as $vreal)
                                        { ?>
                                            <tr>
                                                <td align="center"><?php echo $r; ?></td>
                                                <td align="center"><?php echo substr($vreal['checktime'], 0, 10); ?></td>
                                                <td align="center"><?php echo substr($vreal['checktime'], 11, 8); ?></td>
                                            </tr><?php

                                            $r++;
                                        }
                                    }
                                    else
                                    { ?>
                                        <tr>
                                            <td align="center" colspan="3">Tidak ada data</td>
                                        </tr><?php
                                    } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
      $('.cariPegawai').select2({
        placeholder: '--- Cari Pegawai ---',
      });
</script>
<script>
	var halamanbaru;

	function poptastic(url)
	{
		halamanbaru=window.open(url,'Surat','height=600,width=800');
		if (window.focus) {halamanbaru.focus()}
	}
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
<script>

    const d = new Date();
    let year = d.getFullYear();
    let month = d.getMonth() + 1;
    let nip = document.getElementById("nip").value;
    // Chart
    const options = {
      chart: {
        type: 'pie',
        events: {
            load: getData(nip, year, month)
        }
      },
      title: {
        text: 'Kehadiran'
      },
      tooltip: {
          valueSuffix: '%'
      },
      plotOptions: {
          series: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: [{
                  enabled: true,
                  distance: 20
              }, {
                  enabled: true,
                  distance: -40,
                  format: '{point.percentage:.1f}%',
                  style: {
                      fontSize: '1.2em',
                      textOutline: 'none',
                      opacity: 0.7
                  },
                  filter: {
                      operator: '>',
                      property: 'percentage',
                      value: 10
                  }
              }]
          }
      },
      series: [
        {
            name:'Persentase',
            colorByPoint: true,
            data:[]
        }
      ]
    };

    const options2 = {
      chart: {
        type: 'pie',
        events: {
            load: getData2(nip, year, month)
        }
      },
      title: {
        text: 'Kekurangan Jam Kerja'
      },
      tooltip: {
          valueSuffix: '%'
      },
      plotOptions: {
          series: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: [{
                  enabled: true,
                  distance: 20
              }, {
                  enabled: true,
                  distance: -40,
                  format: '{point.percentage:.1f}%',
                  style: {
                      fontSize: '1.2em',
                      textOutline: 'none',
                      opacity: 0.7
                  },
                  filter: {
                      operator: '>',
                      property: 'percentage',
                      value: 10
                  }
              }]
          }
      },
      series: [
        {
            name:'Persentase',
            colorByPoint: true,
            data:[]
        }
      ]
    };

    const chart = Highcharts.chart('container', options)
    const chart2 = Highcharts.chart('container2', options2)

    // Data
    $("#nip, #tahun, #bulan").change(function(){
        const nip = $("#nip").val();
        const thn = $("#tahun").val();
        const bln = $("#bulan").val();

        getData(nip, thn, bln);
        getData2(nip, thn, bln);
    })

    function getData(nip, tahun, bulan) {
        const url = `/sinerghi/public/presensi/infografis_kehadiran/${nip}/${tahun}/${bulan}`;

        $.getJSON(url, function(p) {

            chart.series[0].update({
                data:p
            })
            chart.redraw();
        })
    }

    function getData2(nip, tahun, bulan) {
        const url = `/sinerghi/public/presensi/infografis_kekurangan/${nip}/${tahun}/${bulan}`;

        $.getJSON(url, function(p) {

            chart2.series[0].update({
                data:p
            })
            chart2.redraw();
        })
    }
</script>
<?= $this->endSection(); ?>
