# recipes
 PHP recipe viewer using Bootstrap 4 and TinyMCE

# Implemented features
1. Add a recipe via HTML/PHP form.
- Recipe form data is formatted in HTML and stored in a dedicated php file
- Filenames are created from the submitted recipeTitle
- The submitted data is displayed on its new, dedicated webpage
- If the filename exists, append a random integer.

1. Format recipe ingredients and preparation information using TinyMCE, implemented via CDN. The editor is stripped down to include only
- **bold**
- _italics_
- ~~strikethrough~~
- hyperlinks
- bulleted lists
- numbered lists

# Current tasks
1. Create template styling for individual recipe pages
1. View all recipes

# Future features
1. Edit/modify recipe
1. Delete recipe
1. Sort recipes by tag
1. View tags as tag cloud
1. Toggle favorite recipe
