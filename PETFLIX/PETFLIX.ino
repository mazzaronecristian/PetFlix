//VERSIONE 1.6 con WATCHDOG per notifica

#include <WiFi.h>
#include <HTTPClient.h>
#include <Arduino_JSON.h>
#include "time.h"
#include "string.h"
#include <ESP32_Servo.h>
#include "pitches.h"
#include <esp_task_wdt.h> 

// Define Pins for RGB LED and delayTime
#define BLUE 13
#define GREEN 12
#define RED 14
#define DELAYTIME 5

//CASA-AREZZO WI-FI
//#define NOME_RETE "FASTWEB-94ACB9" 
//#define PASSWORD "TZPRC4KYK1"
//iphone WI-FI
//#define NOME_RETE "iPhone di Gianluca"
//#define PASSWORD "paranoia"
//Cell Cristian WI-FI
#define NOME_RETE "Galaxy di Cristian"
#define PASSWORD "wwuy2511"

#define SERVER_TIMES "http://petflix.altervista.org/server/actionsArduino.php"
#define SERVER_OPTIONS "http://petflix.altervista.org/server/actionsOptionsArduino.php"
#define SERVER_OPTIONS_POST "http://petflix.altervista.org/server/actionsOptionsArduinoPOST.php"
#define SERVER_WALKS "http://petflix.altervista.org/server/actionsWalksArduino.php"
#define NTP_SERVER "it.pool.ntp.org"
#define GMT 3600 //GMT +1.00
#define DAYLIGHT 0

//3 seconds WDT
#define WDT_TIMEOUT 3

// notes in the melody:
int melody[] = {
  NOTE_C5, NOTE_C5, NOTE_C5, NOTE_G4, NOTE_A4, NOTE_A4, NOTE_G4, NOTE_G4, NOTE_E5, NOTE_E5, NOTE_D5, NOTE_D5, NOTE_C5, NOTE_C5};
int duration = 400;  // 400 miliseconds

Servo myservo;  // create servo object to control a servo

void giveFood(int retard) {
  Serial.println("EROGAZIONE CIBO!!!");
  for (int pos = 0; pos <= 120; pos += 1) { // goes from 0 degrees to 120 degrees
    // in steps of 1 degree
    myservo.write(pos);              // tell servo to go to position in variable 'pos'
    delay(1);                       // waits 15ms for the servo to reach the position
  }
  delay(retard);                    //retard based on the pet's size 
  for (int pos = 120; pos >= 0; pos -= 1) { // goes from 120 degrees to 0 degrees 
    myservo.write(pos);              // tell servo to go to position in variable 'pos'
    delay(1);                       // waits 15ms for the servo to reach the position
  }
}

// the following variables are unsigned longs because the time, measured in
// milliseconds, will quickly become a bigger number than can be stored in an int.
unsigned long lastTime = 0;
// Set timer
unsigned long timerDelay = 1000;
String timeReadings;
JSONVar timeFoodArr[5];
JSONVar timeWalkArr[10];
String currentTime;
String optionReadings;

int foodFlag = 0; //flag which controls if the food has already been given
int tmpFlag = 0;
int soundFlag = 0;

struct OptionsReadings{
  JSONVar key;
  JSONVar value;
  };

//control objects for setting values ​​loaded on server
OptionsReadings optionsReadingsArr[5];
OptionsReadings controlSize = {"impostazione101", "0"};
OptionsReadings controlFoodSwc= {"impostazione102", "1"};
OptionsReadings controlFoodBtn = {"impostazione103", "0"};
OptionsReadings controlWalkSwc= {"impostazione202", "1"};

JSONVar possibleValues[] = {"0", "1", "2", "3"};

void setup() {
  Serial.begin(115200);

  myservo.attach(25);
  pinMode(19,OUTPUT);
  digitalWrite(19,LOW);

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
  WiFi.begin(NOME_RETE, PASSWORD);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    for(int i = 0; i < 255; i += 1){ // fades out red bring green full when i=255 
      redValue -= 1;
      blueValue += 1;
      analogWrite(RED, redValue);
      analogWrite(BLUE, blueValue);
      delay(DELAYTIME);
    }
    delay(500);
    for(int i = 0; i < 255; i += 1){ // fades out red bring green full when i=255
      blueValue -= 1;
      redValue += 1;
      analogWrite(RED, redValue);
      analogWrite(BLUE, blueValue);
      delay(DELAYTIME);
    }
  }
  if(WiFi.status() == WL_CONNECTED) {
    for(int i = 0; i < 255; i += 1){ // fades out red bring green full when i=255
      redValue -= 1;
      greenValue += 1;
      analogWrite(RED, redValue);
      analogWrite(GREEN, greenValue);
      delay(DELAYTIME);
    }
  }
  
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
 
  Serial.println("Timer set to 5 seconds (timerDelay variable), it will take 5 seconds before publishing the first reading.");

  //init and get the time
  configTime(GMT, DAYLIGHT, NTP_SERVER); 
  
}


void loop() {
  
  currentTime = printLocalTime();
  JSONVar jTime = currentTime;
  
  //Send an HTTP GET request
  if ((millis() - lastTime) > timerDelay) {
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      optionReadings = httpGETRequest(SERVER_OPTIONS);

      JSONVar myOptions = JSON.parse(optionReadings);

      //Delay based on pet's size
      int retard =0;
  
      // JSON.typeof(jsonVar) can be used to get the type of the var
      if (JSON.typeof(myOptions) == "undefined") {
        Serial.println("Parsing input failed!");
        return;
      }
    
      // myOptions.keys() can be used to get an array of all the keys in the object
      JSONVar keys = myOptions.keys();

      //organization of the setting's values from server
      for (int i = 0; i < keys.length(); i++) {
        if(keys[i]==controlFoodSwc.key)
          controlFoodSwc.value = myOptions[keys[i]];
        if(keys[i]==controlFoodBtn.key)
          controlFoodBtn.value = myOptions[keys[i]];
        if(keys[i]==controlWalkSwc.key)
          controlWalkSwc.value = myOptions[keys[i]];
        if(keys[i]==controlSize.key)
          controlSize.value = myOptions[keys[i]];
      }

       //setting delay based on pet's size
      if(controlSize.value == possibleValues[1])
        retard = 2000;
      if(controlSize.value == possibleValues[2])
        retard = 4000;
      if(controlSize.value == possibleValues[3])
        retard = 5500;
        

      Serial.print("ritardo:");
      Serial.println(retard);

      Serial.print("Switch Cibo:");
      Serial.println(controlFoodSwc.value);

      Serial.print("impostazione Taglia:");
      Serial.println(controlSize.value);

      Serial.print("Imp. Bottone:");
      Serial.println(controlFoodBtn.value);

      Serial.print("Switch uscita:");
      Serial.println(controlWalkSwc.value);
      
      if(retard != 0){       //doesn't give food if the size is not set 
        if(controlFoodBtn.value == possibleValues[1]){                //gives food if the button "food" is pressed
          giveFood(retard); 
          String httpRequestData = "id=103&state=0";
          httpPOSTRequest(SERVER_OPTIONS_POST, httpRequestData);
        }
        else if(controlFoodSwc.value == possibleValues[1]){          //gives food (based on times) only if the switch is ON
          timeReadings = httpGETRequest(SERVER_TIMES);
          JSONVar myTimes = JSON.parse(timeReadings);
  
          // JSON.typeof(jsonVar) can be used to get the type of the var
          if (JSON.typeof(myTimes) == "undefined") {
             Serial.println("Parsing input failed!");
             return;
          }
    
          // myTimes.keys() can be used to get an array of all the keys in the object
          keys = myTimes.keys();
    
          for (int i = 0; i < keys.length(); i++) {
            JSONVar value = myTimes[keys[i]];
            timeFoodArr[i] = value;       
          }
          if(foodFlag == 0){                      //if foodFlag = 1 the food has already been given
            for(int i=0 ; i<5; i++){
              if(jTime == timeFoodArr[i]){    //gives food based on times
                  giveFood(retard);
                  foodFlag = 1;
              }
            }
          }
          tmpFlag = 0;
          for(int i=0 ; i<5; i++)
            if(jTime == timeFoodArr[i])
              tmpFlag = 1;
          if(tmpFlag == 0)
            foodFlag = 0;
        }
      }
      
      if(controlWalkSwc.value == possibleValues[1]){      //walk switch active
        timeReadings = httpGETRequest(SERVER_WALKS);
        JSONVar myTimes = JSON.parse(timeReadings);

        // JSON.typeof(jsonVar) can be used to get the type of the var
        if (JSON.typeof(myTimes) == "undefined") {
           Serial.println("Parsing input failed!");
           return;
        }
  
        // myTimes.keys() can be used to get an array of all the keys in the object
        keys = myTimes.keys();
  
        for (int i = 0; i < keys.length(); i++) {
          JSONVar value = myTimes[keys[i]];
          timeWalkArr[i] = value;
        }
        if(soundFlag==0)
          for(int i=0 ; i<10; i++){
            if(jTime == timeWalkArr[i]){    //plays melody "b" times based on times
              int b = 2;
              //while(b!= 0){
                for (int thisNote = 0; thisNote < 14; thisNote++) {
                  // pin5 output the voice, every scale is 0.5 second
                  tone(19, melody[thisNote], duration);
                  delay(500);
                  noTone(19);
                }
                b--;
                delay(500);              
                //}
              soundFlag = 1;
              esp_task_wdt_init(WDT_TIMEOUT, true); //enable panic so ESP32 restarts
              esp_task_wdt_add(NULL); //add current thread to WDT watch
            }
          }
        tmpFlag = 0;
        for(int i=0 ; i<10; i++){
          if(jTime == timeWalkArr[i])
            tmpFlag = 1;
          timeWalkArr[i] = {"NULL"};
        }
        if(tmpFlag == 0)
          soundFlag = 0;
        
      }
      
      
    }
    else Serial.println("WiFi Disconnected");
    lastTime = millis();
    
  }
}


void httpPOSTRequest(const char* serverName, String httpRequestData) {
  WiFiClient client;
  HTTPClient http;
    
  // Your Domain name with URL path or IP address with path
  http.begin(client, serverName);

  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  // Send HTTP POST request
  int httpResponseCode = http.POST(httpRequestData);
  http.end(); //free resources
}

String httpGETRequest(const char* serverName) {
  WiFiClient client;
  HTTPClient http;
  
  // Your Domain name with URL path or IP address with path
  http.begin(client, serverName);
  
  // Send HTTP GET request
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
