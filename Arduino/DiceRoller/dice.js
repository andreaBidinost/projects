var MAX_RANDOM_VALUE = 1000;

var MAX_DICE_SIDES = 20;

var gaussianProbabilities=[];




$(document).ready(function(){
  $(".diceButton").click(function(){selectDice(this)});
  
  $("#roll").click(rollDice);
  
  buildGaussianProbabilities();
});

function random(n1, n2){
    return Math.random()*(n2-n1+1) + n1;
}
 
function buildGaussianProbabilities() {
  value = 10;
  sum = value;
  for (i = 0; i < MAX_DICE_SIDES / 2; i++) {
    gaussianProbabilities[i] = sum;
    value += 10;
    sum += value;
  }
}

function uniformMap(n, maxMapValue) {
  return Math.ceil(n * maxMapValue / MAX_RANDOM_VALUE);
}


function gaussianMap(n, maxMapValue) {
  r = random(1, gaussianProbabilities[(maxMapValue / 2 - 1)]);
  
  numbers=[];
  centralNumber = maxMapValue/2;

  for (i = 0; i < maxMapValue / 2; i++) {
    numbers[maxMapValue - 1 - 2*i] = centralNumber - i;
    numbers[maxMapValue - 2 - 2*i] = centralNumber + i + 1;
  }
 
  for (i = 0; i < maxMapValue / 2; i++) {
    if (r < gaussianProbabilities[i]) {
      if (random(0, 100) > 50) {
        return numbers[2 * i];
      } else {
        return numbers[2 * i + 1];
      }
    }
  }
  
}


function gaussianInvMap( n,  maxMapValue) {
  r = random(1, gaussianProbabilities[(maxMapValue / 2 - 1)]);
  
  numbers=[];
  centralNumber = maxMapValue/2;

  for (i = 0; i < maxMapValue / 2; i++) {
    numbers[maxMapValue - 1 - 2*i] = i+1;
    numbers[maxMapValue - 2 - 2*i] = maxMapValue - i;
  }
 
  for (i = 0; i < maxMapValue / 2; i++) {
    if (r < gaussianProbabilities[i]) {
      if (random(0, 100) > 50) {
        return numbers[2 * i];
      } else {
        return numbers[2 * i + 1];
      }
    }
  }
}

function generateRandomNumber(maxValue) {
  switch($("#distribution").val()){
    case "uniform":
      n = random(1, MAX_RANDOM_VALUE); 
      return uniformMap(n, maxValue);
      break;
    
    case "gauss":
      n = random(1, gaussianProbabilities[maxValue/2 -1]);
      return gaussianInvMap(n, maxValue);
      break;
    
    case "gaussInv":
      n = random(1, gaussianProbabilities[maxValue/2 -1]);
      return gaussianInvMap(n, maxValue);
      break;
    
  }
}

function  throwDice(diceSides) {
  side = generateRandomNumber(diceSides);
  return side;
}


function selectDice(dice){
  console.log("yes");
  for(i=0; i<$(".diceButton").length; i++){
    d = $(".diceButton")[i];
    if(d==dice){
      $(d).addClass("selectedDice");
    }else{
      $(d).removeClass("selectedDice");
    }
  }
}

function rollDice(){
  var n;
  for(i=0; i<$(".diceButton").length; i++){
    d = $(".diceButton")[i];
    if($(d).hasClass("selectedDice")){
      n = parseInt($(d).attr("sides"));
    }
  }
  
  $("#result").text(throwDice(n));  
}