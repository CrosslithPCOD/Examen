<?php
require 'header.php';
echo "Debugging debug.php";

function validateForm() {
    $type = $_POST["type"];
    $categories = ['tags[]', 'courses[]', 'chapters[]', 'categories[]'];
    $hasNumberInput = false;
    
    if ($type === "MS" || $type === "MC") {
        $categories[] = 'NumberOptions[]';
    }
    
    foreach ($categories as $category) {
        if (isset($_POST[$category])) {
            $inputs = $_POST[$category];
            
            if ($category === 'NumberOptions[]') {
                $numberInput = $inputs[0];
                if ($numberInput <= 0) {
                    echo "Please enter a valid number for " . str_replace("[]", "", $category);
                    return false;
                }
                $hasNumberInput = true;
            } else {
                if (empty($inputs)) {
                    echo "Please select at least one " . str_replace("[]", "", $category);
                    return false;
                }
            }
        } else {
            echo "Form field " . $category . " is missing.";
            return false;
        }
    }
    
    if (!$hasNumberInput && ($type === "MS" || $type === "MC")) {
        echo "Please enter a valid number for NumberOptions";
        return false;
    }
    
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validateForm()) {
        header("Location: debug.php");
        exit();
    }
}
?>
<head>
    <title>Question Form</title>
</head>
<h2>Question Form</h2>

<form id="questionForm" method="post" onsubmit="return validateAndSubmit();">
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
        <div class="right-column" id="SHOWMS" style="display: none;">
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
function validateAndSubmit() {
    if (validateForm()) {
        document.getElementById("questionForm").action = "debug.php";
        return true; // Allow the form to be submitted
    } else {
        return false;
    }
}

function showWater() {
    var type = document.getElementById("type").value;
    var postres = document.getElementById("chosenType");
    var waterDiv = document.getElementById("SHOWMS");

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

document.getElementById('NumberOptions').addEventListener('input', function() {
    var container = document.getElementById('additionalOptions');
    container.innerHTML = ''; // Clear previous options
    
    var numOptions = parseInt(this.value);
    
    for (var i = 1; i <= numOptions; i++) {
        var optionTitleLabel = document.createElement('label');
        optionTitleLabel.textContent = 'Option ' + i + ' Title:';
        container.appendChild(optionTitleLabel);
        
        var inputTitle = document.createElement('input');
        inputTitle.type = 'text';
        inputTitle.name = 'OptionTitle[]'; // Use array notation
        container.appendChild(inputTitle);
        
        container.appendChild(document.createElement('br'));
        
        var optionPointsLabel = document.createElement('label');
        optionPointsLabel.textContent = 'Option ' + i + ' Points:';
        container.appendChild(optionPointsLabel);
        
        var inputPoints = document.createElement('input');
        inputPoints.type = 'number';
        inputPoints.name = 'OptionPoints[]'; // Use array notation
        container.appendChild(inputPoints);
        
        container.appendChild(document.createElement('br'));
        
        var optionFeedbackLabel = document.createElement('label');
        optionFeedbackLabel.textContent = 'Option ' + i + ' Feedback:';
        container.appendChild(optionFeedbackLabel);
        
        var inputFeedback = document.createElement('input');
        inputFeedback.type = 'text';
        inputFeedback.name = 'OptionFeedback[]'; // Use array notation
        container.appendChild(inputFeedback);
        
        container.appendChild(document.createElement('br'));
        
        var labelRequired = document.createElement('label');
        labelRequired.textContent = 'Option ' + i + ' Required:';
        container.appendChild(labelRequired);
        
        var selectRequired = document.createElement('select');
        selectRequired.name = 'OptionRequired[]'; // Use array notation
        var optionTrue = document.createElement('option');
        optionTrue.value = '1';
        optionTrue.textContent = 'True';
        selectRequired.appendChild(optionTrue);
        var optionFalse = document.createElement('option');
        optionFalse.value = '0';
        optionFalse.textContent = 'False';
        selectRequired.appendChild(optionFalse);
        container.appendChild(selectRequired);
        
        container.appendChild(document.createElement('br'));
        
        var labelExpression = document.createElement('label');
        labelExpression.textContent = 'Option ' + i + ' Expression:';
        container.appendChild(labelExpression);
        
        var selectExpression = document.createElement('select');
        selectExpression.name = 'OptionExpression[]'; // Use array notation
        var optionExprTrue = document.createElement('option');
        optionExprTrue.value = '1';
        optionExprTrue.textContent = 'True';
        selectExpression.appendChild(optionExprTrue);
        var optionExprFalse = document.createElement('option');
        optionExprFalse.value = '0';
        optionExprFalse.textContent = 'False';
        selectExpression.appendChild(optionExprFalse);
        container.appendChild(selectExpression);
        
        container.appendChild(document.createElement('br'));
        container.appendChild(document.createElement('br'));
    }
});

function validateForm() {
    console.log('validateForm() function called');
    
    const type = document.getElementById("type").value;
    const categories = ['tags[]', 'courses[]', 'chapters[]', 'categories[]'];
    let hasNumberInput = false;

    if (type === "MS" || type === "MC") {
        categories.push('NumberOptions[]');
    }

    for (const category of categories) {
        const inputs = document.querySelectorAll(`input[name="${category}"]`);

        if (category === 'NumberOptions[]') {
            const numberInput = inputs[0]; // Assuming only one number input is expected
            if (numberInput.value <= 0) {
                alert(`Please enter a valid number for ${category.replace("[]", "")}`);
                return false;
            }
            hasNumberInput = true;
        } else {
            const checked = Array.from(inputs).some(checkbox => checkbox.checked);
            if (!checked) {
                alert(`Please select at least one ${category.replace("[]", "")}`);
                return false;
            }
        }
    }

    if (!hasNumberInput && (type === "MS" || type === "MC")) {
        alert("Please enter a valid number for NumberOptions");
        return false;
    }

    return true;
}


</script>
<?php require 'footer.php'; ?>
    