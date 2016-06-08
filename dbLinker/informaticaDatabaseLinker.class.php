<?php
include_once 'conectionData.php';
include_once 'dataBaseConnector.php';
include_once 'utils.php';
include_once 'FirePHPCore/FirePHPINF.class.php';

class informaticaDataBaseLinker
{

	var $dbInf;

//-------------------------------------Constructor--------------------------------------------//
	function informaticaDataBaseLinker()
	{
		$this->dbInf = new dataBaseConnector(HOSTING,0,DBPRUEB,USRPRUEB,PASSPRUEB);
	}
//---------------------------------------------------------------------------------------------//

	function agregarInsumo($data)
	{
		$response = new stdClass();
		$response->ret = false;
		$response->message = "Hubo un error agregando el equipo.";
		$query = "INSERT INTO informatica (equipo, estado, fecha_ingreso, hora_ingreso, centro, sector, observaciones,fecha_modificado)
					VALUES('".$data['insumo']."','".$data['estado']."','".$data['fechaRecibido']."','".$data['horaRecibido']."',
					'".$data['centro']."','".$data['sector']."','".$data['observaciones']."',now());";

		try{$this->dbInf->conectar();$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Equipo agregado correctamente.";}
		catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}

		$this->dbInf->desconectar();

		return $response;

	}

	function traerLista()
	{
		$query = "SELECT * from informatica ORDER BY fecha_modificado DESC limit 30;";

		try{$this->dbInf->conectar();$this->dbInf->ejecutarAccion($query);}
		catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}
		$ret = array();
		for($i = 0 ; $i < $this->dbInf->querySize; $i++)
		{
			$result = $this->dbInf->fetchRow($query);
			$ret[] = array('id' => $result['id'],'equipo' => $result['equipo'],'estado' => $result['estado'],'fecha_ingreso' => $result['fecha_ingreso'],'hora_ingreso' => $result['hora_ingreso'],'centro' => $result['centro'],'sector' => $result['sector'], 'observaciones' =>$result['observaciones']);
		}
		$this->dbInf->desconectar();
		return $ret;

	}

	function modificarInsumo($data)
	{
		$response = new stdClass();
		$response->ret = false;
		$response->message = "Hubo un error al actualizar el equipo.";
		$this->dbInf->conectar();
		foreach ($data as $key => $value) {
			$query = "UPDATE informatica SET estado = ".$value." WHERE id = ".$key;
			try{$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Equipo agregado correctamente.";}
			catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}
			
		}

		$this->dbInf->desconectar();
		return $response;

	}

	function getEquiposJson($page, $rows, $filters, $sidx, $sord)
    {
        $response = new stdClass();
        $this->dbInf->conectar();

        $equipossarray = $this->getEquipos($page, $rows, $filters, $sidx, $sord); //

        $response->page = $page;
        $response->total = ceil($this->getCantidadEquipos($filters) / $rows); //
        $response->records = $this->getCantidadEquipos($filters); //

        $this->dbInf->desconectar();

        for ($i=0; $i < count($equipossarray) ; $i++) 
        {
            $equipos = $equipossarray[$i];
            //id de fila
            $response->rows[$i]['id'] = $equipos['id']; 
            //datos de la fila en otro array
            $row = array();
            $row[] = $equipos['id'];
            $row[] = $equipos['equipo'];
            //$row[] = $equipos['estado'];
            switch ($equipos['estado']) {
            	case '1':
            		$row[] = 'En espera';
            		break;
            	case '2':
            		$row[] = 'En reparacion';
            		break;
            	case '3':
            		$row[] = 'Reparado';
            		break;
            	case '4':
            		$row[] = 'Entregado';
            		break;

            	case '5':
            		$row[] = 'Baja';
            		break;
            	
            	default:
            		$row[] = $equipos['estado'];
            		break;
            }
            $row[] = $equipos['fecha_ingreso'];
            $row[] = $equipos['hora_ingreso'];
            //$row[] = $equipos['centro'];
           	 switch ($equipos['centro']) {
            	case '1':
            		$row[] = 'Abete';
            		break;
            	case '2':
            		$row[] = 'Pediatrico';
            		break;
            	case '3':
            		$row[] = 'Materno';
            		break;
            	case '4':
            		$row[] = 'Cormillot';
            		break;

            	case '5':
            		$row[] = 'Polo';
            		break;

            	case '6':
            		$row[] = 'Drozdowski';
            		break;

            	case '7':
            		$row[] = 'Otros';
            		break;
            	
            	default:
            		$row[] = $equipos['estado'];
            		break;
            }
            $row[] = $equipos['sector'];
            $row[] = $equipos['observaciones'];
            $row[] = '';
            //agrego datos a la fila con clave cell


            $response->rows[$i]['cell'] = $row;
        }

        $response->userdata['Id']= 'Id';
        $response->userdata['equipo']= 'equipo';
        $response->userdata['estado']= 'estado';
        $response->userdata['fecha_ingreso']= 'fecha_ingreso';
        $response->userdata['hora_ingreso']= 'hora_ingreso';
        $response->userdata['centro']= 'centro';
        $response->userdata['sector']= 'sector';
        $response->userdata['observaciones']= 'observaciones';
        $response->userdata['myac'] = '';

        return json_encode($response);
    }

    private function getEquipos($page, $rows, $filters, $sidx, $sord)
    {
        $where = "";

        if(strlen($sidx)==0)
        {
        	$sidx = ' id ';
        }

        if(count($filters)>0)
        {
            for($i=0; $i < count($filters['rules']); $i++ )
            {
                $where.=$filters['groupOp']." ";
                $where.=$filters['rules'][$i]['field']." REGEXP '".$filters['rules'][$i]['data']."' ";
            }
        }

        $sort = "ORDER BY ".$sidx." ".$sord;

        $offset = ($page - 1) * $rows;

        $query="SELECT
                    id,
                    equipo AS equipo,
                    estado AS estado,
                    fecha_ingreso AS fecha_ingreso,
                    hora_ingreso AS hora_ingreso,
                    centro AS centro,
                    sector AS sector,
                    observaciones as observaciones
                FROM 
                    informatica
                WHERE
                    fecha_modificado IS NOT NULL ".$where." ".$sort;
    
        $query = $query . " LIMIT ".$rows." OFFSET ".$offset.";";

        $this->dbInf->ejecutarQuery($query);

        $ret = array();

        for ($i = 0; $i < $this->dbInf->querySize; $i++)
        {
            $reclamo = $this->dbInf->fetchRow($query);
            $ret[] = $reclamo;
        }

        return $ret;
    }
    
    private function getCantidadEquipos($filters = null)
    {

        $where = " ";
        $query="SELECT 
                    COUNT(*) as cantidad
                FROM 
                    informatica";
        $query .= " " . $where;
        
        $this->dbInf->ejecutarQuery($query);
        $result = $this->dbInf->fetchRow($query);
        $ret = $result['cantidad'];
        return $ret;
    }

    function actualizarRegistro($data)
    {
    	$response = new stdClass();
		$response->ret = false;
		$response->message = "Hubo un error al actualizar el equipo.";
		$this->dbInf->conectar();
    	$query = "UPDATE informatica SET equipo = '".$data['equipo']."', 
    				estado = '".$data['estado']."', fecha_ingreso = '".$data['fecha_ingreso']."', 
    				hora_ingreso = '".$data['hora_ingreso']."', centro = '".$data['centro']."',
    				sector = '".$data['sector']."', observaciones = '".$data['observaciones']."' ,fecha_modificado = now() WHERE id = ".$data['id'].";";
    	try{$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Equipo modificado correctamente.";}
			catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}
	$this->dbInf->desconectar();
			return $response;
    }



}