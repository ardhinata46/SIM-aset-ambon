<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
{{--  <title>{{$title}}</title>--}}
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: "Montserrat", sans-serif;
      background: #f6f5f7;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: -20px 0 50px;
      margin-top: 20px;
    }

    h1 {
      font-weight: bold;
      margin: 0;
    }

    p {
      font-size: 14px;
      font-weight: 100;
      line-height: 20px;
      letter-spacing: 0.5px;
      margin: 20px 0 30px;
    }

    span {
      font-size: 12px;
    }

    a {
      color: #333;
      font-size: 14px;
      text-decoration: none;
      margin: 15px 0;
    }

    .container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.2), 0 10px 10px rgba(0, 0, 0, 0.2);
      position: relative;
      overflow: hidden;
      width: 768px;
      max-width: 100%;
      min-height: 480px;
    }

    .form-container form {
      background: #fff;
      display: flex;
      flex-direction: column;
      padding: 0 20px;
      height: 100%;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .social-container {
      margin: 20px 0;
    }

    .social-container a {
      border: 1px solid #ddd;
      border-radius: 50%;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      margin: 0 5px;
      height: 40px;
      width: 40px;
    }

    .form-container input {
      background: #eee;
      border: none;
      padding: 12px 15px;
      margin: 8px 0;
      width: 100%;
      border-radius: 5px;
    }

    body {
      display: flex;
      justify-content: center;
      margin: 0;
    }

    button {
      border-radius: 5px;
      border: 1px solid #596ae6;
      background: #6777EF;
      color: #fff;
      font-size: 12px;
      padding: 10px 30px;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: transform 80ms ease-in;
    }

    button:active {
      transform: scale(0.95);
    }

    button:focus {
      outline: none;
    }

    button.ghost {
      background: transparent;
      border-color: #fff;
    }

    .form-container {
      position: absolute;
      top: 0;
      height: 100%;
      transition: all 0.6s ease-in-out;
    }

    .sign-in-container {
      left: 0;
      width: 50%;
      z-index: 2;
    }

    .sign-up-container {
      left: 0;
      width: 50%;
      z-index: 1;
      opacity: 0;
    }

    .overlay-container {
      position: absolute;
      top: 0;
      left: 50%;
      width: 50%;
      height: 100%;
      overflow: hidden;
      transition: transform 0.6s ease-in-out;
      z-index: 100;
    }

    .overlay {
      background: #6777EF;
      background: linear-gradient(to right, #6777EF, #6e7ce9) no-repeat 0 0 / cover;
      color: #fff;
      position: relative;
      left: -100%;
      height: 100%;
      width: 200%;
      transform: translateY(0);
      transition: transform 0.6s ease-in-out;
    }

    .overlay-panel {
      position: absolute;
      top: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 0 40px;
      height: 100%;
      width: 50%;
      text-align: center;
      transform: translateY(0);
      transition: transform 0.6s ease-in-out;
    }

    .overlay-right {
      right: 0;
      transform: translateY(0);
    }

    .overlay-left {
      transform: translateY(-20%);
    }

    /* Move signin to right */
    .container.right-panel-active .sign-in-container {
      transform: translateY(100%);
    }

    /* Move overlay to left */
    .container.right-panel-active .overlay-container {
      transform: translateX(-100%);
    }

    /* Bring signup over signin */
    .container.right-panel-active .sign-up-container {
      transform: translateX(100%);
      opacity: 1;
      z-index: 5;
    }

    /* Move overlay back to right */
    .container.right-panel-active .overlay {
      transform: translateX(50%);
    }
  </style>
</head>

<body>
  <div class="container" id="container">
    @yield('auth')
  </div>
  <script>
    const $signUpButton = document.getElementById("signUp");
    const $signInButton = document.getElementById("signIn");
    const $container = document.getElementById("container");

    $signUpButton.addEventListener("click", () => {
      $container.classList.add("right-panel-active");
    });

    $signInButton.addEventListener("click", () => {
      $container.classList.remove("right-panel-active");
    });
  </script>
</body>

</html>
