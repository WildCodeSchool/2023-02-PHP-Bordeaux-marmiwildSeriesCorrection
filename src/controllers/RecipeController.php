<?php

require __DIR__ . '/../models/RecipeModel.php';

class RecipeController
{
    private RecipeModel $model;

    public function __construct()
    {
        $this->model = new RecipeModel();
    }

    public function browseRecipe(): void
    {
        $recipes = $this->model->getAll();

        require __DIR__ . '/../views/index.php';
    }

    public function getRecipeById(int $id): mixed
    {
        $recipe = $this->model->getRecipeById($id);
        require __DIR__ . '/../views/show.php';
        return $recipe;
    }

    public function addRecipe(array $recipe): void
    {
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            $errors = $this->validate($recipe);

            if (empty($errors)) {

                $this->sanitize($_POST);
                $this->model->saveRecipe($recipe);

                header('Location: /');
            }
        }

        require __DIR__ . '/../views/form.php';
    }

    public function editRecipe(int $id): void
    {
        $recipe = $this->model->getRecipeById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $errors = $this->validate($recipe);

            if (empty($errors)) {

                $recipe['title'] = $_POST['title'];
                $recipe['description'] = $_POST['description'];

                $this->sanitize($recipe);
                $this->model->editRecipeById($id,$recipe);

                header('Location: /');
            }
        }

        require __DIR__ . '/../views/form.php';
    }

    public function deleteRecipe(int $id): void
    {
        $recipe = $this->model->getRecipeById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->model->deleteRecipeById($id);
            header('Location: /');
        }

        require __DIR__ . '/../views/form.php';
    }

    public function validate(array $recipe): array
    {
        if (empty($recipe['title'])){
            $errors[] = 'Title is required';
        }
        if (empty($recipe['description'])){
            $errors[] = 'Description is required';
        }
        if (!empty($recipe['title'])&& strlen($recipe['title'])>250){
            $errors[] = 'Title must be less than 250 characters';
        }

        return $errors ?? [];
    }

    public function sanitize(array $recipe): array
    {
        array_map('trim', $_POST);
        return array_map('htmlentities', $_POST);
    }
}