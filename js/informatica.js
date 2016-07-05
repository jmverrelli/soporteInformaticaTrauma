

$(document).ready(function(){
  
 $('#agregarInsumo').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-agregarReparacion").css('visibility',"visible");
        $("#dialog-agregarReparacion").load("forms/agregarInsumo.php"/*,{cod_centro:centro,nombre_centro:nombrecentro 
        ,cod_secfis:cod_secfis,sectorFisico:sectorFisico}*/,function(){
          $("#dialog-agregarReparacion").dialog({
            modal: true,
           width: "500px",
            height: "auto",
            title: "Agregar Insumo",
            buttons:
            {
              "Agregar":function()
                {
                    /*datastring = "&tipodoc="+tipoDoc+"&nrodoc="+nroDoc;*/
                    dataForm = $('#formInsumo').serialize();
                    $.ajax({
                      data: dataForm,
                      type: "POST",
                      dataType: "json",
                      url: "forms/validarInsumo.php",
                      success: function(data)
                      {
                        if(data.ret)
                        {
                          alert("Equipo agregado correctamente.");
                          location.reload();
                        }
                        else
                        {
                          alert("Hubo un error al ingresar el equipo.");
                        }
                      }
                    });
                },
                "Cerrar":function()
                {
                    $(this).dialog("close");
                }
            }
          });
        });          
  });

 $('#altaUsuario').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-Altausuario").css('visibility',"visible");
        $("#dialog-Altausuario").load("forms/altaUsuario.php",function(){  //HACER ESTE FORM
          $("#dialog-Altausuario").dialog({
            modal: true,
           width: "500px",
            height: "auto",
            title: "Agregar Usuario",
            buttons:
            {
              "Agregar":function()
                {
                    dataForm = $('#formAltaUsuario').serialize(); //PONERLE ESTE ID AL FORM
                    $.ajax({
                      data: dataForm,
                      type: "POST",
                      dataType: "json",
                      url: "forms/agregarUsuario.php", //hacer este php para guardar
                      success: function(data)
                      {
                        if(data.ret)
                        {
                          alert(data.message);
                          location.reload();
                        }
                        else
                        {
                          alert(data.message);
                        }
                      }
                    });
                },
                "Cerrar":function()
                {
                    $(this).dialog("close");
                }
            }
          });
        });          
  });

  $('#modiUsuario').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-ModiUsuario").css('visibility',"visible");
        $("#dialog-ModiUsuario").load("forms/modiUsuario.php",function(){ 
          $("#dialog-ModiUsuario").dialog({
            modal: true,
           width: "500px",
            height: "auto",
            title: "Modifcar Usuario",
            buttons:
            {
              "Modificar":function()
                {
                    dataForm = $('#formModiUsuario').serialize(); //PONERLE ESTE ID AL FORM
                    $.ajax({
                      data: dataForm,
                      type: "POST",
                      dataType: "json",
                      url: "forms/guardarModiUsuario.php", //hacer este php para guardar
                      success: function(data)
                      {
                        if(data.ret)
                        {
                          alert(data.message);
                          location.reload();
                        }
                        else
                        {
                          alert(data.message);
                        }
                      }
                    });
                },
                "Cerrar":function()
                {
                    $(this).dialog("close");
                }
            }
          });
        });          
  });


  $('#bajaUsuario').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-Bajausuario").css('visibility',"visible");
        $("#dialog-Bajausuario").load("forms/bajaUsuario.php",function(){ //HACER ESTE FORM
          $("#dialog-Bajausuario").dialog({
            modal: true,
           width: "500px",
            height: "auto",
            title: "Eliminar Usuario",
            buttons:
            {
              "Eliminar":function()
                {
                    dataForm = $('#formBajaUsuario').serialize(); //PONERLE ESTE ID AL FORM
                    $.ajax({
                      data: dataForm,
                      type: "POST",
                      dataType: "json",
                      url: "forms/eliminarUsuario.php", //hacer este php para guardar
                      success: function(data)
                      {
                        if(data.ret)
                        {
                          alert(data.message);
                          location.reload();
                        }
                        else
                        {
                          alert(data.message);
                        }
                      }
                    });
                },
                "Cerrar":function()
                {
                    $(this).dialog("close");
                }
            }
          });
        });          
  });


 $('#listaPedidos').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-todasReparaciones").css('visibility',"visible");
        $("#dialog-todasReparaciones").load("forms/listaReparaciones.php"/*,{cod_centro:centro,nombre_centro:nombrecentro 
        ,cod_secfis:cod_secfis,sectorFisico:sectorFisico}*/,function(){
          $("#dialog-todasReparaciones").dialog({
            modal: true,
           width: "auto",
            height: "auto",
            title: "Reparaciones",
            buttons:
            {
                "Cerrar":function()
                {
                    $(this).dialog("close");
                    location.reload();
                }
            },
            closeOnEscape: false,
            open: function(event, ui) {
                $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
            }
          });
        });          
  });

  $('#listaStock').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-listaStock").css('visibility',"visible");
        $("#dialog-listaStock").load("forms/listaStock.php"/*,{cod_centro:centro,nombre_centro:nombrecentro 
        ,cod_secfis:cod_secfis,sectorFisico:sectorFisico}*/,function(){
          $("#dialog-listaStock").dialog({
            modal: true,
           width: "auto",
            height: "auto",
            title: "Stock",
            buttons:
            {
                "Cerrar":function()
                {
                    $(this).dialog("close");
                    location.reload();
                }
            },
            closeOnEscape: false,
            open: function(event, ui) {
                $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
            }
          });
        });          
  });

    $('#listaStockSinEd').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-listaStockSinEd").css('visibility',"visible");
        $("#dialog-listaStockSinEd").load("forms/listaStockSinEd.php"/*,{cod_centro:centro,nombre_centro:nombrecentro 
        ,cod_secfis:cod_secfis,sectorFisico:sectorFisico}*/,function(){
          $("#dialog-listaStockSinEd").dialog({
            modal: true,
           width: "auto",
            height: "auto",
            title: "Stock",
            buttons:
            {
                "Cerrar":function()
                {
                    $(this).dialog("close");
                    location.reload();
                }
            },
            closeOnEscape: false,
            open: function(event, ui) {
                $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
            }
          });
        });          
  });


 $('#agregarStock').click(function(event){
    event.preventDefault();
        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialog-agregarStock").css('visibility',"visible");
        $("#dialog-agregarStock").load("forms/agregarStock.php",function(){  //HACER ESTE FORM
          $("#dialog-agregarStock").dialog({
            modal: true,
           width: "500px",
            height: "auto",
            title: "Agregar Nuevo Item al Stock",
            buttons:
            {
              "Agregar":function()
                {
                    dataForm = $('#formAltaStock').serialize(); //PONERLE ESTE ID AL FORM
                    $.ajax({
                      data: dataForm,
                      type: "POST",
                      dataType: "json",
                      url: "forms/agregarNuevoStock.php", //hacer este php para guardar
                      success: function(data)
                      {
                        if(data.ret)
                        {
                          alert(data.message);
                          location.reload();
                        }
                        else
                        {
                          alert(data.message);
                        }
                      }
                    });
                },
                "Cerrar":function()
                {
                    $(this).dialog("close");
                }
            }
          });
        });          
  });



 $('#guardarCambiosEquipos').click(function(event){
    event.preventDefault();
    /*datastring = "&tipodoc="+tipoDoc+"&nrodoc="+nroDoc;*/
    dataForm = $('#formReparaciones').serialize();
    $.ajax({
      data: dataForm,
      type: "POST",
      dataType: "json",
      url: "forms/modificarInsumo.php",
      success: function(data)
      {
        if(data.ret)
        {
          alert("Equipo actualizado correctamente.");
          location.reload();
        }
        else
        {
          alert("Hubo un error al ingresar el equipo.");
        }
      }
    });
});


});



