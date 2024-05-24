<?php
echo "Debugging debug.php";
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'conn/connect.php';
    
    $type = $_POST["type"];
    $title = $_POST["title"];
    $points = $_POST["points"];
    $time = $_POST["time"];
    $image = $_POST["image"];
    $questionText = $_POST["question_text"];
    $feedback = $_POST["feedback"];
    $hint = $_POST["hint"];
    $pool = $_POST["pool"];
    $tags = $_POST["tags"];
    $courses = $_POST["courses"];
    $chapters = $_POST["chapters"];
    $categories = $_POST["categories"];
    
    $tags = is_array($tags) ? $tags : [$tags];
    $courses = is_array($courses) ? $courses : [$courses];
    $chapters = is_array($chapters) ? $chapters : [$chapters];
    $categories = is_array($categories) ? $categories : [$categories];
    
    $tagsStr = is_array($tags) ? implode(',', $tags) . ',' : $tags;
    $coursesStr = is_array($courses) ? implode(',', $courses) . ',' : $courses;
    $chaptersStr = is_array($chapters) ? implode(',', $chapters) . ',' : $chapters;
    $categoriesStr = is_array($categories) ? implode(',', $categories) . ',' : $categories;
    
    $vraag->createVraag($type, $title, $points, $time, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr);
    
    if ($type === 'MC' || $type === 'MS') {
        $NumberOptions = isset($_POST["NumberOptions"]) ? intval($_POST["NumberOptions"]) : 0;
        $OptionUnique = $_POST["OptionUnique"];
        
        try {
            $vraag->insertOption($title, $NumberOptions, $OptionUnique);
            
            if (!empty($NumberOptions)) {
                for ($i = 0; $i < count($NumberOptions); $i++) {
                    $optionTitle = $_POST["OptionTitle"][$i];
                    $optionPoints = $_POST["OptionPoints"][$i];
                    $optionFeedback = $_POST["OptionFeedback"][$i];
                    $optionRequired = $_POST["OptionRequired"][$i];
                    $optionExpression = $_POST["OptionExpression"][$i];
                    
                    $vraag->insertOptionIndividual($title, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression);
                }
            } else {
                echo"no numberoption given";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>