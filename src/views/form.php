<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>List of Recipes</title>
</head>
<body>
<h1>Add Recipe</h1>
<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <li><?= $error; ?></li>
    <?php endforeach; ?>
<?php endif; ?>
<form method="post">
    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?= $recipe['title'] ?? ''; ?>">
    </div>
    <br>
    <div>
        <label for="description">Description</label><br>
        <textarea name="description" id="description" cols="30" rows="10"><?= $recipe['description'] ?? '' ?></textarea>
    </div>
    <button>Submit</button>
</form>
<a href="/">Back home</a>
</body>
</html>
