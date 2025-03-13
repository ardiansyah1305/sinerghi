<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi Kemenko PMK</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .org-title {
            text-align: center;
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .org-info {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .org-info img {
            width: 200px;
            height: 200px;
            margin-right: 40px;
            border: 1px solid #ccc;
            padding: 10px;
            object-fit: cover;
            border-radius: 8px;
        }

        .org-info div {
            max-width: 700px;
        }

        .org-info h2 {
            margin: 0;
            color: #2980b9;
            font-size: 28px;
            font-weight: bold;
        }

        .org-info p {
            color: #2c3e50;
            font-size: 18px;
            line-height: 1.6;
            margin-top: 20px;
        }

        .carousel {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
            overflow: hidden;
            position: relative;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.3s ease;
        }

        .carousel img {
            width: 150px;
            height: 150px;
            margin: 0 10px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s;
            user-select: none;
            pointer-events: none;
        }

        .carousel img:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .org-info {
                flex-direction: column;
                text-align: center;
            }

            .org-info img {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .org-info div {
                max-width: 100%;
            }

            .org-info h2 {
                font-size: 24px;
            }

            .org-info p {
                font-size: 16px;
            }

            .carousel img {
                width: 120px;
                height: 120px;
                margin: 0 5px;
            }
        }

        @media (max-width: 480px) {
            .org-title {
                font-size: 24px;
            }

            .org-info h2 {
                font-size: 20px;
            }

            .org-info p {
                font-size: 14px;
            }

            .carousel img {
                width: 100px;
                height: 100px;
                margin: 0 3px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="org-title">Struktur Organisasi Kemenko PMK</h1>
        <div class="org-info">
            <img src="images/andie_megantara.png" alt="FOTO MENKO PMK">
            <div>
                <h2>Menteri Koordinator Bidang Manusia dan Kebudayaan</h2>
                <p>Prof. Dr. Muhadjir Effendy, M.A.P. adalah Menteri Koordinator Bidang Pembangunan Manusia dan Kebudayaan sejak 23 Oktober 2019 pada Kabinet Indonesia Maju Jokowi-Ma'ruf Amin. Beliau lahir di Madiun, tanggal 29 Juli 1956.</p>
            </div>
        </div>
        <div class="carousel">
            <div class="carousel-track">
                <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
            </div>
        </div>
    </div>

    <script>
        const carouselTrack = document.querySelector('.carousel-track');
        const images = document.querySelectorAll('.carousel img');
        let currentIndex = 0;
        let isDragging = false;
        let startPos = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;
        let animationID;
        let imageWidth = images[0].getBoundingClientRect().width;

        function setPositionByIndex() {
            currentTranslate = currentIndex * -imageWidth;
            prevTranslate = currentTranslate;
            setSliderPosition();
        }

        function setSliderPosition() {
            carouselTrack.style.transform = `translateX(${currentTranslate}px)`;
        }

        function animation() {
            setSliderPosition();
            if (isDragging) requestAnimationFrame(animation);
        }

        function touchStart(index) {
            return function(event) {
                currentIndex = index;
                startPos = event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
                isDragging = true;
                animationID = requestAnimationFrame(animation);
                carouselTrack.classList.add('grabbing');
            }
        }

        function touchMove(event) {
            if (isDragging) {
                const currentPosition = event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
                currentTranslate = prevTranslate + currentPosition - startPos;
            }
        }

        function touchEnd() {
            isDragging = false;
            cancelAnimationFrame(animationID);
            carouselTrack.classList.remove('grabbing');

            const movedBy = currentTranslate - prevTranslate;

            if (movedBy < -100 && currentIndex < images.length - 1) currentIndex += 1;

            if (movedBy > 100 && currentIndex > 0) currentIndex -= 1;

            setPositionByIndex();
        }

        function autoSlide() {
            currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
            setPositionByIndex();
        }

        images.forEach((image, index) => {
            const touchStartHandler = touchStart(index);
            image.addEventListener('dragstart', (e) => e.preventDefault());
            image.addEventListener('touchstart', touchStartHandler);
            image.addEventListener('touchmove', touchMove);
            image.addEventListener('touchend', touchEnd);
            image.addEventListener('mousedown', touchStartHandler);
            image.addEventListener('mousemove', touchMove);
            image.addEventListener('mouseup', touchEnd);
            image.addEventListener('mouseleave', touchEnd);
        });

        setInterval(autoSlide, 3000);

        window.addEventListener('resize', () => {
            imageWidth = images[0].getBoundingClientRect().width;
            setPositionByIndex();
        });

        setPositionByIndex();
    </script>
</body>

</html>

<?= $this->endSection() ?>