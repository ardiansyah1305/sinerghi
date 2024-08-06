<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi Kemenko PMK</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <!-- Tambahkan stylesheet OrgChartJS -->
    <link rel="stylesheet" href="<?= base_url('css/orgchart.css'); ?>">
    <script src="<?= base_url('js/orgchart.js'); ?>"></script>
    <style>
        #tree {
            width: 100%;
            height: 100%;
        }

        .node.red rect {
            fill: grey;
        }

        [data-l-id] path {
            stroke: grey;
        }

        [data-ctrl-n-menu-id] rect:hover~circle {
            fill: white;
        }

        #tree>svg {
            background-color: #ffffff;
        }

        [data-id='search'] {
            display: block !important;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
        }

        .modal.show {
            display: block;
            opacity: 1;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            box-sizing: border-box;
            position: relative;
            transition: transform 0.3s ease-in-out;
            transform: translateY(-20px);
        }

        .modal.show .modal-content {
            transform: translateY(0);
        }

        .modal-content p {
            font-weight: bold;
            font-size: 16px;
        }

        .modal-content img {
            display: block;
            margin: 10px auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .close {
            color: #aaa;
            position: absolute;
            top: -5px;
            right: 10px;
            font-size: 38px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Media queries for responsive modal */
        @media (max-width: 600px) {
            .modal-content {
                width: 90%;
                padding: 15px;
            }

            .close {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="org-title">Struktur Organisasi Kemenko PMK</h1>
        <div id="tree"></div>
    </div>

    <!-- Modal HTML -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalName"></h2>
            <img id="modalImg" src="" alt="Profile Image">
            <p id="modalNamaPejabat"></p>
            <p id="modalTitle"></p>
            <p id="modalEmail"></p>
            <p id="modalNIP"></p>
        </div>
    </div>

    <script>
        // JavaScript untuk OrgChart
        var chart = new OrgChart(document.getElementById("tree"), {
            template: "ula",
            enableSearch: false,
            mouseScrool: OrgChart.action.none,
            nodeBinding: {
                field_0: "name",
                img_0: "img"
            },
            nodes: [{
                    id: 1,
                    name: "Deputi I",
                    title: "Deputi Bidang Koordinasi Peningkatan Kesejahteraan Sosial",
                    img: "images/deputi-1.png"
                },
                {
                    id: 2,
                    pid: 1,
                    name: "Sekretaris Deputi Bidang Koordinasi Peningkatan Kesejahteraan Sosial",
                    namapejabat: "test",
                    title: "Lorem ipsum",
                    email: "sekretaris.deputi1@kemenko.go.id",
                    nip: "123456780",
                    img: "images/menko.png"
                },
                {
                    id: 3,
                    pid: 1,
                    name: "Asisten Deputi Penanganan Kemiskinan",
                    namapejabat: "test",
                    title: "Lorem ipsum",
                    email: "asdep.kemiskinan@kemenko.go.id",
                    nip: "123456781",
                    img: "images/menko.png"
                },
                {
                    id: 4,
                    pid: 1,
                    name: "Deputi Bidang Koordinasi Peningkatan Kesejahteraan Sosial",
                    namapejabat: "test",
                    title: "Lorem ipsum",
                    email: "deputi2@kemenko.go.id",
                    nip: "123456782",
                    img: "images/menko.png"
                },
                {
                    id: 5,
                    pid: 1,
                    name: "Asisten Deputi Jaminan Sosial",
                    namapejabat: "test",
                    title: "Lorem ipsum",
                    email: "asdep.jamsos@kemenko.go.id",
                    nip: "123456783",
                    img: "images/menko.png"
                },
                {
                    id: 6,
                    pid: 1,
                    name: "Asisten Deputi Bantuan dan Subsidi Tepat Sasaran",
                    namapejabat: "test",
                    title: "Lorem ipsum",
                    email: "asdep.bantuan@kemenko.go.id",
                    nip: "123456784",
                    img: "images/menko.png"
                },
                {
                    id: 7,
                    pid: 1,
                    name: "Asisten Deputi Pemberdayaan Disabilitas dan Lanjut Usia",
                    namapejabat: "test",
                    title: "Lorem ipsum",
                    email: "asdep.disabilitas@kemenko.go.id",
                    nip: "123456785",
                    img: "images/menko.png"
                }
            ]
        });

        // JavaScript untuk Modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];

        // Ketika user mengklik span (x), tutup modal
        span.onclick = function() {
            modal.classList.remove('show');
            setTimeout(function() {
                modal.style.display = "none";
            }, 300); // Sesuaikan dengan durasi transition pada CSS
        }

        // Ketika user mengklik di luar modal, tutup modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.remove('show');
                setTimeout(function() {
                    modal.style.display = "none";
                }, 300); // Sesuaikan dengan durasi transition pada CSS
            }
        }

        // Tambahkan event listener untuk klik node
        chart.on('click', function(sender, args) {
            var nodeData = sender.get(args.node.id);

            // Update konten modal
            document.getElementById("modalName").textContent = "" + nodeData.name;
            document.getElementById("modalImg").src = nodeData.img;


            if (nodeData.id === 1) {
                document.getElementById("modalNamaPejabat").style.display = "none";
                document.getElementById("modalTitle").style.display = "block";
                document.getElementById("modalEmail").style.display = "none";
                document.getElementById("modalNIP").style.display = "none";

                document.getElementById("modalTitle").textContent = "" + nodeData.title;

            } else {
                document.getElementById("modalNamaPejabat").style.display = "block";
                document.getElementById("modalTitle").style.display = "block";
                document.getElementById("modalEmail").style.display = "block";
                document.getElementById("modalNIP").style.display = "block";

                document.getElementById("modalNamaPejabat").textContent = "Nama: " + nodeData.namapejabat;
                document.getElementById("modalTitle").textContent = "Jabatan: " + nodeData.title;
                document.getElementById("modalEmail").textContent = "Email: " + nodeData.email;
                document.getElementById("modalNIP").textContent = "NIP: " + nodeData.nip;
            }

            // Tampilkan modal
            modal.style.display = "block";
            setTimeout(function() {
                modal.classList.add('show');
            }, 10); // Sesuaikan dengan durasi transition pada CSS

            // Prevent default click behavior
            return false;
        });

        // Menyesuaikan lebar node berdasarkan panjang teks
        chart.on('redraw', function() {
            chart.nodes.forEach(node => {
                var el = document.querySelector(`[data-n-id='${node.id}']`);
                var name = node.data.name;
                var width = (name.length * 8) + 100; // Adjust multiplier and base value as needed
                el.style.width = width + 'px';
            });
        });
    </script>
</body>

</html>

<?= $this->endSection() ?>