<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Múltiplo de arquivos</title>
</head>
<body>
	<h1>Upload Múltiplo de Arquivos com PHP</h1>

	<form action="recebe_envio.php" method="post" enctype="multipart/form-data">
		<input type="file" name="arquivos[]" multiple> <br />
		<input type="submit" value="Enviar">
	</form>
</body>
</html>