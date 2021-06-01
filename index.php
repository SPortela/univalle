<?php
if (empty($_GET)) {
  $Id = 0;
} else {
  $Id = $_GET['v'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Universidad del Valle</title>
  <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" /> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 d-none d-lg-block">
          <img src="./assets/top-left-lines.png" class="d-block m-auto" alt="" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
          <p class="text-center text-header">
            Ofrecemos una amplia oferta de <br />
            <strong class="text-red text-posgrado">POSGRADOS</strong><br />
            en diversos campos del conocimiento
          </p>
        </div>
        <div class="col-5 d-none d-lg-block">
          <img src="./assets/top-right-lines.png" class="d-line" alt="" />
        </div>
      </div>
    </div>
  </header>
  <main class="sections">
    <section class="section-form">
      <div class="container">
        <div class="row">
          <div class="
                col-lg-6 col-xl-6 col-xxl-6
                d-none d-sm-none d-md-none d-lg-block
              ">
            <div class="text-center text-moment font-bold">
              <p>
                EL MOMENTO DE ESTUDIAR <br />
                CON LOS MEJORES ES
              </p>
              <p class="text-now">¡AHORA!</p>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
            <div class="row">
              <div class="col-12">
                <p class="text-white text-center" style="margin-top: 2%; font-size: 4.375rem">
                  SOLICITA<br />INFORMACIÓN
                </p>
              </div>
              <div class="col-12 mt-4">
                <form role="form" id="univalle-form">
                  <div class="form-group">
                    <label for="txtName"></label>
                    <input type="text" class="form-control form-control-lg" name="txtName" id="txtName" placeholder="NOMBRE Y APELLIDO" />
                  </div>
                  <div class="form-group">
                    <label for="txtEmail"></label>
                    <input type="text" class="form-control form-control-lg" name="txtEmail" id="txtEmail" placeholder="CORREO" />
                  </div>
                  <div class="form-group">
                    <label for="txtTel"></label>
                    <input type="text" class="form-control form-control-lg" name="txtTel" id="txtTel" placeholder="TELÉFONO" />
                  </div>
                  <div class="form-group">
                    <label for="txtSede"></label>
                    <select class="form-select form-select-lg" name="txtSede" id="txtSede">
                      <option value="0">SEDE</option>
                      <option value="1">CALI</option>
                      <option value="2">BUGA</option>
                      <option value="3">PACÍFICO</option>
                      <option value="4">YUMBO</option>
                      <option value="5">TULUÁ</option>
                      <option value="6">ZARZAL</option>
                      <option value="7">NORTE DEL CAUCA</option>
                      <option value="8">EXTENSIÓN NARIÑO</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="txtFacultad"></label>
                    <select class="form-select form-select-lg" name="txtFacultad" id="txtFacultad" disabled>
                      <option value="0">FACULTAD</option>
                      <option value="1">CIENCIAS NATURALES</option>
                      <option value="2">HUMANIDADES</option>
                      <option value="3">CIENCIAS SOCIALES Y ECONÓMICAS</option>
                      <option value="4">INSTITUTO DE EDUCACIÓN Y PEDAGOGÍA</option>
                      <option value="5">INSTITUTO DE PSICOLOGÍA</option>
                      <option value="6">FACULTAD DE ARTES INTEGRADAS</option>
                      <option value="7">FACULTAD DE SALUD</option>
                      <option value="8">INGENIERÍA</option>
                      <option value="9">CIENCIAS DE LA ADMINISTRACIÓN</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="txtPrograma"></label>
                    <select class="form-select form-select-lg" name="txtPrograma" id="txtPrograma">
                      <option value="">PROGRAMA</option>
                    </select>
                  </div>
                  <div class="form-check mt-3">
                    <label class="form-check-label text-white" style="font-size: 1.2rem" for="terminos">
                      <input type="checkbox" class="form-check-input" id="terminos" name="terminos" checked="" />
                      Autorizo el tratamiento de mis datos personales de
                      acuerdo con Política del Tratamiento de la Información
                      Personal.
                    </label>
                    <input type="hidden" name="txtOrigen" value="0" id="txtOrigen" />
                    <input type="hidden" name="txtId" id="txtId" value=<?php echo $Id ?> />
                    <input type="hidden" name="txtCiudad" id="txtCiudad" value="1" />
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn btn-light btn-lg" id="Enviar" value="Enviar">
                      Enviar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section-calendar m-5">
      <div class="container">
        <div class="row">
          <div class="col-12 mb-5 text-center">
            <p class="text-calendar">Calendario</p>
            <strong class="text-red" style="font-size: 5rem">INSCRIPCIÓN Y ADMISIÓN</strong>
            <p class="text-calendar" style="font-size: 4.2rem">2021-2</p>
            <hr class="line-border mx-auto" />
            <p style="font-size: 3rem">CALI Y SEDES REGIONALES</p>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="./assets/date1.png" class="d-block mx-auto" alt="fecha del 14 de julio al 6 de agosto 2021, Periodo para socializar reserva de cupo por parte de los admitidos." />
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="./assets/date2.png" class="d-block mx-auto" alt="hasta el 13 de agosto 2021, Revisión de las reservas de cupo por parte de los programas académicos." />
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="./assets/date3.png" class="d-block mx-auto" alt="A partir del 20 de agostos 2021, Respuesta a las solicitudes de reserva de cupo." />
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="./assets/date4.png" class="d-block mx-auto" alt="20de agosto 2021, Respuesta a las solicitudes de reserva de cupo." />
          </div>
        </div>
      </div>
    </section>
    <section class="section-info m-5">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-md-12 col-lg-6 col-xs-12 section-info--text">
            <p class="font-semib text-spacing" style="font-size: 3.625rem; margin: -1rem">
              AVANZAMOS Y
            </p>
            <p class="font-bold text-spacing" style="font-size: 4.8125rem; margin: -1rem">
              CRECEMOS
            </p>
            <p class="juntos font-bold">
              <span style="vertical-align: sub; font-size: 9.3125rem">J</span>
              <span class="text-underline">UNTOS</span>
            </p>
            <p style="font-size: 1.8125rem">
              Posgrados Universidad del Valle
            </p>
          </div>
          <div class="col-md-6 d-none d-lg-block d-lx-none">
            <picture>
              <img src="./assets/promo.jpeg" height="90%" alt="Imagen promocional Universidad del Valle" />
            </picture>
          </div>
        </div>
      </div>
    </section>
    <section class="section-why m-5">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center" style="font-size: 5rem; line-height: 5.5rem">
            ¿Por qué estudiar un <strong class="text-red">posgrado</strong><br />
            en la
            <strong class="text-red text-underline">Universidad del Valle?</strong>
          </div>
          <div class="container-fluid mt-5 text-center">
            <div class="col-12">
              <div class="row">
                <div class="col-md-4 col-xs-12">
                  <img src="./assets/build.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    <strong class="text-red">Nuestra Universidad</strong>
                    brinda la más variada oferta de posgrados en la Región, en
                    diferentes áreas del conocimiento:ingeniería,salud,
                    ciencias administración, ciencias sociales y económicas,
                    humanidades, artes, educación y pedagogía y psicología.
                  </p>
                </div>
                <div class="col-md-4 col-xs-12">
                  <img src="./assets/messh.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    <strong class="text-red">La calidad</strong>
                    de sus programas de posgrado, sus docentes altamente
                    calificados, sus grupos de investigación con
                    reconocimiento nacional y mundial.
                  </p>
                </div>
                <div class="col-md-4 col-xs-12">
                  <img src="./assets/user.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    <strong class="text-red">Nuestros estudiantes</strong>
                    de posgrado cuentan con toda una infraestuctura adecuada
                    para adelantar sus estudios como salones inteligentes,
                    laboratorios certificados y bibliotecas en cada una de sus
                    sedes.
                  </p>
                </div>
                <div class="col-md-6 col-xs-12">
                  <img src="./assets/hat.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    Contamos con seis centros de investigación, tres
                    institutos y más de 40 grupos de investigación reconocidos
                    por Colciencias. Estos grupos han llevado a que la
                    Universidad del Valle origine
                    <strong class="text-red">invenciones y modelos de utilidad</strong>
                    para la región.
                  </p>
                </div>
                <div class="col-md-6 col-xs-12">
                  <img src="./assets/document.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    Nuestros estudiantes de posgrado, se benefician de las
                    <strong class="text-red">edes internacionales de investigación y
                      colaboración</strong>
                    con las que cuenta la Universidad, lo que les permite
                    realizar sus pasantías y cotutelas en importantes
                    universidades a nivel mundial.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <div class="container pt-5">
      <div class="row">
        <div class="col-md-4 col.xs-12 text-center">
          <img class="mx-auto d-block" src="./assets/logouni.png" alt="Logo universidad del valle" />
          <a class="enlace" href="https://www.univalle.edu.co" target="_blank">www.univalle.edu.co</a>
        </div>
        <div class="col-md-4 col.xs-12 text-center">
          <p class="font-bold text-white enlace">Área de Admisiones</p>
          <a class="enlace text-footer" href="mailto:direccion.posgrados@correounivalle.edu.co" target="_blank">direccion.posgrados@correounivalle.edu.co</a>
        </div>
        <div class="col-md-4 col.xs-12">
          <p class="font-bold text-white enlace">
            Edificio Administración Central
          </p>
          <p class="text-white text-footer text-left">
            Ciudad Universitaria - Meléndez<br />
            Universidad del Valle <br />
            Cali - Colombia
          </p>
        </div>
        <div class="col-12 text-center">
          <br /><br />
          <p class="text-white text-footer">
            Institución de educación superior sujeta a inspección y vigilancia
            por el Ministerio de Educación Nacional
          </p>
          <p class="text-white text-footer">
            © 2020 UNIVERSIDAD DEL VALLE - Todos los derechos reservados
            Diseño y desarrollo web en Cali, Colombia por Ikkonos
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Scripts -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script type="text/javascript" src="front/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="front/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="front/js/valid.js"></script>
  <script type="text/javascript" src="front/js/funciones.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.11/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#txtSede').change(function(){
          if($(this).val() != 1){
            $('#txtFacultad').attr("disabled", true);
            $('#txtFacultad').val(0);
            $("#txtPrograma").empty();
            $("#txtPrograma").append($("<option/>", { "value": "", text: "PROGRAMA" }));
            switch ($(this).val())
            {
              case "2":
                $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN FILOSOFÍA", text: "MAESTRÍA EN FILOSOFÍA" }));
                break;
              case "3":
                $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN FINANZAS", text: "ESPECIALIZACIÓN EN FINANZAS" }));
                break;
              case "4":
                $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ALTA GERENCIA", text: "ESPECIALIZACIÓN EN ALTA GERENCIA" }));
                break;
              case "5":
                $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN AUDITORÍA EN SALUD", text: "ESPECIALIZACIÓN EN AUDITORÍA EN SALUD" }));
                $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD", text: "ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD" }));
                $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN GERENCIA PÚBLICA", text: "ESPECIALIZACIÓN EN GERENCIA PÚBLICA" }));
                $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN ADMINISTRACIÓN", text: "MAESTRÍA EN ADMINISTRACIÓN" }));
                $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN GERENCIA DE PROYECTOS", text: "MAESTRÍA EN GERENCIA DE PROYECTOS" }));
                $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN POLÍTICAS PÚBLICAS", text: "MAESTRÍA EN POLÍTICAS PÚBLICAS" }));
                break;
              case "6":
                  $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN FINANZAS", text: "ESPECIALIZACIÓN EN FINANZAS" }));
                  $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN GERENCIA PÚBLICA", text: "ESPECIALIZACIÓN EN GERENCIA PÚBLICA" }));
                  $("#txtPrograma").append($("<option/>", { "value": "MAESTRíA EN EDUCACIÓN ÉNFASIS EN PEDAGOGÍA DE LA EDUCACIÓN SUPERIOR", text: "MAESTRíA EN EDUCACIÓN ÉNFASIS EN PEDAGOGÍA DE LA EDUCACIÓN SUPERIOR" }));
                break;
              case "7":
                $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN POLÍTICAS PÚBLICAS", text: "MAESTRÍA EN POLÍTICAS PÚBLICAS" }));
                break;
              case "8":
                $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN POLÍTICAS PÚBLICAS", text: "MAESTRÍA EN POLÍTICAS PÚBLICAS" }));
                break;
            }
          }
          else{
            $('#txtFacultad').attr("disabled", false);
          }
      })
      $('#txtFacultad').change(function(){
        $("#txtPrograma").empty();
        $("#txtPrograma").append($("<option/>", { "value": "", text: "PROGRAMA" }));
        switch ($(this).val())
        {
          case "1":
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CIENCIAS - QUÍMICA", text: "MAESTRÍA EN CIENCIAS - QUÍMICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CIENCIAS - FÍSICA", text: "MAESTRÍA EN CIENCIAS - FÍSICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CIENCIAS - MATEMÁTICAS", text: "MAESTRÍA EN CIENCIAS - MATEMÁTICAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN CIENCIAS DEL MAR", text: "DOCTORADO EN CIENCIAS DEL MAR" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN CIENCIAS - QUÍMICAS", text: "DOCTORADO EN CIENCIAS - QUÍMICAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN CIENCIAS - FÍSICA", text: "DOCTORADO EN CIENCIAS - FÍSICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN CIENCIAS - MATEMÁTICAS", text: "DOCTORADO EN CIENCIAS - MATEMÁTICAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN CIENCIAS AMBIENTALES", text: "DOCTORADO EN CIENCIAS AMBIENTALES" }));
            break;
          case "2":
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN LINGÜÍSTICA Y ESPAÑOL", text: "MAESTRÍA EN LINGÜÍSTICA Y ESPAÑOL" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN FILOSOFÍA", text: "MAESTRÍA EN FILOSOFÍA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN HISTORIA", text: "MAESTRÍA EN HISTORIA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN FILOSOFÍA", text: "DOCTORADO EN FILOSOFÍA" }));
            break;
          case "3":
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN PROCESOS DE INTERVENCIÓN SOCIAL", text: "ESPECIALIZACIÓN EN PROCESOS DE INTERVENCIÓN SOCIAL" }));
            break;
          case "4": 
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRíA EN EDUCACIÓN ÉNFASIS EN FILOSOFÍA PARA LA PAZ", text: "MAESTRíA EN EDUCACIÓN ÉNFASIS EN FILOSOFÍA PARA LA PAZ" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO INTERINSTITUCIONAL EN EDUCACIÓN", text: "DOCTORADO INTERINSTITUCIONAL EN EDUCACIÓN" }));
            break;
          case "5": 
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN PSICOLOGÍA", text: "MAESTRÍA EN PSICOLOGÍA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN PSICOLOGÍA", text: "DOCTORADO EN PSICOLOGÍA" }));
            break;
          case "6": 
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ADMINISTRACIÓN DE EMPRESAS DE LA CONSTRUCCIÓN", text: "ESPECIALIZACIÓN EN ADMINISTRACIÓN DE EMPRESAS DE LA CONSTRUCCIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN PAISAJISMO", text: "ESPECIALIZACIÓN EN PAISAJISMO" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INTERNACIONALIZACIÓN DE LAS EMPRESAS DEL SECTOR DE LA CONSTRUCCIÓN", text: "MAESTRÍA EN INTERNACIONALIZACIÓN DE LAS EMPRESAS DEL SECTOR DE LA CONSTRUCCIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CREACIÓN Y DIRECCIÓN ESCÉNICA", text: "MAESTRÍA EN CREACIÓN Y DIRECCIÓN ESCÉNICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CULTURAS AUDIOVISUALES", text: "MAESTRÍA EN CULTURAS AUDIOVISUALES" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRíA EN MÚSICA", text: "MAESTRíA EN MÚSICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN VALORACIÓN Y TASACIÓN DE BIENES", text: "MAESTRÍA EN VALORACIÓN Y TASACIÓN DE BIENES" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN GESTIÓN URBANA Y DEL TERRITORIO", text: "DOCTORADO EN GESTIÓN URBANA Y DEL TERRITORIO" }));
            break;
          case "7":
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN AUDITORÍA EN SALUD", text: "ESPECIALIZACIÓN EN AUDITORÍA EN SALUD" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACION EN PERIODONCIA", text: "ESPECIALIZACION EN PERIODONCIA" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ODONTOLOGÍA PEDIÁTRICA Y ORTOPEDIA MAXILAR", text: "ESPECIALIZACIÓN EN ODONTOLOGÍA PEDIÁTRICA Y ORTOPEDIA MAXILAR" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACION EN ORTODONCIA", text: "ESPECIALIZACION EN ORTODONCIA" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN REHABILITACIÓN ORAL", text: "ESPECIALIZACIÓN EN REHABILITACIÓN ORAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ENFERMERÍA EN CUIDADO A LAS PERSONAS CON HERIDAS Y OSTOMÍAS", text: "ESPECIALIZACIÓN EN ENFERMERÍA EN CUIDADO A LAS PERSONAS CON HERIDAS Y OSTOMÍAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ENDODONCIA", text: "ESPECIALIZACIÓN EN ENDODONCIA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRIA EN GESTIÓN DE LA CALIDAD PARA LABORATORIOS", text: "MAESTRIA EN GESTIÓN DE LA CALIDAD PARA LABORATORIOS" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CIENCIAS BIOMÉDICAS", text: "MAESTRÍA EN CIENCIAS BIOMÉDICAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CIENCIAS ODONTOLÓGICAS", text: "MAESTRÍA EN CIENCIAS ODONTOLÓGICAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN SALUD PÚBLICA", text: "MAESTRÍA EN SALUD PÚBLICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN SALUD OCUPACIONAL", text: "MAESTRÍA EN SALUD OCUPACIONAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN ADMINISTRACIÓN DE SALUD", text: "MAESTRÍA EN ADMINISTRACIÓN DE SALUD" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN EPIDEMIOLOGÍA", text: "MAESTRÍA EN EPIDEMIOLOGÍA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN CIENCIAS BIOMÉDICAS", text: "DOCTORADO EN CIENCIAS BIOMÉDICAS" }));
            break; 
          case "8":
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN GEOMÁTICA", text: "ESPECIALIZACIÓN EN GEOMÁTICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN GEOTECNIA", text: "ESPECIALIZACIÓN EN GEOTECNIA" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ESTRUCTURAS", text: "ESPECIALIZACIÓN EN ESTRUCTURAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN REDES DE COMUNICACIÓN", text: "ESPECIALIZACIÓN EN REDES DE COMUNICACIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN AUTOMATIZACIÓN INDUSTRIAL", text: "ESPECIALIZACIÓN EN AUTOMATIZACIÓN INDUSTRIAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN SISTEMAS DE TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍA ELÉCTRICA", text: "ESPECIALIZACIÓN EN SISTEMAS DE TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍA ELÉCTRICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ESTADÍSTICA APLICADA", text: "ESPECIALIZACIÓN EN ESTADÍSTICA APLICADA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN AUTOMÁTICA", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN AUTOMÁTICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA CIVIL", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA CIVIL" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELECTRÓNICA", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELECTRÓNICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS INGENIERÍA INDUSTRIAL", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS INGENIERÍA INDUSTRIAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE LOS MATERIALES", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE LOS MATERIALES" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA MECÁNICA", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA MECÁNICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA QUÍMICA", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA QUÍMICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA SANITARIA Y AMBIENTAL", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA SANITARIA Y AMBIENTAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE SISTEMAS Y COMPUTACIÓN", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE SISTEMAS Y COMPUTACIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA CON ÉNFASIS EN INGENIERÍA AEROESPACIAL", text: "MAESTRÍA EN INGENIERÍA CON ÉNFASIS EN INGENIERÍA AEROESPACIAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN ESTADÍSTICA", text: "MAESTRÍA EN ESTADÍSTICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN LOGÍSTICA Y GESTIÓN DE CADENAS DE ABASTECIMIENTO", text: "MAESTRÍA EN LOGÍSTICA Y GESTIÓN DE CADENAS DE ABASTECIMIENTO" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN REDES DE COMUNICACIÓN", text: "MAESTRÍA EN REDES DE COMUNICACIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN ANALITICA E INTELIGENCIA DE NEGOCIOS", text: "MAESTRÍA EN ANALITICA E INTELIGENCIA DE NEGOCIOS" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN DESARROLLO SUSTENTABLE", text: "MAESTRÍA EN DESARROLLO SUSTENTABLE" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA DE ALIMENTOS", text: "MAESTRÍA EN INGENIERÍA DE ALIMENTOS" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE ALIMENTOS", text: "DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE ALIMENTOS" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS EN CIENCIAS DE LA COMPUTACIÓN", text: "DOCTORADO EN INGENIERÍA ÉNFASIS EN CIENCIAS DE LA COMPUTACIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA", text: "DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA DE MATERIALES", text: "DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA DE MATERIALES" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA QUÍMICA", text: "DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA QUÍMICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA SANITARIA Y AMBIENTAL", text: "DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA SANITARIA Y AMBIENTAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA INDUSTRIAL", text: "DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA INDUSTRIAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ÉNFASIS EN MECÁNICA DE SÓLIDOS", text: "DOCTORADO EN INGENIERÍA ÉNFASIS EN MECÁNICA DE SÓLIDOS" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA", text: "DOCTORADO EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN MECÁNICA APLICADA", text: "DOCTORADO EN MECÁNICA APLICADA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN INGENIERÍA MECÁNICA", text: "DOCTORADO EN INGENIERÍA MECÁNICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN BIOINGENIERÍA", text: "DOCTORADO EN BIOINGENIERÍA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA SANITARIA Y AMBIENTAL", text: "MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA SANITARIA Y AMBIENTAL" }));
            break; 
          case "9":
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN FINANZAS", text: "ESPECIALIZACIÓN EN FINANZAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN GERENCIA DE MARKETING ESTRATÉGICO", text: "ESPECIALIZACIÓN EN GERENCIA DE MARKETING ESTRATÉGICO" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD", text: "ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN GESTIÓN TRIBUTARIA", text: "ESPECIALIZACIÓN EN GESTIÓN TRIBUTARIA" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN GERENCIA PÚBLICA", text: "ESPECIALIZACIÓN EN GERENCIA PÚBLICA" }));
            $("#txtPrograma").append($("<option/>", { "value": "ESPECIALIZACIÓN EN ALTA GERENCIA", text: "ESPECIALIZACIÓN EN ALTA GERENCIA" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CIENCIAS DE LA ORGANIZACIÓN", text: "MAESTRÍA EN CIENCIAS DE LA ORGANIZACIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN POLÍTICAS PÚBLICAS", text: "MAESTRÍA EN POLÍTICAS PÚBLICAS" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN ADMINISTRACIÓN", text: "MAESTRÍA EN ADMINISTRACIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CONTABILIDAD", text: "MAESTRÍA EN CONTABILIDAD" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN COMERCIO INTERNACIONAL", text: "MAESTRÍA EN COMERCIO INTERNACIONAL" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN CALIDAD PARA LA GESTIÓN DE LAS ORGANIZACIONES", text: "MAESTRÍA EN CALIDAD PARA LA GESTIÓN DE LAS ORGANIZACIONES" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN GERENCIA DE PROYECTOS", text: "MAESTRÍA EN GERENCIA DE PROYECTOS" }));
            $("#txtPrograma").append($("<option/>", { "value": "MAESTRÍA EN PROSPECTIVA E INNOVACIÓN", text: "MAESTRÍA EN PROSPECTIVA E INNOVACIÓN" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN ADMINISTRACIÒN", text: "DOCTORADO EN ADMINISTRACIÒN" }));
            $("#txtPrograma").append($("<option/>", { "value": "DOCTORADO EN GOBIERNO, POLÍTICA PÚBLICA Y ADMINISTRACIÓN PÚBLICA", text: "DOCTORADO EN GOBIERNO, POLÍTICA PÚBLICA Y ADMINISTRACIÓN PÚBLICA" }));
            break; 
        }
      })
    });
  </script>
</body>

</html>