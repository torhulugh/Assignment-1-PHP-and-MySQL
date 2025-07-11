<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Details</title>
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
        .details-area {
            width: 90vw;
            max-width: 700px;
            min-height: 60vh;
            margin: 40px auto 0 auto;
            padding: 36px 0 24px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .detail-label {
            font-weight: bold;
            color: #222;
            font-size: 1.1em;
        }
        .detail-value {
            color: #333;
            margin-bottom: 18px;
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
        .edit-btn {
            display: inline-block;
            background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            margin: 18px 0 0 0;
            box-shadow: 0 2px 8px rgba(253,160,133,0.10);
            transition: background 0.2s;
            text-decoration: none;
        }
        .edit-btn:hover {
            background: linear-gradient(90deg, #fda085 0%, #f6d365 100%);
        }
        .error {
            text-align: center;
            color: #d32f2f;
            font-weight: bold;
            margin: 40px auto 22px auto;
            font-size: 1.2em;
        }
        @media (max-width: 800px) {
            h1 { font-size: 1.5em; }
            .details-area { padding: 18px 0 18px 0; min-height: 50vh; }
        }
    </style>
</head>
<body>
    <h1>Recipe Details</h1>
    <?php
    require('connect.php');
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
        $error = "No recipe specified.";
    }
    if ($error) {
        echo "<div class='error'>$error</div>";
    }
    if ($recipe):
        $difficultyIcon = '';
        if ($recipe['difficulty'] == 'Easy') {
            $difficultyIcon = '🟢';
        } elseif ($recipe['difficulty'] == 'Medium') {
            $difficultyIcon = '🟠';
        } elseif ($recipe['difficulty'] == 'Hard') {
            $difficultyIcon = '🔴';
        }
    ?>
    <div class="details-area">
        <div class="detail-label">Title:</div>
        <div class="detail-value"><?php echo $difficultyIcon . ' ' . htmlspecialchars($recipe['title']); ?></div>
        <div class="detail-label">Cuisine:</div>
        <div class="detail-value"><?php echo htmlspecialchars($recipe['cuisine']); ?></div>
        <div class="detail-label">Difficulty:</div>
        <div class="detail-value"><?php echo htmlspecialchars($recipe['difficulty']); ?></div>
        <div class="detail-label">Prep Time:</div>
        <div class="detail-value"><?php echo $recipe['prep_time_min']; ?> min</div>
        <div class="detail-label">Cook Time:</div>
        <div class="detail-value"><?php echo $recipe['cook_time_min']; ?> min</div>
        <div class="detail-label">Rating:</div>
        <div class="detail-value"><?php echo $recipe['rating']; ?>/5</div>
        <div class="detail-label">Date Tried:</div>
        <div class="detail-value"><?php echo $recipe['date_tried']; ?></div>
        <div class="detail-label">Ingredients:</div>
        <div class="detail-value"><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></div>
        <div class="detail-label">Steps:</div>
        <div class="detail-value"><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></div>
        <div class="detail-label">Notes:</div>
        <div class="detail-value"><?php echo nl2br(htmlspecialchars($recipe['notes'])); ?></div>
        <a class="edit-btn" href="update.php?recipe_id=<?php echo $recipe['recipe_id']; ?>">Edit Recipe</a>
    </div>
    <?php endif; ?>
    <a class="back-link" href="index.php">&larr; Back to Recipe List</a>
</body>
</html> 