<!-- This document processes the data submitted by the add-recipe form and writes the html to file */
<?php
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

/* ============== BEGIN dedicated recipe page ============== */
/* Remove spaces from title for filename */
$tempFileName = preg_replace("/\s+/", "", $recipeTitle);
/* Check for existing recipe */
if (file_exists('../pages/'.$tempFileName.'.php')) {
	$tempFileName .= rand();
}
/* Create new file from recipe title */
$fileName = $tempFileName .".php";
$filePath = '../pages/'.$fileName;
$newFile = fopen($filePath, 'w') or die("can't open ".$filePath);

/* Compile page html */
$output = "<!doctype html><html lang=\"en\"><head>";
$output .= "<meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">";
$output .= "<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css\" integrity=\"sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh\" crossorigin=\"anonymous\">";
$output .= "<link rel=\"stylesheet\" href=\"../css/recipe.css\">";
$output .= "<title>".$recipeTitle."</title></head><body>";
$output .= "<div class=\"container\">";
$output .= "<h2 id=\"recipeTitle\" name=\"$recipeTitle\" class=\"text-center\">$recipeTitle</h2>";
$output .= "<p class=\"h3\">How it's made</p>";
$output .= $prep;
$output .= "<p class=\"h3\">Recipe tags</p>";
$output .= "<ul class=\"list-inline\">";
if(isset($_POST['submit'])) {
	if (!empty($recipeTags)) {
		foreach ($recipeTags as $tag) {
			$output .= "<li class=\"list-inline-item\">".$tag."</li>";
		}
	} else {
		$output .= "<p>No tags selected</p>";
	}
}
$output .= "</ul>";
$output .= "</div></body></html>";

/* Write recipe data to file */
fwrite($newFile, $output);
/* Close file */
fclose($newFile);
/* ============== END dedicated recipe page ============== */

/* ============== BEGIN card ============== */
/* Create card for view-all */
$cardFile = fopen('lib_recipe_cards.php', 'a') or die("can't open lib_recipe_cards");
/* Compile card html */
$card = "<div class=\"card\">";
/*$card .= "<img class=\"card-img-top\" src=\"tbd\" alt=\"$recipeTitle\">";*/
$card .= "<div class=\"card-body\">";
$card .= "<h5 class=\"card-title\"><a href=\"recipe/$filePath\">$recipeTitle</a></h5>";
$output .= "<ul class=\"list-inline\">";
$output .= "</ul>";
$card .= "</div></div>";
/* Write card html to file */
fwrite($cardFile, $card);
/* Close file */
fclose($cardFile);
/* ============== END card ============== */

/* Redirect to new file */
header('Location: '.$filePath);
exit();
?>
