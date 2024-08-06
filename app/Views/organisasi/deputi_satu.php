<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* Change node border and text color to black */
        .node rect {
            stroke: grey !important;
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

        /* Table styling */
        .modal-content table {
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: auto;
        }

        .modal-content th,
        .modal-content td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            width: auto;
        }

        /* Add space between NIP and table */
        #modalNIP {
            margin-bottom: 20px;
        }

        .member-button {
            width: 100%;
            padding: 8px;
            text-align: left;
            border: none;
            border-radius: 5px;
            background: none;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .member-button:hover {
            background-color: #4c94af;
            color: white;
        }

        /* Ensure consistency between modals */
        .modal-content.member-modal-content {
            margin: 5% auto;
            /* Adjust this value to move the modal to the left */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            box-sizing: border-box;
        }

        /* Separator styling */
        .separator {
            border-top: 1px solid #ddd;
            margin: 12px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="org-title">DEPUTI BIDANG KOORDINASI PENINGKATAN KESEJAHTERAAN SOSIAL (Deputi-I)</h1>
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
            <div class="separator"></div> <!-- Separator added here -->
            <div id="modalTeam"></div>
        </div>
    </div>

    <!-- Second Modal HTML for Team Members -->
    <div id="memberModal" class="modal">
        <div class="modal-content member-modal-content">
            <span class="close" id="closeMemberModal">&times;</span>
            <h2 id="memberName"></h2>
            <img id="memberImg" src="" alt="Profile Image">
            <p id="memberEmail"></p>
            <p id="memberNIP"></p>
            <p id="memberFungsional"></p>
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
                    name: "Deputi Bidang Koordinasi Peningkatan Kesejahteraan Sosial",
                    title: "Deputi Bidang Koordinasi Peningkatan Kesejahteraan Sosial",
                    namapejabat: "R. Nunung Nuryartono",
                    email: "deputi2@kemenko.go.id",
                    nip: "123456782",
                    img: "images/nunung-nuryartono.jpg",
                    team: []
                },
                {
                    id: 2,
                    pid: 1,
                    name: "Sekretaris Deputi Bidang Koordinasi Peningkatan Kesejahteraan Sosial",
                    namapejabat: "Ade Rustama",
                    title: "Lorem ipsum",
                    email: "sekretaris.deputi1@kemenko.go.id",
                    nip: "196407231990021001",
                    img: "images/ade-rustama.jpg",
                    teamMembers: [{
                            name: "Erik Dito Tampubolon",
                            email: "erik.dito@kemenko.go.id",
                            nip: "123456789",
                            img: "images/erik.png",
                            fungsional: "Perancang Perundang-undangan Muda"
                        },
                        {
                            name: "Erik",
                            email: "erik@kemenko.go.id",
                            nip: "123456788",
                            img: "images/erik.png",
                            fungsional: "Analis Hukum Muda"
                        },
                        {
                            name: "Dito",
                            email: "erik@kemenko.go.id",
                            nip: "123456788",
                            img: "images/erik.png",
                            fungsional: "Analis Hukum Muda"
                        }
                    ]
                },
                {
                    id: 3,
                    pid: 1,
                    name: "Asisten Deputi Penanganan Kemiskinan",
                    namapejabat: "Katiman",
                    title: "Lorem ipsum",
                    email: "sekretaris.deputi1@kemenko.go.id",
                    nip: "123456780",
                    img: "images/katiman.jpg",
                    teamMembers: [{
                            name: "Erik Dito Tampubolon",
                            email: "erik.dito@kemenko.go.id",
                            nip: "123456789",
                            img: "images/erik.png",
                            fungsional: "Analis Kebijakan Madya"
                        },
                        {
                            name: "Erik",
                            email: "erik@kemenko.go.id",
                            nip: "123456788",
                            img: "images/erik.png",
                            fungsional: "Analis Kebijakan Muda"
                        }
                    ]
                },
                {
                    id: 4,
                    pid: 1,
                    name: "Asisten Deputi Jaminan Sosial",
                    namapejabat: "Niken Ariati",
                    title: "Lorem ipsum",
                    email: "deputi2@kemenko.go.id",
                    nip: "123456782",
                    img: "images/niken-ariati.jpg",
                    teamMembers: []
                },
                {
                    id: 5,
                    pid: 1,
                    name: "Asisten Deputi Bantuan dan Subsidi Tepat Sasaran",
                    namapejabat: "Keukeu Komarawati",
                    title: "Lorem ipsum",
                    email: "asdep.jamsos@kemenko.go.id",
                    nip: "123456783",
                    img: "images/keukeu-komarawati.jpg",
                    teamMembers: [{
                        name: "Erik",
                        email: "erik@kemenko.go.id",
                        nip: "123456784",
                        img: "images/erik.png",
                        fungsional: "Analis Kebijakan Pertama"
                    }]
                },
                {
                    id: 6,
                    pid: 1,
                    name: "Asisten Deputi Pemberdayaan Disabilitas dan Lanjut Usia",
                    namapejabat: "Roos Diana Iskandar",
                    title: "Lorem ipsum",
                    email: "asdep.bantuan@kemenko.go.id",
                    nip: "123456784",
                    img: "images/roos-diana-iskandar.jpg",
                    teamMembers: [{
                            name: "Erik",
                            email: "erik@kemenko.go.id",
                            nip: "123456783",
                            img: "images/erik.png",
                            fungsional: "Arsiparis Muda"
                        },
                        {
                            name: "Erik",
                            email: "erik@kemenko.go.id",
                            nip: "123456782",
                            img: "images/erik.png",
                            fungsional: "Arsiparis Pertama"
                        }
                    ]
                }
            ]
        });

        // JavaScript untuk Modal
        var modal = document.getElementById("myModal");
        var memberModal = document.getElementById("memberModal");
        var span = document.getElementsByClassName("close")[0];
        var closeMemberSpan = document.getElementById("closeMemberModal");

        // Ketika user mengklik span (x), tutup modal
        span.onclick = function() {
            modal.classList.remove('show');
            setTimeout(function() {
                modal.style.display = "none";
            }, 300); // Sesuaikan dengan durasi transition pada CSS
        }

        closeMemberSpan.onclick = function() {
            memberModal.classList.remove('show');
            setTimeout(function() {
                memberModal.style.display = "none";
            }, 300); // Sesuaikan dengan durasi transition pada CSS
        }

        // Ketika user mengklik di luar modal, tutup modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.remove('show');
                setTimeout(function() {
                    modal.style.display = "none";
                }, 300); // Sesuaikan dengan durasi transition pada CSS
            } else if (event.target == memberModal) {
                memberModal.classList.remove('show');
                setTimeout(function() {
                    memberModal.style.display = "none";
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
                document.getElementById("modalNamaPejabat").textContent = "Nama: " + nodeData.namapejabat;
                document.getElementById("modalTitle").style.display = "none";
                document.getElementById("modalEmail").textContent = "Email: " + nodeData.email;
                document.getElementById("modalNIP").textContent = "NIP: " + nodeData.nip;
                document.getElementById("modalTeam").style.display = "none";

            } else {
                document.getElementById("modalNamaPejabat").style.display = "block";
                document.getElementById("modalTitle").style.display = "block";
                document.getElementById("modalEmail").style.display = "block";
                document.getElementById("modalNIP").style.display = "block";
                document.getElementById("modalTeam").style.display = "block";

                document.getElementById("modalNamaPejabat").textContent = "Nama: " + nodeData.namapejabat;
                document.getElementById("modalTitle").textContent = "Jabatan: " + nodeData.title;
                document.getElementById("modalEmail").textContent = "Email: " + nodeData.email;
                document.getElementById("modalNIP").textContent = "NIP: " + nodeData.nip;

                if (nodeData.teamMembers && nodeData.teamMembers.length > 0) {
                    var teamTable = "<table><tr><th>Anggota</th><th>Fungsional</th></tr>";
                    nodeData.teamMembers.forEach(function(member) {
                        teamTable += `<tr><td><button class="member-button" onclick="showMemberModal('${member.name}', '${member.img}', '${member.email}', '${member.nip}', '${member.fungsional}')">${member.name}</button></td><td>${member.fungsional}</td></tr>`;
                    });
                    teamTable += "</table>";
                    document.getElementById("modalTeam").innerHTML = teamTable;
                } else {
                    document.getElementById("modalTeam").innerHTML = "";
                }
            }

            // Tampilkan modal
            modal.style.display = "block";
            setTimeout(function() {
                modal.classList.add('show');
            }, 10); // Sesuaikan dengan durasi transition pada CSS

            // Prevent default click behavior
            return false;
        });

        function showMemberModal(name, img, email, nip, fungsional) {
            document.getElementById("memberName").textContent = name;
            document.getElementById("memberImg").src = img;
            document.getElementById("memberEmail").textContent = "Email: " + email;
            document.getElementById("memberNIP").textContent = "NIP: " + nip;
            document.getElementById("memberFungsional").textContent = "Fungsional: " + fungsional;

            // Display only member information in the modal
            memberModal.style.display = "block";
            setTimeout(function() {
                memberModal.classList.add('show');
            }, 10);
        }

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