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
<form action='' method='post'>
<input type="submit" name="cambiar" value="Modificar datos"/><br>
<input type="submit" name="borrar" value="Eliminar contacto"/>
</nav>
<section id="section">
<article>
<div class="header">
<h1>DATOS DEL CONTACTO:</h1>
<p><a href='index.php'>Volver atras</a></p>
</div>
<hr><br>
<div class="content">
<form action='' method='post'>

<?php
$id=$_GET['id'];

require('include/config.php');

try
{
	$sql=$db->prepare('SELECT id,nombre,apellido,telefono,direccion FROM contactos where id="'.$id.'"');
	$sql->execute();
	
	while($row=$sql->fetch())
	{
		echo "<table border='1' align='center'>
		<tr><td class='th'>Nombre</td><td>".$row['nombre']."</td></tr>
		<tr><td class='th'>Apellidos</td><td>".$row['apellido']."</td></tr>
		<tr><td class='th'>Teléfono movil</td><td>".$row['telefono']."</td></tr>
		<tr><td class='th'>Dirección</td><td>".$row['direccion']."</td></tr>
		</table>";
	}
	
}

catch(PDOException $e)
{
	echo $e->getMessage();
}

if(isset($_POST['borrar']))
{
	header('Location:borrar.php?id='.$id);
}

if(isset($_POST['cambiar']))
{
	header('Location:modificar.php?id='.$id);
}
?>

</form>
</div>
<br><hr>
</article>
</section>
<footer id="footer">			
</footer>
</body>
</html>
