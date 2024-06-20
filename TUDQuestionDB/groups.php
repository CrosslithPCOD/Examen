<?php
require 'header.php';
ob_start();
?>
<div style="text-align:center;">
    <h3>Add/Delete/Search Groups</h3>
    <form action="" method="post">
        <select id="function" name="function" required>
            <option value="create">Create</option>
            <option value="delete">Delete</option>
            <option value="show">Show</option>
        </select>
        <select id="group" name="group" required>
            <option value="pool">Pool</option>
            <option value="tags">Tags</option>
            <option value="courses">Courses</option>
            <option value="chapters">Chapters</option>
            <option value="categories">Categories</option>
            <option value="exams">Examen</option>
        </select>
        <input type="hidden" name="AddDelSearch" value="1"> 
        <input type="text" name="name" placeholder="name">
        <input type="submit" name="submit" value="Go">
    </form>
</div>

<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['AddDelSearch'])) {
    $function = $_POST['function'];
    $group = $_POST['group'];
    $name = $_POST['name'];
    
    //echo "<br>AddDelSearch<br>";
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";
    
    $vraag->allGroupChecker($function, $group, $name);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    $id = $_POST['id'];
    $group = $_POST['group'];
    $oldname = $_POST['oldname'];
    
    $vraag->deleteEntry($id, $group, $oldname);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";
    
    $id = $_POST['id'];
    $oldname = $_POST['oldname'];
    $name = $_POST['name'];
    $group = $_POST['group'];
    
    echo "<br><br> New Entries: " . $id . " and " . $oldname . " and " . $name . " and " . $group . "<br><br>";
    
    $vraag->updateEntry($id, $oldname, $name, $group);
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
echo "<br><br>";
$vraag->showAllGroups();

ob_end_flush();
require 'footer.php';
?>
