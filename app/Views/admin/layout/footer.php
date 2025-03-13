
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; SINERGHI 2024</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

<!-- Scroll to Top Button-->
<button type="button" class="btn btn-secondary btn-scroll-top" id="scrollTopButton">
    <i class="bi bi-arrow-up-circle"></i>
</button>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keluar</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body fs-5 text-center">
                <div class="font-size-custom text-danger text-center"><i class="bi bi-exclamation-circle fs-1"></i></div>
                <div class="text-center fs-5">Apakah Anda ingin keluar?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                <a class="btn btn-danger" href="<?= site_url('logout'); ?>">Keluar</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<!-- Bahasa Indonesia untuk FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Core plugin JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('js/sb-admin-2.min.js'); ?>"></script>

<!-- <script>
        $(document).ready(function() {
            $('.toggle-calendar').on('change', function() {
                let pegawaiId = $(this).data('id');
                $('#calendar-container-' + pegawaiId).toggle(this.checked);
            });

            $('.calendar').each(function() {
                let calendarEl = this;
                let calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    locale: 'id',
                    select: function(info) {
                        let event = calendar.getEventById(info.startStr);
                        if (event) {
                            event.remove();
                        } else {
                            calendar.addEvent({ id: info.startStr, title: '✅ Jadwal', start: info.startStr });
                        }
                    }
                });
                calendar.render();
            });
        });
    </script> -->