// VALIDACION FORMULARIOS 
$("#ceder-form").validate({
  rules: {
    txtAgente: {
      required: true
    }
  },
  messages: {
    txtAgente: {
      required: "Debe seleccionar un Agente a ceder"
    }
  },
  submitHandler: function (form) {
    var vAgenteNew = $('#txtAgente').val();
    var vId = $('#txtCederId').val();
    var vData = '';
    vData = {
      "accion": "give",
      "txtAgente": vAgenteNew,
      "txtId": vId
    };
    $.ajax({
      data: vData,
      type: "POST",
      datatype: "json",
      url: "../../controller/contactosController.php",
    })
      .done(function (data) {
        if (data.success) {
          alertify.alert(data.message);
          document.getElementById("ceder-form").reset();
          document.location.href = "index.php";
        }
        else {
          alertify.alert(data.message);
          document.getElementById("ceder-form").reset();
          document.location.href = "index.php";
        }
      })
      .fail(function (data) {
        alertify.alert('Se ha presentado un problema al iniciar sesión');
      });
  }
});
// ***************************************************
$("#ceder-varios-form").validate({
  rules: {
    txtAgente: {
      required: true
    },
    txtCantidad:{
      required: true
    }
  },
  messages: {
    txtAgente: {
      required: "Debe seleccionar un Agente a ceder"
    },
    txtCantidad:{
      required: "Debe especificar una Cantidad"
    }
  },
  submitHandler: function (form) {
    var vAgenteNew = $('#txtAgenteV').val();
    var vCantidad = $('#txtCantidad').val();
    var vUserId = $('#txtIdUser').val();
    var vData = '';
    vData = {
      "accion": "give-many",
      "txtAgente": vAgenteNew,
      "txtCantidad": vCantidad,
      "txtIdUser": vUserId
    };
    $.ajax({
      data: vData,
      type: "POST",
      datatype: "json",
      url: "../../controller/contactosController.php",
    })
      .done(function (data) {
        if (data.success) {
          alertify.alert(data.message);
          document.getElementById("ceder-varios-form").reset();
          document.location.href = "index.php";
        }
        else {
          alertify.alert(data.message);
          document.getElementById("ceder-varios-form").reset();
          document.location.href = "index.php";
        }
      })
      .fail(function (data) {
        alertify.alert('Se ha presentado un problema al iniciar sesión');
      });
  }
});
//****************************************************/
function cederContacto(Id) {
  $("#ceder-modal").modal({ keyboard: true });
  $('#txtCederId').val(Id);
}