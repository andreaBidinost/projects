/*
	Esempio di utilizzo della libreria BdStepper per ruotare un motore 288BYJ-48 di 90 gradi.
	
	Dopo una serie di test suggerisco di non ruotare per angoli inferiori ai 5 gradi.
*/

#include "BdStepper.h"

//Utilizzo del motore in modalità half step
BdStepper motore_mezzo(MEZZO_PASSO, 2,3,4,5);

//Utilizzo del motore in modalità full step - 1 phase
BdStepper motore_pieno_1(PASSO_PIENO_1_PHASE, 6,7,8,9);

//Utilizzo del motore in modalità full step - 2 phase
BdStepper motore_pieno_2(PASSO_PIENO_2_PHASE, 10,11,12,13);

void setup(){
	//Rotazione in senso orario
	motore_mezzo.ruotaPerGradi(90, SENSO_ORARIO);
	
	//Rotazione in senso antiorario
	motore_pieno_1.ruotaPerGradi(90, SENSO_ANTI_ORARIO);
}

void loop(){
}

