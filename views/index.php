<?php
include_once('methods.php');
function jsInsertValues($var='data',$data=null){
	printf('<script type="text/javascript">var %s=%s</script>', $var, json_encode($data));
}
$puzzle = new Crossword();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Sopa de letras - Test para entrevista</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link href="./style.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
	<?php
		jsInsertValues('fullMatrix', $puzzle->getFullMatrix());
	?>
</head>
<body>

	<form class="form-signin">
		<div class="text-center mb-4">
			<img class="mb-4" src="http://navebinario.com/logo0.png" alt="" width="72" height="72">

			<h1 class="h3 mb-3 font-weight-normal">Sopa de letras</h1>
			<p>Buscar la palabra <strong>OIE</strong> dentro de una matriz en 8 sentidos:</p>
			<ul>
				<li>Horizontal (De derecha a izquierda)</li>
				<li>Horizontal (De izquierda a derecha)</li>
				<li>Vertical (De centro hacia arriba)</li>
				<li>Vertical (De centro hacia abajo)</li>
				<li>4 diagonales</li>
			</ul>
		</div>

		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<label class="input-group-text" for="inputGroupSelect01">Matriz</label>
			</div>
			<select class="custom-select" id="inputGroupSelect01">
				<option selected>Elegir...</option>
			</select>
		</div>

		<button class="btn btn-lg btn-primary btn-block" type="submit" id="calculate">Calcular</button>

		<div class="text-center mt-4" id="answer">
			<h2 class="h3 mb-3 font-weight-normal">Veces que aparece: <strong id="answer_number">8</strong></h1>
			<h3 class="h4 mb-3 font-weight-normal">Matriz:</h1>
			<table class="table" id="matrix_content">
			</table>
		</div>
	</form>
<script type="text/javascript" src="./script.js"></script>
</body>
</html>