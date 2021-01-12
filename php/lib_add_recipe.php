<h2>Add a recipe</h2>
<!-- Form -->
<form action="php/process_form.php" method="POST">
	<!-- Solicit recipe title -->
	<div class="form-group">
    <label for="recipeTitle">Recipe name</label>
    <input type="text" class="form-control" required name="recipeTitle">
	</div>

	<p class="mb-2">Recipe tags</p>
	<div class="form-group text-col-2">
		<!-- Solicit recipe tags -->
		<?php $tags = explode(',', file_get_contents('db_tags.txt'));
		array_pop($tags);
		foreach ($tags as $tag) {
			/* Get template for tag formatting */
			$template = file_get_contents('template_tag.txt');
			/* Replace checkbox template variable with form data */
			$template = str_replace('VAR_TAG', $tag, $template);
			$template = str_replace('VAR_CHECKED', "", $template);
			/* Print formatted tag to page */
			echo $template;
		} ?>
	</div>

	<div class="form-group">
		<!-- Solicit recipe preparation -->
		<label for="recipePrep">Preparation</label>
		<textarea required class="form-control" rows="10" id="recipePrep" name="recipePrep"></textarea>
	</div>

	<!-- Submit form data -->
	<button class="btn btn-primary btn-block mt-3" name="createFile" type="submit">Add recipe</button>
</form>
