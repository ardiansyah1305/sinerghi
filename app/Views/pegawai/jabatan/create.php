<form action="<?= site_url('pegawai/jabatan/store'); ?>" method="post" enctype="multipart/form-data" id="jabatanForm" class="needs-validation" novalidate>
    <?= csrf_field(); ?>

	<div class="modal-body">
        	<div class="form-group mb-3">
        <label for="nama_jabatan">Nama Jabatan
            <span class="fs-5 text-danger">*</span>
        </label>
        <input type="text" id="cnama_jabatan" name="nama_jabatan" class="form-control">
        <div id="cnama_jabatan_error" class="invalid-feedback">
            Kolom Nama Jabatan tidak boleh kosong.
        </div>
        <div id="cnama_jabatan_error_invalid" class="invalid-feedback">
            Nama Jabatan hanya boleh berisi huruf dan tanda koma.
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="eselon">Eselon <br>
            <small class="text-muted fst-italic">Apabila jabatan merupakan Eselon, silakan pilih jenis Eselon</small>
        </label>
        <select name="eselon" id="eselon" class="form-select">
            <option value="" selected disabled>-- Pilih Eselon --</option>
            <?php foreach ($eselons as $eselon): ?>
                <option value="<?= $eselon['kode']; ?>"><?= esc($eselon['nama_eselon']); ?></option>
            <?php endforeach; ?>
        </select>
        <!-- <div id="eselon_error" class="invalid-feedback">
            Pilih Eselon terlebih dahulu
        </div> -->
    </div>

    	<label for="jabatanradio">
            Tipe Jabatan: <br>
            <small class="text-muted fst-italic">Apabila jabatan bukan Eselon, silakan salah satu pilih tipe Jabatan berikut.</small>
        </label>

        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="jabatanradio" id="fungsional" value="fungsional">
            <label class="form-check-label" for="fungsional">
                Fungsional
            </label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="jabatanradio" id="is_pelaksana" value="pelaksana">
            <label class="form-check-label" for="is_pelaksana">
                Pelaksana
            </label>          
        </div>

        <div class="form-check mb-3">           
            <input class="form-check-input" type="radio" name="jabatanradio" id="is_pppk" value="pppk">
            <label class="form-check-label" for="is_pppk">
                PPPK
            </label>
        </div>

        <div class="form-check mb-3">    
            <input class="form-check-input" type="radio" name="jabatanradio" id="is_non_asn" value="non_asn">
            <label class="form-check-label" for="is_non_asn">
                Non ASN
            </label>        
        </div>	  
</div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success fw-semibold" style="margin-right: 22px;">Simpan</button>
    </div>
</form>
