<!-- This document processes the data submitted by all forms -->
<?php
/* global variable: location of recipe card html */
$cardLib = "../db_recipe_cards.txt";
/* ============================ BEGIN process createForm ============================ */
if(isset($_POST['createFile'])) {
	/* Function for easier validation handling */
	function validate($input) {
	  $input = trim($input); /* Strips unwanted characters */
	  $input = stripslashes($input); /* Removes escaped slashes */
	  $input = htmlspecialchars($input); /* Converts special characters to html */
	  return $input;
	}
	/* Validate inputs */
	$recipeTitle = validate($_POST['recipeTitle']);
	$prep = validate($_POST['recipePrep']);
	$prep = htmlspecialchars_decode($prep); /* Allow TinyMCE html formatting */
	$recipeTags = $_POST['recipeTags']; /* Tag options are hardcoded */

	/* ============================ BEGIN create dedicated page ============================ */
	/* Remove spaces from title for filename */
	$tempFileName = preg_replace("/\s+/", "", $recipeTitle);
	/* Check for existing recipe */
	if (file_exists("../pages/".$tempFileName.".php")) {
		$tempFileName .= rand();
	}
	$fileName = $tempFileName;
	$filePath = "../pages/$fileName.htm";

	/* Obtain template for dedicated recipe page */
	$template = file_get_contents('../template_recipe.txt');
	/* Replace template variables with form data */
	$template = str_replace("VAR_TITLE", $recipeTitle, $template);
	$template = str_replace("VAR_PREP", $recipePrep, $template);
	$template = str_replace("VAR_TAGS", $recipeTags, $template);
	$template = str_replace("VAR_FILENAME", $fileName, $template);
	$template = str_replace("VAR_PATH", $filePath, $template);
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
	$template = str_replace("VAR_PATH", $filePath, $template);
	/* Append this card to existing recipe cards */
	$newFile = fopen($cardLib, "a") or die("can't open $cardLib");
	fwrite($newFile, $template);
	fclose($newFile);
	/* ============================ END ============================ */
	/* Redirect to new file */
	header("Location: $filePath");
}
/* ============================ END ============================ */
exit();
?>
