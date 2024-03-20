<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page des Joueurs</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Questionnaire</h2>
        <div id="questionContainer"></div>
        <button id="nextButton" style="display: none;">Suivant</button>
        <div id="score" style="display: none;"></div>
    </div>

    <script>
        $(document).ready(function() {
            var questions = []; 
            var currentQuestionIndex = 0; 
            var score = 0; 
            $.ajax({
                url: 'getquestions.php',
                method: 'GET',
                success: function(response) {
                    questions = response; 
                    displayQuestion(currentQuestionIndex);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching questions:', error);
                }
            });
            $('#nextButton').click(function() {
                var selectedOptions = $('input[name="option"]:checked').map(function() {
                    return $(this).val();
                }).get();
                var correctAnswer = questions[currentQuestionIndex].reponse_correcte;
                if (selectedOptions.includes(correctAnswer)) {
                    score++;
                }
                currentQuestionIndex++;
                if (currentQuestionIndex < questions.length) {
                    displayQuestion(currentQuestionIndex);
                } else {
                    $('#questionContainer').hide();
                    $('#nextButton').hide();
                    $('#score').text('Votre score est de : ' + score + ' / ' + questions.length).show();
                }
            });
        });

        function displayQuestion(index) {
            var question = questions[index];
            $('#questionContainer').html('<h3>Question ' + (index + 1) + '</h3>' +
                '<p>' + question.question + '</p>' +
                '<form id="questionForm">' +
                '<input type="checkbox" name="option" value="1"> ' + question.option1 + '<br>' +
                '<input type="checkbox" name="option" value="2"> ' + question.option2 + '<br>' +
                '<input type="checkbox" name="option" value="3"> ' + question.option3 + '<br>' +
                '</form>').show();
            $('#nextButton').show();
        }
    </script>
</body>
</html>
