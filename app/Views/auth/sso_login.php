<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SSO - SINERGHI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .alert {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">SINERGHI - Login SSO</h4>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <div id="sso-error" class="alert alert-danger" style="display: none;" role="alert"></div>
                
                <div class="text-center mb-4">
                    <img src="<?= base_url('public/img/logo.png') ?>" alt="Logo" height="80">
                </div>
                
                <p class="text-center mb-4">
                    Silakan login menggunakan akun SSO Kementerian
                </p>
                
                <div class="d-grid gap-2">
                    <a href="<?= site_url('sso') ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login dengan SSO
                    </a>
                </div>
                
                <hr class="my-4">
                
                <div class="text-center">
                    <a href="<?= site_url('login') ?>" class="text-decoration-none">
                        Login dengan username dan password
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // SSO configuration
        window.ssoConfig = {
            ssoBaseUrl: '<?= getenv('SSO_URL') ?>',
            ssoLoginUrl: '<?= getenv('SSO_LOGIN_URL') ?>',
            redirectUrl: '<?= base_url() ?>'
        };
    </script>
    <script src="<?= base_url('public/js/sso-auth.js') ?>"></script>
</body>
</html>
