 // VALIDACION FORMULARIO CONTACTO
    $("#gestionar").validate({
      rules:{
        txtStatus:{
          required: true
        },
        txtStatus2:{
          required: true
        },
        txtObs:{
          required: true,
          maxlength: 200
        }


      },
      messages:{

        txtStatus:{
          required: "Debe seleccionar un Estado"
        },
        txtStatus2:{
          required: "Debe seleccionar un Estado"
        },
        txtObs:{
          required: "Debe dejar un comentario",
          maxlength : "Máximo 200 caracteres"
        }


       },

    submitHandler: function(form){
      var vstatus = $('#txtStatus').val();
      var vstatus2 = $('#txtStatus2').val();
      var vObs = $('#txtObs').val();
      var vId = $('#txtId').val();

      var vData = '';
      // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}

        vData = {"accion":"estado", "txtStatus":vstatus, "txtStatus2":vstatus2, "txtObs":vObs, "txtId":vId};


      $.ajax({
        data: vData,
        type: "POST",
        datatype: "json",
        url:"../../controller/contactosController.php",
      })
      .done(function(data){
        if (data.success){
            alert(data.message);
            document.getElementById("gestionar").reset();
            document.location.href = "index.php";
          }
        else{
          alert(data.message);
          document.getElementById("gestionar").reset();
          document.location.href = "index.php";
        }
      })
      .fail(function(data){
        alert('Se ha presentado un problema al iniciar sesión');
      });
     }
  });


//********************************************************************************************************

  $( "#txtMatri" ).change(function() {
    if (this.value == "Si"){
      $('#txtFechaMAtricula2').show();
      $('#txtFechaMAtricula').focus();
      $('#txtJustificacion2').hide();
    }else if (this.value == "No"){
      $('#txtJustificacion2').show();
      $('#txtFechaMAtricula2').hide();
      $('#txtJustificacion').focus();

    }else{
      $('#txtJustificacion2').hide();
      $('#txtFechaMAtricula2').hide();
    }

  });




$( "#txtSatisfecho" ).change(function() {
  if (this.value == "No"){
    $('#txtSatisfechoNo').show();
    $('#txtSatisfeNo').focus();
  }else if (this.value == "Si"){
    $('#txtSatisfechoNo').hide();
    $('#txtTrabaja').focus();
  }

});





$( "#txtObsFinal" ).change(function() {
  if (this.value == "No contactado"){
    $('#txtNoContacta2').show();
    $('#txtNoContacta').focus();

  }else{
    $('#txtNoContacta2').hide();

  }

});




// VALIDACION FORMULARIO CONTACTO
   $("#gestionarAntiguos").validate({
     rules:{
       txtMatri:{
         required: true
       },
       txtActivoCorreo:{
         required: true
       },
       txtSatisfecho:{
          required: true
       },
       txtTrabaja:{
          required: true
       },
       txtRetiro:{
          required: true
       },
       txtObs:{
         required: true,
         maxlength: 300
       },
       txtObsFinal:{
         required: true,
         maxlength: 300
       },
       txtNoContacta:{
        required: true
       }


     },
     messages:{
       txtMatri:{
         required: "Debe seleccionar una Opcion"
       },
       txtActivoCorreo:{
         required: "Debe seleccionar una Opcion"
       },
       txtSatisfecho:{
          required: "Debe seleccionar una Opcion"
       },
       txtTrabaja:{
          required: "Debe seleccionar una Opcion"
       },
       txtRetiro:{
          required: "Debe seleccionar una Opcion"
       },
       txtObs:{
         required: "Debe dejar un comentario",
         maxlength : "Máximo 200 caracteres"
       },
       txtObsFinal:{
         required: "Debe dejar un comentario",
         maxlength : "Máximo 200 caracteres"
       },
       txtNoContacta:{
        required: "Debe seleccionar una Opcion"
       }


      },

   submitHandler: function(form){
     var vMatri = $('#txtMatri').val();
     //Si vMatri = No
     var vJustifiMatri = $('#txtJustificacion').val();
     if(vJustifiMatri == ""){
        vJustifiMatri = "No Aplica"
     }
     //Si vMatri = Si
     var vFechaMatri = $('#txtFechaMAtricula').val();
     if(vFechaMatri == ""){
        vFechaMatri = "No Aplica"
     }
     var vActivoCorreo = $('#txtActivoCorreo').val();
     var vSatisfecho = $('#txtSatisfecho').val();
     //Si vSatisfecho = No
     var vInsatisfecho = $('#txtSatisfeNo').val();
     if(vInsatisfecho == ""){
        vInsatisfecho = "No Aplica"
     }
     var vTrabaja = $('#txtTrabaja').val();
     var vRetirar = $('#txtRetiro').val();
     var vObs2 = $('#txtObs2').val();
     var vObsFinal = $('#txtObsFinal').val();
     var vNoContacta = $('#txtNoContacta').val();
     if(vNoContacta == ""){
        vNoContacta = "No Aplica"
     }
     var vIdA = $('#txtIdA').val();

    var vData = '';



    vData = {"accion":"antiguos", "txtMatri":vMatri, "txtJustificacion":vJustifiMatri, "txtFechaMAtricula":vFechaMatri, "txtActivoCorreo":vActivoCorreo, "txtSatisfecho":vSatisfecho,
              "txtSatisfeNo":vInsatisfecho, "txtTrabaja":vTrabaja, "txtRetiro":vRetirar, "txtObs2":vObs2, "txtObsFinal":vObsFinal, "txtNoContacta":vNoContacta, "txtIdA":vIdA};


     $.ajax({
       data: vData,
       type: "POST",
       datatype: "json",
       url:"../../controller/contactosController.php",
     })
     .done(function(data){
       if (data.success){
           alert(data.message);
           document.getElementById("gestionarAntiguos").reset();
           document.location.href = "index.php";
         }
       else{
         alert(data.message);
         document.getElementById("gestionarAntiguos").reset();
         document.location.href = "index.php";
       }
     })
     .fail(function(data){
       alert('Se ha presentado un problema al iniciar sesión');
     });
    }
 });




// ***************************************************

function cargaGestion(Id){
  /* Realiza conexión con el servidor */
  var vId = Id;
  if(vId != 0){
    $.ajax({
      data: {"accion":"single", "pId":vId},
      type: "POST",
      datatype: "json",
      url: "../../controller/contactosController.php",
    })
    .done(function(data){
      if (data.success) {
        $("#gestionar_contacto").modal({keyboard: true});
        $('#txtId').val(vId);
      }
    })
    .fail(function(){
        alert("Ha ocurrido un problema");
    });
  }
}


// ***************************************************

function cargaGestionAntiguos(Id){
  /* Realiza conexión con el servidor */
  var vId = Id;
  if(vId != 0){
    $.ajax({
      data: {"accion":"single", "pId":vId},
      type: "POST",
      datatype: "json",
      url: "../../controller/contactosController.php",
    })
    .done(function(data){
      if (data.success) {
        $("#gestionar_contacto_Antiguo").modal({keyboard: true});
        $('#txtIdA').val(vId);
      }
    })
    .fail(function(){
        alert("Ha ocurrido un problema");
    });
  }
}