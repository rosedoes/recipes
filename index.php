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
		<?php require 'php/lib_view_recipe_cards.php'; ?>
	</div>

	<!-- TinyMCE rich text editor -->
	<script src="https://cdn.tiny.cloud/1/qzw4mp5f6fbduulq5sc2gef84ftdrp5q8qcdwe9gl39f6rnq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- Add TinyMCE editor to recipe ingredients textarea -->
	<script type="text/javascript">
	tinymce.init({
		selector: '#recipePrep',
		menubar: false,
		plugins: 'lists link',
	  toolbar: 'bold italic underline strikethrough | numlist bullist link',
  	link_context_toolbar: true,
		link_title: false
	});
	</script>

	<!-- jQuery
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
	<!-- Bootstrap JS
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>-->
</body>
</html>
