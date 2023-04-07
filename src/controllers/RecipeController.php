<?php

require __DIR__ . '/../models/RecipeModel.php';

class RecipeController
{
    private $model;

    public function __construct()
    {
        $this->model = new RecipeModel();
    }

    public function browseRecipe(): void
    {
        $recipes = $this->model->getAll();

        require __DIR__ . '/../views/index.php';
    }

    public function getRecipeById(int $id): void
    {
        $recipe = $this->model->getRecipeById($id);
        require __DIR__ . '/../views/show.php';
    }

    public function addRecipe()
    {
        require __DIR__ . '/../views/form.php';
    }
}