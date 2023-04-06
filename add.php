<?php

require_once 'config.php';
require 'src/models/recipe-model.php';

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

require __DIR__ . '/src/views/form.php';
