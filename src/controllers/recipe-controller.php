<?php
require __DIR__ . '/../models/recipe-model.php';

function browseRecipes(): void
{
    $recipes = getAllRecipes();

    require __DIR__ . '/../views/index.php';
}

function showRecipe(int $id){
    // Input GET parameter validation (integer >0)
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
    if (false === $id || null === $id) {
        header("Location: /");
        exit("Wrong input parameter");
    }

    $recipe = getRecipeById($id);

// Database result check
    if (!isset($recipe['title']) || !isset($recipe['description'])) {
        header("Location: /");
        exit("Recipe not found");
    }

// Generate the web page
    require __DIR__ . '/../views/show.php';
// return the recipe
    return $recipe;
}

function addRecipe(){

    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $recipe = array_map('trim', $_POST);
        if (empty($recipe['title'])){
            $errors[] = 'Title is required';
        }
        if (empty($recipe['description'])){
            $errors[] = 'Description is required';
        }
        if (!empty($recipe['title'])&& strlen($recipe['title'])>250){
            $errors[] = 'Title must be less than 250 charactere';
        }

        if (empty($errors)) {
            saveRecipe($recipe);
            header('Location: /');
        }
    }

    require __DIR__ . '/../views/form.php';
}