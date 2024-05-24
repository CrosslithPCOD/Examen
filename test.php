<form method="post" action="process_form.php" onsubmit="return validateForm();">
  <input type="submit" value="Submit"><br><br>
  
  <!-- Example of dynamic input fields -->
  <?php
  // Define the number of input fields you want
  $numFields = 9;
  
  // Loop to create input fields
  for ($i = 1; $i <= $numFields; $i++) {
      echo '<label for="fname' . $i . '">First name ' . $i . ':</label><br>';
      echo '<input type="text" id="water' . $i . '" name="water[]" ><br>';
      echo '<label for="lname' . $i . '">Last name ' . $i . ':</label><br>';
      echo '<input type="text" id="vuur' . $i . '" name="vuur[]"><br><br>';
  }
  ?>
</form>
