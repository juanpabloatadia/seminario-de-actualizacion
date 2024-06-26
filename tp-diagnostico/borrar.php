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
<h1>ELIMINAR CONTACTO:</h1>
</div>
<hr><br>
<div class="content">
<form action="" method="post">
<label>¿Desea eliminar este contacto?:</label><br><br>
<input type="submit" name="borrar" value="Borrar Contacto"/>&nbsp;
&nbsp;<input type="reset" name="cancelar" value="Cancelar"/>
<p><a href='index.php'>Volver atras</a></p>
</form>

<?php
$id=$_GET['id'];

if(isset($_POST['borrar']))
{
	require('include/config.php');
	
	try
	{
		$sql = $db->prepare('DELETE FROM contactos WHERE id=:id');
		$sql->bindParam(':id', $id);
		$sql->execute();
		echo "Contacto eliminado!";
		echo "<p><a href='index.php'>Volver atras</a></p>";
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

</div>
<br><hr>
</article>
</section>
<footer id="footer">			
</footer>
</body>
</html>
