<?php require 'php/_head.php'; ?>

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
