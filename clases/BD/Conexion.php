<?php
class Conexion
{
	private $hostname, $database;

	public function __construct($server,$bd)
	{
		$this->hostname = $server;
		$this->database = $bd;
	}

	public function __get($propiedad)
	{
		switch($propiedad)
		{
			case 'hostname':
				return $this->hostname;
				break;

			case 'database':
				return $this->database;
				break;

			default:
				return NULL;
		}
	}

	public function Conectar()
	{
		$str = "mysql:dbname=" . $this->database . ";host=" . $this->hostname;
		if (!($con = new PDO($str,"username","password")))
			throw new Exception("Unable to connect - [" . $this->database . "]");
		return $con;
	}
}
?>