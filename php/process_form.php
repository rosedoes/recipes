<!-- This document processes the data submitted by all forms -->
<?php
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
	$recipeTags = $_POST['recipeTags']; /* tTags are hardcoded as checkbox items */

	/* ============================ BEGIN create dedicated page ============================ */
	/* Remove spaces from title for filename */
	$tempFileName = preg_replace("/\s+/", "", $recipeTitle);
	/* Check for existing recipe */
	if (file_exists("../pages/".$tempFileName.".php")) {
		$tempFileName .= rand();
	}
	$fileName = $tempFileName .".php";
	$filePath = "../pages/".$fileName;
	/* Create new file from recipe title */
	$newFile = fopen($filePath, "w") or die("can't open ".$filePath);
	/* Compile page html */
	/* between <head> tags */
	$head = "<!doctype html><html lang=\"en\"><head>";
	$head .= "<meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">";
	$head .= "<link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css\" integrity=\"sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2\" crossorigin=\"anonymous\">";
	$head .= "<link rel=\"stylesheet\" href=\"../css/recipe.css\">";
	$head .= "<title>".$recipeTitle."</title></head><body>";
	/* buttons to edit/delete recipe */
	/* edit button */
	$eButton = "<form action=\"../php/process_form.php\" method=\"POST\">";
	$eButton .= "<button type=\"submit\" class=\"close\" aria-label=\"Edit recipe\" name=\"editFile\">";
	$eButton .= "<span aria-hidden=\"true\">&#47;</span> Edit recipe";
	$eButton .= "</button></form>";
	/* delete button */
	$dButton = "<form action=\"../php/process_form.php\" method=\"POST\">";
	$dButton .= "<input type=\"hidden\" name=\"passFileName\" value=\"$fileName\">"; /* make fileName accessible to delete function */
	$dButton .= "<button type=\"submit\" class=\"close\" aria-label=\"Delete recipe\" name=\"deleteFile\">";
	$dButton .= "<span aria-hidden=\"true\">&times;</span> Delete recipe";
	$dButton .= "</button></form>";
	$editOptions = $eButton.$dButton;
	/* content from html form */
	$content = "<div class=\"container\">";
	$content .= $editOptions;
	$content .= "<h2 id=\"recipeTitle\" name=\"$recipeTitle\" class=\"text-center\">$recipeTitle</h2>";
	$content .= "<p class=\"h3\">How it's made</p>";
	$content .= $prep;
	if (!empty($recipeTags)) {
		$showTags = "<p class=\"h3\">Recipe tags</p>";
		$showTags .= "<ul class=\"list-inline\">";
		foreach ($recipeTags as $tag) {
			$showTags .= "<li class=\"list-inline-item\">$tag</li>";
		}
		$showTags .= "</ul>";
	}
	$content .= $showTags;
	/* head + content + closing tags */
	$output = $head.$content."</div></body></html>";

	/* Write recipe data to file */
	fwrite($newFile, $output);
	/* Close file */
	fclose($newFile);
	/* ============================ END ============================ */

	/* ============================ BEGIN create card ============================ */
	/* Create card for view-all */
	$cardFile = fopen($cardLib, "a") or die("can't open $cardLib");
	/* Compile card html */
	$card = "<div class=\"card\" name=\"$fileName\">";
	/*$card .= "<img class=\"card-img-top\" src=\"tbd\" alt=\"$recipeTitle\">";*/
	$card .= "<div class=\"card-body\">";
	$card .= "<h5 class=\"card-title\"><a href=\"recipe/$filePath\">$recipeTitle</a></h5>";
	$output .= "<ul class=\"list-inline\">";
	$output .= "</ul>";
	$card .= "</div></div><!--End card-->";
	/* Write card html to file */
	fwrite($cardFile, $card);
	/* Close file */
	fclose($cardFile);
	/* ============================ END ============================ */
	/* Redirect to new file */
	header("Location: ".$filePath);
}
/* ============================ END ============================ */

/* ============================ BEGIN process editFile ============================ */
if(isset($_POST['editFile'])) {
	/*rename ('originalfile.txt', 'renamedfile.txt');*/
}
/* ============================ END ============================ */

/* ============================ BEGIN process deleteFile ============================ */
if(isset($_POST['deleteFile'])) {
	$dFileName = $_POST['passFileName'];
	$dFilePath = "../pages/$dFileName";
	/* Delete dedicated recipe page */
	if (file_exists($dFilePath)) {
		if (unlink($dFilePath)) {
			echo "Redirect: This recipe has been deleted.";
		} else {
			echo "Error: This recipe could not be deleted.";
		}
	} else {
		echo "404: This recipe does not exist.";
	}
	/* Delete recipe card */
	$old = file_get_contents($cardLib);
	$new = preg_replace("#<div class=\"card\" name=\"".$dFileName."\">[\s\S]+?<?--End card-->#s", "", $old);
	echo $new;
	/* Write changes to file */
	file_put_contents($cardLib, $new);
}
/* ============================ END ============================ */
exit();
?>
