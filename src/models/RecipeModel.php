<?php
class RecipeModel
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = new \PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USER, PASSWORD);
    }

    public function getAll(): array
    {
        $statement = $this->connection->query('SELECT id, title FROM recipe');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecipeById(int $id)
    {
        // Fetching a recipe from database -  assuming the database is okay
        $query = 'SELECT title, description FROM recipe WHERE id=:id';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $recipe = $statement->fetch(PDO::FETCH_ASSOC);
    }
}