<!-- This document processes the data submitted by the add-recipe form and writes the html to file */
<?php
/* Function for easier validation handling */
function check_input($input) {
  $input = trim($input); /* Strips unwanted characters */
  $input = stripslashes($input); /* Removes escaped slashes */
  $input = htmlspecialchars($input); /* Converts special characters to html */
  return $input;
}

/* Validate inputs */
$recipeTitle = check_input($_POST['recipeTitle']);
$prep = check_input($_POST['recipePrep']);
$recipeTags = $_POST['recipeTags'];
$recipeNotes = check_input($_POST['recipeNotes']);

/* Create new file from recipe title */
$fileName = preg_replace("/\s+/", "", $recipeTitle) .".php";
$newFile = fopen('../pages/'.$fileName, 'a') or die("can't open file");

/* Compile html */
$output = "<!doctype html><html lang=\"en\"><head>";
$output .= "<meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">";
$output .= "<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css\" integrity=\"sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh\" crossorigin=\"anonymous\">";
$output .= "<link rel=\"stylesheet\" href=\"../css/recipe.css\">";
$output .= "<title>".$recipeTitle."</title></head><body>";
$output .= "<div class=\"container\">";
$output .= "<h2>".$recipeTitle."</h2>";
$output .= "<small>".$recipeNotes."</small>";
$output .= "<h3>How it's made</h3>";
$output .= $prep;
$output .= "<h4>Recipe tags</h4>";
$output .= "<ul class=\"list-inline\">";
if(isset($_POST['submit'])) {
	if (!empty($recipeTags)) {
		foreach ($recipeTags as $tag) {
			$output .= "<li class=\"list-inline-item\">$tag</li>";
		}
	} else {
		$output .= "<p>No tags selected</p>";
	}
}
$output .= "</ul></div></body></html>";

/* Write recipe data to file */
fwrite($newFile, $output);

/* Close file */
fclose($newFile);

/* Redirect to created  page */
header('Location: ../pages/'.$fileName.');
exit();
?>
