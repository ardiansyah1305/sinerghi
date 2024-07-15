document.getElementById('closePopup').addEventListener('click', function () {
    closePopup();
});

document.getElementById('popupBackground').addEventListener('click', function () {
    closePopup();
});

var slideIndex = 0;
var slides = document.getElementsByClassName("carousel-slide");
var slideInterval;

function showSlides(n) {
    if (n >= slides.length) {
        slideIndex = 0;
    }
    if (n < 0) {
        slideIndex = slides.length - 1;
    }
    for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex].style.display = "block";
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('popupBackground').style.display = 'none';
    clearInterval(slideInterval);
}

function startSlideShow() {
    slideInterval = setInterval(function () {
        showSlides(slideIndex += 1);
    }, 3000); // Slide akan berubah setiap 3 detik
}

document.getElementById('prevSlide').addEventListener('click', function () {
    showSlides(slideIndex -= 1);
});

document.getElementById('nextSlide').addEventListener('click', function () {
    showSlides(slideIndex += 1);
});

for (var i = 0; i < slides.length; i++) {
    slides[i].addEventListener('click', function () {
        closePopup();
    });

    slides[i].addEventListener('mouseover', function () {
        clearInterval(slideInterval);
    });

    slides[i].addEventListener('mouseout', function () {
        startSlideShow();
    });
}

showSlides(slideIndex);
startSlideShow();

// Tampilkan pop-up saat halaman dimuat
window.onload = function () {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('popupBackground').style.display = 'block';
};

// Menambahkan event listener untuk gambar popup-trigger
document.addEventListener('DOMContentLoaded', function () {
    var popupTriggers = document.querySelectorAll('.popup-trigger');
    popupTriggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var sectionId = trigger.getAttribute('data-section');
            document.querySelector(sectionId).scrollIntoView({ behavior: 'smooth' });
            document.getElementById('popup').style.display = 'block';
            document.getElementById('popupBackground').style.display = 'block';
        });
    });
});
