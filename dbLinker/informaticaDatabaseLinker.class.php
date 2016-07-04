<?php
if(session_id() == '') {
    session_start();
}
include_once 'conectionData.php';
include_once 'dataBaseConnector.php';
include_once 'utils.php';
include_once 'user.class.php';

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
		$query = "INSERT INTO informatica (equipo, estado, fecha_ingreso, hora_ingreso, centro, sector, observaciones,fecha_modificado, usuario)
					VALUES('".$data['insumo']."','".$data['estado']."','".$data['fechaRecibido']."','".$data['horaRecibido']."',
					'".$data['centro']."','".$data['sector']."','".$data['observaciones']."',now(), '".$data['user']."');";

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
			$ret[] = array('id' => $result['id'],'equipo' => $result['equipo'],'estado' => $result['estado'],'fecha_modificado' => $result['fecha_modificado'],'fecha_ingreso' => $result['fecha_ingreso'],'hora_ingreso' => $result['hora_ingreso'],'centro' => $result['centro'],'sector' => $result['sector'], 'observaciones' =>$result['observaciones'],'usuario' => $result['usuario']);
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

            $fuemodif = "";
            $query="SELECT estado FROM informatica where id = ".$key.";";

            $this->dbInf->ejecutarQuery($query);
            $result = $this->dbInf->fetchRow($query);
            if($result['estado'] != $value)
            {
                $fuemodif = " , fecha_modificado = now() ";
            }

			$query = "UPDATE informatica SET estado = ".$value." ".$fuemodif." WHERE id = ".$key;
			try{$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Equipo agregado correctamente.";}
			catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}
			
		}

		$this->dbInf->desconectar();
		return $response;

	}

	function getStockJson($page, $rows, $filters, $sidx, $sord)
    {
        $response = new stdClass();
        $this->dbInf->conectar();

        $stockarray = $this->getStock($page, $rows, $filters, $sidx, $sord); //

        $response->page = $page;
        $response->total = ceil($this->getCantidadStock($filters) / $rows); //
        $response->records = $this->getCantidadStock($filters); //

        $this->dbInf->desconectar();

        for ($i=0; $i < count($stockarray) ; $i++) 
        {
            $equipos = $stockarray[$i];
            //id de fila
            $response->rows[$i]['Id'] = $equipos['Id']; 
            //datos de la fila en otro array
            $row = array();
            $row[] = $equipos['Id'];
            $row[] = $equipos['Equipo'];
            //$row[] = $equipos['estado'];
            $row[] = $equipos['Cantidad'];
            $row[] = $equipos['fecha_modificado'];
            //$row[] = $equipos['centro'];
           	 $row[] = '';
            //agrego datos a la fila con clave cell


            $response->rows[$i]['cell'] = $row;
        }

        $response->userdata['Id']= 'Id';
        $response->userdata['Equipo']= 'Equipo';
        $response->userdata['Cantidad']= 'Cantidad';
        $response->userdata['fecha_modificado']= 'fecha_modificado';
        $response->userdata['myac'] = '';

        return json_encode($response);
    }

    private function getStock($page, $rows, $filters, $sidx, $sord)
    {
        $where = "";

        if(strlen($sidx)==0)
        {
        	$sidx = ' Id ';
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
                    Id,
                    Equipo AS Equipo,
                    Cantidad AS Cantidad,
                    fecha_modificado AS fecha_modificado
                FROM 
                    stock
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
    
    private function getCantidadStock($filters = null)
    {

        $where = " ";
        $query="SELECT 
                    COUNT(*) as cantidad
                FROM 
                    stock";
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


    function actualizarRegistroStock($data)
    {
        $response = new stdClass();
        $response->ret = false;
        $response->message = "Hubo un error al actualizar el stock.";
        $this->dbInf->conectar();
        $query = "UPDATE stock SET cantidad = '".$data['Cantidad']."', 
                    fecha_modificado = now() WHERE id = ".$data['id'].";";
        try{$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Equipo modificado correctamente.";}
            catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}
    $this->dbInf->desconectar();
            return $response;
    }

    function tieneAcceso($usr, $psw)
    {
        $query= "SELECT usuario as usuario, password as password from usuarios WHERE usuario = '$usr' and habilitado = 1;";
        $this->dbInf->conectar();
        $this->dbInf->ejecutarQuery($query);
        $result = $this->dbInf->fetchRow($query);
        $returned = false;
        if($usr == $result['usuario']){
            if($psw == $result['password']){
                $returned = true;
            }
        }
        
        $this->dbInf->desconectar();
        return $returned;
    }

    function agregarUsuario($data)
    {
        $response = new stdClass();
        $response->ret = false;
        $response->message = "Hubo un error agregando el usuario.";
        $query = "INSERT INTO usuarios (usuario, password, habilitado)
                    VALUES('".$data['usuario']."','".md5($data['password'])."',1);";

        try{$this->dbInf->conectar();$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Usuario agregado correctamente.";}
        catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}

        $this->dbInf->desconectar();

        return $response;

    }

    function agregarNuevoStock($data)
    {
        $response = new stdClass();
        $response->ret = false;
        $response->message = "Hubo un error agregando el stock.";
        $query = "INSERT INTO stock (equipo, cantidad, fecha_modificado)
                    VALUES('".$data['equipo']."',".$data['cantidad'].",now());";

        try{$this->dbInf->conectar();$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Stock agregado correctamente.";}
        catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}

        $this->dbInf->desconectar();

        return $response;

    }

    function eliminarUsuario($data)
    {
        $response = new stdClass();
        $response->ret = false;
        $response->message = "Hubo un error eliminando el usuario.";
        $query = "SELECT * FROM usuarios WHERE usuario = '".$data['usuario']."' and habilitado = 1";
        $this->dbInf->conectar();
        $this->dbInf->ejecutarQuery($query);
        $result = $this->dbInf->fetchRow($query);
        if(!$result)
        {
            $response->message = "No existe un usuario con ese nombre.";
            $this->dbInf->desconectar();
            return $response;
        }
        
        $query = "UPDATE usuarios SET habilitado = 0 WHERE id = ".$result['id']." and habilitado = 1;";

        try{$this->dbInf->conectar();$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Usuario eliminado correctamente.";}
        catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}

        $this->dbInf->desconectar();

        return $response;

    }


    function existeUsuario($data)
    {
        $response = new stdClass();
        $response->ret = false;
        $response->message = "Hubo un error validando el usuario.";
        $query = "SELECT * FROM usuarios WHERE usuario = '".$data['username']."' and habilitado = 1";
        $this->dbInf->conectar();
        $this->dbInf->ejecutarQuery($query);
        $result = $this->dbInf->fetchRow($query);
        if(!$result)
        {
            $response->message = "No existe un usuario con ese nombre.";
            $this->dbInf->desconectar();
            return $response;
        }
        if(md5($data['password']) == $result['password'])
        {
            $user = new usuarioSoporteInformatica();
            $user->setUsuario($result['usuario']);
            $user->setId($result['id']);
            $_SESSION['usuarioSoporteInf'] = $result['id'];
            $response->ret = true;
            $response->message = "LogIn";
        }

        return $response;


    }

    function devolverUsuario($id)
    {
        $query = "SELECT * FROM usuarios WHERE id = '".$id."' and habilitado = 1";
        $this->dbInf->conectar();
        $this->dbInf->ejecutarQuery($query);
        $result = $this->dbInf->fetchRow($query);
        if(!$result)
        {
            $response->message = "No existe un usuario con ese nombre.";
            $this->dbInf->desconectar();
            return false;
        }
        $user = new usuarioSoporteInformatica();
        $user->setUsuario($result['usuario']);
        $user->setId($result['id']);
        return $user;
    }

    function agregarModifUsuario($data)
    {
        $response = new stdClass();
        $response->ret = false;
        $response->message = "Hubo un error al actualizar el usuario.";
        $this->dbInf->conectar();


        $query = "UPDATE usuarios SET password = '".md5($data['password'])."' WHERE id = ".$data['id'];
        try{$this->dbInf->ejecutarAccion($query);$response->ret = true; $response->message = "Password modificado correctamente.";}
        catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}
            

        $this->dbInf->desconectar();
        return $response;

    }

    function traerPermisos($data)
    {
        $query="SELECT * from permisos where idusuario = ".$data.";";

        try{$this->dbInf->conectar();$this->dbInf->ejecutarAccion($query);}
        catch (Exception $e){echo "error intentando ejecutar query: $query <br> " . $e->getMessage();}
        $ret = array();
        for($i = 0 ; $i < $this->dbInf->querySize; $i++)
        {
            $result = $this->dbInf->fetchRow($query);
            $ret[] = array('idusuario' => $result['idusuario'],'permiso' => $result['permiso']);
        }
        $this->dbInf->desconectar();
        return $ret;
    }

    function is_serialized($value, &$result = null)
{
    // Bit of a give away this one
    if (!is_string($value))
    {
        return false;
    }
    // Serialized false, return true. unserialize() returns false on an
    // invalid string or it could return false if the string is serialized
    // false, eliminate that possibility.
    if ($value === 'b:0;')
    {
        $result = false;
        return true;
    }
    $length = strlen($value);
    $end    = '';
    switch ($value[0])
    {
        case 's':
            if ($value[$length - 2] !== '"')
            {
                return false;
            }
        case 'b':
        case 'i':
        case 'd':
            // This looks odd but it is quicker than isset()ing
            $end .= ';';
        case 'a':
        case 'O':
            $end .= '}';
            if ($value[1] !== ':')
            {
                return false;
            }
            switch ($value[2])
            {
                case 0:
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                break;
                default:
                    return false;
            }
        case 'N':
            $end .= ';';
            if ($value[$length - 1] !== $end[0])
            {
                return false;
            }
        break;
        default:
            return false;
    }
    if (($result = @unserialize($value)) === false)
    {
        $result = null;
        return false;
    }
    return true;
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
            $row[] = $equipos['usuario'];
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
        $response->userdata['usuario']= 'usuario';
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
                    observaciones as observaciones,
                    usuario as usuario
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


}