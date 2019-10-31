#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <Adafruit_Fingerprint.h>
#include <LiquidCrystal_I2C.h>

const char *ssid = "cwiz";  
const char *password = "password";
const char *host = "http://www.asyoulike.com";

int nam;
String rollno,postData;

LiquidCrystal_I2C lcd(0x27, 16, 2);
SoftwareSerial mySerial(13, 15);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);
void setup(){
   lcd.begin();
   lcd.backlight();
   wifi_setup();
   sensor_setup();
}


void loop(){
  datapost();
}
void wifi_setup(){
  delay(1000);
  WiFi.mode(WIFI_OFF);
  delay(1000);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  lcd.setCursor(0, 0);
  lcd.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    lcd.print(".");
   }
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Connected To ");
  lcd.print(ssid);
  
}

void sensor_setup(){
  finger.begin(57600);
  if (finger.verifyPassword()) {
   lcd.clear();
   lcd.setCursor(0,0);
   lcd.print("Found FPsensor!");
   delay(2000);
  } else {
    lcd.print("NOTFOUND Sensor!");
    while (1) { delay(1); }
  }
 
}
void datapost(){
  HTTPClient http;    //Declare object of class HTTPClient
  rollno = getStudentfingerID();
  lcd.clear();
  lcd.print("Roll NO =" + rollno);
  delay(1500);
  

  //Post Data
  postData = "rollno=" + rollno;
  
  http.begin("http://www.asyoulike.com/postphp.php");              //Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header

  int httpCode = http.POST(postData);   //Send the request
  String payload = http.getString();    //Get the response payload

  lcd.clear();
  lcd.print(httpCode);   //Print HTTP return code
  delay(1000);
  lcd.clear();
  lcd.print(payload);    //Print  request response payload 
  delay(2000);
  http.end();  //Close connection
  
  //delay(5000);  //Post Data at every 5 seconds
}
int getStudentfingerID(){
  // Will return FingerprintID in int format
  // -1 indicate error code
  int p = -1;
  while (p != FINGERPRINT_OK){
    p = finger.getImage(); // Get Fingerprint Image
    switch (p) {
      case FINGERPRINT_OK:
        lcd.clear();
        lcd.print("OOOKKK");
        break;
      case FINGERPRINT_NOFINGER:
        lcd.clear();
        lcd.print("WaitingFinger...");
        break;
      default:
        lcd.clear();
        lcd.print("ERR_GETIMAGE");
        break;
    }
  }

  p = finger.image2Tz(); // Convert Image
  switch (p) {
    case FINGERPRINT_OK:
      break;
    default:
      lcd.clear();
      lcd.print("ERR_CONVERT");
      return -1;
  }

  p = finger.fingerFastSearch();
  switch (p){
    case FINGERPRINT_OK:
      return finger.fingerID;
    case FINGERPRINT_NOTFOUND:
      return -1;
  }
}
