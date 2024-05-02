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
<h1>MODIFICAR CONTACTO:</h1>
</div>
<hr><br>
<div class="content">

<?php
$id=$_GET['id'];

require('include/config.php');
	try
	{
		$sql=$db->prepare('SELECT id,nombre,apellido,telefono,direccion FROM contactos WHERE id=:id');
		$sql->execute(array(':id'=>$id));
		$row=$sql->fetch();
	}
	
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
?>

<form action="" method="post" enctype="multipart/form-data">
<table border="0" align="center">
<tr><td class="left"><label>Introduce el nombre:*</label></td>
<td class="right"><input type="text" required name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>"/></td></tr>
<tr><td class="left"><label>Introduce los apellidos:*</label></td>
<td class="right"><input type="text" required name="apellido" placeholder="Apellido" value="<?php echo $row['apellido']; ?>"/></td></tr>
<tr><td class="left"><label>Introduce el teléfono móvil:*</label></td>
<td class="right"><input type="text" required name="telefono" placeholder="Teléfono" value="<?php echo $row['telefono']; ?>"/></td></tr>
<tr><td class="left"><label>Introduce la dirección:*</label></td>
<td class="right"><input type="text" required name="direccion" placeholder="Dirección" value="<?php echo $row['direccion']; ?>"/></td></tr>
<tr><td><input type="submit" name="cambiar" value="Modificar"/>&nbsp;</td>
<td>&nbsp;<input type="reset" name="cancelar" value="Cancelar"/></td></tr>
<p><a href='index.php'>Volver atras</a></p>
</table>
</form>
</div>
<br><hr>
</article>
</section>

<?php
if(isset($_POST["cambiar"]))
{
	$nombre=$_POST["nombre"];
	$apellido=$_POST["apellido"];
	$telefono=$_POST["telefono"];
	$direccion=$_POST['direccion'];
	
	try
	{
		$sql=$db->prepare('UPDATE contactos SET	nombre="'.$nombre.'", apellido="'.$apellido.'",	telefono="'.$telefono.'", direccion="'.$direccion.'" WHERE id=:id');
		$sql->execute(array(':id'=>$id));
		header("refresh:0;");
		echo "<script>alert('Contacto modificado!');</script>";
		exit;
	}
	
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

if(isset($_POST["cancelar"]))
{
	header("location:contacto.php");
}
?>

<footer id="footer">			
</footer>
</body>
</html>
