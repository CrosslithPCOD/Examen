<?php
require '../header.php';

foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        echo "$key: " . implode(',', $value) . "<br>";
    } else {
        echo "$key: $value <br>";
    }
}

$type = $_POST['type'] ?? '';
$title = $_POST['title'] ?? '';
$points = $_POST['points'] ?? '';
$time = $_POST['time'] ?? '';
$image = $_POST['image'] ?? '';
$questionText = $_POST['question_text'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$hint = $_POST['hint'] ?? '';
$pool = $_POST['pool'] ?? '';
$tags = $_POST['tags'] ?? [];
$courses = $_POST['courses'] ?? [];
$chapters = $_POST['chapters'] ?? [];
$categories = $_POST['categories'] ?? [];

$tagsStr = implode(',', $tags);
$coursesStr = implode(',', $courses);
$chaptersStr = implode(',', $chapters);
$categoriesStr = implode(',', $categories);

$vraag->createVraag($type, $title, $points, $time, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr);

if ($type == "MC" || $type == "MS") {
    $numberOptions = $_POST['numberoptions'] ?? '';
    $optionUnique = $_POST['optionunique'] ?? '';
    $vraag->insertOption($title, $numberOptions, $optionUnique);
    
    for ($i = 1; $i <= $numberOptions; $i++) {
        $optionNumber = $i;
        $optionTitle = $_POST["option{$i}"] ?? '';
        $optionPoints = $_POST["optionPoints{$i}"] ?? '';
        $optionFeedback = $_POST["optionFeedback{$i}"] ?? '';
        $optionRequired = isset($_POST["optionRequired{$i}"]) ? 1 : 0;
        $optionExpression = $_POST["optionExpression{$i}"] ?? '';
        
        echo "Option Number: $optionNumber <br>";
        $vraag->insertOptionIndividual($title, $optionNumber, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression);
    }
}
?>
