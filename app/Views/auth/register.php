<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.0/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #32C2B8 0%, #ACE1E1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            font-family: 'Nunito', sans-serif;
        }

        .moving-background {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            animation: move 20s infinite linear;
        }

        .circle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
            animation-duration: 15s;
        }

        .circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 40%;
            left: 20%;
            animation-duration: 20s;
        }

        .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 60%;
            left: 70%;
            animation-duration: 25s;
        }

        .circle:nth-child(4) {
            width: 250px;
            height: 250px;
            top: 20%;
            left: 80%;
            animation-duration: 30s;
        }

        .circle:nth-child(5) {
            width: 300px;
            height: 300px;
            top: 80%;
            left: 30%;
            animation-duration: 35s;
        }

        @keyframes move {
            0% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(50px) translateX(50px);
            }
            100% {
                transform: translateY(0) translateX(0);
            }
        }

        .register-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            z-index: 1;
            animation: fadeIn 1.5s ease-in-out;
        }

        .register-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            transform: translateY(-50px);
            animation: slideIn 1s ease-out forwards;
        }

        .register-box img {
            margin-bottom: 20px;
            width: 80px;
        }

        .text-primary {
            color: #32C2B8 !important;
        }

        .btn-primary {
            background-color: #32C2B8 !important;
            border-color: #32C2B8 !important;
            border-radius: 50px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #287c7c !important;
            border-color: #287c7c !important;
            transform: scale(1.05);
        }

        .small a {
            color: #32C2B8 !important;
        }

        .text-center a {
            color: #32C2B8 !important;
        }

        .text-center .black-text {
            color: #000000 !important;
        }

        .login-link {
            display: inline-block;
            margin-left: 5px;
        }

        .form-control-user {
            border-radius: 50px;
            padding: 10px 20px;
            border: 1px solid #32C2B8;
            transition: all 0.3s ease;
        }

        .form-control-user:focus {
            box-shadow: 0 0 10px rgba(50, 194, 184, 0.5);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
            }
            to {
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .register-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="moving-background">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="register-container">
        <div class="register-box">
            <div class="text-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/Logo_of_the_Coordinating_Ministry_for_Human_Development_and_Culture_of_the_Republic_of_Indonesia.png" alt="Logo">
                <h1 class="h4 text-primary mb-4">ASN Kemenko PMK</h1>
            </div>
            <?php if (isset($validation)) : ?>
                <div><?= $validation->listErrors() ?></div>
            <?php endif; ?>
            <form class="user" action="/register/store" method="post">
                <div class="form-group">
                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email" name="username" required value="<?= set_value('username') ?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" required value="<?= set_value('password') ?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="exampleInputConfirmPassword" placeholder="Confirm Password" name="confpassword" required>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
                <hr>
            </form>
            <hr>
            <div class="text-center">
                <span class="black-text">Sudah memiliki akun?</span>
                <a class="small login-link" href="<?= site_url('login'); ?>">Login</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.0/js/sb-admin-2.min.js"></script>

</body>

</html>
