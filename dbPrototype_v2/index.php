<?php
require 'header.php';
echo "Home.php";

?>
<head>
    <title>Question Form</title>
</head>
<h2>Question Form</h2>

<form id="questionForm" action="conn/createVraag.php" method="post">
<input type="submit" value="Submit"><br><br>
    <div class="container">
        <div class="left-column">
            <label for="type">Type:</label>
            <select id="type" name="type" onchange="showWater()">
            <?php $vraag->fetchTypes(); ?>
            </select>
            <p>Chosen: <b id="chosenType">2q3</b></p>
            
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required><br><br>
            
            <label for="points">Points:</label><br>
            <input type="number" id="points" name="points">
            <p>If left blank, default 100 points.</p><br>
            
            <label for="time">Time:</label><br>
            <input type="number" id="time" name="time">
            <p>If left blank, default 60 seconds.</p><br>
            
            <label for="image">Image:</label><br>
            <input type="text" id="image" name="image"><br><br>
            
            <label for="question_text">Question Text:</label><br>
            <textarea type="text" id="question_text" name="question_text" rows="4" cols="22"></textarea><br><br>
            
            <label for="feedback">Feedback:</label><br>
            <input type="text" id="feedback" name="feedback"></input><br><br>
            
            <label for="hint">Hint:</label><br>
            <input id="hint" name="hint"></input><br><br>
            
            <label for="pool">Pool:</label>
            <select id="pool" name="pool">
            <?php $vraag->fetchPools(); ?>
            </select><br><br>
            
            <label>Tags:</label><br>
            <?php $vraag->fetchTags(); ?>
            <br>
            
            <label>Courses:</label><br>
            <?php $vraag->fetchCourses(); ?>
            <br>
            
            <label>Chapters:</label><br>
            <?php $vraag->fetchChapters(); ?>
            <br>
            
            <label>Categories:</label><br>
            <?php $vraag->fetchCategories(); ?>
            <br>
        </div>
        <div class="right-column" id="SHOWMCMS" style="display: none;">
            <label for="NumberOptions">Option Amount (1-9):</label><br>
            <input placeholder="1" type="number" id="NumberOptions" name="NumberOptions[]" min="1" max="9" maxlength="1"><br><br>
            
            <label for="OptionUnique">Option Unique (1 or multiple):</label><br>
            <select id="OptionUnique" name="OptionUnique">
                <option value="1">True</option>
                <option value="0">False</option>
            </select><br><br>
            
            <div id="additionalOptions"></div>
        </div>
    </div>
<input type="submit" value="Submit">
</form>

<script>
function showWater() {
    var type = document.getElementById("type").value;
    var postres = document.getElementById("chosenType");
    var waterDiv = document.getElementById("SHOWMCMS");

    if (type == "MC") {
        waterDiv.style.display = "block";
        postres.innerHTML = "Multiple Choice";
    } else if (type == "MS") {
        waterDiv.style.display = "block";
        postres.innerHTML = "Multiple Selection";
    } else if (type == "WR") {
        waterDiv.style.display = "none";
        postres.innerHTML = "Written Response";
    } else if (type == "TF") {
        waterDiv.style.display = "none";
        postres.innerHTML = "True or False";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    showWater();
    
    var typeSelect = document.getElementById("type");
    typeSelect.addEventListener("change", showWater);
});
</script>
<?php require 'footer.php'; ?>
    