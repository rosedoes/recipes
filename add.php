<?php
/* global variable: location of recipe card html */
$cardLib = "data/db_recipe_cards.txt";

/* ============================ BEGIN process addTag ============================ */
if(isset($_POST['addTag'])) {
	/* Validate input */
	$tagName = trim(stripslashes(htmlspecialchars($_POST['tagName'])));
	$dbTags = "data/db_tags.txt";

	/* Check if tag already exists */
	if(strpos(file_get_contents($dbTags), $tagName) !== false) {
		echo "This tag already exists. Add a recipe!";
	} else {
		/* Open tag db */
		$tagDb = fopen($dbTags, "a") or die("can't open $dbTags");
		/* Append tagName with comma */
		fwrite($tagDb, $tagName.',');
		fclose($tagDb);
	}
	/* Redirect to addTag form */
	header("Location: https://darlingrosette.com/recipe/add.php");
}
/* ============================ END ============================ */

/* ============================ BEGIN process createFile ============================ */
if(isset($_POST['createFile'])) {
	/* Validate inputs */
	$recipeTitle = trim(stripslashes(htmlspecialchars($_POST['recipeTitle'])));
	$recipePrep = trim(stripslashes($_POST['recipePrep'])); /* Allow TinyMCE html formatting */
	$recipeTags = $_POST['recipeTags']; /* Tag options are hardcoded */
	$recipeTags = implode(',', $recipeTags);

	/* ============================ BEGIN create dedicated page ============================ */
	/* Remove spaces from title for filename */
	$tempFileName = preg_replace("/\s+/", "", $recipeTitle);
	/* Check for existing recipe */
	if (file_exists("pages/$tempFileName.php")) {
		$tempFileName .= rand();
	}
	$fileName = $tempFileName;
	$filePath = "pages/$fileName.php";

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
/* ============================ END ============================ */

/* ============================ BEGIN process deleteFile ============================ */
if(isset($_POST['deleteFile'])) {
	$fileName = $_POST['passFileName'];
	$filePath = "pages/$fileName.php";
	if (file_exists($filePath)) {
		/* Delete dedicated recipe page */
		if (unlink($filePath)) {
			/* Delete recipe card */
			$oldCard = file_get_contents($cardLib);
			$newCard = preg_replace("#<!--BEGIN $fileName-->[\s\S]+?<!--END-->#s", "", $oldCard);
			file_put_contents($cardLib, $newCard);
			header("Location: https://darlingrosette.com/recipe/");
			echo "This recipe has been successfully deleted. Redirecting...";
		} else {
			header("Location: $filePath");
			echo "Error: This recipe could not be deleted. Redirecting...";
		}
	} else {
		header("Location: https://darlingrosette.com/recipe/");
		echo "404: This recipe does not exist. Redirecting...";
	}
}
/* ============================ END ============================ */
?>

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
		<!-- BEGIN add recipe -->
		<h2>Add a recipe</h2>
		<form action="add.php" method="POST">
			<!-- Solicit recipe title -->
			<div class="form-group">
		    <label for="recipeTitle">Recipe name</label>
		    <input type="text" class="form-control" required name="recipeTitle">
			</div>

			<p class="mb-2">Recipe tags</p>
			<div class="form-group text-col-2">
				<!-- Solicit recipe tags -->
				<?php $tags = explode(',', file_get_contents('data/db_tags.txt'));
				array_pop($tags);
				foreach ($tags as $tag) {
					/* Get template for tag formatting */
					$template = file_get_contents('templates/template_tag.txt');
					/* Replace template variables with form data */
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
		<!-- END -->

		<!-- BEGIN add tag -->
		<h2>Add a tag</h2>
		<form action="add.php" method="POST">
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
</body>
</html>
