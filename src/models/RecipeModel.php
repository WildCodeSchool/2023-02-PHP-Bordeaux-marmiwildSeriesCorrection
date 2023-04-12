<?php
namespace Src\Models;
//require_once 'DBConnexion.php';
use PDO;

class RecipeModel extends DBConnexion
{
    /*
    private int $id;
    private string $title;
    private string $description;
    */

    public function getAll(): array
    {
        $statement = $this->connection->query('SELECT id, title FROM recipe');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecipeById(int $id)
    {
        $query = 'SELECT * FROM recipe WHERE id=:id';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $recipe = $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function saveRecipe(array $recipe): void
    {
        $query = "INSERT INTO recipe(title, description) VALUE (:title, :description)";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(":title", $recipe['title'], PDO::PARAM_STR);
        $statement->bindValue(':description', $recipe['description'], PDO::PARAM_STR);

        $statement->execute();

        $statement->closeCursor();
    }

    public function editRecipeById(int $id, array $recipe): void
    {
        $query = 'UPDATE recipe SET title =:title, description = :description WHERE id=:id';

        $statement = $this->connection->prepare($query);

        $statement->bindValue(':title', $recipe['title'], PDO::PARAM_STR);
        $statement->bindValue(':description', $recipe['description'], PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        $statement->closeCursor();
    }

    public function deleteRecipeById(int $id): void
    {
        $query = 'DELETE from recipe WHERE id=:id';

        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        $statement->closeCursor();
    }

}