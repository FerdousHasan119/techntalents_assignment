<?php
session_start();
include '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = (int)$_POST['question_id'];

    // Fetch the question and its answers
    $query = "SELECT q.id AS question_id, q.ques, a.id AS answer_id, a.answer, a.correct 
              FROM question q 
              JOIN answers a ON q.id = a.ques_id 
              WHERE q.id = $question_id 
              ORDER BY a.id";
    $result = mysqli_query($con, $query);

    $question = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $question['question'] = $row['ques'];
        $question['answers'][] = [
            'answer_id' => $row['answer_id'],
            'answer_text' => $row['answer'],
            'is_correct' => $row['correct']
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<center>
<h2>Edit Question</h2>
<form action="update_question.php" method="POST">
    <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
    <label for="question">Question:</label><br>
    <textarea name="question" id="question" rows="3" cols="40" required><?php echo $question['question']; ?></textarea><br><br>
    <div id="answers">
        <?php foreach ($question['answers'] as $index => $answer): ?>
            <div>
                <input type="hidden" name="answer_ids[]" value="<?php echo $answer['answer_id']; ?>">
                <input type="text" name="answers[]" value="<?php echo $answer['answer_text']; ?>" required>
                <input type="radio" name="correct" value="<?php echo $index; ?>" <?php if ($answer['is_correct']) echo 'checked'; ?>> Correct
                <button type="button" class="add-answer">+</button>
            </div>
        <?php endforeach; ?>
    </div>
    <br>
    <button type="submit">Update</button>
</form>
</center>

<script>
        $(document).on('click', '.add-answer', function() {
            var answerCount = $('#answers div').length;
            $('#answers').append('<div><input type="text" name="answers[]" placeholder="Type your answer here" required> <input type="radio" name="correct" value="'+answerCount+'"> Correct <button type="button" class="add-answer">+</button></div>');
        });

    </script>
</body>
</html>
