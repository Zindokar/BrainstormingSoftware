<?php
include_once("Conexion.php");

class IdeaDB
{
	public static function getAllIdeas()
	{
		$conector = new Conexion("server","database");
		try
		{
			$con = $conector->Conectar();
			$con->exec('SET CHARACTER SET utf8');
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$consulta = $con->query("SELECT id, nombre, idea, fecha FROM Idea ORDER BY id DESC;");
			$conector = null;
			$con = null;
			return $consulta;
		}
		catch (Exception $e)
		{
			$conector = null;
			$con = null;
			throw $e;
		}
	}

	public static function insertIdea($nombre,$idea,$fecha)
	{
		$conector = new Conexion("server","database");
		try
		{
			$con = $conector->Conectar();
			$con->exec('SET CHARACTER SET utf8');
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$consulta = $con->prepare("INSERT INTO Idea (nombre, idea, fecha) VALUES (:nombre, :idea, :fecha);");
			$consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
			$consulta->bindParam(':idea', $idea, PDO::PARAM_STR);
			$consulta->bindParam(':fecha', $idea, PDO::PARAM_STR, 40);
			$datos = array('nombre'=>$nombre,
						   'idea'=>$idea,
						   'fecha'=>$fecha);
			$consulta->execute($datos);
			$conector = null;
			$con = null;
			return $consulta;
		}
		catch (Exception $e)
		{
			$conector = null;
			$con = null;
			throw $e;
		}
	}
}
?>