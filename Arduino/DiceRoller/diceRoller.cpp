#include <iostream>
#include <math.h>
#include <stdlib.h>     /* srand, rand */
#include <time.h>       /* time */

using namespace std;

 
const int MAX_RANDOM_VALUE = 1000;

 
const int MAX_DICE_SIDES = 20;

int gaussianProbabilities[MAX_DICE_SIDES / 2];


int random(int n1, int n2){
    return rand()%(n2-1) +1;
}
 
void buildGaussianProbabilities() {
  int value = 10;
  int sum = value;
  for (int i = 0; i < MAX_DICE_SIDES / 2; i++) {
    gaussianProbabilities[i] = sum;
    value += 10;
    sum += value;
  }
}



int uniformMap(int n, int maxMapValue) {
  return ceil(n * maxMapValue / MAX_RANDOM_VALUE) + 1;
}


int gaussianMap(int n, int maxMapValue) {
  int r = random(1, gaussianProbabilities[(maxMapValue / 2 - 1)]);
  
  int numbers[maxMapValue];
  int centralNumber = maxMapValue/2;

  for (int i = 0; i < maxMapValue / 2; i++) {
    numbers[maxMapValue - 1 - 2*i] = centralNumber - i;
    numbers[maxMapValue - 2 - 2*i] = centralNumber + i + 1;
  }
 
  for (int i = 0; i < maxMapValue / 2; i++) {
    if (r < gaussianProbabilities[i]) {
      if (random(0, 100) > 50) {
        return numbers[2 * i];
      } else {
        return numbers[2 * i + 1];
      }
    }
  }
  
}


int gaussianInvMap(int n, int maxMapValue) {
  int r = random(1, gaussianProbabilities[(maxMapValue / 2 - 1)]);
  
  int numbers[maxMapValue];
  int centralNumber = maxMapValue/2;

  for (int i = 0; i < maxMapValue / 2; i++) {
    numbers[maxMapValue - 1 - 2*i] = i+1;
    numbers[maxMapValue - 2 - 2*i] = maxMapValue - i;
  }
 
  for (int i = 0; i < maxMapValue / 2; i++) {
    if (r < gaussianProbabilities[i]) {
      if (random(0, 100) > 50) {
        return numbers[2 * i];
      } else {
        return numbers[2 * i + 1];
      }
    }
  }
}

int generateRandomNumber(int maxValue) {
  /*
  FOR GAUSSIAN OR GAUSSIAN-INV USAGE
  int n = random(1, gaussianProbabilities[maxValue/2 -1]);
  n= gaussianInvMap(n, maxValue);*/
  
  int n = random(1, MAX_RANDOM_VALUE); 
  n= uniformMap(n, maxValue);
  return n;
}

int  throwDice(int diceSides) {
  int side = generateRandomNumber(diceSides);

 return side;
}

int main () 
{
    srand (time(NULL));
 
    buildGaussianProbabilities ();
    int n = 4;
    
    
    for(int i=0; i<10000; i++){
       cout << throwDice(20) << endl; 
    }
}
