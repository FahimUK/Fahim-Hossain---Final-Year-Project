//containers and button used within results page
const classAttempts = document.getElementById('class-attempts');
const classTime = document.getElementById('class-average-time-taken');
const classMessageContainer = document.getElementById('class-message');
const classVisualisationContainer = document.getElementById('class-visualisation');

//variables used for chart creation
const classPiechartContainer = document.getElementById('class-pie-chart-container');
const classBarchartContainer = document.getElementById('class-bar-chart-container');
const classPiechartGood = document.getElementById('class-piechart-good');
const classPiechartBad = document.getElementById('class-piechart-bad');
const classBarchart = document.getElementById('class-barchart');
const classChartMessage = document.getElementById('class-chart-message');

//event listeners for when buttons are clicked
window.addEventListener('resize', windowSizeCheck);
window.addEventListener('load', visualisation);

//chart looks unappealing on small screens, this checks to see if the screen is too small, if so a warning messageis revealed
function windowSizeCheck() {
    let w = window.innerWidth;
    if(w < 700){
        classPiechartContainer.classList.add('hide');
        classBarchartContainer.classList.add('hide');
        classChartMessage.classList.remove('hide');
    } else {
        classPiechartContainer.classList.remove('hide');
        classBarchartContainer.classList.remove('hide');
        classChartMessage.classList.add('hide');
    }
}

//takes metrics from database and turns them into visual information
function visualisation() {
    $.ajax({ //post request to get data from database
        type: 'POST',
        url: 'inc/view-results.inc.php',
        data: {username: '', typeOfData: 'class', submit : 'submit'},
        beforeSend: function(){ //before requesting data, the visualisation page prepared
            windowSizeCheck();
        },
        success: function(data) { //once data is recieved
            classMessageContainer.classList.remove('hide');
            if(!isJsonString(data)){ //checks to see if the data gotten is json string or not, if not then an error message is shown
                classMessageContainer.innerHTML = data;
            } else { //otherwise the data is handled and converted to information
                classVisualisationContainer.classList.remove('hide');
                storedData = JSON.parse(data);
                classMessageContainer.classList.add('hide');
                classAttempts.innerHTML = storedData[(storedData.length - 2)] + '<br> total attempt(s)'; //students attempts shown
                let averageTime = Math.floor(storedData[(storedData.length - 1)] / storedData[(storedData.length - 3)]);
                let minutes = Math.floor(averageTime / 60);
                let seconds = averageTime - minutes * 60;
                let value = '';
                if(minutes < 10) {
                    value += '0';
                }
                value += minutes +':';
                if(seconds < 10) {
                    value += '0';
                }
                value += seconds;
                classTime.innerHTML = value  + '<br> on average to complete'; //time is converted to minuets and seconds before being shown
                //preparing pie chart to show question type of all questions answered correct
                classPiechartContainer.classList.add('pie-graph-container');
                let labels = ['Spelling', 'Punctuation', 'Grammar', 'Understanding'];
                let values = [0,0,0,0]; //will be used to store values to use for the chart
                let colourHex  = ['#02BCF580','#FA3CF780','#FAC02F80','#00E9B780']; //will be used for the colours of each slice in the pie chart
                for(let i = 0; i < (storedData.length - 3); i++){ //loop through all the questions (since last three items in array are time, attempts and count)
                    if(storedData[i].correct == 1){ //if the student got the question correct
                        for(let j =0; j < labels.length; j++){ //determine what question type it was and increment the count by 1
                            if(storedData[i].type == labels[j]){
                                values[j] += 1;
                            }
                        }
                    }
                }
                //creating the pie chart
                let goodPieChart = classPiechartGood.getContext('2d');
                new Chart(goodPieChart, {
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
                for(let i = 0; i < (storedData.length - 3); i++){//loop through all the questions
                    if(storedData[i].correct == 0){ //if the student got the question incorrect
                        for(let j =0; j < labels.length; j++){ //determine what question type it was and increment the count by 1
                            if(storedData[i].type == labels[j]){
                                values[j] += 1;
                            }
                        }
                    }
                }
                //creating the pie chart
                let badPieChart = classPiechartBad.getContext('2d');
                new Chart(badPieChart, {
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
                //preparing bar chart to show average time taken for each question type
                classBarchartContainer.classList.add('bar-graph-container');
                let barChartVis = classBarchart.getContext('2d');
                values = [0,0,0,0]; //will be used to store values to use for the chart
                let valuesCount = [0,0,0,0]; //will be used to store values to use for the chart
                for(let i = 0; i < (storedData.length - 3); i++){ //loop through all the questions
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
                //creating the bar chart
                new Chart(barChartVis, {
                    type: 'bar',
                    data: {
                        xAxisID: 'HELLO',
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