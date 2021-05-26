// VALIDACION FORMULARIO CONTACTO
	$("#login").validate({
  	rules:{
  		txtUser:{
  			required: true
  		},
      txtPass:{
        required:true

      }

  	},
  	messages:{

  		txtUser:{
  			required: "Debe escribir su Usuario"
  		},
      txtPass:{
        required: "Debe escribir su Contraseña"

      }

  	 },

  submitHandler: function(form){
            var vUser = $('#txtUser').val();
            var vPass = $('#txtPass').val();
            // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}

            $.ajax({
              data: {"accion":"login", "txtUser":vUser, "txtPass":vPass},
              type: "POST",
              datatype: "json",
              url:"../controller/accessController.php",
            })
            .done(function(data){


              if (data.success){

                if (data.Perfil == 1) {
                  document.location.href = "../vista/home/";
                  document.getElementById("login").reset();
                }else if (data.Perfil == 0) {
                  document.location.href = "../vista/agente/";
                  document.getElementById("login").reset();
                }else if (data.Perfil == 5) {
                  document.location.href = "../vista/recepcion/";
                  document.getElementById("login").reset();

                }else if(data.Perfil == 6) {

                  document.location.href = "../vista/administrativo/";
                  document.getElementById("login").reset();

                }else{
                  document.location.href = "../vista/agencia/";
                  document.getElementById("login").reset();
                }
              }
              else{
                alert(data.message);
                document.getElementById("login").reset();
              }
            })
            .fail(function(data){
              alert('Se ha presentado un problema al iniciar sesión');
            });
   }





});