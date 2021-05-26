 // VALIDACION FORMULARIO CONTACTO
 $("#EnviarFormGestionado").click(function(){
    var vStatus1 = $("#txtStatus3").val();
    var vStatus2 = $("#txtStatus23").val();
    var vtxtObserva = $("#txtObs3").val();
    var vtxtIdEMp = $("#txtId").val();
    var vtxtIdUser = $("#IdUsuario").val();
    var vtxtIdNotifi = $("#IdNotificacion").val();





    var msg  = "";

    if(vStatus1 == ""){

      msg += '- Debe seleccionar un estado. \n';


    }

    /*if(vStatus2 == ""){

      msg += '- Debe seleccionar un segundo estados. \n';

    }*/

    if(vtxtObserva == ""){

      msg += '- Ingrese una observación. \n';


    }

    if (msg != "") {

      alert(msg);

    }



    var vData = '';
    // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}

      vData = {"accion":"GestionAgenda", "txtStatus3":vStatus1, "txtStatus23":vStatus2, "txtObs3":vtxtObserva, "txtId":vtxtIdEMp, "IdNotificacion":vtxtIdNotifi};

    $.ajax({
      data: vData,
      type: "POST",
      datatype: "json",
      url:"../../controller/contactosController.php",
    })
    .done(function(data){
      if (data.success){
          alert(data.message);
          //document.getElementById("Formgestionar1").reset();
          document.location.href = "index.php";
        }
      else{
        alert(data.message);
        //document.getElementById("Formgestionar1").reset();
        document.location.href = "index.php";
      }
    })
    .fail(function(data){
      alert('Se ha presentado un problema al iniciar sesión');
      document.location.href = "index.php";
    });




  });





 // VALIDACION FORMULARIO CONTACTO
 $("#EnviarGestionado").click(function(){



    var vStatusG = $("#txtStatusGestion").val();
    var vInfoG = $("#txtInfoGestion").val();
    var vObsG = $("#txtObsGestion").val();
    var vIdEMpG = $("#txtEmpGestion").val();
    var vIdUserG = $("#IdUsuarioGestion").val();
    var vIdNotifiG = $("#IdNotiGestion").val();





    var msg  = "";

    if(vStatusG == ""){

      msg += '- Debe seleccionar un estado. \n';


    }

    /*if(vStatus2 == ""){

      msg += '- Debe seleccionar un segundo estados. \n';

    }*/

    if( vObsG == ""){

      msg += '- Ingrese una observación. \n';


    }

    if (msg != "") {

      alert(msg);


    }



    var vData = '';
    // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}

      vData = {"accion":"GestionAgenda", "txtStatus3":vStatusG, "txtStatus23":vInfoG, "txtObs3":vObsG, "txtId":vIdEMpG, "IdNotificacion":vIdNotifiG};

    $.ajax({
      data: vData,
      type: "POST",
      datatype: "json",
      url:"../../controller/contactosController.php",
    })
    .done(function(data){
      if (data.success){
          alert(data.message);


          document.location.href = "index.php";
        }
      else{
        alert(data.message);

        document.location.href = "index.php";
      }
    })
    .fail(function(data){
      alert('Se ha presentado un problema al iniciar sesión');
      document.location.href = "index.php";
    });




  });



























 // VALIDACION FORMULARIO CONTACTO
   $("#form_empresa").validate({
     rules:{

       txtTipo:{
         required: true
       },
       txtDoc:{
         required: true
       },
       txtRsocial:{
         required: true
       },
       txtDir:{
         required: true
       },
       txtNameC:{
         required: true
       },
       txtCargo:{
         required: true
       },
       txtEmail:{
         required: true
       },
       txtFijo:{
         required: true
       },
       txtCel:{
         required: true
       }




     },
     messages:{

       txtTipo:{
         required: "Debe seleccionar una opcion"
       },
       txtDoc:{
         required: "Campo obligatorio"
       },
       txtRsocial:{
         required: "Campo obligatorio"
       },
       txtDir:{
         required: "Campo obligatorio"
       },
       txtNameC:{
         required: "Campo obligatorio"
       },
       txtCargo:{
         required: "Campo obligatorio"
       },
       txtEmail:{
         required: "Campo obligatorio"
       },
       txtFijo:{
         required: "Campo obligatorio"
       },
       txtCel:{
         required: "Campo obligatorio"
       }


      },

   submitHandler: function(form){


     var TipoDoc = $('#txtTipo').val();
     var Nit = $('#txtDoc').val();
     var RazonSocial = $('#txtRsocial').val();
     var Direccion = $('#txtDir').val();
     var NameC = $('#txtNameC').val();
     var Cargo = $('#txtCargo').val();
     var Email = $('#txtEmail').val();
     var Fijo = $('#txtFijo').val();
     var Cel = $('#txtCel').val();
     var vTab = $('#txtTab').val();
     var vCamp = $('#txtId').val();





     var vData = '';

     // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}
     if (vTab == 1 ) {
       vData = {"accion":"ins", "txtTipo":TipoDoc, "txtDoc":Nit, "txtRsocial":RazonSocial, "txtDir":Direccion, "txtNameC":NameC,
        "txtCargo":Cargo, "txtEmail":Email, "txtFijo":Fijo, "txtCel":Cel, "txtId":vCamp};
     }else{
         var vIdUser = $('#txtIdU').val();
       vData = {"accion":"upd", "txtTipo":TipoDoc, "txtDoc":Nit, "txtRsocial":RazonSocial, "txtDir":Direccion, "txtNameC":NameC,
        "txtCargo":Cargo, "txtEmail":Email, "txtFijo":Fijo, "txtCel":Cel, "txtId":vCamp, "txtIdup":vIdUser};
     }

     $.ajax({
       data: vData,
       type: "POST",
       datatype: "json",
       url:"../../controller/contactosController.php",
     })
     .done(function(data){
       if (data.success){
           alert(data.message);
           document.getElementById("form_empresa").reset();
             window.location.href = "index.php";
         }
       else{
         alert(data.message);
         document.getElementById("form_empresa").reset();
         window.location.href = "index.php";
       }
     })
     .fail(function(data){
       alert('Se ha presentado un problema al iniciar sesión');
     });
    }
 });













   /***************************************************************/
   /*               CARGA DATOS DE USUARIO                          */
   /***************************************************************/
   function cargaModal(Id){
     /* Realiza conexión con el servidor */
     var vId = Id;

     if(vId != 0){
       $.ajax({
         data: {"accion":"single", "pId":vId},
         type: "POST",
         datatype: "json",
         url:"../../controller/notificacionesController.php",
       })

       .done(function(data){
         if (data.success) {
           $('#ModalNotificacion2').modal({keyboard: false});
           //$("#txtTipo option[value="+ data.TipoDoc +"]").attr("selected",true);

          $('#stGestion').html(data.Status);
          $('#pName').html(data.Nombre);
          $('#pCor').html(data.Email);
          $('#pCel').html(data.Celular);
          $('#DateGestion').html(data.Fecha_Cita);
          $('#ComentAgendado').html(data.Comentario);
          $('#upNotiGestion').val(data.Id);
          $('#txtEmpGestion').val(data.Empresa_Id);
          $('#IdNotiGestion').val(data.Id);
          $('#IdUsuarioGestion').val(data.Registro_Id);
          $('#txtFechaGestionNoti').val(data.Fecha_Cita);

         }
       })
       .fail(function(){
           alert("Ha ocurrido un problema");
       });
     }
   }




   $("#NuevaFechaGestion").click(function(){

     var NuevaFecha = $("#txtFechaGestionNoti").val();

     if(NuevaFecha == ""){

           alert("DEBE SELECCIONAR UNA FECHA");

     }else{
         var IdNotif = $("#upNotiGestion").val();

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