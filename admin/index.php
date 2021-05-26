<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="Conjunto Digital">
  <meta name="keyword" content="Dashboard, Admin, CRM">
  <link rel="shortcut icon" href="img/favicon.png">
  <title>Administración</title>
  <!-- Bootstrap CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="../css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="../css/elegant-icons-style.css" rel="stylesheet" />
  <link href="../css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="../css/style-login.css" rel="stylesheet">
  <link href="../css/style-responsive.css" rel="stylesheet" />
  <!-- Alertify -->
  <link href="../css/alertify.default.css" rel="stylesheet">
  <link href="../css/alertify.core.css" rel="stylesheet" />
  <style>
    .modal-lg {
      width: 900px;
    }

    .conjunto {
      width: 100%;
    }

    .conjunto-logo {
      width: 13rem;
      height: 10rem;
    }

    .widget .padd,
    .modal-body {
      padding: 0px;
    }

    .panel-heading,
    .modal-header {
      background: #016ebb;
      color: #016ebb;
      text-shadow: 0px 1px #0066b3;
      border-bottom: 1px solid #0266b4;
      border-top: 1px solid #016ebb;
    }

    .modal-footer {
      margin-top: -2px;
      padding: 19px 20px 20px;
      text-align: right;
      border-top: 1px solid #e5e5e5;
      background-color: #015cab !important;
      background: none;
      border-bottom: 1px solid #0065b3;

    }

    .modal-content {
      border-radius: 0px;
      background: rgb(0 106 182);
    }

    .close {
      float: right;
      font-size: 21px;
      font-weight: bold;
      line-height: 1;
      color: #ffffff;
      text-shadow: none;
      opacity: 1;
      filter: alpha(opacity=20);
    }

    .login-logo-body {
      background: no-repeat center/50% url("../assets/logoConjunto.png");
    }

    @media screen and (max-width: 991px) {
      .modal-lg {
        width: 600px;
      }
    }

    @media screen and (max-width: 600px) {
      .modal-lg {
        width: 100%;
      }
    }
  </style>
</head>

<body class="login-logo-body">
  <div class="container">
    <form class="login-form" id="login">
      <div class="login-wrap">
        <p class="login-img">
          <!-- <i class="icon_lock_alt"></i> -->
          <img src="../assets/logoConjunto.png" alt="Conjunto Digital" class="conjunto-logo">
        </p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control" placeholder="Nombre de Usuario" autofocus name="txtUser" id="txtUser">
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" placeholder="Contraseña" name="txtPass" id="txtPass">
        </div>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Recuerdame  
          <span class="pull-right"> <a href="#"> Olvidaste la contraseña?</a></span>
        </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Iniciar</button>
        <button class="btn btn-info btn-lg btn-block" type="submit">Registrarse</button>
      </div>
    </form>
  </div>
  <!-- scripts -->
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../front/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="../js/process/validacion.js"></script>
  <!-- alertify -->
  <script type="text/javascript" src="../js/alertify.min.js"></script>
</body>

</html>