<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $answers = $_POST['answers'];
    $correct = (int)$_POST['correct'];

  
    $q2 = "INSERT INTO question (ques) VALUES ('$question')";
    $run = mysqli_query($con, $q2);
    
    if ($run) {
        $question_id = mysqli_insert_id($con); 
        
        // Insert each answer into the database
        foreach ($answers as $index => $answer) {
            $is_correct = ($index == $correct) ? 1 : 0;
            $answer = mysqli_real_escape_string($con, $answer);
            $q3 = "INSERT INTO answers (ques_id, answer, correct) VALUES ('$question_id', '$answer', '$is_correct')";
            mysqli_query($con, $q3);
        }

        $_SESSION['insert'] = "Successfully Added to the Database";
    } else {
        $_SESSION['insert'] = "Error: " . mysqli_error($con);
    }

    header("Location: view_question.php");
    exit();
}
?>
