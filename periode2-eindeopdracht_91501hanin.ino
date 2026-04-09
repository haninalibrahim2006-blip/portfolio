// Hanin Alibrahim
// 31-10-2025
// Project: LED modes + RGB + LDR sensor
// Deze code laat LED’s in verschillende patronen branden
// en gebruikt een lichtsensor (LDR) om de RGB-lamp te laten reageren op licht/donker.

// ----- Pin-instellingen -----
const int button = 2;        // pin waar de knop is aangesloten
const int led1 = 3;          // LED 1 pin
const int led2 = 4;          // LED 2 pin
const int led3 = 5;          // LED 3 pin
const int led4 = 6;          // LED 4 pin
const int led5 = 7;          // LED 5 pin

const int greenLEDPin = 9;   // groene pin van de RGB LED
const int redLEDPin = 11;    // rode pin van de RGB LED
const int blueLEDPin = 10;   // blauwe pin van de RGB LED
const int sensorPin = A2;    // pin waar de lichtsensor (LDR) op zit

// ----- Variabelen -----
int sensorValue = 0;         // leest de waarde van de lichtsensor
int redValue = 0;            // helderheid van rode kleur (0–255)
int greenValue = 0;          // helderheid van groene kleur (0–255)
int blueValue = 0;           // helderheid van blauwe kleur (0–255)
int buttonState = 0;         // huidige status van de knop (ingedrukt of niet)
int buttonCheck = 0;         
int lightMode = 0;           

void setup()
{
  // Stel pinnen in als input of output
  pinMode(button, INPUT);       // knop is een invoer
  pinMode(led1, OUTPUT);        // LED1 is uitvoer
  pinMode(led2, OUTPUT);
  pinMode(led3, OUTPUT);
  pinMode(led4, OUTPUT);
  pinMode(led5, OUTPUT);
  pinMode(greenLEDPin, OUTPUT);
  pinMode(blueLEDPin, OUTPUT);
  pinMode(redLEDPin, OUTPUT);
  pinMode(sensorPin, INPUT);    // LDR is invoer

  Serial.begin(9600);           // start communicatie met de computer (voor debuggen)
}

void loop()
{
  // Lees de waarde van de sensor (0–1023)
  sensorValue = analogRead(sensorPin);

  // Lees de huidige stand van de knop (HIGH of LOW)
  buttonState = digitalRead(button);

  // Controleer of de knopstatus veranderd is
  if (buttonState != buttonCheck) // verschil afvragen
  {
    if (buttonState == HIGH)      // als de knop net is ingedrukt
    {
      lightMode++;                // ga naar de volgende lichtmodus
      if (lightMode == 6)         // als we voorbij 5 gaan, terug naar 0
      {
        lightMode = 0;
      }
      // Toon de actieve modus in de seriële monitor
      Serial.print("Lightmode = ");
      Serial.println(lightMode);
    }
  }

  // Sla de huidige knopstatus op voor de volgende keer
  buttonCheck = buttonState;

  // ----- Verschillende lichtmodi -----

  // Modus 0: alle LED’s uit
  if (lightMode == 0)
  {
    digitalWrite(led1, LOW);
    digitalWrite(led2, LOW);
    digitalWrite(led3, LOW);
    digitalWrite(led4, LOW);
    digitalWrite(led5, LOW);
  }

  // Modus 1: alle LED’s aan
  else if (lightMode == 1)
  {
    digitalWrite(led1, HIGH);
    digitalWrite(led2, HIGH);
    digitalWrite(led3, HIGH);
    digitalWrite(led4, HIGH);
    digitalWrite(led5, HIGH);
  }

  // Modus 2: alle LED’s knipperen aan/uit
  else if (lightMode == 2)
  {
    delay(300);                  // wacht 0.3 seconden
    digitalWrite(led1, HIGH);
    digitalWrite(led2, HIGH);
    digitalWrite(led3, HIGH);
    digitalWrite(led4, HIGH);
    digitalWrite(led5, HIGH);
    delay(300);                  // wacht nog 0.3 seconden
    digitalWrite(led1, LOW);
    digitalWrite(led2, LOW);
    digitalWrite(led3, LOW);
    digitalWrite(led4, LOW);
    digitalWrite(led5, LOW);
  }

  // Modus 3: lopend licht van LED1 → LED5
  else if (lightMode == 3)
  {
    delay(70); digitalWrite(led1, HIGH);
    delay(70); digitalWrite(led1, LOW);
    digitalWrite(led2, HIGH);
    delay(70); digitalWrite(led2, LOW);
    digitalWrite(led3, HIGH);
    delay(70); digitalWrite(led3, LOW);
    digitalWrite(led4, HIGH);
    delay(70); digitalWrite(led4, LOW);
    digitalWrite(led5, HIGH);
    delay(70); digitalWrite(led5, LOW);
  }

  // Modus 4: RGB reageert op lichtsensor
  // Wanneer het donker is → RGB aan, wanneer het licht is → RGB uit
  else if (lightMode == 4)
  {
    if (sensorValue > 500)       // hoge waarde betekent donker
    {
      redValue = 305;
      blueValue = 305;
      greenValue = 305;
    }
    else                         // lage waarde betekent licht
    {
      redValue = 0;
      blueValue = 0;
      greenValue = 0;
    }
  }

  // Stuur de kleurwaarden naar de RGB LED (PWM)
  analogWrite(redLEDPin, redValue);     // stel rood in
  analogWrite(greenLEDPin, greenValue); // stel groen in
  analogWrite(blueLEDPin, blueValue);   // stel blauw in
}


