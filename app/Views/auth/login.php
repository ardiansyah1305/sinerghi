<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('images/pmklogo.png'); ?>">
    
    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template (Bootstrap 5) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1687A7 0%, #3A595C 100%);
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

        .triangle {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
            border-bottom: 50px solid rgba(255, 255, 255, 0.2);
            animation: moveTriangle 20s infinite linear;
        }

        .triangle:nth-child(1) {
            top: 30%;
            left: 15%;
            animation-duration: 15s;
        }

        .triangle:nth-child(2) {
            top: 50%;
            left: 60%;
            animation-duration: 20s;
        }

        .triangle:nth-child(3) {
            top: 80%;
            left: 40%;
            animation-duration: 25s;
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

        @keyframes moveTriangle {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
            }

            50% {
                transform: translateY(50px) translateX(50px) rotate(180deg);
            }

            100% {
                transform: translateY(0) translateX(0) rotate(360deg);
            }
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            z-index: 1;
            animation: fadeIn 1.5s ease-in-out;
        }

        .login-box {
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

        .login-box img {
            margin-bottom: 20px;
            width: 80px;
        }

        .text-primary {
            color: #1687A7 !important;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #1687A7 !important;
            border-color: #1687A7 !important;
            border-radius: 50px;
            padding: 10px 20px;
            transition: all 0.3s ease;
            width: 100%;
            display: block;
            text-align: center;
            margin: 0 auto;
        }

        .btn-primary:hover {
            background-color: #3A595C !important;
            border-color: #3A595C !important;
            transform: scale(1.05);
        }

        .form-control-user {
            border-radius: 50px;
            padding: 10px 20px;
            border: 1px solid #1687A7;
            transition: all 0.3s ease;
        }

        .form-control-user:focus {
            box-shadow: 0 0 10px rgba(22, 135, 167, 0.5);
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
            .login-box {
                padding: 20px;
            }
        }
    </style>
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
</head>

<body>

    <div class="moving-background">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="triangle"></div>
        <div class="triangle"></div>
        <div class="triangle"></div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <div class="text-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/Logo_of_the_Coordinating_Ministry_for_Human_Development_and_Culture_of_the_Republic_of_Indonesia.png" alt="Logo">
                <h1 class="h4 text-primary mb-4">ASN Kemenko PMK</h1>
            </div>

            <form id="loginForm" class="user">
                <div class="form-group mb-3">
                    <input type="text" class="form-control form-control-user" id="username" aria-describedby="usernameHelp" 
                           placeholder="Username" name="username" required>
                    <div class="invalid-feedback" id="usernameError"></div>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group has-validation">
                        <input type="password" class="form-control form-control-user" id="password" 
                               placeholder="Password" name="password" required
                               oninvalid="this.setCustomValidity('Password tidak boleh kosong')"
                               oninput="this.setCustomValidity('')">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="invalid-feedback" id="passwordError"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block" id="loginButton">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="loginSpinner"></span>
                    Login
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const loginSpinner = document.getElementById('loginSpinner');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            let errorTimeout;

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Handle form submission
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show spinner
                loginButton.disabled = true;
                loginSpinner.classList.remove('d-none');
                
                // Get form data
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                
                // Send AJAX request
                $.ajax({
                    url: '<?= site_url('loginAuth'); ?>',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        // Redirect to dashboard on success
                        window.location.href = '<?= site_url('/dashboard'); ?>';
                    },
                    error: function(xhr) {
                        // Hide spinner
                        loginButton.disabled = false;
                        loginSpinner.classList.add('d-none');
                        
                        // Show error message
                        let errorMessage = 'Login gagal. Silakan coba lagi.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        // Display error in form
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'alert alert-danger mt-3';
                        errorDiv.textContent = errorMessage;
                        
                        // Remove any existing error messages
                        const existingError = loginForm.querySelector('.alert');
                        if (existingError) {
                            existingError.remove();
                        }
                        
                        // Add new error message
                        loginForm.appendChild(errorDiv);
                        
                        // Clear error after 5 seconds
                        if (errorTimeout) {
                            clearTimeout(errorTimeout);
                        }
                        errorTimeout = setTimeout(() => {
                            errorDiv.remove();
                        }, 5000);
                    }
                });
            });
        });
    </script>
</body>
</html>
