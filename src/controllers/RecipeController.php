<?php
namespace Src\Controllers;

use Src\Models\RecipeModel;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class RecipeController
{
    private RecipeModel $model;
    private Environment $twig;

    public function __construct()
    {
        $this->model = new RecipeModel();
        $loader = new FilesystemLoader(__DIR__ . '/../views/');
        $this->twig = new Environment($loader,[
            'debug' => true
        ]);
        $this->twig->addExtension(new DebugExtension());
    }

    public function browseRecipe(): string
    {
        $recipes = $this->model->getAll();

        return $this->twig->render('index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    public function getRecipeById(int $id): mixed
    {
        $recipe = $this->model->getRecipeById($id);

        return $this->twig->render('show.html.twig', [
            'recipe' => $recipe
        ]);
    }

    function addRecipe(array $recipe): string
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

        return $this->twig->render('form.html.twig');
    }

    public function editRecipe(int $id): string
    {
        $recipe = $this->model->getRecipeById($id);
        $errors = [];

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

        return $this->twig->render('edit.html.twig', [
            'recipe' => $recipe,
            'errors' => $errors
        ]);
    }

    public function deleteRecipe(int $id): string
    {
        $recipe = $this->model->getRecipeById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->model->deleteRecipeById($id);
            header('Location: /');
        }

        return $this->twig->render('delete.html.twig', [
            'recipe' => $recipe,
        ]);
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