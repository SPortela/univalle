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
          <img src="../assets/top-left-lines.png" class="d-block m-auto" alt="" />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
          <p class="text-center text-header">
            Ofrecemos una amplia oferta de <br />
            <strong class="text-red" style="font-size: 7rem">POSGRADOS</strong><br />
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
                    <label for="txtPrograma"></label>
                    <select class="form-select form-select-lg" name="txtPrograma" id="txtPrograma">
                      <option value="DOCTORADO EN ADMINISTRACIÓN">DOCTORADO EN ADMINISTRACIÓN</option>
                      <option value="DOCTORADO EN BIOINGENIERÍA">DOCTORADO EN BIOINGENIERÍA</option>
                      <option value="DOCTORADO EN CIENCIAS - FÍSICA">DOCTORADO EN CIENCIAS - FÍSICA</option>
                      <option value="DOCTORADO EN MECÁNICA APLICADA">DOCTORADO EN MECÁNICA APLICADA</option>
                      <option value="DOCTORADO EN INGENIERÍA MECÁNICA">DOCTORADO EN INGENIERÍA MECÁNICA</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA SANITARIA Y AMBIENTAL">DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA SANITARIA Y AMBIENTAL</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA QUÍMICA">DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA QUÍMICA</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA DE MATERIALES">DOCTORADO EN INGENIERÍA ÉNFASIS INGENIERÍA DE MATERIALES</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS EN MECÁNICA DE SÓLIDOS">DOCTORADO EN INGENIERÍA ÉNFASIS EN MECÁNICA DE SÓLIDOS</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA INDUSTRIAL">DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA INDUSTRIAL</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA">DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE ALIMENTOS">DOCTORADO EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE ALIMENTOS</option>
                      <option value="DOCTORADO EN INGENIERÍA ÉNFASIS EN CIENCIAS DE LA COMPUTACIÓN">DOCTORADO EN INGENIERÍA ÉNFASIS EN CIENCIAS DE LA COMPUTACIÓN</option>
                      <option value="DOCTORADO EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA">DOCTORADO EN INGENIERÍA ELÉCTRICA Y ELECTRÓNICA</option>
                      <option value="DOCTORADO EN GOBIERNO, POLÍTICA PÚBLICA Y ADMINISTRACIÓN PÚBLICA">DOCTORADO EN GOBIERNO, POLÍTICA PÚBLICA Y ADMINISTRACIÓN PÚBLICA</option>
                      <option value="DOCTORADO EN GESTIÓN URBANA Y DEL TERRITORIO">DOCTORADO EN GESTIÓN URBANA Y DEL TERRITORIO</option>
                      <option value="DOCTORADO EN FILOSOFÍA">DOCTORADO EN FILOSOFÍA</option>
                      <option value="DOCTORADO EN CIENCIAS DEL MAR">DOCTORADO EN CIENCIAS DEL MAR</option>
                      <option value="DOCTORADO EN CIENCIAS BIOMÉDICAS">DOCTORADO EN CIENCIAS BIOMÉDICAS</option>
                      <option value="DOCTORADO EN CIENCIAS AMBIENTALES">DOCTORADO EN CIENCIAS AMBIENTALES</option>
                      <option value="DOCTORADO EN CIENCIAS - QUÍMICAS">DOCTORADO EN CIENCIAS - QUÍMICAS</option>
                      <option value="DOCTORADO EN CIENCIAS - MATEMÁTICAS">DOCTORADO EN CIENCIAS - MATEMÁTICAS</option>
                      <option value="DOCTORADO EN PSICOLOGÍA">DOCTORADO EN PSICOLOGÍA</option>
                      <option value="DOCTORADO INTERINSTITUCIONAL EN EDUCACIÓN">DOCTORADO INTERINSTITUCIONAL EN EDUCACIÓN</option>
                      <option value="MAESTRÍA EN ADMINISTRACIÓN - SEDE CALI">MAESTRÍA EN ADMINISTRACIÓN - SEDE CALI</option>
                      <option value="MAESTRÍA EN ADMINISTRACIÓN - SEDE TULUÁ">MAESTRÍA EN ADMINISTRACIÓN - SEDE TULUÁ</option>
                      <option value="MAESTRÍA EN EPIDEMIOLOGÍA">MAESTRÍA EN EPIDEMIOLOGÍA</option>
                      <option value="MAESTRÍA EN EDUCACIÓN ÉNFASIS EN PEDAGOGÍA DE LA EDUCACIÓN SUPERIOR - SEDE ZARZAL">MAESTRÍA EN EDUCACIÓN ÉNFASIS EN PEDAGOGÍA DE LA EDUCACIÓN SUPERIOR - SEDE ZARZAL</option>
                      <option value="MAESTRÍA EN EDUCACIÓN ÉNFASIS EN FILOSOFÍA PARA LA PAZ">MAESTRÍA EN EDUCACIÓN ÉNFASIS EN FILOSOFÍA PARA LA PAZ</option>
                      <option value="MAESTRÍA EN DESARROLLO SUSTENTABLE">MAESTRÍA EN DESARROLLO SUSTENTABLE</option>
                      <option value="MAESTRÍA EN COMERCIO INTERNACIONAL">MAESTRÍA EN COMERCIO INTERNACIONAL</option>
                      <option value="MAESTRÍA EN CREACIÓN Y DIRECCIÓN ESCÉNICA">MAESTRÍA EN CREACIÓN Y DIRECCIÓN ESCÉNICA</option>
                      <option value="MAESTRÍA EN CONTABILIDAD">MAESTRÍA EN CONTABILIDAD</option>
                      <option value="MAESTRÍA EN CULTURAS AUDIOVISUALES">MAESTRÍA EN CULTURAS AUDIOVISUALES</option>
                      <option value="MAESTRÍA EN CIENCIAS ODONTOLÓGICAS">MAESTRÍA EN CIENCIAS ODONTOLÓGICAS</option>
                      <option value="MAESTRÍA EN CIENCIAS BIOMÉDICAS">MAESTRÍA EN CIENCIAS BIOMÉDICAS</option>
                      <option value="MAESTRÍA EN CIENCIAS - QUÍMICA">MAESTRÍA EN CIENCIAS - QUÍMICA</option>
                      <option value="MAESTRÍA EN CIENCIAS - MATEMÁTICAS">MAESTRÍA EN CIENCIAS - MATEMÁTICAS</option>
                      <option value="MAESTRÍA EN CIENCIAS - FÍSICA">MAESTRÍA EN CIENCIAS - FÍSICA</option>
                      <option value="MAESTRÍA EN CALIDAD PARA LA GESTIÓN DE LAS ORGANIZACIONES">MAESTRÍA EN CALIDAD PARA LA GESTIÓN DE LAS ORGANIZACIONES</option>
                      <option value="MAESTRÍA EN ANALITICA E INTELIGENCIA DE NEGOCIOS">MAESTRÍA EN ANALITICA E INTELIGENCIA DE NEGOCIOS</option>
                      <option value="MAESTRÍA EN ADMINISTRACIÓN DE SALUD">MAESTRÍA EN ADMINISTRACIÓN DE SALUD</option>
                      <option value="MAESTRÍA EN CIENCIAS DE LA ORGANIZACIÓN">MAESTRÍA EN CIENCIAS DE LA ORGANIZACIÓN</option>
                      <option value="MAESTRÍA EN LOGÍSTICA Y GESTIÓN DE CADENAS DE ABASTECIMIENTO">MAESTRÍA EN LOGÍSTICA Y GESTIÓN DE CADENAS DE ABASTECIMIENTO</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA SANITARIA Y AMBIENTAL">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA SANITARIA Y AMBIENTAL</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS INGENIERÍA INDUSTRIAL">MAESTRÍA EN INGENIERÍA ÉNFASIS INGENIERÍA INDUSTRIAL</option>
                      <option value="MAESTRÍA EN INTERNACIONALIZACIÓN DE LAS EMPRESAS DEL SECTOR DE LA CONSTRUCCIÓN">MAESTRÍA EN INTERNACIONALIZACIÓN DE LAS EMPRESAS DEL SECTOR DE LA CONSTRUCCIÓN</option>
                      <option value="MAESTRÍA EN LINGÜÍSTICA Y ESPAÑOL">MAESTRÍA EN LINGÜÍSTICA Y ESPAÑOL</option>
                      <option value="MAESTRÍA EN POLÍTICAS PÚBLICAS - SEDE ZARZAL">MAESTRÍA EN POLÍTICAS PÚBLICAS - SEDE ZARZAL</option>
                      <option value="MAESTRíA EN MÚSICA">MAESTRíA EN MÚSICA</option>
                      <option value="MAESTRÍA EN POLÍTICAS PÚBLICAS">MAESTRÍA EN POLÍTICAS PÚBLICAS</option>
                      <option value="MAESTRÍA EN POLÍTICAS PÚBLICAS - SEDE TULUÁ">MAESTRÍA EN POLÍTICAS PÚBLICAS - SEDE TULUÁ</option>
                      <option value="MAESTRÍA EN POLÍTICAS PÚBLICAS - EXTENSIÓN NARIÑO">MAESTRÍA EN POLÍTICAS PÚBLICAS - EXTENSIÓN NARIÑO</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA MECÁNICA">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA MECÁNICA</option>
                      <option value="MAESTRÍA EN PROSPECTIVA E INNOVACIÓN">MAESTRÍA EN PROSPECTIVA E INNOVACIÓN</option>
                      <option value="MAESTRÍA EN PSICOLOGÍA">MAESTRÍA EN PSICOLOGÍA</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA QUÍMICA">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA QUÍMICA</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE SISTEMAS Y COMPUTACIÓN">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE SISTEMAS Y COMPUTACIÓN</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELECTRÓNICA">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELECTRÓNICA</option>
                      <option value="MAESTRIA EN GESTIÓN DE LA CALIDAD PARA LABORATORIOS">MAESTRIA EN GESTIÓN DE LA CALIDAD PARA LABORATORIOS</option>
                      <option value="MAESTRÍA EN ESTADÍSTICA">MAESTRÍA EN ESTADÍSTICA</option>
                      <option value="MAESTRÍA EN FILOSOFÍA - SEDE CALI">MAESTRÍA EN FILOSOFÍA - SEDE CALI</option>
                      <option value="MAESTRÍA EN FILOSOFÍA - SEDE BUGA">MAESTRÍA EN FILOSOFÍA - SEDE BUGA</option>
                      <option value="MAESTRÍA EN GERENCIA DE PROYECTOS">MAESTRÍA EN GERENCIA DE PROYECTOS</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA ELÉCTRICA</option>
                      <option value="MAESTRÍA EN GERENCIA DE PROYECTOS - SEDE TULUÁ">MAESTRÍA EN GERENCIA DE PROYECTOS - SEDE TULUÁ</option>
                      <option value="MAESTRÍA EN HISTORIA">MAESTRÍA EN HISTORIA</option>
                      <option value="MAESTRÍA EN INGENIERÍA CON ÉNFASIS EN INGENIERÍA AEROESPACIAL">MAESTRÍA EN INGENIERÍA CON ÉNFASIS EN INGENIERÍA AEROESPACIAL</option>
                      <option value="MAESTRÍA EN INGENIERÍA DE ALIMENTOS">MAESTRÍA EN INGENIERÍA DE ALIMENTOS</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN AUTOMÁTICA">MAESTRÍA EN INGENIERÍA ÉNFASIS EN AUTOMÁTICA</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA CIVIL">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA CIVIL</option>
                      <option value="MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE LOS MATERIALES">MAESTRÍA EN INGENIERÍA ÉNFASIS EN INGENIERÍA DE LOS MATERIALES</option>
                      <option value="MAESTRÍA EN REDES DE COMUNICACIÓN">MAESTRÍA EN REDES DE COMUNICACIÓN</option>
                      <option value="MAESTRÍA EN SALUD OCUPACIONALMAESTRÍA EN SALUD PÚBLICA">MAESTRÍA EN SALUD OCUPACIONALMAESTRÍA EN SALUD PÚBLICA</option>
                      <option value="MAESTRÍA EN VALORACIÓN Y TASACIÓN DE BIENES">MAESTRÍA EN VALORACIÓN Y TASACIÓN DE BIENES</option>
                      <option value="ESPECIALIZACIÓN EN ADMINISTRACIÓN DE EMPRESAS DE LA CONSTRUCCIÓN">ESPECIALIZACIÓN EN ADMINISTRACIÓN DE EMPRESAS DE LA CONSTRUCCIÓN</option>
                      <option value="ESPECIALIZACIÓN EN GEOMÁTICA">ESPECIALIZACIÓN EN GEOMÁTICA</option>
                      <option value="ESPECIALIZACIÓN EN FINANZAS - SEDE ZARZAL">ESPECIALIZACIÓN EN FINANZAS - SEDE ZARZAL</option>
                      <option value="ESPECIALIZACIÓN EN FINANZAS - SEDE PACÍFICO">ESPECIALIZACIÓN EN FINANZAS - SEDE PACÍFICO</option>
                      <option value="ESPECIALIZACIÓN EN ENFERMERÍA EN CUIDADO A LAS PERSONAS CON HERIDAS Y OSTOMÍAS">ESPECIALIZACIÓN EN ENFERMERÍA EN CUIDADO A LAS PERSONAS CON HERIDAS Y OSTOMÍAS</option>
                      <option value="ESPECIALIZACIÓN EN FINANZAS">ESPECIALIZACIÓN EN FINANZAS</option>
                      <option value="ESPECIALIZACIÓN EN ESTRUCTURAS">ESPECIALIZACIÓN EN ESTRUCTURAS</option>
                      <option value="ESPECIALIZACIÓN EN ESTADÍSTICA APLICADA">ESPECIALIZACIÓN EN ESTADÍSTICA APLICADA</option>
                      <option value="ESPECIALIZACIÓN EN AUDITORÍA EN SALUD - SEDE TULUÁ">ESPECIALIZACIÓN EN AUDITORÍA EN SALUD - SEDE TULUÁ</option>
                      <option value="ESPECIALIZACIÓN EN ENDODONCIA">ESPECIALIZACIÓN EN ENDODONCIA</option>
                      <option value="ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD - SEDE TULUÁ">ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD - SEDE TULUÁ</option>
                      <option value="ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD - SEDE CALI">ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD - SEDE CALI</option>
                      <option value="ESPECIALIZACIÓN EN AUTOMATIZACIÓN INDUSTRIAL">ESPECIALIZACIÓN EN AUTOMATIZACIÓN INDUSTRIAL</option>
                      <option value="ESPECIALIZACIÓN EN AUDITORÍA EN SALUD - SEDE CALI">ESPECIALIZACIÓN EN AUDITORÍA EN SALUD - SEDE CALI</option>
                      <option value="ESPECIALIZACIÓN EN ALTA GERENCIA - SEDE YUMBO">ESPECIALIZACIÓN EN ALTA GERENCIA - SEDE YUMBO</option>
                      <option value="ESPECIALIZACIÓN EN ALTA GERENCIA- SEDE CALI">ESPECIALIZACIÓN EN ALTA GERENCIA- SEDE CALI</option>
                      <option value="ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD - MODALIDAD VIRTUAL">ESPECIALIZACIÓN EN CALIDAD DE LA GESTIÓN Y PRODUCTIVIDAD - MODALIDAD VIRTUAL</option>
                      <option value="ESPECIALIZACIÓN EN ODONTOLOGÍA PEDIÁTRICA Y ORTOPEDIA MAXILAR">ESPECIALIZACIÓN EN ODONTOLOGÍA PEDIÁTRICA Y ORTOPEDIA MAXILAR</option>
                      <option value="ESPECIALIZACION EN PERIODONCIA">ESPECIALIZACION EN PERIODONCIA</option>
                      <option value="ESPECIALIZACIÓN EN PAISAJISMO">ESPECIALIZACIÓN EN PAISAJISMO</option>
                      <option value="ESPECIALIZACION EN ORTODONCIA">ESPECIALIZACION EN ORTODONCIA</option>
                      <option value="ESPECIALIZACIÓN EN GERENCIA PÚBLICA - SEDE TULUÁ">ESPECIALIZACIÓN EN GERENCIA PÚBLICA - SEDE TULUÁ</option>
                      <option value="ESPECIALIZACIÓN EN GESTIÓN TRIBUTARIA">ESPECIALIZACIÓN EN GESTIÓN TRIBUTARIA</option>
                      <option value="ESPECIALIZACIÓN EN GERENCIA PÚBLICA - SEDE ZARZAL">ESPECIALIZACIÓN EN GERENCIA PÚBLICA - SEDE ZARZAL</option>
                      <option value="ESPECIALIZACIÓN EN GERENCIA PÚBLICA">ESPECIALIZACIÓN EN GERENCIA PÚBLICA</option>
                      <option value="ESPECIALIZACIÓN EN GERENCIA DE MARKETING ESTRATÉGICO">ESPECIALIZACIÓN EN GERENCIA DE MARKETING ESTRATÉGICO</option>
                      <option value="ESPECIALIZACIÓN EN GEOTECNIA">ESPECIALIZACIÓN EN GEOTECNIA</option>
                      <option value="ESPECIALIZACIÓN EN PROCESOS DE INTERVENCIÓN SOCIAL">ESPECIALIZACIÓN EN PROCESOS DE INTERVENCIÓN SOCIAL</option>
                      <option value="ESPECIALIZACIÓN EN REDES DE COMUNICACIÓN">ESPECIALIZACIÓN EN REDES DE COMUNICACIÓN</option>
                      <option value="ESPECIALIZACIÓN EN REHABILITACIÓN ORAL">ESPECIALIZACIÓN EN REHABILITACIÓN ORAL</option>
                      <option value="ESPECIALIZACIÓN EN SISTEMAS DE TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍAELÉCTRICA">ESPECIALIZACIÓN EN SISTEMAS DE TRANSMISIÓN Y DISTRIBUCIÓN DE ENERGÍAELÉCTRICA</option>
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
            <img src="../assets/date1.png" class="d-block mx-auto" alt="fecha del 14 de julio al 6 de agosto 2021, Periodo para socializar reserva de cupo por parte de los admitidos." />
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <img src="../assets/date2.png" class="d-block mx-auto" alt="hasta el 13 de agosto 2021, Revisión de las reservas de cupo por parte de los programas académicos." />
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
            ¿Por qué estudiar un <strong class="text-red">posgrado</strong><br />
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
                    brinda la más variada oferta de posgrados en la Región, en
                    diferentes áreas del conocimiento:ingeniería,salud,
                    ciencias administración, ciencias sociales y económicas,
                    humanidades, artes, educación y pedagogía y psicología.
                  </p>
                </div>
                <div class="col-md-4 col-xs-12">
                  <img src="../assets/messh.png" height="100px" alt="" />
                  <p class="m-5 mt-2 p-4 text-why">
                    <strong class="text-red">La calidad</strong>
                    de sus programas de posgrado, sus docentes altamente
                    calificados, sus grupos de investigación con
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
                    Contamos con seis centros de investigación, tres
                    institutos y más de 40 grupos de investigación reconocidos
                    por Colciencias. Estos grupos han llevado a que la
                    Universidad del Valle origine
                    <strong class="text-red">invenciones y modelos de utilidad</strong>
                    para la región.
                  </p>
                </div>
                <div class="col-md-6 col-xs-12">
                  <img src="../assets/document.png" height="100px" alt="" />
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
          <img class="mx-auto d-block" src="../assets/logouni.png" alt="Logo universidad del valle" />
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
  <script type="text/javascript" src="../front/js/jquery.min.js"></script>
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