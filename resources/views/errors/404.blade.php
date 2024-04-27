<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page</title>
    <!-- Latest compiled and minified CSS -->
<!-- Favicons -->
<link href="assets/img/rockpay.png" rel="icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="{{asset('css/error-404-style.css')}}">

</head>
<body>
    <div class="cont_principal">
        <div class="cont_error">  
        <h1 style="color: #8a65df;">404</h1>
        <h1>Oops</h1>  
          <p>The Page you're looking for isn't here.</p>
          <div class="grad-btn"><a href="/login">Go to Homepage</a></div>
          </div>
        <div class="cont_aura_1"></div>
        <div class="cont_aura_2"></div>
    </div>
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    window.onload = function(){
        document.querySelector('.cont_principal').className= "cont_principal cont_error_active";    
    }
    var lvalue= document.getElementById("rectangle").innerHTML;
    var textLength = lvalue.length();
    </script>
</body>
</html>