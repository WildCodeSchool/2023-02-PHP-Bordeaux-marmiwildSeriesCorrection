<?php

require  '../vendor/autoload.php';
use Src\Controllers\RecipeController as RecipeController;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$recipeController = new RecipeController();

if ('/' === $urlPath) {
    echo $recipeController->browseRecipe();
} elseif ('/show' === $urlPath && isset($_GET['id'])) {
    echo $recipeController->getRecipeById($_GET['id']);
} elseif ('/add' === $urlPath) {
    echo $recipeController->addRecipe($_POST);
}elseif ('/edit' === $urlPath && isset($_GET['id'])) {
    echo $recipeController->editRecipe($_GET['id']);
}
elseif ('/delete' === $urlPath && isset($_GET['id'])) {
   echo $recipeController->deleteRecipe($_GET['id']);
}
else {
    header('HTTP/1.1 404 Not Found');
}