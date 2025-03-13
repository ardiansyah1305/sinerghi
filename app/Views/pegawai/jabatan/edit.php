<form action="<?= site_url('pegawai/jabatan/update/' . $jabatan['id']); ?>" method="post" enctype="multipart/form-data" id="editjabatanForm" class="needs-validation" novalidate>
    <?= csrf_field(); ?>

	<div class="modal-body">
        	<div class="form-group mb-3">
        <label for="nama_jabatan">Nama Jabatan</label>
        <input type="text" name="nama_jabatan" class="form-control" id="enama_jabatan" value="<?= esc($jabatan['nama_jabatan']); ?>">
        <div id="enama_jabatan_error" class="invalid-feedback">
            Kolom Nama Jabatan tidak boleh kosong.
        </div>
        <div id="enama_jabatan_error_invalid" class="invalid-feedback">
            Nama Jabatan hanya boleh berisi huruf dan tanda koma.
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="eselon">Eselon <br>
		<small class="text-muted fst-italic">Apabila jabatan merupakan Eselon, silakan pilih jenis Eselon</small>
	</label>
        <select name="eselon" class="form-select" id="eselon">
            <option value="" selected disabled>-- Pilih Eselon --</option>
            <?php foreach ($eselons as $eselon): ?>
                <option value="<?= $eselon['kode']; ?>" <?= $jabatan['eselon'] === $eselon['kode'] ? 'selected' : ''; ?>>
                    <?= esc($eselon['nama_eselon']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- <div id="edit_eselon_error" class="invalid-feedback">
            Pilih Eselon terlebih dahulu.
        </div> -->
    </div>

    <label for="jabatanradio">
            Tipe Jabatan: <br>
            <small class="text-muted fst-italic">Apabila jabatan bukan Eselon, silakan salah satu pilih tipe Jabatan berikut.</small>
        </label>
        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="jabatanradio" id="fungsional" value="fungsional" 
                <?= $jabatan['is_fungsional'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="fungsional">
                Fungsional
            </label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="jabatanradio" id="is_pelaksana" value="pelaksana" 
                <?= $jabatan['is_pelaksana'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_pelaksana">
                Pelaksana
            </label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="jabatanradio" id="is_pppk" value="pppk" 
                <?= $jabatan['is_pppk'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_pppk">
                PPPK
            </label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="jabatanradio" id="is_non_asn" value="non_asn" 
                <?= $jabatan['is_non_asn'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_non_asn">
                Non ASN
            </label>
        </div>
</div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning fw-semibold" style="margin-right: 22px;">Simpan</button>
    </div>

</form>


