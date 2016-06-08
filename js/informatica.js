

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



