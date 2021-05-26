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
              url:"controller/accessController.php",
            })
            .done(function(data){
              if (data.success){
                if (data.Perfil == 1) {
                  document.location.href = "../vista/home/";
                }else{
                  alertify.alert("Perfil Incorrecto");
                  document.getElementById("form_zonasegura").reset();
                }
              }
              else{
                alertify.alert(data.message);
                document.getElementById("login").reset();
              }
            })
            .fail(function(data){
              alert('Se ha presentado un problema al iniciar sesión');
            });
   }
});