<h2>Add a recipe</h2>
<!-- Form -->
<form action="php/process_form.php" method="POST">
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

	<div class="form-group">
		<!-- Solicit recipe preparation -->
		<label for="recipePrep">Preparation</label>
		<textarea required class="form-control" rows="10" id="recipePrep" name="recipePrep"></textarea>
	</div>

	<!-- Submit form data -->
	<button class="btn btn-primary btn-block mt-3" name="createFile" type="submit">Add recipe</button>
</form>
