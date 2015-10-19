<?php
include_once("BD/IdeaDB.php");

class Idea
{
	private $id, $nombre, $idea, $fecha;

	public function __construct($id = "", $nombre = "", $idea = "", $fecha = "")
	{
		$this->id = $id;
		$this->nombre = $nombre;
		$this->idea = $idea;
		$this->fecha = $fecha;
	}

	public function __get($propiedad)
	{
		switch ($propiedad)
		{
			case "id":
				return $this->id;
				break;

			case "nombre":
				return $this->nombre;
				break;

			case "idea":
				return $this->idea;
				break;

			case "fecha":
				return $this->fecha;
				break;

			default:
				return null;
				break;
		}
	}

	public function __set($propiedad, $valor)
	{
		switch ($propiedad)
		{
			case "id":
				$this->id = $valor;
				break;

			case "nombre":
				$this->nombre = $valor;
				break;

			case "idea":
				$this->idea = $valor;
				break;

			case "fecha":
				$this->fecha = $valor;
				break;

			default:
				return null;
				break;
		}
	}

	public function __toString()
	{
		return "ID: " . $this->id . " - Nombre: " . $this->nombre . " - Idea: " . $this->idea . " - Fecha: " . $this->fecha;
	}
	
	public function getAllIdeas()
	{
		$ideas = IdeaDB::getAllIdeas();
		if ($ideas->rowCount() == 0)
			throw new Exception("Nothing stored.");
		return $ideas;
	}
	
	public function insertIdea($nombre,$idea,$fecha)
	{
		IdeaDB::insertIdea($nombre,$idea,$fecha);
	}
}
?>