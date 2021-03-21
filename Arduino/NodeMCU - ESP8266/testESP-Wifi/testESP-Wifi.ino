#include <Arduino.h>
#include <ESP8266WiFi.h>

// WiFi parameters
const char* ssid = "Nome della rete qui"; //replace with your ssid
const char* password = "password della rete qui";//replace with your pw

WiFiClient client;

void setupWiFi(){
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.print(ssid);
  Serial.println("...");

  WiFi.begin(ssid, password);
  int retries = 0;
  while ((WiFi.status() != WL_CONNECTED) && (retries < 15)){ retries++; delay(500); Serial.print("."); } if(retries>14){
    Serial.println("WiFi conenction FAILED");
  }
  if (WiFi.status() == WL_CONNECTED){
    Serial.println("WiFi connected!");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
  }
  Serial.println("Setup ready");
}

void setup() {
  Serial.begin(115200); //set the baud rate for Wemos D1 mini
  setupWiFi(); //call our WiFi method to connect to the internet
}

void loop(){

}
