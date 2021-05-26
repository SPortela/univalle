//  --------------------  Función para redireccionar     -----------------------------
function redireccionarPagina() {
  window.location.href = "https://www.univalle.edu.co/";
}

// VALIDACION FORMULARIO CONTACTO
$("#univalle-form").validate({
  rules: {
    txtName: {
      required: true
    },
    txtTel: {
      required: true,
      number: true,
      minlength: 7,
      maxlength: 20
    },
    txtEmail: {
      required: true,
      email: true
    },
    txtPrograma: {
      required: true
    },
    terminos: {
      required: true
    }
  },
  messages: {
    txtName: {
      required: "Debes escribir tu Nombre"
    },
    txtTel: {
      required: "Debes escribir tu Teléfono",
      number: " Solo ingrese números ",
      minlength: "Ingresa mínimo 7 números",
      maxlength: "Debes escribir Máximo 20 números"
    },
    txtEmail: {
      required: "Debes escribir tu Correo Electrónico",
      email: "Tu Correo es incorrecto"
    },
    txtPrograma: {
      required: "Selecciona un Programa"
    },
    terminos: {
      required: "Acepta los términos y políticas <br>"
    }
  },

  submitHandler: function (form) {

    $("#Enviar").prop("disabled", true);
    var urlc = "";
    var vCity = "";
    var vNom = $('#txtName').val();
    var vEml = $('#txtEmail').val();
    var vTel = $('#txtTel').val();
    var vTra = $('#txtPrograma').val();
    var vTabCity = $('#txtCiudad').val();
    var vOrigen = $('#txtOrigen').val();
    var vPrograma = "";
    var vcarrera1 = "";
    var vPregrado = "";
    var vPosgrado = "";
    var urlc = "controller/contactosController.php";
    var vCity = "Cali";
    var vIdM = $('#txtId').val();
    var vData = {
      "accion": 'ins', 
      "txtName": vNom,
      "txtEmail": vEml, 
      "txtTel": vTel, 
      "txtTratamiento": vTra,
      "txtId": vIdM, 
      "txtCiudad": vCity,
      "txtOrigen": vOrigen
    }
    $.ajax({
      data: vData,
      type: "POST",
      datatype: "json",
      url: urlc,
    })
      .done(function (data) {
        if (data.success) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 3000
          });
          document.getElementById("univalle-form").reset();
          $("#Enviar").prop("disabled", true);
          // Activamos la redirección luego de 3.5seg
          setTimeout("redireccionarPagina()", 3100);
        }
        else {
          alertify.alert(data.message);
          document.getElementById("univalle-form").reset();
          $("#Enviar").prop("disabled", false);
        }
      })
      .fail(function (data) {
        alertify.alert('algo ha sucedido al conectar con el servidor');
      });
  }
});