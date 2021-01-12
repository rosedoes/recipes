<?php
if(isset($_POST['editFile'])) {
	$recipeTitle = $_POST['passRecipeTitle'];
	$recipePrep = $_POST['passRecipePrep'];
	$recipeTags = $_POST['passRecipeTags'];
	$fileName = $_POST['passFileName'];
}
/* global variable: location of recipe card html */
$cardLib = "data/db_recipe_cards.txt";

/* ============================ BEGIN process saveChanges ============================ */
if(isset($_POST['saveChanges'])) {
	$recipeTitle = trim(stripslashes(htmlspecialchars($_POST['editTitle'])));
	$recipePrep = trim(stripslashes($_POST['editPrep']));
	$recipeTags = $_POST['recipeTags'];
	$recipeTags = implode(',', $recipeTags);
	$oldFileName = $_POST['oldFileName'];

	/* Remove spaces from title for filename */
	$tempFileName = preg_replace("/\s+/", "", $recipeTitle);
	/* Check for existing recipe */
	if (file_exists("../pages/$tempFileName.php")) {
		$tempFileName .= rand();
	}
	$fileName = $tempFileName;
	$filePath = "pages/$fileName.php";

	/* Remove original recipe page */
	if (file_exists("pages/$oldFileName.php")) {
		if (unlink("pages/$oldFileName.php")) {
			/* Remove original card */
			$oldCard = file_get_contents($cardLib);
			$newCard = preg_replace("#<!--BEGIN $oldFileName-->[\s\S]+?<!--END-->#s", "", $oldCard);
			file_put_contents($cardLib, $newCard);

			/* ============================ BEGIN create dedicated page ============================ */
			/* Obtain template for dedicated recipe page */
			$template = file_get_contents('templates/template_recipe.txt');
			/* Replace template variables with form data */
			$template = str_replace("VAR_TITLE", $recipeTitle, $template);
			$template = str_replace("VAR_PREP", $recipePrep, $template);
			$template = str_replace("VAR_TAGS", $recipeTags, $template);
			$template = str_replace("VAR_FILENAME", $fileName, $template);
			/* Create dedicated recipe page for this recipe */
			$newFile = fopen($filePath, "w") or die("can't open $filePath");
			/* Write recipe data to file */
			fwrite($newFile, $template);
			fclose($newFile);
			/* ============================ END ============================ */

			/* ============================ BEGIN create card ============================ */
			$template = file_get_contents('templates/template_card.txt');
			/* Replace template variables with form data */
			$template = str_replace("VAR_TITLE", $recipeTitle, $template);
			$template = str_replace("VAR_TAGS", $recipeTags, $template);
			$template = str_replace("VAR_FILENAME", $fileName, $template);
			/* Append this card to existing recipe cards */
			$newFile = fopen($cardLib, "a") or die("can't open $cardLib");
			fwrite($newFile, $template);
			fclose($newFile);
			/* ============================ END ============================ */
			/* Redirect to new file */
			header("Location: $filePath");
		}
	}
} /* ============================ END ============================ */
?>

<?php require 'php/_head.php'; ?>

  <title>Edit recipe - Rose Does Things</title>
</head>

<body>
	<div class="container">
		<h2>Update recipe</h2>
		<!-- Form -->
		<form action="edit.php" method="POST">
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
				$allTags = explode(',', file_get_contents('data/db_tags.txt'));
				array_pop($allTags);
				/* Get checked tags as array */
				$recipeTags = explode(',', $recipeTags);
				foreach($allTags as $tag){
		      $checked = "";
		      if(in_array($tag, $recipeTags)){
		        $checked = "checked";
		      }
					/* Get template for tag formatting */
					$template = file_get_contents('templates/template_tag.txt');
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
			<input type="hidden" name="oldFileName" value="<?php echo $fileName;?>">
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
