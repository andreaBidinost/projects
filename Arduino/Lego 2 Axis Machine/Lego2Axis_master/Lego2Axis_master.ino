//MASTER
#include "LiquidCrystal.h"
#include <DHT.h>
#include "DHT.h"
#include <Wire.h>

#define X_MIN 0.0
#define Y_MIN 0.0
#define X_MAX 5.0
#define Y_MAX 5.0
#define CM_PER_90_DEG 0.075

#define I2C_SLAVE 8


const int pinDht = 5;
DHT dht(pinDht, DHT11);

const int pinBlue = 2;
const int pinRed = 3;
const int pinGreen = 4;

LiquidCrystal lcd(13,12,11,10,9,8);

const int jvx = A0;
const int jvy = A1;
const int jpush = 6;

double xDest = 00.00;
double yDest = 00.00;
double xAct = 00.00;
double yAct = 00.00;

int curX = 3;
int curY = 0;

int n90StepX = 0;
int n90StepY = 0;

int stato = 0;


void setup() {
  lcd.begin(16,2);
  lcd.clear();

  pinMode(jpush, INPUT_PULLUP);
  
  pinMode(pinBlue,OUTPUT);
  pinMode(pinRed,OUTPUT);
  pinMode(pinGreen,OUTPUT);

  Wire.begin();

  writeLcd("Inizializzazione","Macchina");
  delay(2000);
}

void loop() {
  switch(stato){
    case 0:{
      lightOn(1,1,0);
      zeroMachine();
      lightOff();
      stato = 1;

      curX = 3;
      curY = 0;
      break;
    }
    case 1:{
      lightOn(0,0,1);
      
      getCoordinates();
      
      if(curY == 2){
        stato = 2;
      }
      break;
    }
    case 2:{
      fromPointToRotations();
      stato = 3;
      break;
    }
    case 3:{
      lightOn(1, 1, 0);
      rotateMotors();

      stato = 4;
      break;
    }
    case 4:{
      writeLcd("Movimento", "Completato");
      for(int i=0; i<10; i++){
         lightOn(0, 1, 0);
         delay(100);
         lightOff();
         delay(100);
      }
      
      lightOn(0, 1, 0);
      writeLcd("Coord. Attuali", "X: " + String(xAct) + " Y: " + String(yAct));
      delay(2000);

      curX = 3;
      curY = 0;
      stato = 1;
      break;
    }
  }
}

void zeroMachine(){
  writeLcd("Azzeramento","Macchina");
  Wire.beginTransmission(I2C_SLAVE);
  Wire.write('z');
  Wire.endTransmission();
  delay(1000);

  Wire.requestFrom(I2C_SLAVE, 1);
  
  while(Wire.available()){
    char c = Wire.read();
    delay(3000);
    if(c == 'Z'){
      writeLcd("Azzeramento", "Terminato");
      xAct = 0.0;
      yAct = 0.0;
      delay(2000);
    }
  }
}

void getCoordinates(){
  String row1 = "X: ";
  String row2 = "Y: ";

  if(xDest<10){
    row1 += "0";
  }
  row1 += xDest ;
  
  if(yDest<10){
    row2 += "0";
  }
  row2 += yDest ;

  writeLcd(row1, row2);
  
  lcd.setCursor(curX,curY);
  lcd.blink();

  int val = digitalRead(jpush);
  if(val == LOW){
    curY ++;
    curX = 3;
    delay(300);
  }

  int varX = analogRead(jvx);
  int varY = analogRead(jvy);
  int increment = 0;

  if(varY < 300){//SINISTRA
    curX --;
    delay(100);
  } else if(varY > 700){//DESTRA
    curX ++;
    delay(100);
  }

  curX = max(3, curX); //limito a sinistra la posizione del cursore
  curX = min(7, curX); //limito a destra la posizione del cursore

  if(varX < 300){//BASSO
    increment = -1;
    delay(100);
  } else if(varX > 700){//ALTO
    increment = 1;
    delay(100);
  }

  if(increment != 0){
    switch(curX){
      case 3:{//decine
        if(curY == 0){//modifico la xDest
          xDest += increment*10;
        } else if(curY == 1){ //modifico la yDest
          yDest += increment*10;
        }
        break;
      }
      case 4:{//unità
        if(curY == 0){//modifico la xDest
          xDest += increment;
        } else if(curY == 1){ //modifico la yDest
          yDest += increment;
        }
        break;
      }
      case 6:{//decimi
        if(curY == 0){//modifico la xDest
          xDest += increment * 0.1;
        } else if(curY == 1){ //modifico la yDest
          yDest += increment * 0.1;
        }
        break;
      }
      case 7:{//centesimi
        if(curY == 0){//modifico la xDest
          xDest += increment * 0.01;
        } else if(curY == 1){ //modifico la yDest
          yDest += increment * 0.01;
        }
        break;
      }
    }
  }

  xDest = max(X_MIN, xDest); //limito inferiormente la coordinata xDest
  yDest = max(Y_MIN, yDest); //limito inferiormente la coordinata yDest

  xDest = min(X_MAX, xDest); //limito superiormente la coordinata xDest
  yDest = min(Y_MAX, yDest); //limito superiormente la coordinata xDest
    
  delay(100);
  lcd.noBlink();
}

void fromPointToRotations(){
  writeLcd("Elaborazione", "Coordinate");

  n90StepX = (xDest - xAct) / CM_PER_90_DEG;
  n90StepY = (yDest - yAct) / CM_PER_90_DEG;

  delay(3000);
  lightOn(0,1,0);
  delay(1000);
}

void writeLcd(String r1, String r2){
  lcd.clear();
  lcd.home();
  lcd.print(r1);
  lcd.setCursor(0,1);
  lcd.print(r2);
}

void lightOn(int r, int g, int b){
  digitalWrite(pinGreen, g==1 ? HIGH: LOW);
  digitalWrite(pinRed, r==1 ? HIGH: LOW);
  digitalWrite(pinBlue, b==1 ? HIGH: LOW);
}

void lightOff(){
  digitalWrite(pinGreen, LOW);
  digitalWrite(pinRed, LOW);
  digitalWrite(pinBlue, LOW);
}

void rotateMotors(){
  char buf[10];
  memset(buf,0,10);
  Wire.beginTransmission(I2C_SLAVE);
  
  Wire.write('s');
  
  Wire.write('X');
  String(n90StepX).toCharArray(buf, 10);
  Wire.write(buf);

  memset(buf,0,10);
  Wire.write('Y');
  String(n90StepY).toCharArray(buf, 10);
  Wire.write(buf);
  
  Wire.endTransmission();

  writeLcd("Dest X: " + String(xDest) + "...", "Dest Y: " + String(yDest) + "...");
  delay(4000);

  writeLcd("In movimento", "Temp: " + String(dht.readTemperature()));
  Wire.requestFrom(I2C_SLAVE,1);
  
  while(Wire.available()){
    char c = Wire.read();
    delay(3000);
    if(c == 'S'){
      xAct = xDest;
      yAct = yDest;
    }
  }
}
