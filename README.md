# recipes
 PHP recipe viewer using Bootstrap 4 and TinyMCE

# Implemented features
1. Add a recipe via HTML/PHP form.
- Recipe form data is formatted in HTML and stored in a dedicated php file
- Filenames are created from the submitted recipeTitle
- The submitted data is displayed on its new, dedicated webpage
- If the filename exists, append a random integer

1. Format recipe ingredients and preparation information using TinyMCE, implemented via CDN. The editor is stripped down to include only
- **bold**
- _italics_
- ~~strikethrough~~
- hyperlinks
- bulleted lists
- numbered lists

1. View all recipes
- Displays all recipe titles
- Card titles link to dedicated recipe page
- Bootstrap cards are arranged in a card deck for easy responsiveness

1. Delete recipe from dedicated recipe page
- Removes recipeTitle.php from pages/
- Removes associated div.card from lib_recipe_cards

# Current tasks
1. Edit/modify recipe
1. Try changing dedicated page file ext to html - should be fine; create new html directory

# Future features
1. Sort recipes by tag
1. View tags as tag cloud
1. Toggle favorite recipe
1. Add/edit/delete tags
1. Styling for dedicated recipe pages

# Known issues
1. Changes to code processing do not automatically update existing recipes
1. Potential duplicate filenames are only checked once. Would be better to check against all titles and offer the option of appending or creating a new file.
