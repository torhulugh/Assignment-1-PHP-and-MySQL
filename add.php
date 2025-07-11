<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add a Recipe</title>
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
        .form-area {
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
            h1 { font-size: 1.5em; }
            .form-area { padding: 24px 0 24px 0; min-height: 60vh; }
        }
    </style>
</head>
<body>
    <h1>Add a New Recipe</h1>
    <?php
    require('connect.php');
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        $query = "INSERT INTO recipes (title, cuisine, difficulty, prep_time_min, cook_time_min, ingredients, steps, rating, date_tried, notes) VALUES ('$title', '$cuisine', '$difficulty', $prep_time_min, $cook_time_min, '$ingredients', '$steps', $rating, '$date_tried', '$notes')";
        if (mysqli_query($connect, $query)) {
            $message = "Recipe added!";
        } else {
            $message = "Error: " . mysqli_error($connect);
        }
    }
    if ($message) echo "<div class='message'>$message</div>";
    ?>
    <form method="POST" class="form-area">
        <label>Title:
            <input type="text" name="title" required>
        </label>
        <label>Cuisine:
            <input type="text" name="cuisine">
        </label>
        <label>Difficulty:
            <select name="difficulty" required>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>
        </label>
        <label>Prep Time (minutes):
            <input type="number" name="prep_time_min" min="0" required>
        </label>
        <label>Cook Time (minutes):
            <input type="number" name="cook_time_min" min="0" required>
        </label>
        <label>Ingredients:
            <textarea name="ingredients" rows="3" required></textarea>
        </label>
        <label>Steps:
            <textarea name="steps" rows="4" required></textarea>
        </label>
        <label>Rating (1-5):
            <input type="number" name="rating" min="1" max="5" required>
        </label>
        <label>Date Tried:
            <input type="date" name="date_tried" required>
        </label>
        <label>Notes:
            <textarea name="notes" rows="2"></textarea>
        </label>
        <button type="submit">Add Recipe</button>
    </form>
    <a class="back-link" href="index.php">&larr; Back to Recipe List</a>
</body>
</html>