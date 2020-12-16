<h2>Add a recipe</h2>
<!-- Form -->
<form action="php/add_recipe.php" method="POST">
	<!-- Solicit recipe title -->
	<div class="form-group">
    <label for="recipeTitle">Recipe name</label>
    <input type="text" class="form-control" required name="recipeTitle">
	</div>

	<div class="form-group text-col-2">
		<p class="mb-2">Recipe tags</p>
		<!-- Solicit recipe tags -->
		<?php require 'php/lib_form_tags.php'; ?>
	</div>

	<div class="form-row">
		<div class="col-sm">
			<!-- Solicit recipe preparation -->
			<label for="recipePrep">Preparation</label>
			<textarea required class="form-control" rows="10" id="recipePrep" name="recipePrep"></textarea>
		</div>
		<div class="col-sm">
			<!-- Solicit recipe notes -->
			<label for="recipeNotes">Misc notes</label>
			<textarea class="form-control" name="recipeNotes"></textarea>
		</div>
	</div>

	<!-- Submit form data -->
	<button class="btn btn-primary btn-block mt-3" name="submit" type="submit">Add recipe</button>
</form>
