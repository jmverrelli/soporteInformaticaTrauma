<?php

class UsuarioSoporteInf {
	
	var $id;
	var $usuario;
	var $password;

	function UsuarioSoporteInf(){

		$this->id = 0;
		$this->usuario = null;
		$this->password = null;
	}

	function getId(){
		return $this->id;
	}

	function getUsuario(){
		return $this->usuario;
	}

	function getPassword(){
		return $this->password;
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}

	function setPassword($password)
	{
		$this->password = $password;
	}
}