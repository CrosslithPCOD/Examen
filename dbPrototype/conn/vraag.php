<?php

class Vraag {
    protected $ID;
    protected $Type;
    protected $Title;
    protected $Points;
    protected $Time;
    protected $Image;
    protected $QuestionText;
    protected $Feedback;
    protected $Hint;
    protected $Pool;
    protected $Tags;
    protected $Course;
    protected $Chapter;
    protected $Category;
    protected $NumberOptions;
    protected $OptionUnique;
    protected $OptionTitle;
    protected $OptionPoints;
    protected $OptionFeedback;
    protected $OptionRequired;
    protected $OptionExpression;
    
    public function __construct($ID = null, $Type = null, $Title = null, $Points = null, $Time = null,$Image = null, $QuestionText = null, $Feedback = null, $Hint = null,$Pool = null, $Tags = null, $Course = null, $Chapter = null,$Category = null, $NumberOptions = null, $OptionUnique = null,$OptionTitle = null, $OptionPoints = null, $OptionFeedback = null,$OptionRequired = null, $OptionExpression = null) 
    {
            $this->ID = $ID;
            $this->Type = $Type;
            $this->Title = $Title;
            $this->Points = $Points;
            $this->Time = $Time;
            $this->Image = $Image;
            $this->QuestionText = $QuestionText;
            $this->Feedback = $Feedback;
            $this->Hint = $Hint;
            $this->Pool = $Pool;
            $this->Tags = $Tags;
            $this->Course = $Course;
            $this->Chapter = $Chapter;
            $this->Category = $Category;
            $this->NumberOptions = $NumberOptions;
            $this->OptionUnique = $OptionUnique;
            $this->OptionTitle = $OptionTitle;
            $this->OptionPoints = $OptionPoints;
            $this->OptionFeedback = $OptionFeedback;
            $this->OptionRequired = $OptionRequired;
            $this->OptionExpression = $OptionExpression;
    }
    
    public function getID() {
        return $this->ID;
    }
    
    public function getType() {
        return $this->Type;
    }
    
    public function setType($Type) {
        $this->Type = $Type;
    }
    
    public function getTitle() {
        return $this->Title;
    }
    
    public function setTitle($Title) {
        $this->Title = $Title;
    }
    
    public function getPoints() {
        return $this->Points;
    }
    
    public function setPoints($Points) {
        $this->Points = $Points;
    }
    
    public function getTime() {
        return $this->Time;
    }
    
    public function setTime($Time) {
        $this->Time = $Time;
    }
    
    public function getImage() {
        return $this->Image;
    }
    
    public function setImage($Image) {
        $this->Image = $Image;
    }
    
    public function getQuestionText() {
        return $this->QuestionText;
    }
    
    public function setQuestionText($QuestionText) {
        $this->QuestionText = $QuestionText;
    }
    
    public function getFeedback() {
        return $this->Feedback;
    }
    
    public function setFeedback($Feedback) {
        $this->Feedback = $Feedback;
    }
    
    public function getHint() {
        return $this->Hint;
    }
    
    public function setHint($Hint) {
        $this->Hint = $Hint;
    }
    
    public function getPool() {
        return $this->Pool;
    }
    
    public function setPool($Pool) {
        $this->Pool = $Pool;
    }
    
    public function getTags() {
        return $this->Tags;
    }
    
    public function setTags($Tags) {
        $this->Tags = $Tags;
    }
    
    public function getCourse() {
        return $this->Course;
    }
    
    public function setCourse($Course) {
        $this->Course = $Course;
    }
    
    public function getChapter() {
        return $this->Chapter;
    }
    
    public function setChapter($Chapter) {
        $this->Chapter = $Chapter;
    }
    
    public function getCategory() {
        return $this->Category;
    }
    
    public function setCategory($Category) {
        $this->Category = $Category;
    }
    
    public function getNumberOptions() {
        return $this->NumberOptions;
    }
    
    public function setNumberOptions($NumberOptions) {
        $this->NumberOptions = $NumberOptions;
    }
    
    public function getOptionUnique() {
        return $this->OptionUnique;
    }
    
    public function setOptionUnique($OptionUnique) {
        $this->OptionUnique = $OptionUnique;
    }
    
    public function getOptionTitle() {
        return $this->OptionTitle;
    }
    
    public function setOptionTitle($OptionTitle) {
        $this->OptionTitle = $OptionTitle;
    }
    
    public function getOptionPoints() {
        return $this->OptionPoints;
    }
    
    public function setOptionPoints($OptionPoints) {
        $this->OptionPoints = $OptionPoints;
    }
    
    public function getOptionFeedback() {
        return $this->OptionFeedback;
    }
    
    public function setOptionFeedback($OptionFeedback) {
        $this->OptionFeedback = $OptionFeedback;
    }
    
    public function getOptionRequired() {
        return $this->OptionRequired;
    }
    
    public function setOptionRequired($OptionRequired) {
        $this->OptionRequired = $OptionRequired;
    }
    
    public function getOptionExpression() {
        return $this->OptionExpression;
    }
    
    public function setOptionExpression($OptionExpression) {
        $this->OptionExpression = $OptionExpression;
    }
    
    public static function fetchTypes() {
        require 'connect.php';
        $types = [];
        $stmt = $conn->query("
            SELECT DISTINCT type
            FROM types
        ");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $types[] = $row['type'];
        }
        foreach ($types as $type) {
            echo "<option value='$type'>$type</option>";
        }
    }
    
    public static function fetchPools() {
        require 'connect.php';
        $pools = [];
        $stmt = $conn->query("SELECT name FROM pool");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pools[] = $row['name'];
        }
        foreach ($pools as $pool) {
            echo "<option value='$pool'>$pool</option>";
        }
    }
    
    public static function fetchTags() {
        require 'connect.php';
        $tags = [];
        $stmt = $conn->query("SELECT name FROM tags");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tags[] = $row['name'];
        }
        foreach ($tags as $tag) {
            echo "<input type='checkbox' id='$tag' name='tags[]' value='$tag'>";
            echo "<label for='$tag'>$tag</label><br>";
        }
    }
    
    public static function fetchCourses() {
        require 'connect.php';
        $courses = [];
        $stmt = $conn->query("SELECT name FROM courses");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $courses[] = $row['name'];
        }
        foreach ($courses as $course) {
            echo "<input type='checkbox' id='$course' name='courses[]' value='$course'>";
            echo "<label for='$course'>$course</label><br>";
        }
    }
    
    public static function fetchChapters() {
        require 'connect.php';
        $chapter = [];
        $stmt = $conn->query("SELECT name FROM chapters");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $chapter[] = $row['name'];
        }
        foreach ($chapter as $chapter) {
            echo "<input type='checkbox' id='$chapter' name='chapters[]' value='$chapter'>";
            echo "<label for='$chapter'>$chapter</label><br>";
        }
    }
    
    public static function fetchCategories() {
        require 'connect.php';
        $categories = [];
        $stmt = $conn->query("SELECT name FROM categories");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row['name'];
        }
        foreach ($categories as $category) {
            echo "<input type='checkbox' id='$category' name='categories[]' value='$category'>";
            echo "<label for='$category'>$category</label><br>";
        }
    }
    
    public function createVraag($type, $title, $points, $time, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr) {
        require 'connect.php';
        
        $stmt = $conn->prepare("SELECT COUNT(*) FROM vraag WHERE Title = ?");
        $stmt->execute([$title]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            $stmt = $conn->prepare("UPDATE vraag SET Type = ?, Points = ?, Time = ?, Image = ?, QuestionText = ?, Feedback = ?, Hint = ?, Pool = ?, Tags = ?, Course = ?, Chapter = ?, Category = ? WHERE Title = ?");
            $stmt->execute([$type, $points, $time, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr, $title]);
        } else {
            $stmt = $conn->prepare("INSERT INTO vraag (Type, Title, Points, Time, Image, QuestionText, Feedback, Hint, Pool, Tags, Course, Chapter, Category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$type, $title, $points, $time, $image, $questionText, $feedback, $hint, $pool, $tagsStr, $coursesStr, $chaptersStr, $categoriesStr]);
        }
    }
    
    public function insertOption($title, $NumberOptions, $OptionUnique) {
        require 'connect.php';
        
        $stmt = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
        $stmt->execute([$title]);
        $vraagID = $stmt->fetchColumn();
        
        $stmt = $conn->prepare("SELECT COUNT(*) FROM vraagmcms WHERE VraagID = ?");
        $stmt->execute([$vraagID]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            $stmt = $conn->prepare("UPDATE vraagmcms SET NumberOptions = ?, OptionUnique = ? WHERE VraagID = ?");
            $stmt->execute([$NumberOptions, $OptionUnique, $vraagID]);
        } else {
            $stmt = $conn->prepare("INSERT INTO vraagmcms (VraagID, NumberOptions, OptionUnique) VALUES (?, ?, ?)");
            $stmt->execute([$vraagID, $NumberOptions, $OptionUnique]);
        }
    }
    
    public function insertOptionIndividual($title, $optionTitle, $optionPoints, $optionFeedback, $optionRequired, $optionExpression) {
        require 'connect.php';
        
        try {
            $stmt = $conn->prepare("SELECT ID FROM vraag WHERE Title = ?");
            $stmt->execute([$title]);
            $vraagID = $stmt->fetchColumn();
            
            // Prepare and execute the SQL query
            $stmt = $conn->prepare("INSERT INTO optionmcms (vraagID, OptionTitle, OptionPoints, OptionFeedback, OptionRequired, OptionExpression) VALUES (:vraagID, :optionTitle, :optionPoints, :optionFeedback, :optionRequired, :optionExpression)");
            $stmt->execute(array(':vraagID' => $vraagID, ':optionTitle' => $optionTitle, ':optionPoints' => $optionPoints, ':optionFeedback' => $optionFeedback, ':optionRequired' => $optionRequired, ':optionExpression' => $optionExpression));
            
            echo "Data inserted successfully.";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
    
?>