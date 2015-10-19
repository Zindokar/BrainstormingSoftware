<?php
	include_once("clases/Idea.php");
	session_start();
	// Declaramos e inicialiazmos las variables
	if(!isset($_SESSION['timestamp']))
		$_SESSION['timestamp'] = "";
	if(!isset($_SESSION['mensaje']))
		$_SESSION['mensaje'] = "";
	if(!isset($_SESSION['idea']))
		$_SESSION['idea'] = new Idea();
	if(!isset($_SESSION['timestamp']))
		$_SESSION['timestamp'] = "";
	// Si le damos al botón enviar controlamos el insert
	if (isset($_POST['enviar']))
	{
		// Controlamos que pase 15 segundos
		if ($_SESSION['timestamp'] != "" && $_SESSION['timestamp'] + 16 > date("U"))
		{
			$segundos = (-1) * ((date("U") - $_SESSION['timestamp']) - 15);
			$str = ($segundos > 1) ? "seconds" : "second";
			$_SESSION['mensaje'] = "You must wait " . $segundos  . " " . $str . " before submiting a new idea.";
			$_SESSION['estilo'] = "error";
		}
		else
		{
			// Si los campos de texto están vacíos no entra
			if ($_POST['nombre'] != "" && $_POST['idea'] != "")
			{
				try
				{
					$_SESSION['idea']->insertIdea($_POST['nombre'], $_POST['idea'], date("d-m-Y H:i:s"));
					$_SESSION['mensaje'] = "Idea stored.";
					$_SESSION['estilo'] = "exito";
					$_SESSION['timestamp'] = date("U");
					header("Location: ?"); // Hacemos que al refrescar la página no se envíe el post anterior
				}
				catch (Exception $e)
				{
					$_SESSION['mensaje'] = $e;
					$_SESSION['estilo'] = "error";
				}
			}
			else
			{
				$_SESSION['mensaje'] = "All fields must be filled.";
				$_SESSION['estilo'] = "error";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Ideas - Brainstorm</title>
	<link href="css/estilos.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="js/javascript.js"></script>
</head>
<body>
	<div id="cabecera">
		<img src="imgs/logo_cacaEdition.png" alt="logo" />
	</div>
	<br /><br />
	<div id="cuerpo">
		<h1>Envía tu idea</h1>
		<br />
<?php
		if ($_SESSION['mensaje'] != "") echo "<div class=\"" . $_SESSION['estilo'] . "\">" . $_SESSION['mensaje'] . "</div><br />";
?>
		<form action="index.php" method="post">
			<table align="center">
				<tr>
					<td>Nombre: </td>
					<td><input type="text" class="tbox" name="nombre" id="nombre" /></td>
				</tr>
				<tr>
					<td>Idea: </td>
					<td><textarea class="txtarea" name="idea" id="idea"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"><input type="submit" class="btn" name="enviar" id="enviar" value="Enviar" /></td>
				</tr>
			</table>
		</form>
		<center><font color="red" size="2"><i>We only accept &lt;br /&gt; HTML tag</i></font></center>
		<div class="linea"></div>
		<div class="ideas">
			<h1>List of ideas</h1>
			<br />
<?php
			try
			{
				foreach ($_SESSION['idea']->getAllIdeas() as $cada)
				{
					$nombre = strip_tags($cada['nombre']);
					$idea = strip_tags($cada['idea'], '<br>');
?>
					<div class="idea">
						<div class="ideacabecera"><font size="4"><b><?php echo $nombre; ?></b></font> - <?php echo $cada['fecha']; ?></div>
						<div class="ideacontenido"><?php echo $idea; ?></div>
					</div>
<?php
				}
			}
			catch (Exception $e)
			{
				echo "<div class=\"error\">Nothing stored</div><br />";
			}
?>
		</div>
	</div>
	<div id="pie">
		overflowschool.com - info@overflowschool.com
	</div>
</body>
</html>