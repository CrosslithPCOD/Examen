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
            <input type="number" id="points" name="points"><br><br>
            
            <label for="time">Time:</label><br>
            <input type="number" id="time" name="time"><br><br>
            
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
            <label for="numberoptions">Option Amount (1-9):</label><br>
            <input placeholder="1" type="number" id="numberoptions" name="numberoptions" min="1" max="9" maxlength="1"><br><br>
            
            <label for="optionunique">Option Unique (1 or multiple):</label><br>
            <select id="optionunique" name="optionunique">
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
    var mcmsDiv = document.getElementById("SHOWMCMS");
    
    if (type == "MC" || type == "MS") {
        mcmsDiv.style.display = "block";
        postres.innerHTML = type == "MC" ? "Multiple Choice" : "Multiple Selection";
    } else if (type == "WR") {
        mcmsDiv.style.display = "none";
        postres.innerHTML = "Written Response";
    } else if (type == "TF") {
        mcmsDiv.style.display = "none";
        postres.innerHTML = "True or False";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    showWater();
    
    var typeSelect = document.getElementById("type");
    typeSelect.addEventListener("change", showWater);
});

function generateOptionFields() {
    var numOptions = document.getElementById("numberoptions").value;
    var optionsDiv = document.getElementById("additionalOptions");
    optionsDiv.innerHTML = ""; // Clear previous fields
    
    for (var i = 1; i <= numOptions; i++) {
        var optionLabel = document.createElement("label");
        optionLabel.textContent = "Option " + i + ":";
        
        var optionInput = document.createElement("input");
        optionInput.type = "text";
        optionInput.name = "option" + i;
        
        var optionPointsLabel = document.createElement("label");
        optionPointsLabel.textContent = "Points:";
        
        var optionPointsInput = document.createElement("input");
        optionPointsInput.type = "number";
        optionPointsInput.name = "optionPoints" + i;
        
        var optionFeedbackLabel = document.createElement("label");
        optionFeedbackLabel.textContent = "Feedback:";
        
        var optionFeedbackInput = document.createElement("input");
        optionFeedbackInput.type = "text";
        optionFeedbackInput.name = "optionFeedback" + i;
        
        var optionRequiredLabel = document.createElement("label");
        optionRequiredLabel.textContent = "Required:";
        
        var optionRequiredInput = document.createElement("input");
        optionRequiredInput.type = "checkbox";
        optionRequiredInput.name = "optionRequired" + i;
        
        var optionExpressionLabel = document.createElement("label");
        optionExpressionLabel.textContent = "Expression:";
        
        var optionExpressionInput = document.createElement("input");
        optionExpressionInput.type = "checkbox";
        optionExpressionInput.name = "optionExpression" + i;
        
        optionsDiv.appendChild(optionLabel);
        optionsDiv.appendChild(optionInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionPointsLabel);
        optionsDiv.appendChild(optionPointsInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionFeedbackLabel);
        optionsDiv.appendChild(optionFeedbackInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionRequiredLabel);
        optionsDiv.appendChild(optionRequiredInput);
        optionsDiv.appendChild(document.createElement("br"));
        
        optionsDiv.appendChild(optionExpressionLabel);
        optionsDiv.appendChild(optionExpressionInput);
        optionsDiv.appendChild(document.createElement("br"));
        optionsDiv.appendChild(document.createElement("br"));
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Generate fields when the page loads
    generateOptionFields();
    
    var numberOptionsInput = document.getElementById("numberoptions");
    numberOptionsInput.addEventListener("change", generateOptionFields);
});
</script>
<?php require 'footer.php'; ?>
    