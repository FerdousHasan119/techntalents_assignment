<!DOCTYPE html>
<html>
<head>
    <title>Insert Question</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<center>
<h2>Insert Question</h2>
    <form action="save_process.php" method="POST">
        <label for="question">Question:</label><br>
        <textarea name="question" id="question" placeholder="Please type your question here" rows="3" cols="40" required></textarea><br><br>

        <div id="answers">
            <div>
                <label for="answerlist">Answer list:</label><br>
                <input type="text" name="answers[]" placeholder="Type your answer here" required>
                <input type="radio" name="correct" value="0"> Correct
                <button type="button" class="add-answer">+</button>
                <button type="button" class="remove-answer">-</button>
            </div>
        </div>
        <br>

        <button type="submit">Save</button>
    </form>
</center>

    <script>
        $(document).on('click', '.add-answer', function() {
            var answerCount = $('#answers div').length;
            $('#answers').append('<div><input type="text" name="answers[]" placeholder="Type your answer here" required> <input type="radio" name="correct" value="'+answerCount+'"> Correct <button type="button" class="add-answer">+</button> <button type="button" class="remove-answer">-</button></div>');
        });

        $(document).on('click', '.remove-answer', function() {
            $(this).parent().remove();
        });
    </script>
</body>
</html>
