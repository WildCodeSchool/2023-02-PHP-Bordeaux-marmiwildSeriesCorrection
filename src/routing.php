<?php

require_once __DIR__.'/controllers/RecipeController.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$recipeController = new RecipeController();

if ('/' === $urlPath) {
    $recipeController->browseRecipe();
    // browseRecipes();
} elseif ('/show' === $urlPath && isset($_GET['id'])) {
    $recipeController->getRecipeById($_GET['id']);
} elseif ('/add' === $urlPath) {
    $recipeController->addRecipe();
} else {
    header('HTTP/1.1 404 Not Found');
}