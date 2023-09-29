<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.min.css " rel="stylesheet">
</head>
<body class="bg-dark">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-warning">
    <div class="container">
        <a class="navbar-brand" href="#">TWC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Login/Register Form -->
            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="text-white" id="cardHeader">Login</h5>
                </div>
                <div class="card-body">
                    <!-- Login Form -->
                    <form id="login-form">
                        <div class="mb-3">
                            <label for="loginUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="loginUsername" name="loginUsername"
                                   minlength="3" maxlength="20" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" minlength="8" maxlength="50"
                                   name="loginPassword"
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>

                    <!-- Registration Form -->
                    <form id="register-form" style="display: none;">
                        <div class="mb-3">
                            <label for="registerUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="registerUsername" minlength="3"
                                   name="registerUsername" maxlength="20"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" minlength="4"
                                   name="registerEmail" maxlength="50" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" minlength="8"
                                   name="registerPassword" maxlength="50"
                                   required>
                        </div>
                        <button type="submit" class="btn btn-secondary">Register</button>
                    </form>
                </div>
                <div class="card-footer">
                    <button id="switch-form-btn" class="btn btn-link text-secondary">Create account?</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<footer class="mt-5 bg-primary text-center py-3">
    <div class="container">
        <p class="text-white">Useful Links: <a href="#" class="text-dark">Privacy Policy</a> | <a href="#"
                                                                                                  class="text-dark">Terms
            of Service</a></p>
        <p class="text-white">&copy; 2023 TWC. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap JS (Popper.js and Bootstrap.js) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js"
        integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const loginForm = document.getElementById("login-form");
        const registerForm = document.getElementById("register-form");
        const switchFormButton = document.getElementById("switch-form-btn");
        const cardHeader = document.getElementById("cardHeader");

        switchFormButton.addEventListener("click", function (event) {
            event.preventDefault();
            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                switchFormButton.textContent = "Create account?";
                cardHeader.textContent = "Login";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                switchFormButton.textContent = "Already have an account?";
                cardHeader.textContent = "Register";
            }
        });

        registerForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const username = document.getElementById("registerUsername").value;
            const email = document.getElementById("registerEmail").value;
            const password = document.getElementById("registerPassword").value;

            if (username.length > 20 || password.length > 50 || email.length > 50) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please ensure that username is 20 characters or less, password is 50 characters or less, and email is 50 characters or less.'
                });
                return; // Prevent further processing
            }

            const headers = {
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'App-Request-Header': 'TheWestClone/API/ACCESS/1.0.0'
            };
            // Make a POST request to /api/register using Axios
            axios.post('http://localhost/thewest_clone/api/register', {
                username: username,
                useremail: email,
                userpassword: password
            }, {
                headers: headers // Add headers to the request
            })
                .then(function (response) {
                    // Handle the response based on "success" and "message" values
                    const data = response.data;
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful',
                            text: data.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed',
                            text: data.message
                        });
                    }
                })
                .catch(function (error) {
                    // Handle any errors
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Error',
                        text: error.response.data.message
                    });
                });
        });

        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const username = document.getElementById("loginUsername").value;
            const password = document.getElementById("loginPassword").value;

            if (username.length > 20 || password.length > 50) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please ensure that username is 20 characters or less, password is 50 characters or less, and email is 50 characters or less.'
                });
                return; // Prevent further processing
            }

            const headers = {
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'App-Request-Header': 'TheWestClone/API/ACCESS/1.0.0'
            };
            // Make a POST request to /api/register using Axios
            axios.post('http://localhost/thewest_clone/api/login', {
                username: username,
                userpassword: password
            }, {
                headers: headers // Add headers to the request
            })
                .then(function (response) {
                    // Handle the response based on "success" and "message" values
                    const data = response.data;
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            sessionStorage.setItem("user_token", data.message);
                            window.location.href = "../game/";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: data.message
                        });
                    }
                })
                .catch(function (error) {
                    // Handle any errors
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Error',
                        text: error.response.data.message
                    });
                });
        });
    });
</script>
</body>
</html>
