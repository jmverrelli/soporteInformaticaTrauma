<script type="text/javascript">
	
 $("#jqgridListos").jqGrid(
{ 
    url:'forms/traerReparaciones.php', 
    /*postData: {nrodoc:nrodoc, tipodoc:tipodoc}, 
    mtype: "POST",*/
    datatype: "json",
    colNames:['Id','equipo', 'estado', 'fecha_ingreso', 'hora_ingreso','centro', 'sector','observaciones',''],
    colModel:[ 
    {name:'id', index:'id',width:'100%',align:"left",fixed:true,editable:false},
    {name:'equipo', index:'equipo',width:'100%',align:"left",fixed:true,editable:true, search: true, sortable:true},
    {name:'estado', index:'estado',width:'100%',align:"center",fixed:true,editable:true,sortable:true, edittype:"select",
	editoptions:{value:"1:En espera;2:En reparacion;3:Reparado;4:Entregado;5:Baja;"}},
    {name:'fecha_ingreso', index:'fecha_ingreso',width:'100%',align:"left",fixed:true,editable:true,sortable:true},
    {name:'hora_ingreso', index:'hora_ingreso',width:'100%',align:"left",fixed:true,editable:true},
    {name:'centro', index:'centro',width:'100%',align:"center",fixed:true,editable:true,sortable:true, edittype:"select",
	editoptions:{value:"1:Abete;2:Pediatrico;3:Materno;4:Cormillot;5:Polo;6:Drozdowski;7:Otros"}},
    {name:'sector', index:'sector',width:'100%',align:"left",fixed:true,editable:true,sortable:true},
    {name:'observaciones', index:'observaciones',width:'100%',align:"left",fixed:true,editable:true, search: false, sortable:false},                
                    {name: 'myac', width: '40%', fixed: true, sortable: false, resize: false, formatter: 'actions', search: false,
                    formatoptions: 
                    {
                        keys: true,
                        delbutton: false,
                        editbutton: true,
                        onError: function(_, xhr) {
                            alert(xhr.responseText);
                        }
                    }
                }
    ],    
    rowNum:true, 
    viewrecords: true,
    altRows : true,
    caption:"Equipos",
    rowNum:20, 
    rowList:[10,20,30,50],
    pager: '#jqListosFoot',
    editurl :'forms/inlineEdit.php',
    sortname: 'id',
    sortorder: "desc",
    width: '1024px',
    height: '100%',
    ajaxRowOptions: { async: true }
});

  jQuery("#jqgridListos").jqGrid('filterToolbar', { stringResult: true, searchOnEnter: false, defaultSearch: "cn" });
</script>

<table id="jqgridListos" name="jqgridListos"></table>  
    <div id="jqListosFoot"></div>