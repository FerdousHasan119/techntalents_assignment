<?php
session_start();
include '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = (int)$_POST['question_id'];

    // Delete answers related to the question
    $delete_answers_query = "DELETE FROM answers WHERE ques_id = $question_id";
    mysqli_query($con, $delete_answers_query);

    // Delete the question
    $delete_question_query = "DELETE FROM question WHERE id = $question_id";
    mysqli_query($con, $delete_question_query);

    $_SESSION['message'] = "Question deleted successfully.";
    header("Location: view_question.php");
    exit();
}
?>
