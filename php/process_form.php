<!-- This document processes the data submitted by all forms -->
<?php
/* global variable: location of recipe/ root */
$root = "https://darlingrosette.com/recipe";
/* global variable: location of recipe card html */
$cardLib = "lib_recipe_cards.php";
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
	header("Location: $root/pages/$filePath");
}
/* ============================ END ============================ */

/* ============================ BEGIN process deleteFile, editFile ============================ */
if(isset($_POST['deleteFile']) || isset($_POST['editFile'])) {
	$dRecipeTitle = $_POST['passRecipeTitle'];
	$dRecipePrep = $_POST['passRecipePrep'];
	$dRecipeTags = $_POST['passRecipeTags'];
	$dFileName = $_POST['passFileName'];
	$dFilePath = $_POST['passFilePath'];

	/* ============================ BEGIN process deleteFile ============================ */
	if(isset($_POST['deleteFile'])) {
		/* Delete dedicated recipe page */
		if (file_exists($dFilePath)) {
			if (unlink($dFilePath)) {
				/* Delete recipe card */
				$oldCard = file_get_contents($cardLib);
				$newCard = preg_replace("#<div class=\"card\" name=\"$dFileName\">[\s\S]+?<?--End card-->#s", "", $oldCard);
				/* Write changes to file */
				file_put_contents($cardLib, $newCard);
				echo "Redirect: This recipe has been deleted.";
				/* Redirect to main page */
				header("Location: ".$root);
			} else {
				echo "Error: This recipe could not be deleted.";
				header("Location: ".$dFilePath);
			}
		} else {
			echo "404: This recipe does not exist.";
			header("Location: ".$root);
		}
	}
	/* ============================ END ============================ */

}
/* ============================ END ============================ */
exit();
?>
