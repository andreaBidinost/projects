/*
	Esempio di utilizzo della libreria BdStepper per ruotare un motore 288BYJ-48 per un quantitativo di tempo specificato (in millisecondi).
	
	Dopo una serie di test suggerisco di non impostare un intervallo di tempo inferiore ai 50 millisecondi.
*/

#include "BdStepper.h"

//Utilizzo del motore in modalità half step
BdStepper motore_mezzo(MEZZO_PASSO, 2,3,4,5);

//Utilizzo del motore in modalità full step - 1 phase
BdStepper motore_pieno_1(PASSO_PIENO_1_PHASE, 6,7,8,9);

//Utilizzo del motore in modalità full step - 2 phase
BdStepper motore_pieno_2(PASSO_PIENO_2_PHASE, 10,11,12,13);

void setup(){
	//Rotazione in senso orario per 1 secondo
	motore_mezzo.ruotaPerMillisecondi(1000, SENSO_ORARIO);
	
	//Rotazione in senso antiorario per mezzo secondo
	motore_pieno_1.ruotaPerGradi(500, SENSO_ANTI_ORARIO);
}

void loop(){
}

