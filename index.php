<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Plugin CSS -->
	<link rel="stylesheet" href="https://darlingrosette.com/recipe/css/recipe.css">

  <title>Recipes - Rose Does Things</title>
</head>

<body>
	<div class="container">
		<?php require 'php/lib_add_recipe.php'; ?>

		<h2>Find a recipe</h2>
		<!-- BEGIN recipe cards -->
		<!-- Display tag sort -->
		<!-- Display search -->
		<div class="card-deck">
			<!-- Display recipe cards -->
			<?php require 'db_recipe_cards.txt'; ?>
		</div>
		<!-- END -->

		<!-- BEGIN add tag -->
		<h2>Add a tag</h2>
		<form action="php/process_form.php" method="POST">
			<div class="form-group row">
				<label for="tagName">Name of tag </label>
				<div class="col-sm-5">
					<input type="text" class="form-control" required name="tagName">
				</div>
				<div class="col-sm-3">
					<button class="btn btn-primary btn-block" name="addTag" type="submit">Add tag</button>
				</div>
			</div>
		</form>
		<!-- END -->
	</div>

	<!-- TinyMCE rich text editor -->
	<script src="https://cdn.tiny.cloud/1/qzw4mp5f6fbduulq5sc2gef84ftdrp5q8qcdwe9gl39f6rnq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- Add TinyMCE editor to recipe ingredients textarea -->
	<script type="text/javascript">
	tinymce.init({
		selector: '#recipePrep',
		plugins: 'lists link',
	  toolbar: 'bold italic underline strikethrough | numlist bullist link',
		menubar: false,
		contextmenu: false,
  	link_context_toolbar: true,
		link_title: false,
		setup: function (editor) {
      // Apply the focus effect
	    editor.on('init', () => {
	      editor.getContainer().style.transition =
	        'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out';
	    });
	    editor.on('focus', () => {
	      (editor.getContainer().style.boxShadow =
	        '0 0 0 .2rem rgba(0, 123, 255, .25)'),
	        (editor.getContainer().style.borderColor = '#80bdff');
	    });
	    editor.on('blur', () => {
	      (editor.getContainer().style.boxShadow = ''),
	        (editor.getContainer().style.borderColor = '');
	    });
    }
	});
	</script>

	<!-- jQuery
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
	<!-- Bootstrap JS
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>-->
</body>
</html>
