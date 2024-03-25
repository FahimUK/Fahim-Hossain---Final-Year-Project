//upon page load, initialse important variables
window.addEventListener('load', init);

//question that will be used within the quiz (researched exisiting KS1 exams to get the same style and content)
const quiz = [
    {
        visualQuestion: 'B _ N _ N _', //question shown on screen
        audableQuestion: 'What letter fits to complete the word, Banana', //question spoken to the user
        options: [ //option they can pick
            {choice: 'A', correct: true}, //this is the correct answer
            {choice: 'N', correct: false},
            {choice: 'B', correct: false},
            {choice: 'Y', correct: false}
        ],
        type: 'Spelling' //this is the type of question this is
    },
    {
        visualQuestion: 'A _ _ L E',
        audableQuestion: 'What letter fits to complete the word, Apple',
        options: [
            {choice: 'P', correct: true},
            {choice: 'N', correct: false},
            {choice: 'B', correct: false},
            {choice: 'Y', correct: false}
        ],
        type: 'Spelling'
    },
    {
        visualQuestion: 'I love my older _____',
        audableQuestion: 'Choose the correct spelling, I love my older brother',
        options: [
            {choice: 'Brother', correct: true},
            {choice: 'Brudduh', correct: false},
            {choice: 'Bruvver', correct: false},
            {choice: 'Brovor', correct: false}
        ],
        type: 'Spelling'
    },
    {
        visualQuestion: 'Remember to _____ off the light',
        audableQuestion: 'Choose the correct spelling, Remember to switch off the light',
        options: [
            {choice: 'Switch', correct: true},
            {choice: 'Sweetch', correct: false},
            {choice: 'Swich', correct: false},
            {choice: 'Switche', correct: false}
        ],
        type: 'Spelling'
    },
    {
        visualQuestion: 'In maths, we learnt what a _____ is',
        audableQuestion: 'Choose the correct spelling, In maths, we learnt what a fraction is',
        options: [
            {choice: 'Fraction', correct: true},
            {choice: 'Fraktion', correct: false},
            {choice: 'Fuhracksion', correct: false},
            {choice: 'Frahction', correct: false}
        ],
        type: 'Spelling'
    },
    {
        visualQuestion: 'Why did Jasmine paint the top of the shed?',
        audableQuestion: 'Jasmine and her younger brother wanted to paint the shed. As Jasmine fetched the ladder she said "These steps are a bit wobbly, I\'ll do the roof". She placed the ladder down and began painting the roof purple, her favourite colour.',
        options: [
            {choice: 'The steps were dangerous', correct: true},
            {choice: 'She was the tallest', correct: false},
            {choice: 'She was the oldest', correct: false},
            {choice: 'The shed roof was her favourite colour', correct: false}
        ],
        type: 'Understanding'
    },
    {
        visualQuestion: 'Why was Jamila tired when she got to school?',
        audableQuestion: 'Jamila was on her way to school but missed her bus! Oh no, now she has to walk all the way there, what a pitty. When she arrived at school she was all tired out!',
        options: [
            {choice: 'She missed her bus and had to walk', correct: true},
            {choice: 'She decided to run to school', correct: false},
            {choice: 'Her school was very far away', correct: false},
            {choice: 'School is so boring', correct: false}
        ],
        type: 'Understanding'
    },
    {
        visualQuestion: 'How long have ducks been living as pets for?',
        audableQuestion: 'Ducks are friendly creatures and have been living as pets and farm animals for more than 500 years! Ducks can live between 5 to 10 years in the wild and 8+ years in captivity.',
        options: [
            {choice: '500 years', correct: true},
            {choice: '5 years', correct: false},
            {choice: '10 years', correct: false},
            {choice: '8 years', correct: false}
        ],
        type: 'Understanding'
    },
    {
        visualQuestion: 'How do Kangaroos move?',
        audableQuestion: 'Kangaroos use their small but powerful legs to hop around everywhere and use their strong tails for balance.',
        options: [
            {choice: 'Use their legs to jump', correct: true},
            {choice: 'Use their tails to jump', correct: false},
            {choice: 'They can\'t their legs are too small', correct: false},
            {choice: 'They walk just like us', correct: false}
        ],
        type: 'Understanding'
    },
    {
        visualQuestion: 'Why did Micheal drop his tray?',
        audableQuestion: 'Micheal got his lunch from the dinner line and was trying to decide on which table to eat at. He made his way to the table but he didn\'t see the wet floor sign and slipped dropping his tray and all his food on the ground',
        options: [
            {choice: 'The floor was wet', correct: true},
            {choice: 'The food was too hot', correct: false},
            {choice: 'He tripped on a sign', correct: false},
            {choice: 'He didn\'t like the food', correct: false}
        ],
        type: 'Understanding'
    },
    {
        visualQuestion: 'the boys raced to the park.',
        audableQuestion: 'What is needed in this sentence, the boys raced to the park',
        options: [
            {choice: 'a capital letter', correct: true},
            {choice: 'a question mark', correct: false},
            {choice: 'a comma', correct: false},
            {choice: 'an apostrophe', correct: false}
        ],
        type: 'Punctuation'
    },
    {
        visualQuestion: 'Are we there yet',
        audableQuestion: 'What is needed in this sentence, Are we there yet',
        options: [
            {choice: 'a question mark', correct: true},
            {choice: 'a capital letter', correct: false},
            {choice: 'a comma', correct: false},
            {choice: 'an apostrophe', correct: false}
        ],
        type: 'Punctuation'
    },
    {
        visualQuestion: 'my friend _____ just loves to dance',
        audableQuestion: 'Where does the capital letter go? my friend James just loves to dance',
        options: [
            {choice: 'James', correct: true},
            {choice: 'JAMES', correct: false},
            {choice: 'jaMes', correct: false},
            {choice: 'jAmes', correct: false}
        ],
        type: 'Punctuation'
    },
    {
        visualQuestion: 'Which sentence is a question?',
        audableQuestion: 'Which sentence below is a question?',
        options: [
            {choice: 'Where is my puzzle', correct: true},
            {choice: 'This puzzle is hard', correct: false},
            {choice: 'I hate puzzles', correct: false},
            {choice: 'That puzzle is mine', correct: false}
        ],
        type: 'Punctuation'
    },
    {
        visualQuestion: 'Simon\'s cat is so cute',
        audableQuestion: 'Choose the correct punctuation, Simon\'s cat is so cute!',
        options: [
            {choice: '!', correct: true},
            {choice: '?', correct: false},
            {choice: ',', correct: false},
            {choice: '*', correct: false}
        ],
        type: 'Punctuation'
    },
    {
        visualQuestion: 'We will make it on time _____ we leave right now',
        audableQuestion: 'Choose the correct word to complete the sentence',
        options: [
            {choice: 'if', correct: true},
            {choice: 'when', correct: false},
            {choice: 'where', correct: false},
            {choice: 'so', correct: false}
        ],
        type: 'Grammar'
    },
    {
        visualQuestion: 'Jason\'s clothes were _____ after football practice',
        audableQuestion: 'Choose the correct word to complete the sentence',
        options: [
            {choice: 'Dirty', correct: true},
            {choice: 'Dirted', correct: false},
            {choice: 'Dirt', correct: false},
            {choice: 'Dirtly', correct: false}
        ],
        type: 'Grammar'
    },
    {
        visualQuestion: 'Zahir \'run\' to his house because it was raining',
        audableQuestion: 'Choose the correct word to change \'run\' to past tense',
        options: [
            {choice: 'Ran', correct: true},
            {choice: 'Runned', correct: false},
            {choice: 'Running', correct: false},
            {choice: 'Runner', correct: false}
        ],
        type: 'Grammar'
    },
    {
        visualQuestion: 'My friend, Mayesha, is a cool girl',
        audableQuestion: 'Which word from this sentence is the adjective, My friend, Mayesha, is a cool girl',
        options: [
            {choice: 'cool', correct: true},
            {choice: 'Mayesha', correct: false},
            {choice: 'friend', correct: false},
            {choice: 'girl', correct: false}
        ],
        type: 'Grammar'
    },
    {
        visualQuestion: 'Milo lightly tapped me on the shoulder',
        audableQuestion: 'What type of word is \'lightly\' in the sentence Milo lightly tapped me on the shoulder',
        options: [
            {choice: 'Adverb', correct: true},
            {choice: 'Adjective', correct: false},
            {choice: 'Noun', correct: false},
            {choice: 'Verb', correct: false}
        ],
        type: 'Grammar'
    }
];

let questions = []; //store results that would be sent to database
let maxNumQuestions = 10; //only show 10 questions to the student
let maxAttempts = 3; //at max, each student is given 3 goes per question
let overallTimeTaken = 0; //store overal time taken to complete the quiz, in seconds
let numQuestionCorrect = 0; //store how many questions the student got correct
let currentAttempts; //used to determine how many attempts the student is currently on
let startTime, endTime, overallStartTime, overallEndTime, activityid; //more statistics to store in database

//setting the question array up so that it's ready to take in metrics
for(let i = 0; i < maxNumQuestions; i++){
    let input = {
        correct: undefined, //if student got the question wrong
        attempts: undefined, //how many attempts at the question they took
        timeTaken: undefined, //how long they took on this question
        questionType: undefined, //what the question's type is
        questionTitle: undefined, //question's title
        correctChoice: undefined, //correct answer
        choicesList: [], //all options given to the student
        choicesPicked: [] //what choices they picked
        }
    questions.push(input);
}

let currentQuestion, shuffledQuestions; //used to determine which questions get shown to the student
let speech = new SpeechSynthesisUtterance(); //initiallising Speech Synthesis

//containers and button used within quiz page
const startContainer = document.getElementById('title-page');
const resultsContainer = document.getElementById('results-container');
const startBtn = document.getElementById('title-btn');
const quizContainer = document.getElementById('activity');
const questionContainer = document.getElementById('question');
const choicesContainer = document.getElementById('choices');
const endContainer = document.getElementById('end-page');
const bearIcon = document.getElementById('bear-icon-activity');
const bearIconTrans = document.getElementById('bear-icon-transition');
const synth = window.speechSynthesis;
const homeBtn = document.getElementById('home-btn');
const endBtn = document.getElementById('endBtn');
const muteBtn = document.getElementById('mute-btn');
const muteBtnIcon = document.getElementById('mute-btn-icon');
const transitionContainer = document.getElementById('transition');
const repeatBtn = document.getElementById('repeat-btn');
const nextBtn = document.getElementById('nextBtn');
const activatePage = document.getElementById('start-page');
const transMessage = document.getElementById('transition-message');
const endMessage = document.getElementById('end-message');

//sound files
const titleScreenSound = new Audio("./audio/titlescreen.mp3");
const quizScreenSound = new Audio("./audio/quiz.mp3");
const transitionScreenSoundGood = new Audio("./audio/transition-correct.mp3");
const transitionScreenSoundBad = new Audio("./audio/transition-wrong.mp3");
const sucessSound = new Audio("./audio/success.wav");
const failSound = new Audio("./audio/fail.wav");
const endScreenGood = new Audio("./audio/endscreen-welldone.mp3");
const endScreenBad = new Audio("./audio/endscreen-tryagain.mp3");

let voices = synth.getVoices();
let mute = false; //used to mute application, by default sound is playing
window.addEventListener("beforeunload", synth.cancel()); //if the user leaves the page and sound is playing, cancel it so the sound doesn't bleed over

//takes in a string and speaks it as long as the sound isn't muted
function textToSpeech(e) {
    if('speechSynthesis' in window && !mute){   
        synth.cancel();
        speech.text = e;
        synth.speak(speech);
    }
}

//loading voices, it is asyncronous so the function is called over and over until voice that is needed is loaded
function loadVoices() {
    voices = synth.getVoices();
    if (voices.length !== 0) {
        if(voices[5] !== undefined) { //this is the choosen voice for the application
           speech.voice = voices[5];
        } else {
            speech.voice = voices[0]; //non chrome browser sometimes don't support it so chose a voice they do support
        }
    } else {
        loadVoices();
    }
}

//when page is first loaded, load the voices and set their critera up
//set the music critera up as well and set all the music to loop
function init () {
    if('speechSynthesis' in window){
        loadVoices();
    }
    speech.rate = 0.9;
    speech.pitch = 1;
    endScreenGood.volume = 0.2;
    endScreenBad.volume = 0.2;
    titleScreenSound.volume = 0.4;
    quizScreenSound.volume = 0.2;
    transitionScreenSoundGood.volume = 0.2;
    transitionScreenSoundBad.volume = 0.2;
    titleScreenSound.loop = true;
    quizScreenSound.loop = true;
    transitionScreenSoundGood.loop = true;
    transitionScreenSoundBad.loop = true;
    endScreenBad.loop = true;
    endScreenGood.loop = true;
}

//title screen for the application
function titleScreen (e) {
    activityid = e; //grap the id for this activity, will be used to store into database
    if(!mute){ //if not muted
        titleScreenSound.currentTime = 0; //start music from the beginning
        titleScreenSound.play(); //play the music
    }
    transitionScreenSoundGood.pause(); //pause any exisitng music that shouldn't play on this page
    transitionScreenSoundBad.pause(); //pause any exisitng music that shouldn't play on this page
    quizScreenSound.pause(); //pause any exisitng music that shouldn't play on this page
    endScreenBad.pause(); //pause any exisitng music that shouldn't play on this page
    endScreenGood.pause(); //pause any exisitng music that shouldn't play on this page
    startContainer.classList.remove('hide'); //show the start container
    activatePage.classList.add('hide'); //hide all others
    quizContainer.classList.add('hide'); //hide all others
    endContainer.classList.add('hide'); //hide all others
    currentAttempts = 0; //attempts start at 0
    startBtn.addEventListener('click',startQuiz); //when user clicks the start button, get ready to start the quiz
}

//starting the quiz
function startQuiz () {
    startContainer.classList.add('hide'); //hide containers not needed
    endContainer.classList.add('hide'); //hide containers not needed
    quizContainer.classList.remove('hide'); //show the quiz container
    shuffledQuestions = quiz.sort(function(){return 0.5 - Math.random()}); //psudo randomly shuffle the questions in the quiz array
    currentQuestion = 0; //questions start from index 0
    overallStartTime = new Date(); //start recording overal time from now
    displayQuiz(shuffledQuestions[currentQuestion]); //show the first question to the student
}

function displayQuiz (e) {
    questions[currentQuestion].questionTitle = shuffledQuestions[currentQuestion].visualQuestion; //record the questions title for storage
    questions[currentQuestion].questionType = shuffledQuestions[currentQuestion].type; //record the questions type for storage
    startTime = new Date(); //start recording the student's time on this paricular question
    titleScreenSound.pause(); //pause the music not needed on this screen
    transitionScreenSoundGood.pause(); //pause the music not needed on this screen
    transitionScreenSoundBad.pause(); //pause the music not needed on this screen
    if(!mute){ //if not muted
        quizScreenSound.currentTime = 0; //start music from the beginning
        quizScreenSound.play(); //play the music
    }
    repeatBtn.addEventListener('click',repeat); //if the repeat button is clicked, repeat the question for the user
    muteBtn.addEventListener('click',toggleMute); //if the mute button is clicked, toggle sound between on and off
    homeBtn.addEventListener('click', function(){location.reload()}); //if the home button is clicked, refresh page
    while (choicesContainer.firstChild) { //remove all existing choices to make room for this new question's one
        choicesContainer.removeChild(choicesContainer.firstChild);
    }
    questionContainer.innerText = e.visualQuestion; //display the visual question on screen
    repeat(); //speak the question to the user
    shuffledAnswers = e.options.sort(function(){return 0.5 - Math.random()}); //psudo randomly shuffle the choices
    let i = 1; //each choice class follows the naming convention of "choice" followed by a number, this keeps track of it
    shuffledAnswers.forEach(function(option) { //for every option this question has
        const button = document.createElement('button'); //create a button
        button.innerText = option.choice; //display a choice for that button
        questions[currentQuestion].choicesList.push(option.choice); //store the choice into the question array to store in database
        let btnClass = 'choice' + i; //add a button class to it (i gets incrimented so first buton gets choice1, second choice2 etc)
        button.classList.add(btnClass);
        if(option.correct){ //if this button is correct, add the correct dataset to it so the system knows
            button.dataset.correct = option.correct;
            questions[currentQuestion].correctChoice = option.choice; //store that this choice was the correct one in the question array to store in database later
        }
        button.addEventListener('click', selectAnswer); //if this button get's clicked, do some checks
        choicesContainer.appendChild(button)
        i++;
    })
}

//if an option get's selected
function selectAnswer (e) {
    currentAttempts++; //incriment attempt by one as student used an attempt up
    const selected = e.target;
    questions[currentQuestion].choicesPicked.push(selected.innerHTML); //store this choice as a choice the student clicked to be stored in the database later
    if(selected.dataset.correct){ //if this option was the correct answer
        if(!mute){ //if not muted
            sucessSound.currentTime = 0; //reset the success sound
            sucessSound.play(); //play the success soundbite
        }
        questions[currentQuestion].correct = 1; //store in the qustions array that the student got this question right
        questions[currentQuestion].attempts = currentAttempts; //store the amount of attempts the student took on this question
        endTime = new Date(); //end recording the time as the studnent completed the question
        questions[currentQuestion].timeTaken = Math.ceil((endTime - startTime) / 1000.0); //store time taken in seconds
        transitionScreen(); //move students to the tranision screen
    } else { //if this option was incorrect
        if(!mute){ //if not muted
            failSound.currentTime = 0; //reset the fail sound
            failSound.play(); //play it to the user
        }
        bearIcon.style.backgroundImage = "url(img/bear-sad.png)"; //turn the bear icon sad
        textToSpeech('Almost had it, Try again!'); //reassure the student they could try again
        setTimeout(resetBear, 1500); //resut the bear to happy after 1.5 seconds
        if(currentAttempts == maxAttempts) { //if user used all their allocated attempts
            questions[currentQuestion].correct = 0; //store that the user couldn't get the question right
            questions[currentQuestion].attempts = currentAttempts; //store how many attempts they too (here will always be 3 since that's the current max allowed)
            endTime = new Date(); //end recording the time as the question is complete
            questions[currentQuestion].timeTaken = Math.ceil((endTime - startTime) / 1000.0); //store time taken in seconds
            transitionScreen(); //move students to the tranision screen
        }
    }
}

//tranisition screen before questions
function transitionScreen() {
    currentAttempts = 0; //reset the user's available attempts
    quizScreenSound.pause(); //pause the music not needed on this screen
    if(!mute){ //if not muted
        if(questions[currentQuestion].correct == 1){ //if user got the question correct
            transitionScreenSoundGood.currentTime = 0; //reset the success music
            transitionScreenSoundGood.play(); //play the success music
        } else { //if user got the question wrong
            transitionScreenSoundBad.currentTime = 0; //reset the failure music
            transitionScreenSoundBad.play(); //play the failure music
        }
    }
    quizContainer.classList.add('hide'); //hide containers not needed
    transitionContainer.classList.remove('hide'); //show the transition screen
    resetBear(); //reset the bear to default state
    if(questions[currentQuestion].correct == 1) { //if user got the question correct
        bearIconTrans.style.backgroundImage = "url(img/bear-happy.png)"; //show he bear happy
        transMessage.innerHTML = 'Well Done!' //congratulate the student
        textToSpeech('Well Done, that was the correct answer'); //congratulate the student
    } else { //if user got the question wrong
        bearIconTrans.style.backgroundImage = "url(img/bear-sad.png)"; //show he bear sad
        transMessage.innerHTML = 'OOPS' //consolidate the student
        textToSpeech('OOPS, that wasn\'t right'); //consolidate the student
    }
    nextBtn.addEventListener('click',nextQuestion); //when user clicked next question button, move on
}

function nextQuestion () {
    currentQuestion++; //move to the next question
    if(currentQuestion >= maxNumQuestions){ //ensure the value isn't the end
        overallEndTime = new Date(); //if end, stop recording overal time
        end(); //end the quiz
    } else { //if more questions left
        transitionContainer.classList.add('hide'); //hide the transition screen
        quizContainer.classList.remove('hide'); //show quiz
        displayQuiz(shuffledQuestions[currentQuestion]); //display the next question
    }
}

function resetBear() {
    bearIcon.style.backgroundImage = "url(img/bear-happy.png)"; //resets the beat back to happy
}

//end of the quiz
function end () {
    overallTimeTaken = Math.ceil((overallEndTime - overallStartTime)/ 1000.0); //store time taken in 
    for(let i = 0; i < questions.length; i++){ //determine how many questions the student got corrct
        if(questions[i].correct){
           numQuestionCorrect++;
        }
    }
    transitionScreenSoundGood.pause(); //pause the music not needed on this screen
    transitionScreenSoundBad.pause(); //pause the music not needed on this screen
    endContainer.classList.remove('hide'); //show the end container screen
    transitionContainer.classList.add('hide'); //hide all others
    quizContainer.classList.add('hide'); //hide all others
    if(numQuestionCorrect >= 5){ //if user got above half right, they did well
        if(!mute){ //if not muted
            endScreenGood.currentTime = 0; //reset the success music
            endScreenGood.play(); //play the success music
        }
        endMessage.innerHTML = 'Well Done!'; //congratulate the student
        textToSpeech('Well Done! That was amazing!'); //congratulate the student
    } else {
        if(!mute){ //if not muted
            endScreenBad.currentTime = 0; //reset the failure music
            endScreenBad.play(); //play the failure music
        }
        endMessage.innerHTML = 'OOPS'; //consolidate the student
        textToSpeech('Good Attempt, maybe you should try it again?'); //consolidate the student
    }
    for(let i = 0; i < questions.length; i++) { //loop through all questions, showing a tick for those correct and a cross for those incorrect
        let currentIcon = resultsContainer.getElementsByClassName("result-icon")[i];
        if(questions[i].correct){
            currentIcon.innerHTML = '<i class="fas fa-check-circle result-good"></i>'   
        } else {
            currentIcon.innerHTML = '<i class="fas fa-times-circle result-bad"></i>'   
        }
    }
    //send data to a php file for storing
    $.ajax({ //post request to store data to database
        type: 'POST',
        url: 'inc/results-submit.inc.php',                      
        data: {data: questions, time : overallTimeTaken, activityid: activityid, submit : 'submit-results'},
        success: function(data) {
          alert(data); //upon success alert to the user the given success or error message
        }
    });
    endBtn.addEventListener('click', function(){location.reload()}); //when the end button is clicked, reload the page to refresh everything
}

//if mute button is clicked
function toggleMute() {
    mute = !mute; //toggle between on and off
    if(mute){ //if sound off
       quizScreenSound.pause(); //stop playing music
    } else { //if sound on
        quizScreenSound.play(); //play the music
    }
    //swap icons depending on function
    muteBtnIcon.classList.toggle("fa-volume-up");
    muteBtnIcon.classList.toggle("fa-volume-mute");
}

//if repeat question button is clicked
function repeat() {
    let question = shuffledQuestions[currentQuestion]; //find what the current question is
    textToSpeech(question.audableQuestion); //speak it's audio string
}