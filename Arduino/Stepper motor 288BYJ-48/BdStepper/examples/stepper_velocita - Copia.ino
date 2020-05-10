/*
	Esempio di utilizzo della libreria BdStepper per ruotare un motore 288BYJ-48 impostando una certa velocità.
	
	La velocità può essere impostata in:
	- radianti al secondo (RAD_SEC)
	- gradi al secondo (GRADI_SEC)
	- giri al minuto (GIRI_MIN)
	
	La velocità può essere impostata sia nella modalità mezzo passo che passo pieno.
	
	Dopo diversi test ti consiglio di non superare i seguenti valori di velocità altrimenti il motore non si 
	muoverà e si surriscalderà:
	- radianti al secondo: 1.496
	- gradi al secondo: 85.71
	- giri al minuto: 14.28
*/

#include "BdStepper.h"

//Utilizzo del motore in modalità half step
BdStepper motore_mezzo(MEZZO_PASSO, 2,3,4,5);

void setup(){
	
	//Impostazione della velocità a 0.84 radianti al secondo
	motore_mezzo.impostaVelocita(RAD_SEC, 0.84);
	
	//Rotazione in senso orario per 1 secondo con la velocità impostata
	motore_mezzo.ruotaPerMillisecondi(1000, SENSO_ORARIO);
	
	//Impostazione della velocità a 50.2 gradi al secondo
	motore_mezzo.impostaVelocita(GRADI_SEC, 50.2);
	
	//Rotazione in senso orario per 1 secondo con la velocità impostata
	motore_mezzo.ruotaPerMillisecondi(1000, SENSO_ORARIO);
	
	//Impostazione della velocità a 7 giri al minuto
	motore_mezzo.impostaVelocita(GIRI_MIN, 0.84);
	
	//Rotazione in senso orario per 1 secondo con la velocità impostata
	motore_mezzo.ruotaPerMillisecondi(1000, SENSO_ORARIO);
}

void loop(){
}

