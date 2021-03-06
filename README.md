# recipes
 PHP recipe manager using Bootstrap 4 and TinyMCE 5

# Implemented features

## 1/ Add a recipe via HTML/PHP form.
- Recipe form data is formatted in HTML and stored in a dedicated .php file
- Filenames are created from the submitted [recipeTitle]
- The submitted data is displayed on its new, dedicated webpage
- If the filename exists, append a random integer

## 2/ Format recipe ingredients and preparation information using TinyMCE, implemented via CDN. The editor is modified to include only
- **bold**
- _italics_
- ~~strikethrough~~
- hyperlinks
- bulleted lists
- numbered lists

## 3/ View all recipes
- Displays all recipe titles with tags
- Card titles link to dedicated recipe page
- Bootstrap cards are arranged in a card deck for easy responsiveness

## 4/ Delete recipe
- Initiated from dedicated recipe page
- Removes [recipeTitle].php from pages/
- Removes associated div.card from lib_recipe_cards

## 5/ Add tags one at a time
- Adds tag to comma-separated .txt file
- Tags are formatted at time of printing

## 6/ Modify recipe
- Initiated from dedicated recipe page
- Removes original dedicated recipe page from pages/
- Removes associated div.card from lib_recipe_cards
- Creates new dedicated recipe page
- Creates new div.card

# Current tasks
1. Delete tag from tag database
1. Style dedicated recipe pages

# Future tasks
1. Toggle favorite recipes
1. Sort recipes by tag
1. View tags as tag cloud

# Known issues
1. Changes to form processing do not automatically update existing recipes
1. Potential duplicate filenames are only checked once. Would be better to check against all titles and offer the option of editing an existing file or creating a new file.
1. Adding a tag does not add it to appropriate recipes. Possible solution: have user select appropriate recipes from a checkbox list of recipes, offering an option to skip this step.
