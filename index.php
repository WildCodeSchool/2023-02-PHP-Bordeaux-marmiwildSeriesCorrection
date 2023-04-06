<?php

require_once 'config.php';
require __DIR__ . '/src/models/recipe-model.php';

// Fetching all recipes from database - assuming the database is okay
$recipes = getAllRecipes();

// Generate the web page
require __DIR__ . '/src/views/index.php';

