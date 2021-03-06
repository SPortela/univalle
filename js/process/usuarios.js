// VALIDACION FORMULARIO NUEVO USUARIO
$("#usuarios").validate({
  rules: {
    txtImg: {
      extension: "png|jpg",
    },
    txtDoc: {
      required: true,
    },
    txtName: {
      required: true,
    },
    txtDir: {
      required: true,
    },
    txtTel: {
      required: true,
    },
    txtEml: {
      required: true,
      email: true,
    },
    txtUser: {
      required: true,
    },
    SelPerfil: {
      required: true,
    },
    txtPass: {
      required: true,
    },
    txtPass2: {
      required: true,
      equalTo: "#txtPass",
    },
  },
  messages: {
    txtImg: {
      extension: "Por favor adjunta un formato .png o .jpg",
    },
    txtDoc: {
      required: "Debe escribir su cedula",
    },
    txtName: {
      required: "Debe escribir su nombre",
    },
    txtDir: {
      required: "Debe escribir su dirección",
    },
    txtTel: {
      required: "Debe escribir su teléfono",
    },
    txtEml: {
      required: "Debe escribir su E-mail",
      email: "E-mial Incorrecto",
    },
    txtUser: {
      required: "Genere un Usuario",
    },
    SelPerfil: {
      required: "Seleccione una opción",
    },
    txtPass: {
      required: "Debe escribir su Contraseña",
    },
    txtPass2: {
      required: "Debe confirmar su contraseña",
      equalTo: "Las contraseñas no coinciden",
    },
  },
  submitHandler: function (form) {
    var vDoc = $("#txtDoc").val();
    var vName = $("#txtName").val();
    var vDir = $("#txtDir").val();
    var vTel = $("#txtTel").val();
    var vEml = $("#txtEml").val();
    var vUser = $("#txtUser").val();
    var vPass = $("#txtPass").val();
    var vImg = $("#txtImg").val();
    var vData = "";
    var vId = $("#txtId").val();
    var vPerfil = $("#SelPerfil").val();
    if (vPerfil == 0)
      var vIdAdmin = $("#SelSuper").val();
    else
      vIdAdmin = "";

    if (vId > 0) {
      /* envia todos los campos del formulario*/
      var vData = new FormData(document.getElementById("usuarios"));
    } else {
      var vData = new FormData(document.getElementById("usuarios"));
    }
    // var vData = {"accion":"ins", "pNombre":vName, "pCedula":vDoc, "pDireccion":vDir, "pTelefono":vTel, "pEmail":vEml, "pUsuario":vUser, "pPassword":vPass, "txtImg":vImg};
    $.ajax({
      data: vData,
      type: "POST",
      datatype: "json",
      url: "../../controller/usuariosController.php",
      contentType: false,
      processData: false,
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(jqXHR, textStatus, errorThrown);
      }
    })
      .done(function (data) {
        if (data.success) {
          alert(data.message);
          document.location.href = "index.php";
          document.getElementById("usuarios").reset();
        } else {
          alert(data.message);
          document.location.href = "index.php";
          document.getElementById("usuarios").reset();
        }
      })
      .fail(function () {
        alert("Error al tratar de crear el usuario. Contacte al Administrador");
      });
  },
});

/***************************************************************/
/*               CARGA DATOS DE USUARIO                          */
/***************************************************************/
function cambia_status(Id, Status) {
  /* Realiza conexión con el servidor */
  var vId = Id;
  var vSt = Status;
  if (vSt == 1) {
    vSt = 0;
  } else {
    vSt = 1;
  }
  if (vId != 0) {
    $.ajax({
      data: { accion: "Status", pId: vId, pStatus: vSt },
      type: "POST",
      datatype: "json",
      url: "../../controller/usuariosController.php",
    })
      .done(function (data) {
        if (data.success) {
          window.location.href = "index.php";
        }
      })
      .fail(function () {
        alert("Ha ocurrido un problema");
      });
  }
}
/***************************************************************/
/*               CARGA DATOS DE USUARIO                          */
/***************************************************************/
function perfil(Id) {
  /* Realiza conexión con el servidor */
  var vId = Id;
  if (vId != 0) {
    $.ajax({
      data: { accion: "single", pId: vId },
      type: "POST",
      datatype: "json",
      url: "../../controller/usuariosController.php",
    })

      .done(function (data) {
        if (data.success) {
          $("#txtDoc").val(data.Cedula);
          $("#txtName").val(data.Nombre);
          $("#txtDir").val(data.Direccion);
          $("#txtTel").val(data.Telefono);
          $("#txtEml").val(data.Email);
          $("#txtUser").val(data.Usuario);
          $(".linkImg").empty();
          $(".linkImg").append(
            '<img src="../../' + data.Foto + '"  width="140px">'
          );
          $("#upd").empty();
          $("#upd").append(
            '<input type="hidden" id="img" name="accion" class="form-control" value="upd">'
          );
          $("#txtId").val(vId);
        }
      })
      .fail(function () {
        alert("Ha ocurrido un problema");
      });
  }
}

/***************************************************************/
/*              CAMBIA CONTRASEÑA                    */
/***************************************************************/

$("#cambiaPass").validate({
  rules: {
    txtPass: {
      required: true,
    },
    txtPass2: {
      required: true,
      equalTo: "#txtPass",
    },
  },
  messages: {
    txtPass: {
      required: "Debes generar una contraseña",
    },
    txtPass2: {
      required: "Debes confirmar la contraseña",
      equalTo: "Las contraseñas no coinciden",
    },
  },

  submitHandler: function (form) {
    var vPass2 = $("#txtPass2").val();
    var vId = $("#txtId").val();

    // if (vId > 0) {
    //  /* envia todos los campos del formulario*/
    //   var vData = new FormData(document.getElementById("usuarios"));
    // }else{
    //   var vData = new FormData(document.getElementById("usuarios"));
    // }
    var vData = { accion: "chg", pPass: vPass2, pId: vId };
    $.ajax({
      data: vData,
      type: "POST",
      datatype: "json",
      url: "../../controller/usuariosController.php",
    })
      .done(function (data) {
        if (data.success) {
          alert(data.message);
          document.location.href = "index.php";
        } else {
          alert(data.message);
          // document.getElementById("login").reset();
        }
      })
      .fail(function (data) {
        alert("Se ha presentado un problema al iniciar sesión");
      });
  },
});

/* ONCHANGE PERFIL */

$("#SelPerfil").change(function () {
  var selPerfil = $("#SelPerfil").val();

  if (selPerfil == 0) {
    $("#selSuperAdmin").show();
  } else {
    $("#selSuperAdmin").hide();
    $("#SelPerfil option[value='-1']").attr("selected", true);
  }
});
