<?php if(isset($_POST['editFile'])) {
	$recipeTitle = $_POST['passRecipeTitle'];
	$recipePrep = $_POST['passRecipePrep'];
	$recipeTags = $_POST['passRecipeTags'];
	$fileName = $_POST['passFileName'];
} ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="https://darlingrosette.com/media/favicon.ico" type="image/x-icon">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Plugin CSS -->
	<link rel="stylesheet" href="css/recipe.css">

  <title>Edit recipe - Rose Does Things</title>
</head>

<body>
	<div class="container">
		<h2>Update recipe</h2>
		<!-- Form -->
		<form action="edit_recipe.php" method="POST">
			<!-- Solicit recipe title -->
			<div class="form-group">
		    <label for="editTitle">Recipe name</label>
		    <input type="text" class="form-control" required name="editTitle" value="<?php echo $recipeTitle;?>">
			</div>

			<div class="form-group text-col-2">
				<p class="mb-2">Recipe tags</p>
				<!-- Display and solicit recipe tags -->
				<?php
				/* Get all tags as array */
				$allTags = explode(',', file_get_contents('db_tags.txt'));
				array_pop($allTags);
				/* Get checked tags as array */
				$recipeTags = explode(',', $recipeTags);
				foreach($allTags as $tag){
		      $checked = "";
		      if(in_array($tag, $recipeTags)){
		        $checked = "checked";
		      }
					/* Get template for tag formatting */
					$template = file_get_contents('template_tag.txt');
					/* Replace checkbox template variable with form data */
					$template = str_replace('VAR_TAG', $tag, $template);
					$template = str_replace('VAR_CHECKED', $checked, $template);
					/* Print formatted tag to page */
					echo $template;
		    }	?>
			</div>

			<div class="form-group">
				<!-- Solicit recipe preparation -->
				<label for="editPrep">Preparation</label>
				<textarea required class="form-control" rows="10" id="editPrep" name="editPrep"></textarea>
			</div>

			<!-- Submit form data -->
			<input type="hidden" name="passFileName" value="<?php echo $fileName;?>">
			<button class="btn btn-primary btn-block mt-3" name="saveChanges" type="submit">Save changes</button>
		</form>
	</div>

	<!-- TinyMCE rich text editor -->
	<script src="https://cdn.tiny.cloud/1/qzw4mp5f6fbduulq5sc2gef84ftdrp5q8qcdwe9gl39f6rnq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<!-- Add TinyMCE editor to recipe ingredients textarea -->
	<script type="text/javascript">
	tinymce.init({
		selector: '#editPrep',
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
				editor.setContent('<?php echo $recipePrep;?>');
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
</body>
</html>
