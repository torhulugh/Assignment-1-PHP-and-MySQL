<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Manager</title>
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
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 40px;
            letter-spacing: 2px;
            font-size: 2.2em;
        }
        .add-link {
            display: block;
            text-align: center;
            margin: 30px auto 36px auto;
            color: #f57c00;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.2em;
            letter-spacing: 1px;
        }
        .add-link:hover {
            text-decoration: underline;
            color: #d84315;
        }
        .recipe-list {
            width: 90vw;
            max-width: 700px;
            margin: 0 auto 40px auto;
            padding: 0;
        }
        .recipe-entry {
            margin-bottom: 38px;
            padding: 0 0 18px 0;
            border-bottom: 2px solid #fff3e0;
        }
        .recipe-title {
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 6px;
            color: #222;
        }
        .recipe-meta {
            color: #444;
            margin-bottom: 5px;
            font-size: 1.05em;
        }
        p {
            color: #333;
            margin: 6px 0 10px 0;
        }
        a.action-link {
            display: inline-block;
            min-width: 80px;
            text-align: center;
            margin-right: 10px;
            font-size: 1em;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 999px;
            border: none;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        a.edit-link {
            background: #1976d2;
        }
        a.edit-link:hover {
            background: #1565c0;
        }
        a.delete-link {
            background: #d32f2f;
        }
        a.delete-link:hover {
            background: #b71c1c;
        }
        a.details-link {
            background: #f57c00;
        }
        a.details-link:hover {
            background: #ef6c00;
        }
        @media (max-width: 800px) {
            h1 { font-size: 1.5em; }
            .recipe-list { max-width: 98vw; }
        }
    </style>
</head>
<body>
    <h1>Recipe Manager</h1>
    <a class="add-link" href="add.php">Add a New Recipe</a>
    <div class="recipe-list">
    <?php
    require('connect.php');
    $query = "SELECT * FROM recipes ORDER BY date_tried DESC";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $difficultyIcon = '';
            if ($row['difficulty'] == 'Easy') {
                $difficultyIcon = '🟢';
            } elseif ($row['difficulty'] == 'Medium') {
                $difficultyIcon = '🟠';
            } elseif ($row['difficulty'] == 'Hard') {
                $difficultyIcon = '🔴';
            }

            echo "<div class='recipe-entry'>";
            echo "<div class='recipe-title'>{$difficultyIcon} " . htmlspecialchars($row['title']) . "</div>";
            echo "<div class='recipe-meta'>Cuisine: " . htmlspecialchars($row['cuisine']) . " | Difficulty: " . $row['difficulty'] . " | Tried: " . $row['date_tried'] . "</div>";
            echo "<div class='recipe-meta'>Prep: " . $row['prep_time_min'] . " min | Cook: " . $row['cook_time_min'] . " min | Rating: " . $row['rating'] . "/5</div>";
            echo "<p><strong>Ingredients:</strong> " . htmlspecialchars($row['ingredients']) . "</p>";
            echo "<p><strong>Steps:</strong> " . htmlspecialchars($row['steps']) . "</p>";
            echo "<p><strong>Notes:</strong> " . htmlspecialchars($row['notes']) . "</p>";
            echo "<a class='action-link edit-link' href='update.php?recipe_id=" . $row['recipe_id'] . "'>Edit</a>";
            echo "<a class='action-link delete-link' href='delete.php?recipe_id=" . $row['recipe_id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a>";
            echo "<a class='action-link details-link' href='detail.php?recipe_id=" . $row['recipe_id'] . "'>Details</a>";
            echo "</div>";
        }
    } else {
        echo "<p style='text-align:center; color:#d32f2f; font-weight:bold;'>No recipes found in your collection.</p>";
    }
    ?>
    </div>
</body>
</html>

