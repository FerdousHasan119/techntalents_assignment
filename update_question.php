<?php
session_start();
include '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = (int)$_POST['question_id'];
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $answers = $_POST['answers'];
    $answer_ids = $_POST['answer_ids'];
    $correct = (int)$_POST['correct'];

    // Update the question
    $update_question_query = "UPDATE question SET ques = '$question' WHERE id = $question_id";
    mysqli_query($con, $update_question_query);

    // Update existing answers and insert new answers
    foreach ($answers as $index => $answer_text) {
        $answer_id = (int)$answer_ids[$index];
        $is_correct = ($index == $correct) ? 1 : 0;
        $answer_text = mysqli_real_escape_string($con, $answer_text);
        
        if ($answer_id > 0) {
            // Existing answer, update it
            $update_answer_query = "UPDATE answers SET answer = '$answer_text', correct = $is_correct WHERE id = $answer_id";
            mysqli_query($con, $update_answer_query);
        } else {
            // New answer, insert it
            $insert_answer_query = "INSERT INTO answers (ques_id, answer, correct) VALUES ($question_id, '$answer_text', $is_correct)";
            mysqli_query($con, $insert_answer_query);
        }
    }

    $_SESSION['message'] = "Question updated successfully.";
    header("Location: view_question.php");
    exit();
}
?>


