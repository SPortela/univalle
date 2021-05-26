  // VALIDACION FORMULARIO CONTACTO
    $("#asignar_agente").validate({
      rules:{
        txtStatus:{
          required: true
        }


      },
      messages:{

        txtStatus:{
          required: "Debe seleccionar un agente"
        }


       },

    submitHandler: function(form){
      var vAgente = $('#txtStatus').val();
      var vId = $('#txtId').val();
      var vData = '';
      // var vData = {"accion":"login", "txtUser":vUser, "txtPass":vPass}
      if (vId == 0 ) {
        vData = {"accion":"ins", "txtName":vName, "txtStatus":vStatus};
      }else{
        vData = {"accion":"asigna", "txtAgente":vAgente, "txtId":vId};
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
            document.getElementById("asignar_agente").reset();
              window.location.href = "index.php";
          }
        else{
          alert(data.message);
          document.getElementById("asignar_agente").reset();
          window.location.href = "index.php";
        }
      })
      .fail(function(data){
        alert('Se ha presentado un problema al iniciar sesi贸n');
      });
     }
  });


  /***************************************************************/
  /*               ASIGNA 1 AGENTE A VARIOS REGISTROS            */
  /***************************************************************/
  function asignar_agentes(Id){
    /* Realiza conexi贸n con el servidor */
    var id = [];
    // tomamos el id de cada elemento chekeado
    $('.update_registro:checked').each(function(i){
        id[i] = $(this).val();
      });
    if(id.length == 0){
        alert("No hay registros seleccionados para asignar");
    }else{
        // abrimos modal con el form
       $("#Modal_Asigna_varios").modal({keyboard: true});
        // validamos el formulario
         $("#asignar_varios").validate({
           rules:{
             txtAgente:{
               required: true
             }
           },
           messages:{
             txtAgente:{
               required: "Debe seleccionar un agente jeejej"
             }
            },

         submitHandler: function(form){
            // recojemos el valor del agente para asignar
           var vAgente = $('#txtAgente').val();
           // peticion ajax
          $.ajax({
            data: {"accion":"asignaV", "txtAgente":vAgente, "pId":id},
            type: "POST",
            datatype: "json",
            url: "../../controller/contactosController.php",
          })
          .done(function(data){
              alert(data.message);
              document.location.href = "index.php";
          })
          .fail(function(){
              alert("Ha ocurrido un problema");
          });
          }
       });
    }
  }


  /***************************************************************/
  /*               CARGA DATOS DE ESTADOS                        */
  /***************************************************************/
  function TipoAsignacion(Id, Cedula){
    /* Realiza conexi贸n con el servidor */
    var vId = Id;
    var vCedula = Cedula;

    if (vId == 1) {
      vId = 2;
    }else{
      vId = 1;
    }


    if(vId != 0){

      $.ajax({
        data: {"accion":"tipoAsignacion", "Tasig":vId, "Cedula":vCedula},
        type: "POST",
        datatype: "json",
        url: "../../controller/usuariosController.php",
      })
      .done(function(data){
        if (data.success) {
          document.location.href = "index.php";
        }
      })
      .fail(function(){
          alert("Ha ocurrido un problema");
      });

    }
  }

  /***************************************************************/
  /*               CARGA DATOS DEL REGISTRO                       */
  /***************************************************************/

  function cargaInfo(Id){
    /* Realiza conexi贸n con el servidor */
    var vId = Id;

    var vurl = "";

    var vurl = "../../controller/contactosController.php";

    if(vId != 0){

      $.ajax({
        data: {"accion":"single", "pId":vId},
        type: "POST",
        datatype: "json",
        url: vurl,
      })

      .done(function(data){
        if (data.success) {
          $('#verContacto').modal({keyboard: false});
          $("#ft").append(data.Status);
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
              if (vTab == 1 ) {
                vData = {"accion":"insSede", "txtName":vName, "txtCel":vCel, "txtStatus2":vInfoP, "txtEmail":vEmail, "txtTratamiento":vTra, "txtCity":vCity, "txtId":vId};
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




  $(document).ready(function() {

    $("#Clean").click(function(){  //"select all" change
      var vacio = "";
      $("#FiltroPrograma option[value=" + vacio +"]").attr("selected",true);
      $("#Filtrorigen option[value=" + vacio +"]").attr("selected",true);
      $("#Filtronombre").val("");
      $("#FiltroCedula").val("");
      /*$("#Filtrorigen option[value=""]").attr("selected",true);*/
    });



  });