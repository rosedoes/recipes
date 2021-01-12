<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="https://darlingrosette.com/media/favicon.ico" type="image/x-icon">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Plugin CSS -->
	<link rel="stylesheet" href="https://darlingrosette.com/recipe/css/recipe.css">

  <title>Recipes - Rose Does Things</title>
</head>

<body>
	<div class="container">
		<?php include 'php/_nav.php'; ?>
		<!-- BEGIN recipe cards -->
		<h2>Find a recipe</h2>
		<!-- Display tag sort -->
		<!-- Display search -->
		<div class="card-deck">
			<!-- Display recipe cards -->
			<?php require 'data/db_recipe_cards.txt'; ?>
		</div>
		<!-- END -->
	</div>
</body>
</html>
