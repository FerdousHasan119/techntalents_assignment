<?php
session_start();
include '_dbconnect.php';

// Fetch all questions and their answers
$query = "SELECT q.id AS question_id, q.ques, a.id AS answer_id, a.answer, a.correct 
          FROM question q 
          JOIN answers a ON q.id = a.ques_id 
          ORDER BY q.id, a.id";
$result = mysqli_query($con, $query);

$questions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $questions[$row['question_id']]['question'] = $row['ques'];
    $questions[$row['question_id']]['answers'][] = [
        'answer_id' => $row['answer_id'],
        'answer_text' => $row['answer'],
        'is_correct' => $row['correct']
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Questions</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .correct { color: green; font-weight: bold; }
        .actions { text-align: center; }
        .thumb-up { color: green; }
    </style>
</head>
<body>
<center>
<h2>Manage Questions</h2>
<form action="question.php">
    <button type="submit">Add new Question</button>
</form>
<?php if (isset($_SESSION['message'])): ?>
    <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
<?php endif; ?>
<br>
<table>
    <tr>
        <th>Question</th>
        <th>Answers</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($questions as $question_id => $data): ?>
        <tr>
            <td><?php echo $data['question']; ?></td>
            <td>
                <ul>
                    <?php foreach ($data['answers'] as $answer): ?>
                        <li>
                            <?php echo $answer['answer_text']; ?>
                            <?php if ($answer['is_correct']): ?>
                                <span class="thumb-up">&#128077;</span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td class="actions">
                <form action="edit_question.php" method="POST" style="display:inline;">
                    <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                    <button type="submit">Edit</button>
                </form>
                <form action="delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this question?');">
                    <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</center>
</body>
</html>
