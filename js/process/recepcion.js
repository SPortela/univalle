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
            var vCity = $('#txtCity').val();
            var vName = $('#txtName').val();
            var vEmail = $('#txtEmail').val();
            var vCel = $('#txtCel').val();
            var vTra = $('#txtTratamiento').val();
            var vId = $('#txtId').val();
            var vInfoP = $('#txtInfoP').val();
            var vData = '';
            // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}
            if (vId == 0 ) {
              vData = {"accion":"ins", "txtName":vName, "txtCel":vCel, "txtStatus2":vInfoP, "txtEmail":vEmail, "txtTratamiento":vTra, "txtCity":vCity, "txtId":vId};
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

  /***************************************************************/
  /*               CARGA DATOS DE ESTADOS                        */
  /***************************************************************/
  function VerDatos(Id){
    /* Realiza conexión con el servidor */
    var vId = Id;

    var vurl = "";

    var vurl = "../../controller/registroRecepcionController.php";

    if(vId != 0){

      $.ajax({
        data: {"accion":"single", "pId":vId},
        type: "POST",
        datatype: "json",
        url: vurl,
      })

      .done(function(data){
        if (data.success) {

          var medio = "";

          if(data.Status2 == 1){
            medio = "Whatsapp";
          }else if(data.Status2 == 2){
            medio = "Celular";
          }else if(data.Status2 == 3){
            medio = "Asistencia Fisica";
          }


          $('#verContacto').modal({keyboard: false});
          $("#ft").empty();
          $("#ft").append(data.Status);
          $('#Medio').html(medio);
          $('#cedu').html(data.Cedula);
          $('#nombre').html(data.Nombre_completo);
          $('#tel').html(data.Celular);
          $('#dir').html(data.Tratamiento);
          $('#mail').html(data.Email);
          $('#per').html(data.Ciudad);
          $('#usu').html(data.Origen_Campana);
          $('#reg').html(data.Usuario_agente);
          $('#reg2').html(data.Created_date);
          $('#cre').html(data.NombreCreador);
          $("#upd").empty();
          $("#upd").append('<input type="hidden" id="img" name="accion" class="form-control" value="upd">');
          $('#txtId').val(vId);
        }
      })
      .fail(function(){
          alert("Ha ocurrido un problema");
      });
    }
  }



  /***************************************************************/
  /*               CARGA DATOS DE ESTADOS                        */
  /***************************************************************/
  function cargaUpdate(Id){
    /* Realiza conexión con el servidor */
    var vId = Id;

    var vurl = "";

    var Status2 = "";

    var vurl = "../../controller/registroRecepcionController.php";

    if(vId != 0){

      $.ajax({
        data: {"accion":"single", "pId":vId},
        type: "POST",
        datatype: "json",
        url: vurl,
      })

      .done(function(data){
        if (data.success) {

          $("#txtTab").val('2');

          $('#NuevaEmpresa').modal({keyboard: false});
          $('#txtName').val(data.Nombre_completo);
          $('#txtCel').val(data.Celular);
          $('#txtEmail').val(data.Email);

          $("#txtTratamiento option[value='"+ data.Tratamiento +"']").attr("selected",true);
          $("#txtInfoP option[value='"+ data.Status2 +"']").attr("selected",true);

          $('#txtId').val(vId);
        }
      })
      .fail(function(){
          alert("Ha ocurrido un problema");
      });
    }
  }



  /***************************************************************/
  /*               CARGA DATOS DE ESTADOS                        */
  /***************************************************************/
  function cargaUpdateU(Id){
    /* Realiza conexión con el servidor */
    var vId = Id;

    var vurl = "";

    var vurl = "../../controller/administrativoController.php";

    if(vId != 0){

      $.ajax({
        data: {"accion":"single", "pId":vId},
        type: "POST",
        datatype: "json",
        url: vurl,
      })

      .done(function(data){
        if (data.success) {

          $("#txtTab").val('2');

          $('#NuevaEmpresa').modal({keyboard: false});
          $('#txtName').val(data.Nombre_completo);
          $('#txtCel').val(data.Celular);
          $('#txtEmail').val(data.Email);

          $("#txtTratamiento option[value='"+ data.Tratamiento +"']").attr("selected",true);

          $('#txtId').val(vId);
        }
      })
      .fail(function(){
          alert("Ha ocurrido un problema");
      });
    }
  }