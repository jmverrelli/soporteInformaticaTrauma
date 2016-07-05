<script type="text/javascript">
	
 $("#jqGridStock").jqGrid(
{ 
    url:'forms/traerStock.php', 
    /*postData: {nrodoc:nrodoc, tipodoc:tipodoc}, 
    mtype: "POST",*/
    datatype: "json",
    colNames:['Id','equipo', 'Cantidad',''],
    colModel:[ 
    {name:'Id', index:'Id',width:'100%',align:"left",fixed:true,editable:false},
    {name:'Equipo', index:'Equipo',width:'100%',align:"left",fixed:true,editable:false, search: true, sortable:true},
    {name:'Cantidad', index:'Cantidad',width:'100%',align:"left",fixed:true,editable:true,sortable:true},
    {name: 'myac', width: '40%', fixed: true, sortable: false, resize: false, formatter: 'actions', search: false,
        formatoptions: 
            {
                keys: true,
                delbutton: false,
                editbutton: false,
                onError: function(_, xhr) {
                alert(xhr.responseText);
                    }
                }
            }
    ],    
    rowNum:true, 
    viewrecords: true,
    altRows : true,
    caption:"Stock",
    rowNum:20, 
    rowList:[10,20,30,50],
    pager: '#jqStockFoot',
    editurl :'forms/inlineEditStock.php',
    sortname: 'Id',
    sortorder: "desc",
    width: '1024px',
    height: '100%',
    ajaxRowOptions: { async: true }
});

  jQuery("#jqGridStock").jqGrid('filterToolbar', { stringResult: true, searchOnEnter: false, defaultSearch: "cn" });
</script>

<table id="jqGridStock" name="jqGridStock"></table>  
    <div id="jqStockFoot"></div>