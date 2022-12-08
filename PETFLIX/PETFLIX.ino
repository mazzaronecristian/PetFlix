#include <WiFi.h>
#include <HTTPClient.h>
#include <Arduino_JSON.h>
#include "time.h"
#include "string.h"
#include <ESP32_Servo.h>

// Define Pins for RGB LED and delayTime
#define BLUE 13
#define GREEN 12
#define RED 14
#define delayTime 5

Servo myservo;  // create servo object to control a servo
// twelve servo objects can be created on most boards
int pos = 0;    // variable to store the servo position

const char* ntpServer = "it.pool.ntp.org";
const long gmtOffset_sec = 3600; //GMT +1.00
const int daylightOffset_sec = 0; 

//CASA AREZZO
//const char* ssid = "FASTWEB-94ACB9";
//const char* password = "TZPRC4KYK1";

//TARANTO
//const char* ssid = "FASTWEB-2.4G";
//const char* password = "3hm3XVW28f";

//iphone
//const char* ssid = "iPhone di Gianluca";
//const char* password = "paranoia";

//Cell Cristian
const char* ssid = "Galaxy A517D88";
const char* password = "fmnk8665";

//Your Domain name with URL path or IP address with path
const char* serverName = "http://petflix.altervista.org/server/actionsArduino.php";

// the following variables are unsigned longs because the time, measured in
// milliseconds, will quickly become a bigger number than can be stored in an int.
unsigned long lastTime = 0;
// Timer set to 10 minutes (600000)
//unsigned long timerDelay = 600000;
// Set timer to 5 seconds (5000)
unsigned long timerDelay = 1000;

String timeReadings;
JSONVar timeReadingsArr[5];
String currentTime;

void setup() {
  Serial.begin(115200);

  myservo.attach(26);
  
  //RGB LED SETUP
  pinMode(RED, OUTPUT);
  pinMode(GREEN, OUTPUT);
  pinMode(BLUE, OUTPUT);
  digitalWrite(RED, HIGH);
  digitalWrite(GREEN, LOW);
  digitalWrite(BLUE, LOW);
  int redValue = 255; // choose a value between 1 and 255 to change the color.
  int greenValue = 0;
  int blueValue = 0;

  //SETUP CONNECTION
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    for(int i = 0; i < 255; i += 1) // fades out red bring green full when i=255
         {
          redValue -= 1;
          blueValue += 1;
          analogWrite(RED, redValue);
          analogWrite(BLUE, blueValue);
          delay(delayTime);
         }
         delay(500);
         for(int i = 0; i < 255; i += 1) // fades out red bring green full when i=255
         {
          blueValue -= 1;
          redValue += 1;
          analogWrite(RED, redValue);
          analogWrite(BLUE, blueValue);
          delay(delayTime);
         }
  }
  if(WiFi.status() == WL_CONNECTED) {
    for(int i = 0; i < 255; i += 1) // fades out red bring green full when i=255
         {
          redValue -= 1;
          greenValue += 1;
          analogWrite(RED, redValue);
          analogWrite(GREEN, greenValue);
          delay(delayTime);
         }
    }
  
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
 
  Serial.println("Timer set to 5 seconds (timerDelay variable), it will take 5 seconds before publishing the first reading.");

  //init and get the time
  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer); 
  
}

void loop() {
  currentTime = printLocalTime();
  JSONVar jTime = currentTime; 
  
  //Send an HTTP GET request
  if ((millis() - lastTime) > timerDelay) {
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
              
      timeReadings = httpGETRequest(serverName);
      JSONVar myObject = JSON.parse(timeReadings);
  
      // JSON.typeof(jsonVar) can be used to get the type of the var
      if (JSON.typeof(myObject) == "undefined") {
        Serial.println("Parsing input failed!");
        return;
      }
    
      // myObject.keys() can be used to get an array of all the keys in the object
      JSONVar keys = myObject.keys();
    
      for (int i = 0; i < keys.length(); i++) {
        JSONVar value = myObject[keys[i]];
        timeReadingsArr[i] = value;
      }
      for(int i=0 ; i<5; i++){
        if(jTime == timeReadingsArr[i]){

          for (pos = 0; pos <= 180; pos += 1) { // goes from 0 degrees to 180 degrees
            // in steps of 1 degree
            myservo.write(pos);              // tell servo to go to position in variable 'pos'
            delay(5);                       // waits 15ms for the servo to reach the position
          }
          for (pos = 180; pos >= 0; pos -= 1) { // goes from 180 degrees to 0 degrees
            myservo.write(pos);              // tell servo to go to position in variable 'pos'
            delay(5);                       // waits 15ms for the servo to reach the position
          }
        }
      }   
    }
    else {
      Serial.println("WiFi Disconnected");
    }
    lastTime = millis();
  }
  delay(1000);
}



String httpGETRequest(const char* serverName) {
  WiFiClient client;
  HTTPClient http;
    
  // Your Domain name with URL path or IP address with path
  http.begin(client, serverName);
  
  // If you need Node-RED/server authentication, insert user and password below
  //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
  
  // Send HTTP POST request
  int httpResponseCode = http.GET();
  
  String payload = "{}"; 
  
  if (httpResponseCode>0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
    payload = http.getString();
  }
  else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }
  // Free resources
  http.end();
  return payload;
}

String printLocalTime(){
  time_t rawtime;
  struct tm *timeinfo;
  char timeString[6];
  time(&rawtime);
  timeinfo = localtime(&rawtime);
  strftime(timeString, sizeof(timeString), "%H:%M", timeinfo);
  String(complexTime) = timeString; 
  return complexTime;
}
