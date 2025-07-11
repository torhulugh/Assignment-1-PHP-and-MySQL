<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe</title>
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
        .form-card {
            width: 90vw;
            max-width: 700px;
            min-height: 70vh;
            margin: 40px auto 0 auto;
            padding: 48px 0 36px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #222;
            font-size: 1.1em;
        }
        input, select, textarea {
            width: 100%;
            padding: 14px;
            margin-bottom: 22px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1.1em;
            background: #fff8f0;
            transition: border 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            border: 2px solid #fda085;
            outline: none;
        }
        button {
            background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
            color: #fff;
            border: none;
            padding: 18px 0;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 2px 8px rgba(253,160,133,0.10);
            transition: background 0.2s;
        }
        button:hover {
            background: linear-gradient(90deg, #fda085 0%, #f6d365 100%);
        }
        .message {
            text-align: center;
            color: #388e3c;
            font-weight: bold;
            margin-bottom: 22px;
            font-size: 1.1em;
        }
        .error {
            text-align: center;
            color: #d32f2f;
            font-weight: bold;
            margin-bottom: 22px;
            font-size: 1.1em;
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
        @media (max-width: 800px) {
            .form-card {
                padding: 24px 0 24px 0;
                min-height: 60vh;
            }
            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <h1>Edit Recipe</h1>
    <?php
    require('connect.php');
    $message = '';
    $error = '';
    $recipe = null;

    if (isset($_GET['recipe_id'])) {
        $recipe_id = $_GET['recipe_id'];
        $result = mysqli_query($connect, "SELECT * FROM recipes WHERE recipe_id = $recipe_id");
        if ($result && mysqli_num_rows($result) > 0) {
            $recipe = mysqli_fetch_assoc($result);
        } else {
            $error = "Recipe not found.";
        }
    } else {
        $error = "No recipe selected.";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipe_id'])) {
        $recipe_id = $_POST['recipe_id'];
        $title = $_POST['title'];
        $cuisine = $_POST['cuisine'];
        $difficulty = $_POST['difficulty'];
        $prep_time_min = $_POST['prep_time_min'];
        $cook_time_min = $_POST['cook_time_min'];
        $ingredients = $_POST['ingredients'];
        $steps = $_POST['steps'];
        $rating = $_POST['rating'];
        $date_tried = $_POST['date_tried'];
        $notes = $_POST['notes'];

        $query = "UPDATE recipes SET title='$title', cuisine='$cuisine', difficulty='$difficulty', prep_time_min=$prep_time_min, cook_time_min=$cook_time_min, ingredients='$ingredients', steps='$steps', rating=$rating, date_tried='$date_tried', notes='$notes' WHERE recipe_id=$recipe_id";
        if (mysqli_query($connect, $query)) {
            $message = "Recipe updated!";
            $result = mysqli_query($connect, "SELECT * FROM recipes WHERE recipe_id = $recipe_id");
            if ($result && mysqli_num_rows($result) > 0) {
                $recipe = mysqli_fetch_assoc($result);
            }
        } else {
            $error = "Error: " . mysqli_error($connect);
        }
    }

    if ($message) echo "<div class='message'>$message</div>";
    if ($error) echo "<div class='error'>$error</div>";
    if ($recipe):
    ?>
    <form method="POST" class="form-card">
        <input type="hidden" name="recipe_id" value="<?php echo $recipe['recipe_id']; ?>">
        <label>Title:
            <input type="text" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
        </label>
        <label>Cuisine:
            <input type="text" name="cuisine" value="<?php echo htmlspecialchars($recipe['cuisine']); ?>">
        </label>
        <label>Difficulty:
            <select name="difficulty" required>
                <option value="Easy" <?php if($recipe['difficulty']=='Easy') echo 'selected'; ?>>Easy</option>
                <option value="Medium" <?php if($recipe['difficulty']=='Medium') echo 'selected'; ?>>Medium</option>
                <option value="Hard" <?php if($recipe['difficulty']=='Hard') echo 'selected'; ?>>Hard</option>
            </select>
        </label>
        <label>Prep Time (minutes):
            <input type="number" name="prep_time_min" min="0" value="<?php echo $recipe['prep_time_min']; ?>" required>
        </label>
        <label>Cook Time (minutes):
            <input type="number" name="cook_time_min" min="0" value="<?php echo $recipe['cook_time_min']; ?>" required>
        </label>
        <label>Ingredients:
            <textarea name="ingredients" rows="3" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
        </label>
        <label>Steps:
            <textarea name="steps" rows="4" required><?php echo htmlspecialchars($recipe['steps']); ?></textarea>
        </label>
        <label>Rating (1-5):
            <input type="number" name="rating" min="1" max="5" value="<?php echo $recipe['rating']; ?>" required>
        </label>
        <label>Date Tried:
            <input type="date" name="date_tried" value="<?php echo $recipe['date_tried']; ?>" required>
        </label>
        <label>Notes:
            <textarea name="notes" rows="2"><?php echo htmlspecialchars($recipe['notes']); ?></textarea>
        </label>
        <button type="submit">Update Recipe</button>
    </form>
    <?php endif; ?>
    <a class="back-link" href="index.php">&larr; Back to Recipe List</a>
</body>
</html>
