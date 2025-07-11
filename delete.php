<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Recipe</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            background: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 40px;
            letter-spacing: 2px;
            font-size: 2.2em;
        }
        .message {
            text-align: center;
            color: #388e3c;
            font-weight: bold;
            margin: 40px auto 22px auto;
            font-size: 1.2em;
        }
        .error {
            text-align: center;
            color: #d32f2f;
            font-weight: bold;
            margin: 40px auto 22px auto;
            font-size: 1.2em;
        }
        .back-link {
            display: block;
            text-align: center;
            margin: 36px auto 0 auto;
            color: #f57c00;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.2em;
            letter-spacing: 1px;
        }
        .back-link:hover {
            text-decoration: underline;
            color: #d84315;
        }
    </style>
</head>
<body>
    <h1>Delete Recipe</h1>
    <?php
    require('connect.php');
    $message = '';
    $error = '';
    if (isset($_GET['recipe_id'])) {
        $recipe_id = $_GET['recipe_id'];
        $query = "DELETE FROM recipes WHERE recipe_id = $recipe_id";
        if (mysqli_query($connect, $query)) {
            $message = "Recipe deleted successfully.";
        } else {
            $error = "Error deleting recipe: " . mysqli_error($connect);
        }
    } else {
        $error = "No recipe specified.";
    }
    if ($message) echo "<div class='message'>$message</div>";
    if ($error) echo "<div class='error'>$error</div>";
    ?>
    <a class="back-link" href="index.php">&larr; Back to Recipe List</a>
</body>
</html>