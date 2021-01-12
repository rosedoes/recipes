<!-- This document processes the data submitted by all forms -->
<?php
/* global variable: location of recipe card html */
$cardLib = "../db_recipe_cards.txt";
/* ============================ BEGIN process addTag ============================ */
if(isset($_POST['addTag'])) {
	/* Validate input */
	$tagName = trim(stripslashes(htmlspecialchars($_POST['tagName'])));
	$dbTags = "../db_tags.txt";

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
}
/* Redirect to addTag form */
header("Location: https://darlingrosette.com/recipe/");
/* ============================ END ============================ */

/* ============================ BEGIN process createForm ============================ */
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
	if (file_exists("../pages/$tempFileName.php")) {
		$tempFileName .= rand();
	}
	$fileName = $tempFileName;
	$filePath = "../pages/$fileName.php";

	/* Obtain template for dedicated recipe page */
	$template = file_get_contents('../template_recipe.txt');
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
	$template = file_get_contents('../template_card.txt');
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
	$filePath = "../pages/$fileName.php";
	if (file_exists($filePath)) {
		/* Delete dedicated recipe page */
		if (unlink($filePath)) {
			/* Delete recipe card */
			$oldCard = file_get_contents('../db_recipe_cards.txt');
			$newCard = preg_replace("#<!--BEGIN $fileName-->[\s\S]+?<!--END-->#s", "", $oldCard);
			file_put_contents('../db_recipe_cards.txt', $newCard);
			echo "Redirect: This recipe has been deleted.";
			header("Location: https://darlingrosette.com/recipe");
		} else {
			echo "Error: This recipe could not be deleted.";
			header("Location: $filePath");
		}
	} else {
		echo "404: This recipe does not exist.";
		header("Location: https://darlingrosette.com/recipe");
	}
}
/* ============================ END ============================ */
exit();
?>
