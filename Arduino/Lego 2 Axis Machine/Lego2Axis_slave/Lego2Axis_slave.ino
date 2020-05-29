//SLAVE
#include <Wire.h>
#include "BdStepper.h"

#define I2C_SLAVE 8

const int trig = 3;
const int echo = 2;

BdStepper xMotor(MEZZO_PASSO, 8,9,10,11);
BdStepper yMotor(MEZZO_PASSO, 4,5,6,7);

int n90StepX, n90StepY;

/*
 * requestKind:
 * 'z': zero machine
 * 's': provide step
 */
int requestKind;

void setup() {
  Serial.begin(9600);
  
  pinMode(trig, OUTPUT);
  pinMode(echo, INPUT);

  Wire.begin(I2C_SLAVE);
  Wire.onReceive(updateState);
  Wire.onRequest(computeMasterRequest);
}

void loop() {
}

int getDistance(){
  digitalWrite(trig, LOW);
  digitalWrite(trig, HIGH);
  delayMicroseconds(10);
  digitalWrite(trig, LOW);
  return  pulseIn(echo, HIGH) * 0.01715;
}

void computeMasterRequest(){
  switch(requestKind){
    case 'z':{
      zeroMachine();
      Serial.println("Zeroed");
      Wire.write('Z');
      break;
    }
    case 's':{
      rotateMotors();
      Serial.println("Moved");
      Wire.write('S');
      break;
    }
  }
  
}

void updateState(int howMany){
  char c = Wire.read();

  switch(c){
    case 'z':{
      requestKind = 'z';
      break;
    }
    case 's':{
      updateSteps();
      Serial.println("Updated steps");
      requestKind = 's';
      break;
    }
  }
}

void updateSteps(){
  //Save X-axis and Y-axis steps
       
  while(Wire.available()){
    char c = Wire.read();
    if(c == 'X'){
      String number = "";
      while((c = Wire.read()) != 'Y'){
        number += String(c);
      }
      number.trim();
      n90StepX = number.toInt();
      
    }
    
    if(c == 'Y'){
      String number = "";
      while(Wire.available()){
        char k = Wire.read();
        number += String(k);
      }
      number.trim();
      n90StepY = number.toInt();
    }
  }
}

void zeroMachine(){
  while(getDistance()>4){
    yMotor.ruotaPerGradi(90, SENSO_ORARIO);
  }

  for(int i=0; i<5; i++){
    xMotor.ruotaPerGradi(360, SENSO_ANTI_ORARIO);
  }
}

void rotateMotors(){
  
  int xWise = n90StepX >= 0 ? SENSO_ORARIO: SENSO_ANTI_ORARIO;
  int yWise = n90StepY >= 0 ? SENSO_ANTI_ORARIO: SENSO_ORARIO;
  
  for(int i = 0; i<abs(n90StepX); i++){
    xMotor.ruotaPerGradi(90, xWise);
  }
  
  for(int i = 0; i<abs(n90StepY); i++){
    yMotor.ruotaPerGradi(90, yWise);
  }
}
