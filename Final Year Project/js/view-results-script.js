//containers and button used within results page
const studentContainer = document.getElementById('student-records');
const visualisationContainer = document.getElementById('visualisation');
const messageContainer = document.getElementById('message');
const resultContainer = document.getElementById('results-text');
const studentbtn = document.getElementById('students');
const visualisationbtn = document.getElementById('results');

const quizQuestionContainers = document.getElementsByClassName('quiz-information');
const questionTitle = document.getElementsByClassName('question-title');
const questionChoices = document.getElementsByClassName('question-choices');
const questionType = document.getElementsByClassName('question-type');
const questionCorrectAnswer = document.getElementsByClassName('question-correct');
const studentName = document.getElementById('student-name');
const studentAttempts = document.getElementById('attempts');
const studentTime = document.getElementById('average-time-taken');
const studentScore = document.getElementById('percentage-correct');
const dataContainer = document.getElementsByClassName('data-container');
const questionTime = document.getElementsByClassName('data-time-taken');

//variables used for chart creation
const piechartContainer = document.getElementById('pie-chart-container');
const barchartContainer = document.getElementById('bar-chart-container');
const piechartGood = document.getElementById('piechart-good');
const piechartBad = document.getElementById('piechart-bad');
const barchart = document.getElementById('barchart');
const chartMessage = document.getElementById('chart-message');

let dataLoaded = false;
let newStudent = false;
let positivePieChart, negativePieChart, timeBarChart;

//event listeners for when buttons are clicked
studentbtn.addEventListener('click',displayStudent);
visualisationbtn.addEventListener('click',displayVisualisation);
window.addEventListener('resize', windowSizeCheck);

//chart looks unappealing on small screens, this checks to see if the screen is too small, if so a warning messageis revealed
function windowSizeCheck() {
    let w = window.innerWidth;
    if(w < 700){
        piechartContainer.classList.add('hide');
        barchartContainer.classList.add('hide');
        chartMessage.classList.remove('hide');
    } else {
        piechartContainer.classList.remove('hide');
        barchartContainer.classList.remove('hide');
        chartMessage.classList.add('hide');
    }
}

//When student tab clicked, this function sets the tab as active
function displayStudent () {
    messageContainer.classList.add('hide');
    visualisationContainer.classList.add('hide');
    visualisationbtn.classList.add('tab-unselected');
    visualisationbtn.classList.remove('tab-selected');
    studentContainer.classList.remove('hide');
    studentbtn.classList.remove('tab-unselected');
    studentbtn.classList.add('tab-selected');
}

//When results tab clicked, this function sets the tab as active
function displayVisualisation () {
    studentContainer.classList.add('hide');
    studentbtn.classList.add('tab-unselected');
    studentbtn.classList.remove('tab-selected');
    if(dataLoaded){
        visualisationContainer.classList.remove('hide');
    } else {
        messageContainer.classList.remove('hide');
    }
    visualisationbtn.classList.remove('tab-unselected');
    visualisationbtn.classList.add('tab-selected');
}

//takes metrics from database and turns them into visual information
function visualisation(username, typeOfData) {
    $.ajax({ //post request to get data from database
        type: 'POST',
        url: 'inc/view-results.inc.php',
        data: {username: username, typeOfData: typeOfData, submit : 'submit'},
        beforeSend: function(){ //before requesting data, the visualisation page is shown
            dataLoaded = false;
            windowSizeCheck();
            displayVisualisation();
        },
        success: function(data) { //once data is recieved
            visualisationContainer.classList.add('hide');
            messageContainer.classList.remove('hide');
            if(!isJsonString(data)){ //checks to see if the data gotten is json string or not, if not then an error message is shown
               messageContainer.innerHTML = data;
            } else { //otherwise the data is handled and converted to information
                dataLoaded = true;
                visualisationContainer.classList.remove('hide');
                messageContainer.classList.add('hide');
                storedData = JSON.parse(data);
                studentName.innerHTML = username; //student name is shown
                studentAttempts.innerHTML = storedData[(storedData.length - 2)] + '<br> attempt(s)'; //students attempts shown
                let minutes = Math.floor(storedData[(storedData.length - 1)] / 60);
                let seconds = storedData[(storedData.length - 1)] - minutes * 60;
                let value = '';
                if(minutes < 10) {
                    value += '0';
                }
                value += minutes +':';
                if(seconds < 10) {
                    value += '0';
                }
                value += seconds;
                studentTime.innerHTML = value  + '<br> to complete'; //time is converted to minuets and seconds before being shown
                let percentage = 0;
                for(let i = 0; i < (storedData.length - 2); i++){
                    if(storedData[i].correct == 1){
                       percentage++;
                    }
                }
                studentScore.innerHTML = percentage + '/10 <br> correct'; //student results out of 10 is calculated and shown
                for(let i = 0; i < (storedData.length - 2); i++){ //loop through all questions in the database (since last two items in array are time and attempts)
                    quizQuestionContainers[i].classList.remove('correct-container');
                    quizQuestionContainers[i].classList.remove('incorrect-container');
                    if(storedData[i].correct == 1){ //if question was correct, the green container is used
                        quizQuestionContainers[i].classList.add('correct-container');
                    } else { //if question was incorrect, the red container is used
                        quizQuestionContainers[i].classList.add('incorrect-container');
                    }
                    questionTitle[i].innerHTML = (i+1)+') ' + storedData[i].title; //title of question is shown
                    let choices = storedData[i].choices.split(','); //each question choices are shown
                    questionChoices[i].getElementsByClassName('quiz-choice')[0].innerHTML = '<i class="fas fa-square questions-choice1"></i> ' + choices[0];
                    questionChoices[i].getElementsByClassName('quiz-choice')[1].innerHTML = '<i class="fas fa-square questions-choice2"></i> ' + choices[1];
                    questionChoices[i].getElementsByClassName('quiz-choice')[2].innerHTML = '<i class="fas fa-square questions-choice3"></i> ' + choices[2];
                    questionChoices[i].getElementsByClassName('quiz-choice')[3].innerHTML = '<i class="fas fa-square questions-choice4"></i> ' + choices[3];
                    questionType[i].innerHTML = 'Question Type: ' + storedData[i].type; //question type is shown
                    questionCorrectAnswer[i].innerHTML = 'Correct Answer: ' + storedData[i].answer; //the correct answer is shown
                    let picked = storedData[i].picked.split(',');
                    let choicesLabel = ['First Choice:','Second Choice:','Third Choice:'];
                    let pickedCount = 0;
                    for(let j = 0; j < picked.length; j++){ //each choices picked for the question is shown
                        dataContainer[i].getElementsByClassName('picked')[j].innerHTML = choicesLabel[j] + ' ' + picked[j];
                        pickedCount = j + 1;
                    }
                    for(let j = pickedCount; j < 3; j++){ //if not all three choices picked needed, refresh the unused slots
                        dataContainer[i].getElementsByClassName('picked')[j].innerHTML = '';
                    }
                    minutes = Math.floor(storedData[i].time / 60);
                    seconds = storedData[i].time - minutes * 60;
                    value = 'Time Taken: ';
                    if(minutes < 10) {
                        value += '0';
                    }
                    value += minutes +':';
                    if(seconds < 10) {
                        value += '0';
                    }
                    value += seconds;
                    questionTime[i].innerHTML = value; //time is converted to minuets and seconds before being shown
                }
                piechartContainer.classList.add('pie-graph-container'); 
                //preparing pie chart to show question type of all questions answered correct
                let labels = ['Spelling', 'Punctuation', 'Grammar', 'Understanding'];
                let values = [0,0,0,0]; //will be used to store values to use for the chart
                let colourHex  = ['#02BCF580','#FA3CF780','#FAC02F80','#00E9B780']; //will be used for the colours of each slice in the pie chart
                for(let i = 0; i < (storedData.length - 2); i++){ //loop through all the questions
                    if(storedData[i].correct == 1){ //if the student got the question correct
                        for(let j =0; j < labels.length; j++){ //determine what question type it was and increment the count by 1
                            if(storedData[i].type == labels[j]){
                                values[j] += 1;
                            }
                        }
                    }
                }
                if(newStudent) { //if a pie chart was created before, destory it before making a new one
                   positivePieChart.destroy();
                }
                //creating the pie chart
                let goodPieChart = piechartGood.getContext('2d');
                positivePieChart = new Chart(goodPieChart, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Question Types',
                            backgroundColor: colourHex,
                            borderWidth: 5,
                            data: values
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Percentage difference of the question type that were answered correctly',
                            fontSize: 25,
                            fontColor: '#000',
                            padding: 15
                        }
                    }
                });
                //preparing pie chart to show question type of all questions answered incorrect
                values = [0,0,0,0]; //will be used to store values to use for the chart
                for(let i = 0; i < (storedData.length - 2); i++){ //loop through all the questions
                    if(storedData[i].correct == 0){ //if the student got the question incorrect
                        for(let j =0; j < labels.length; j++){ //determine what question type it was and increment the count by 1
                            if(storedData[i].type == labels[j]){
                                values[j] += 1;
                            }
                        }
                    }
                }
                if(newStudent) { //if a pie chart was created before, destory it before making a new one
                   negativePieChart.destroy();
                }
                //creating the pie chart
                let badPieChart = piechartBad.getContext('2d');
                negativePieChart = new Chart(piechartBad, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Question Types',
                            backgroundColor: colourHex,
                            borderWidth: 5,
                            data: values
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Percentage difference of the question type that were answered incorrectly',
                            fontSize: 25,
                            fontColor: '#000',
                            padding: 15
                        }
                    }
                });
                barchartContainer.classList.add('bar-graph-container');
                //preparing bar chart to show average time taken for each question type
                values = [0,0,0,0]; //will be used to store values to use for the chart
                let valuesCount = [0,0,0,0]; //will be used to store values to use for the chart
                for(let i = 0; i < (storedData.length - 2); i++){ //loop through all the questions
                    for(let j =0; j < labels.length; j++){ //loop through all question types
                        if(storedData[i].type == labels[j]){ //if the question type is the current type being checked
                            values[j] += storedData[i].time; //incriment the time taken
                            valuesCount[j] += 1; //that question type count is incrimented by 1
                        }
                    }
                }
                for(let i = 0; i < values.length; i++){ //loop through all the times divided by their count to get average time
                    values[i] = Math.floor(values[i] / valuesCount[i]);
                }
                if(newStudent) { //if a bar chart was created before, destory it before making a new one
                   timeBarChart.destroy();
                }
                //creating the bar chart
                let barChartVis = barchart.getContext('2d');
                timeBarChart = new Chart(barChartVis, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Average time in seconds',
                            backgroundColor: colourHex,
                            data: values
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Bar chart showing average time taken for each question type',
                            fontSize: 25,
                            fontColor: '#000',
                            padding: 15
                        },
                        layout: {
                            padding: 50
                        }
                    }
                });
                newStudent = true; //once these charts have been made once, set to true so subsquent charts get destoryed before new charts are made
            }
        },
        error: function(errorMessage) { //if an error occured
            messageContainer.innerHTML = errorMessage; //let the user know
        }
    });
}

function isJsonString(str) { //checks if given string is in a json format
    try {
        let data = JSON.parse(str); //if this fails
    } catch (e) {
        return false; //it isn't
    }
    return true; //otherwise it is
}