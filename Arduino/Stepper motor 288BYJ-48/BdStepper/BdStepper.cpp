#include "Arduino.h"
#include "BdStepper.h"

BdStepper::BdStepper(int passo, int p1, int p2, int p3, int p4){
	pinMode(p1, OUTPUT);
	pinMode(p2, OUTPUT);
	pinMode(p3, OUTPUT);
	pinMode(p4, OUTPUT);
	
	_passo = passo;
	_p1 = p1;
	_p2 = p2;
	_p3 = p3;
	_p4 = p4;	
}

void BdStepper::ruotaPerGradi(int angolo, int verso){
	
	if(_passo == MEZZO_PASSO){
		int nStep = ((double)STEP_PER_GIRO_HALF)*angolo/ANGOLO_GIRO;
		int i;
	
		if(verso == SENSO_ORARIO){ //senso orario
			for(long int n=0; n<nStep; n++){
				i = n % 8;
				digitalWrite(_p1, (i>=1 && i<=2)?HIGH:LOW);
				digitalWrite(_p2, (i>=2 && i<=4)?HIGH:LOW);
				digitalWrite(_p3, (i>=4 && i<=6)?HIGH:LOW);
				digitalWrite(_p4, (i>=6)?HIGH:LOW);
				delay(1);
			} 
		} else {
			for(long int n=nStep-1; n>=0; n--){
				i = n % 8;
				digitalWrite(_p1, (i>=1 && i<=2)?HIGH:LOW);
				digitalWrite(_p2, (i>=2 && i<=4)?HIGH:LOW);
				digitalWrite(_p3, (i>=4 && i<=6)?HIGH:LOW);
				digitalWrite(_p4, (i>=6)?HIGH:LOW);
				delay(1);
			} 
		}
	} else if (_passo == PASSO_PIENO_1_PHASE){
		int nStep = ((double)STEP_PER_GIRO_FULL)*angolo/ANGOLO_GIRO;
		int i;
	
		if(verso == SENSO_ORARIO){ //senso orario
			for(long int n=0; n<nStep; n++){
				i = n % 4;
				digitalWrite(_p1, i==0?HIGH:LOW);
				digitalWrite(_p2, i==1?HIGH:LOW);
				digitalWrite(_p3, i==2?HIGH:LOW);
				digitalWrite(_p4, i==3?HIGH:LOW);
				delayMicroseconds(2019);
			} 
		} else {
			for(long int n=nStep-1; n>=0; n--){
				i = n % 4;
				digitalWrite(_p1, i==0?HIGH:LOW);
				digitalWrite(_p2, i==1?HIGH:LOW);
				digitalWrite(_p3, i==2?HIGH:LOW);
				digitalWrite(_p4, i==3?HIGH:LOW);
				delayMicroseconds(2019);
			} 
		}
	} else if(_passo == PASSO_PIENO_2_PHASE){
		int nStep = ((double)STEP_PER_GIRO_FULL)*angolo/ANGOLO_GIRO;
		int i;
	
		if(verso == SENSO_ORARIO){ //senso orario
			for(long int n=0; n<nStep; n++){
				i = n % 4;
				digitalWrite(_p1, i==3 || i==0?HIGH:LOW);
				digitalWrite(_p2, i==0 || i==1?HIGH:LOW);
				digitalWrite(_p3, i==1 || i==2?HIGH:LOW);
				digitalWrite(_p4, i==2 || i==3?HIGH:LOW);
				delayMicroseconds(2018);
			} 
		} else {
			for(long int n=nStep-1; n>=0; n--){
				i = n % 4;
				digitalWrite(_p1, i==3 || i==0?HIGH:LOW);
				digitalWrite(_p2, i==0 || i==1?HIGH:LOW);
				digitalWrite(_p3, i==1 || i==2?HIGH:LOW);
				digitalWrite(_p4, i==2 || i==3?HIGH:LOW);
				delayMicroseconds(2018);
			} 
		}
	}	
}

void BdStepper::ruotaPerMillisecondi(long duration, int verso){
	long startMills = millis();
	int i;
	
	if(_passo == MEZZO_PASSO){
		if(verso == SENSO_ORARIO){ //senso orario
			i=0;
			while(millis() - startMills <= duration){
				digitalWrite(_p1, (i>=1 && i<=2)?HIGH:LOW);
				digitalWrite(_p2, (i>=2 && i<=4)?HIGH:LOW);
				digitalWrite(_p3, (i>=4 && i<=6)?HIGH:LOW);
				digitalWrite(_p4, (i>=6)?HIGH:LOW);
				delay(1);
				i = (i+1) % 8;
			} 
			return;
		} else {
			i=7;
			while(millis() - startMills <= duration){
				digitalWrite(_p1, (i>=1 && i<=2)?HIGH:LOW);
				digitalWrite(_p2, (i>=2 && i<=4)?HIGH:LOW);
				digitalWrite(_p3, (i>=4 && i<=6)?HIGH:LOW);
				digitalWrite(_p4, (i>=6)?HIGH:LOW);
				delay(1);
				i = (i+7) % 8;
			} 
			return;
		}
	} else if (_passo == PASSO_PIENO_1_PHASE){
	
		if(verso == SENSO_ORARIO){ //senso orario
			i=0;
			while(millis() - startMills <= duration){
				
				digitalWrite(_p1, i==0?HIGH:LOW);
				digitalWrite(_p2, i==1?HIGH:LOW);
				digitalWrite(_p3, i==2?HIGH:LOW);
				digitalWrite(_p4, i==3?HIGH:LOW);
				delayMicroseconds(2019);
				i = (i+1)%4;
			} 
			return;
		} else {
			i = 3;
			while(millis() - startMills <= duration){
				digitalWrite(_p1, i==0?HIGH:LOW);
				digitalWrite(_p2, i==1?HIGH:LOW);
				digitalWrite(_p3, i==2?HIGH:LOW);
				digitalWrite(_p4, i==3?HIGH:LOW);
				delayMicroseconds(2019);
				i = (i + 3) % 4;	
			} 
			return;
		}
	} else if(_passo == PASSO_PIENO_2_PHASE){
	
		if(verso == SENSO_ORARIO){ //senso orario
			i=0;
			while(millis() - startMills <= duration){
				digitalWrite(_p1, i==3 || i==0?HIGH:LOW);
				digitalWrite(_p2, i==0 || i==1?HIGH:LOW);
				digitalWrite(_p3, i==1 || i==2?HIGH:LOW);
				digitalWrite(_p4, i==2 || i==3?HIGH:LOW);
				delayMicroseconds(2018);
				i = (i+1)%4;
			} 
			return;
		} else {
			i = 3;
			while(millis() - startMills <= duration){
				digitalWrite(_p1, i==3 || i==0?HIGH:LOW);
				digitalWrite(_p2, i==0 || i==1?HIGH:LOW);
				digitalWrite(_p3, i==1 || i==2?HIGH:LOW);
				digitalWrite(_p4, i==2 || i==3?HIGH:LOW);
				delayMicroseconds(2018);
				i = (i + 3) % 4;
			} 
			return;
		}
	}	
}


