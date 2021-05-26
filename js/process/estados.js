// VALIDACION FORMULARIO CONTACTO
	$("#estados").validate({
  	rules:{
  		txtStatus:{
  			required: true
  		},
      txtName:{
        required:true

      },
      txtTipo:{
        required:true

      }

  	},
  	messages:{

  		txtStatus:{
  			required: "Debe seleccionar un estado"
  		},
      txtName:{
        required: "Debe escribir un nombre"

      },
      txtTipo:{
        required:"Debe seleccionar una opción"

      }

  	 },

  submitHandler: function(form){
            var vStatus = $('#txtStatus').val();
            var vName = $('#txtName').val();
            var vOpcion = $('#txtTipo').val();
            var vColor = $('#txtColor').val();
            var vId = $('#txtId').val();
            var vData = '';
            // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}
            if (vId == 0 ) {
              vData = {"accion":"ins", "txtName":vName, "txtStatus":vStatus, "txtTipo":vOpcion, "txtColor":vColor};
            }else{
              vData = {"accion":"upd", "txtName":vName, "txtStatus":vStatus, "txtId":vId, "txtTipo":vOpcion, "txtColor":vColor};
            }

            $.ajax({
              data: vData,
              type: "POST",
              datatype: "json",
              url:"../../controller/estadosController.php",
            })
            .done(function(data){
              if (data.success){
                  alert(data.message);
                  document.getElementById("estados").reset();
                  window.location.href = "index.php";
                }
              else{
                alertify.alert(data.message);
                document.getElementById("login").reset();
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
  function cargaEstado(Id){
    /* Realiza conexión con el servidor */
    var vId = Id;
    if(vId != 0){
      $.ajax({
        data: {"accion":"single", "pId":vId},
        type: "POST",
        datatype: "json",
        url: "../../controller/estadosController.php",
      })
      .done(function(data){
        var color = "";
        if (data.success) {

          color = data.Color;

          $("#Modal_Usuarios").modal({keyboard: true});
          $('#txtStatus').val(data.Status);
          $('#txtName').val(data.Nombre);
          $("#txtTipo option[value='"+ data.Tipo +"']").attr("selected",true);
          $("#txtColor").val(color);
          $('#txtId').val(vId);
          //$('#contColor').empty();
        }
      })
      .fail(function(){
          alert("Ha ocurrido un problema");
      });
    }
  }