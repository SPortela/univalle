 // VALIDACION FORMULARIO CONTACTO
    $("#gestionar").validate({
      rules:{
        txtStatus:{
          required: true
        },
        txtStatus2:{
          required: false
        },
        txtObs:{
          required: true,
          maxlength: 600
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
          maxlength : "Máximo 600 caracteres"
        }

       },

    submitHandler: function(form){
      var vstatus = $('#txtStatus').val();
      var vstatus2 = $('#txtStatus2').val();
      var vObs = $('#txtObs').val();
      var vFechaReunion = $('#txtFechaEntrevista').val();
      var vId = $('#txtId3').val();

      var vData = '';
      // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}

        vData = {"accion":"notificacion", "txtStatus":vstatus, "txtStatus2":vstatus2, "txtObs":vObs, "txtId3":vId, "vFechaReunion":vFechaReunion};

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
        $('#txtId3').val(vId);
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



/***************************************************************/
/*               CARGA DATOS DE USUARIO                          */
/***************************************************************/
function VerDatos(Id){
  /* Realiza conexión con el servidor */
  var vId = Id;
  if(vId != 0){
    $.ajax({
      data: {"accion":"single", "pId":vId},
      type: "POST",
      datatype: "json",
      url:"../../controller/contactosController.php",
    })

    .done(function(data){
      if (data.success) {

        var medio = "";

        if (data.Status2 == 1) {
          medio = "Whatsapp";
        } else if(data.Status2 == 2){
          medio = "Celular";
        }else if(data.Status2 == 3){
          medio = "Asistencia Fisica";
        }else{
          medio = "No registra";
        }
        $('#verEmpresa').modal({keyboard: false});

        $('#st1').html(data.Nombre_estado);
        $('#st2').html(medio);
        $('#nom').html(data.Nombre_completo);
        $('#tel').html(data.Celular);
        $('#ema').html(data.Email);
        $('#ciu').html(data.Ciudad);
        $('#tra').html(data.Tratamiento);
        $('#fec').html(data.Created_date);
        $('#ori').html(data.Origen_Campana);
        $('#Fas').html(data.Fecha_asignado);
        $('#cre').html(data.NombreCreador);
        $('#IdNotificacion').val(data.Id);

      }
    })
    .fail(function(){
        alert("Ha ocurrido un problema");
    });
  }
}


/***************************************************************/
/*               CARGA DATOS DE USUARIO                          */
/***************************************************************/
function CargarEmpresa(Id){
  /* Realiza conexión con el servidor */
  var vId = Id;
  if(vId != 0){
    $.ajax({
      data: {"accion":"single", "pId":vId},
      type: "POST",
      datatype: "json",
      url:"../../controller/contactosController.php",
    })

    .done(function(data){
      if (data.success) {
        $('#NuevaEmpresa').modal({keyboard: false});

        $("#txtTipo option[value="+ data.TipoDoc +"]").attr("selected",true);

        $('#txtDoc').val(data.Cedula);

        $('#txtRsocial').val(data.RazonSocial);
        $('#txtDir').val(data.Direccion);
        $('#txtNameC').val(data.Nombre_completo);
        $('#txtCargo').val(data.Cargo);
        $('#txtEmail').val(data.Email);
        $('#txtFijo').val(data.Fijo);
        $('#txtCel').val(data.Celular);
        $('#txtId').val(data.Campana_Id);
        $('#txtTab').val("2");


        $("#vId").empty();
        $("#vId").append('<input type="hidden" name="txtIdU" id="txtIdU"  class="form-control" value="'+data.Id+'">');



      }
    })
    .fail(function(){
        alert("Ha ocurrido un problema");
    });
  }
}



$("#NuevaFecha").click(function(){

  var NuevaFecha = $("#txtFechaEntrevista2").val();

  if(NuevaFecha == ""){

        alert("DEBE SELECCIONAR UNA FECHA");

  }else{
      var IdNotif = $("#upNoti").val();

      vData = "";

      $.ajax({
        data: {"accion":"reprograma", "vId":IdNotif, "NuevaFecha":NuevaFecha},
        type: "POST",
        datatype: "json",
        url:"../../controller/notificacionesController.php",
      })

      .done(function(data){
        if (data.success) {
          alert(data.message);
          document.location.href = "index.php";

        }
      })
      .fail(function(){
          alert("Ha ocurrido un problema");
      });

  }

  });




$("#BtnGestionarAgendado").click(function(){


  $("#GestionarAgendado").toggle();


  });



$("#BtnNotificacion").click(function(){


  $("#PanelGestionarNotificacion").toggle();


  });




// VALIDACION FORMULARIO CONTACTO
  $("#Paciente").validate({
    rules:{
      txtStatus:{
        required: true
      },
      txtName:{
        required:true

      },
      txtEmail:{
        required:true

      },
      txtCel:{
        required:true

      },
      txtTratamiento:{
        required: true
      }

    },
    messages:{

      txtStatus:{
        required: "Debe seleccionar un estado"
      },
      txtName:{
        required: "Debe escribir un nombre"

      },
      txtEmail:{
        required: "Debe escribir un Email"

      },
      txtCel:{
        required:"Debe escribir un Célular"

      },
      txtTratamiento:{
        required: "Seleccione un tratamiento"
      }

     },

  submitHandler: function(form){

            var vCity = $('#txtCityO').val();
            var vName = $('#txtNameO').val();
            var vEmail = $('#txtEmailO').val();
            var vCel = $('#txtCelO').val();
            var vTra = $('#txtTratamientoO').val();
            var vId = $('#txtIdO').val();
            var vTab = $('#txtTabO').val();
            var vInfoP = $('#txtInfoPO').val();
            var vOrigen = $('#txtOrigenO').val();

            var CedulaAgente = $('#txtCedulaO').val();


            var vData = '';
            // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}
            if (vTab == 0 ) {
              vData = {"accion":"insPerfil", "txtName":vName, "txtCel":vCel, "txtStatus2":vInfoP, "txtEmail":vEmail, "txtTratamiento":vTra, "txtCity":vCity, "txtId":vId, "txtCedulaA":CedulaAgente};
            }else{
              vData = {"accion":"upd", "txtName":vName, "txtCel":vCel, "txtStatus2":vInfoP, "txtEmail":vEmail, "txtTratamiento":vTra, "txtCity":vCity, "txtId":vId};
            }

            $.ajax({
              data: vData,
              type: "POST",
              datatype: "json",
              url:"../../controller/registroRecepcionController.php",
            })
            .done(function(data){
              if (data.success){
                  alert(data.message);
                  document.getElementById("Paciente").reset();
                  window.location.href = "index.php";
                }
              else{
                alert(data.message);
                document.getElementById("Paciente").reset();
                window.location.href = "index.php";
              }
            })
            .fail(function(data){
              alert('Se ha presentado un problema al iniciar sesión');
            });
   }
});




