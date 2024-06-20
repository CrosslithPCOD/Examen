<?php
echo "Debugging debug.php";
require_once 'header.php';

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
    
    $tagsStr = implode(',', $tags);
    $coursesStr = implode(',', $courses);
    $chaptersStr = implode(',', $chapters);
    $categoriesStr = implode(',', $categories);
    
    $vraag = new Vraag();  // Ensure you create an instance of Vraag
    $vraag->createVraag($type, $title, $points, $time, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr);
    
    if ($type === 'MC' || $type === 'MS') {
        $NumberOptions = $_POST["NumberOptions"];
        $OptionUnique = $_POST["OptionUnique"];
        
        echo "Debugging NumberOptions: ";
        var_dump($NumberOptions);
        
        if (!empty($NumberOptions) && is_array($NumberOptions)) {
            $vraag->insertOption($title, $NumberOptions, $OptionUnique);
            
            for ($i = 0; $i < count($NumberOptions); $i++) {
                $optionTitle = $_POST["OptionTitle"][$i];
                $optionPoints = $_POST["OptionPoints"][$i];
                $optionFeedback = $_POST["OptionFeedback"][$i];
                $optionRequired = $_POST["OptionRequired"][$i];
                $optionExpression = $_POST["OptionExpression"][$i];
                
                $vraag->insertOptionIndividual($title, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression);
            }
        } else {
            echo "No NumberOptions given or NumberOptions is not an array.";
        }
    }
}

?>
