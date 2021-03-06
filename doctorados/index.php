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
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 d-none d-lg-block">
          <picture>
            <!-- <source srcset="../assets/top-right-lines.png" media="(max-width: 480px)"> -->
            <img src="../assets/top-left-lines.png" class="d-block m-auto" alt="" />
          </picture>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
          <p class="text-center text-header">
            Ofrecemos una amplia oferta de <br />
            <strong class="text-red text-posgrado">POSGRADOS</strong><br />
            en diversos campos del conocimiento
          </p>
        </div>
        <div class="col-5 d-none d-lg-block">
          <img src="../assets/top-right-lines.png" class="d-line" alt="" />
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
              <p class="text-now">??AHORA!</p>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
            <div class="row">
              <div class="col-12">
                <p class="text-white text-center" style="margin-top: 2%; font-size: 4.375rem">
                  SOLICITA<br />INFORMACI??N
                </p>
              </div>
              <div class="col-12 mt-4">
                <form role="form" id="univalledoc-form">
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
                    <input type="text" class="form-control form-control-lg" name="txtTel" id="txtTel" placeholder="TEL??FONO" />
                  </div>
                  <div class="form-group">
                    <label for="txtPrograma"></label>
                    <select class="form-select form-select-lg" name="txtPrograma" id="txtPrograma">
                      <option value="DOCTORADO EN ADMINISTRACI??N">DOCTORADO EN ADMINISTRACI??N</option>
                      <option value="DOCTORADO EN BIOINGENIER??A">DOCTORADO EN BIOINGENIER??A</option>
                      <option value="DOCTORADO EN CIENCIAS - F??SICA">DOCTORADO EN CIENCIAS - F??SICA</option>
                      <option value="DOCTORADO EN MEC??NICA APLICADA">DOCTORADO EN MEC??NICA APLICADA</option>
                      <option value="DOCTORADO EN INGENIER??A MEC??NICA">DOCTORADO EN INGENIER??A MEC??NICA</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS INGENIER??A SANITARIA Y AMBIENTAL">DOCTORADO EN INGENIER??A ??NFASIS INGENIER??A SANITARIA Y AMBIENTAL</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS INGENIER??A QU??MICA">DOCTORADO EN INGENIER??A ??NFASIS INGENIER??A QU??MICA</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS INGENIER??A DE MATERIALES">DOCTORADO EN INGENIER??A ??NFASIS INGENIER??A DE MATERIALES</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS EN MEC??NICA DE S??LIDOS">DOCTORADO EN INGENIER??A ??NFASIS EN MEC??NICA DE S??LIDOS</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS EN INGENIER??A INDUSTRIAL">DOCTORADO EN INGENIER??A ??NFASIS EN INGENIER??A INDUSTRIAL</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS EN INGENIER??A EL??CTRICA Y ELECTR??NICA">DOCTORADO EN INGENIER??A ??NFASIS EN INGENIER??A EL??CTRICA Y ELECTR??NICA</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS EN INGENIER??A DE ALIMENTOS">DOCTORADO EN INGENIER??A ??NFASIS EN INGENIER??A DE ALIMENTOS</option>
                      <option value="DOCTORADO EN INGENIER??A ??NFASIS EN CIENCIAS DE LA COMPUTACI??N">DOCTORADO EN INGENIER??A ??NFASIS EN CIENCIAS DE LA COMPUTACI??N</option>
                      <option value="DOCTORADO EN INGENIER??A EL??CTRICA Y ELECTR??NICA">DOCTORADO EN INGENIER??A EL??CTRICA Y ELECTR??NICA</option>
                      <option value="DOCTORADO EN GOBIERNO, POL??TICA P??BLICA Y ADMINISTRACI??N P??BLICA">DOCTORADO EN GOBIERNO, POL??TICA P??BLICA Y ADMINISTRACI??N P??BLICA</option>
                      <option value="DOCTORADO EN GESTI??N URBANA Y DEL TERRITORIO">DOCTORADO EN GESTI??N URBANA Y DEL TERRITORIO</option>
                      <option value="DOCTORADO EN FILOSOF??A">DOCTORADO EN FILOSOF??A</option>
                      <option value="DOCTORADO EN CIENCIAS DEL MAR">DOCTORADO EN CIENCIAS DEL MAR</option>
                      <option value="DOCTORADO EN CIENCIAS BIOM??DICAS">DOCTORADO EN CIENCIAS BIOM??DICAS</option>
                      <option value="DOCTORADO EN CIENCIAS AMBIENTALES">DOCTORADO EN CIENCIAS AMBIENTALES</option>
                      <option value="DOCTORADO EN CIENCIAS - QU??MICAS">DOCTORADO EN CIENCIAS - QU??MICAS</option>
                      <option value="DOCTORADO EN CIENCIAS - MATEM??TICAS">DOCTORADO EN CIENCIAS - MATEM??TICAS</option>
                      <option value="DOCTORADO EN PSICOLOG??A">DOCTORADO EN PSICOLOG??A</option>
                      <option value="DOCTORADO INTERINSTITUCIONAL EN EDUCACI??N">DOCTORADO INTERINSTITUCIONAL EN EDUCACI??N</option>
                    </select>
                  </div>
                  <div class="form-check mt-3">
                    <label class="form-check-label text-white" style="font-size: 1.2rem" for="terminos">
                      <input type="checkbox" class="form-check-input" id="terminos" name="terminos" checked="" />
                      <a class="terminos" href="https://www.univalle.edu.co/politica-de-tratamiento-de-la-informacion-personal">
                        Autorizo el tratamiento de mis datos personales de
                        acuerdo con Pol??tica del Tratamiento de la Informaci??n
                        Personal.
                      </a>
                    </label>
                    <input type="hidden" name="txtOrigen" value="0" id="txtOrigen" />
                    <input type="hidden" name="txtId" id="txtId" value=<?php echo $Id ?> />
                    <input type="hidden" name="txtCiudad" id="txtCiudad" value="1" />
                  </div>
                  <div class="text-center mt-4">
                    <button type="submit" class="btn btn-light btn-lg" id="Enviar" value="Enviar">
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
            <strong class="text-red text-inscripcion">INSCRIPCI??N Y ADMISI??N</strong>
            <p class="text-calendar" style="font-size: 4.2rem">2021-2</p>
            <hr class="line-border mx-auto" />
            <p style="font-size: 3rem">CALI Y SEDES REGIONALES</p>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="../assets/date1.png" class="d-block mx-auto" alt="fecha del 14 de julio al 6 de agosto 2021, Periodo para socializar reserva de cupo por parte de los admitidos." />
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="../assets/date2.png" class="d-block mx-auto" alt="hasta el 13 de agosto 2021, Revisi??n de las reservas de cupo por parte de los programas acad??micos." />
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="../assets/date3.png" class="d-block mx-auto" alt="A partir del 20 de agostos 2021, Respuesta a las solicitudes de reserva de cupo." />
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="../assets/date4.png" class="d-block mx-auto" alt="20de agosto 2021, Respuesta a las solicitudes de reserva de cupo." />
          </div>
        </div>
      </div>
    </section>
    <section class="section-info m-5">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-md-12 col-lg-6 col-xs-12 section-info--text">
            <p class="font-semib text-spacing text-avanza">
              AVANZAMOS Y
            </p>
            <p class="font-bold text-spacing text-crece">
              CRECEMOS
            </p>
            <p class="juntos font-bold">
              <span class="text-junto">J</span>
              <span class="text-underline">UNTOS</span>
            </p>
            <p style="font-size: 1.8125rem">
              Posgrados Universidad del Valle
            </p>
          </div>
          <div class="col-md-6 d-none d-lg-block d-lx-none">
            <picture>
              <img src="../assets/promo.jpeg" height="90%" alt="Imagen promocional Universidad del Valle" />
            </picture>
          </div>
        </div>
      </div>
    </section>
    <section class="section-why m-5">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center" style="font-size: 5rem; line-height: 5.5rem">
            ??Por qu?? estudiar un <strong class="text-red">posgrado</strong><br />
            en la
            <strong class="text-red text-underline">Universidad del Valle?</strong>
          </div>
          <div class="container-fluid mt-5 text-center">
            <div class="col-12">
              <div class="row">
                <div class="col-md-4 col-xs-12">
                  <img src="../assets/build.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    <strong class="text-red">Nuestra Universidad</strong>
                    brinda la m??s variada oferta de posgrados en la Regi??n, en
                    diferentes ??reas del conocimiento:ingenier??a,salud,
                    ciencias administraci??n, ciencias sociales y econ??micas,
                    humanidades, artes, educaci??n y pedagog??a y psicolog??a.
                  </p>
                </div>
                <div class="col-md-4 col-xs-12">
                  <img src="../assets/messh.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    <strong class="text-red">La calidad</strong>
                    de sus programas de posgrado, sus docentes altamente
                    calificados, sus grupos de investigaci??n con
                    reconocimiento nacional y mundial.
                  </p>
                </div>
                <div class="col-md-4 col-xs-12">
                  <img src="../assets/user.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    <strong class="text-red">Nuestros estudiantes</strong>
                    de posgrado cuentan con toda una infraestuctura adecuada
                    para adelantar sus estudios como salones inteligentes,
                    laboratorios certificados y bibliotecas en cada una de sus
                    sedes.
                  </p>
                </div>
                <div class="col-md-6 col-xs-12">
                  <img src="../assets/hat.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    Contamos con seis centros de investigaci??n, tres
                    institutos y m??s de 40 grupos de investigaci??n reconocidos
                    por Colciencias. Estos grupos han llevado a que la
                    Universidad del Valle origine
                    <strong class="text-red">invenciones y modelos de utilidad</strong>
                    para la regi??n.
                  </p>
                </div>
                <div class="col-md-6 col-xs-12">
                  <img src="../assets/document.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    Nuestros estudiantes de posgrado, se benefician de las
                    <strong class="text-red">edes internacionales de investigaci??n y
                      colaboraci??n</strong>
                    con las que cuenta la Universidad, lo que les permite
                    realizar sus pasant??as y cotutelas en importantes
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
          <img class="mx-auto d-block" src="../assets/logouni.png" alt="Logo universidad del valle" />
          <a class="enlace" href="https://www.univalle.edu.co" target="_blank">www.univalle.edu.co</a>
        </div>
        <div class="col-md-4 col.xs-12 text-center">
          <p class="font-bold text-white enlace">??rea de Admisiones</p>
          <a class="enlace text-footer" href="mailto:direccion.posgrados@correounivalle.edu.co" target="_blank">direccion.posgrados@correounivalle.edu.co</a>
        </div>
        <div class="col-md-4 col-xs-12 text-center text-md-start text-lg-start text-xl-start">
          <p class="font-bold text-white enlace">
            Edificio Administraci??n Central
          </p>
          <p class="text-white text-footer text-left">
            Ciudad Universitaria - Mel??ndez<br />
            Universidad del Valle <br />
            Cali - Colombia
          </p>
        </div>
        <div class="col-12 text-center">
          <br /><br />
          <p class="text-white text-footer">
            Instituci??n de educaci??n superior sujeta a inspecci??n y vigilancia
            por el Ministerio de Educaci??n Nacional
          </p>
          <p class="text-white text-footer">
            ?? 2020 UNIVERSIDAD DEL VALLE - Todos los derechos reservados
            Dise??o y desarrollo web en Cali, Colombia por Ikkonos
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Scripts -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script type="text/javascript" src="../front/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../front/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="../front/js/valid.js"></script>
  <script type="text/javascript" src="../front/js/funciones.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.11/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#txtPrograma').val(null).trigger("change");
      $('#txtPrograma').select2({
        allowClear: true,
        placeholder: 'PROGRAMA',
        width: '100%',
        closeOnSelect: true,
        language: {
          noResults: "No se encontraron resultados",
        },
        focus: true,
      });
    });
  </script>
</body>

</html>