<?php
$dbTags = "data/db_tags.txt";
/* ============================ BEGIN process addTag ============================ */
if(isset($_POST['addTag'])) {
	/* Validate input */
	$tagName = trim(stripslashes(htmlspecialchars($_POST['tagName'])));

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
	header("Location: https://darlingrosette.com/recipe/tag-manager.php");
}
/* ============================ END ============================ */

/* ============================ BEGIN process removeTag ============================ */
if(isset($_POST['removeTag'])) {
	/* Get tags to be removed */
	$toRemove = $_POST['recipeTags'];
	$toRemove = implode(',', $toRemove);
	foreach ($toRemove as $tag) {
		/* Remove tag from pages/* */
		foreach (glob("pages/*") as $file) {
	    $content = file_get_contents("pages/$file");
			/* If tag is found on recipe page, remove all occurrences */
	    if (strpos($content, $tag) !== false) {
        $newContent = str_replace($tag, "", $content);
				file_put_contents("pages/$file", $newContent);
	    }
		}
		/* Remove tag from data/db_tags */
		$oldTags = file_get_contents($dbTags);
		$newTags = str_replace($tag.",", "", $oldTags);
		file_put_contents($dbTags, $newTags);
	}
	/* Redirect to addTag form */
	header("Location: https://darlingrosette.com/recipe/tag-manager.php");
}
/* ============================ END ============================ */
?>

<?php require 'php/_head.php'; ?>

  <title>Recipe Tag Manager - Rose Does Things</title>
</head>

<body>
	<div class="container">
		<?php include 'php/_nav.php'; ?>

		<!-- BEGIN add tags -->
		<h2>Add tags</h2>
		<form method="POST">
			<div class="form-row">
				<label class="col-form-label" for="tagName">Name of tag </label>
				<div class="col-sm-5">
					<input type="text" class="form-control" required autofocus name="tagName">
				</div>
				<div class="col-sm-3">
					<button class="btn btn-primary btn-block" name="addTag" type="submit">Add tag</button>
				</div>
			</div>
		</form>
		<!-- END -->

		<!-- BEGIN remove tags -->
		<h2>Remove tags</h2>
		<form method="POST">
			<div class="form-group text-col-2">
				<?php
				/* Get all tags as array */
				$tags = explode(',', file_get_contents('data/db_tags.txt'));
				array_pop($tags);
				foreach($tags as $tag){
					/* Get template for tag formatting */
					$template = file_get_contents('templates/template_tag.txt');
					/* Replace template variable with form data */
					$template = str_replace('VAR_TAG', $tag, $template);
					/* Print formatted tag to page */
					echo $template;
				} ?>
			</div>
			<button class="btn btn-primary btn-block mt-3" name="removeTag" type="submit">Remove selected</button>
		</form>
		<!-- END -->
	</div>
</body>
</html>
