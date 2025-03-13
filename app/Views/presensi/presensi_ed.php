<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<div class="container mt-4">
    <div class="row">
        <!-- Konten Utama -->
        <div class="col-12">
            <div class="row">
                <form action="<?php echo base_url("presensi/store"); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-3">
                            <input type="text" name="nip_baru" class="form-control form-control-sm" value="<?php echo $presensi_by_id['nip']; ?>" readonly>
                            <input type="hidden" name="nip" value="<?php echo $presensi_by_id['nip']; ?>">
                            <input type="hidden" name="xusername" value="<?php echo $xusername; ?>">
                            <input type="hidden" name="status_verifikasi" value="<?php echo $presensi_by_id['status_verifikasi']; ?>">
                            <input type="hidden" name="q" value="<?php echo $q; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-3">
                            <input type="text" name="nama" class="form-control form-control-sm" value="<?php echo $pegawai_by_nip['nama']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-3">
                            <input type="text" name="tanggal" class="form-control form-control-sm" value="<?php echo $presensi_by_id['tanggal']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">Jam</label>
                        <div class="col-sm-3">
                            <input type="text" name="jam" class="form-control form-control-sm" value="<?php echo $presensi_by_id['jam']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">Kekurangan</label>
                        <div class="col-sm-3">
                            <input type="text" name="kekurangan" class="form-control form-control-sm" value="<?php echo $presensi_by_id['kekurangan']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-3"><?php

                            $arr_status = array("0" => "",  "1" => "Datang", "9" => "Pulang");
                            $status = $presensi_by_id['status']; ?>

                            <input type="text" name="nama_status" class="form-control form-control-sm" value="<?php echo $arr_status[$status]; ?>" readonly>
                            <input type="hidden" name="status" value="<?php echo $status; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-3">
                            <textarea name="keterangan" class="form-control form-control-sm" <?php if ($presensi_by_id['status_verifikasi'] == "1") echo "readonly=\"readonly\""; ?>><?php echo $presensi_by_id['keterangan']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="m" class="col-sm-2 col-form-label">File Bukti</label>
                        <div class="col-sm-3">
                            <input type="file" name="file_bukti" class="form-control form-control-sm" <?php if ($presensi_by_id['status_verifikasi'] == "1") echo "disabled=\"disabled\""; ?>>
                        </div>
                    </div><br>
                    <div class="form-group row">
                        <label for="ok" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-5">
                            <a href="<?php echo base_url('presensi'); ?>" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
      $('.cariPegawai').select2({
        placeholder: '--- Cari Pegawai ---',
      });
</script>
<?= $this->endSection(); ?>
