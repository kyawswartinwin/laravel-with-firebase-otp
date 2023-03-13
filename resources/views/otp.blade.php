<!doctype html>
<html lang="en">

<head>
  <title>Verify Your Number</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

    <div class="bg-dark" style="height: 100vh;">
        <div class="container my-5">
            <div class="row">
                <div class="col-12 col-lg-4 offset-lg-4">
                    <h4 class="text-center text-white my-3">Verify your phone number</h4>

                    <div id="send">
                        <div class="alert alert-danger d-none" id="error-message"></div>
                        <div class="alert alert-success d-none" id="sent-message"></div>
                        <div id="recaptcha-container"></div>
                        <div class="input-group my-2">
                        <input type="text" name="phone" id="phone" value="{{$phone}}" class="form-control" required>
                        <button type="button" class="btn btn-outline-success" id="get" onclick="getCode()">Generate code</button>
                        </div>
                    </div>

                    <div id="verify" class="d-none">
                        <div class="input-group">
                            <input type="text" name="otp" id="otp" class="form-control my-2">
                            <button type="button" class="btn btn-outline-success my-2" onclick="verifyOtp()">Verify</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
    <script type="text/javascript">
        const firebaseConfig = {
            "Your Code HERE"
        };

        firebase.initializeApp(firebaseConfig);
</script>

<script type="text/javascript">
              window.onload=function () {
            render();
    };

    function render() {
        window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }

    function getCode() {
          var phoneNumber = document.getElementById('phone').value;
            const appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then((confirmationResult) => {
                     //  SMS is sent
                    document.getElementById("sent-message").classList.remove('d-none');
                    document.getElementById("sent-message").innerHTML = "Success";
                    document.getElementById('send').classList.add('d-none');
                    document.getElementById('verify').classList.remove('d-none');
                    window.confirmationResult = confirmationResult;
                    otpResult = confirmationResult;

                    })
                .catch((error) => {
                    document.getElementById("error-message").classList.remove("d-none");
                    document.getElementById("error-message").innerHTML = error.message;
                });

        }

    function verifyOtp() {
        var otp = document.getElementById('otp').value;
        otpResult.confirm(otp).then(function (result) {
        document.getElementById('verify').classList.add('d-none');

        document.getElementById('error-message').innerText = '';
        location.href="{{route('otp.verified')}}";
           }).catch(function (error) {
            document.getElementById('error-message').innerText = error;
        });

    }
    </script>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>
