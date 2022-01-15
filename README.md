# recipes
 PHP recipe manager using Bootstrap 4 and TinyMCE 5

# Implemented features

## 1/ Add a recipe via HTML/PHP form
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

## 3/ List all recipes
- Displays all recipe titles with tags
- Card titles link to dedicated recipe page
- Bootstrap cards are arranged in a card deck for easy responsiveness
- [**TODO**] Quick filters organize recipes by tag
- [**TODO**] Tags shown in a tag cloud indicating most/least common tags

## 4/ View individual recipe
- Displays recipe title, tags, and preparation information
- Provides links to Edit and Delete recipe
- [**TODO**] Style recipe display page
- [**TODO**] Each tag links to a page listing all recipes sharing the tag
- [**TODO**] Provides toggle to add/remove recipe as tag-favorite

## 5/ Delete recipe
- Initiated from dedicated recipe page
- Removes [recipeTitle].php from pages/
- Removes associated div.card from lib_recipe_cards

## 6/ Edit recipe (in progress)
- Initiated from dedicated recipe page
- Removes original dedicated recipe page from pages/
- Removes associated div.card from lib_recipe_cards
- Creates new dedicated recipe page
- Creates new div.card

## 7/ Add tags one at a time
- Adds tag to comma-separated .txt file
- Tags are formatted at time of printing

## 8/ Remove tags (in progress)
- [**TODO**] Remove tag from tag database on form submit
