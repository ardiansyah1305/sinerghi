document.addEventListener('DOMContentLoaded', function () {
    const popupBackground = document.getElementById('popupBackground');
    const popup = document.getElementById('popup');
    const closePopup = document.getElementById('closePopup');
    const closePopupButton = document.getElementById('closePopupButton');

    function showPopup() {
        popupBackground.classList.add('show');
        popup.classList.add('show');
    }

    function hidePopup() {
        popupBackground.classList.remove('show');
        popup.classList.remove('show');
    }

    closePopup.addEventListener('click', hidePopup);
    closePopupButton.addEventListener('click', hidePopup);
    popupBackground.addEventListener('click', hidePopup);

    // Menampilkan pop-up setelah 2 detik halaman dimuat
    setTimeout(showPopup, 2000);

    // Mengaktifkan carousel otomatis
    $('#popupCarousel').carousel({
        interval: 2000 // Mengatur interval slide (dalam milidetik)
    });
});
