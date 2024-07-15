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
            background: url('/images/bg.png') no-repeat center center fixed;
            background-size: cover;
        }

        .register-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .register-box {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .register-box img {
            margin-bottom: 20px;
        }

        .text-primary {
            color: #e88504 !important;
        }

        .btn-primary {
            background-color: #e88504 !important;
            border-color: #e88504 !important;
        }

        .btn-primary:hover {
            background-color: #b8860b !important;
            border-color: #b8860b !important;
        }

        .small a {
            color: #e88504 !important;
        }

        .text-center a {
            color: #e88504 !important;
        }

        .text-center .black-text {
            color: #000000 !important;
        }

        .login-link {
            display: inline-block;
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <?php if (isset($validation)) : ?>
        <div><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <div class="register-container">
        <div class="register-box">
            <div class="text-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/Logo_of_the_Coordinating_Ministry_for_Human_Development_and_Culture_of_the_Republic_of_Indonesia.png" alt="Logo" width="100">
                <h1 class="h4 text-primary mb-4">ASN Kemenko PMK</h1>
            </div>
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