<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>CONTACTOS</title>		
</head>
<body>
<header id="header">
<a href="index.php">				
</a>
</header>
<nav>
</nav>
<section id="section">
<article>
<div class="header">
<h1>NUEVO CONTACTO:</h1>
</div>
<hr><br>
<div class="content">
<form action="" method="post" enctype="multipart/form-data">
<table border="0" align="center">
<tr><td class="left"><label>Introduce el nombre:*</label></td>
<td class="right"><input type="text" required name="nombre" placeholder="Nombre"/></td></tr>
<tr><td class="left"><label>Introduce el apellido:*</label></td>
<td class="right"><input type="text" required name="apellido" placeholder="Apellido"/></td></tr>
<tr><td class="left"><label>Introduce el teléfono:*</label></td>
<td class="right"><input type="text" required name="telefono" placeholder="Teléfono"/></td></tr>
<tr><td class="left"><label>Introduce la dirección:*</label></td>
<td class="right"><input type="text" required name="direccion" placeholder="Dirección"/></td></tr>
<tr><td><input type="submit" name="crear" value="Crear Contacto"/>&nbsp;</td>
<td>&nbsp;<input type="reset" name="cancelar" value="Cancelar"/></td></tr>
<p><a href='index.php'>Volver atras</a></p>
</table>
</form>
</div>
<br><hr>
</article>
</section>

<?php
if(isset($_POST["crear"]))
{
	$nombre=$_POST["nombre"];
	$apellido=$_POST["apellido"];
	$telefono=$_POST["telefono"];
	$direccion=$_POST['direccion'];

	try
	{
		$sql=$db->prepare('INSERT INTO contactos (nombre,apellido,telefono,direccion) VALUES (:nombre,:apellido,:telefono,:direccion)');
		$sql->execute(array(':nombre'=>$nombre, ':apellido'=>$apellido,	':telefono'=>$telefono,	':direccion'=>$direccion));
		echo "Contacto creado!";
		exit;
	}
	
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
	
if(isset($_POST["cancelar"]))
{
	header("location:index.php");
}
?>

<footer id="footer">			
</footer>
</body>
</html>
