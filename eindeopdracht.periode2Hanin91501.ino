// 91501
// Dit programma maakt gebruik van 3 knoppen.
// - Bij een verkeerde code: rood LED gaat aan, piezo buzzer klinkt, servo beweegt NIET
// - Bij een juiste code: groen LED gaat aan, servo draait, piezo maakt geluid

#include <Servo.h>   // Bibliotheek om de servo aan te sturen

//PIN

// Knoppen
const int button1 = 2;
const int button2 = 3;
const int button3 = 4;

// LEDs, servo en piezo
const int roodLED = 6;
const int groenLED = 7;
const int servoMotorPin = 9;
const int piezzopin = 8;

// Servo object aanmaken
Servo slotServo;

//VARIABELEN

// Laatste status van de knoppen voor detectie van indrukken
int laatste1 = HIGH;
int laatste2 = HIGH;
int laatste3 = HIGH;

// Array waarin de ingevoerde code wordt opgeslagen
int invoer[3];
int invoerIndex = 0;   // Houdt bij hoeveel knoppen zijn ingedrukt
bool bezig = false;   // Zorgt dat er geen nieuwe invoer komt tijdens controle

// De juiste geheime code (knop 3, knop 3, knop 1)
int codeJuist[3] = {3, 3, 1};

//SETUP

void setup()
{
  Serial.begin(9600);   // Start seriële communicatie voor debuggen

  // Knoppen als input instellen
  pinMode(button1, INPUT);
  pinMode(button2, INPUT);
  pinMode(button3, INPUT);

  // LEDs en piezo als output instellen
  pinMode(roodLED, OUTPUT);
  pinMode(groenLED, OUTPUT);
  pinMode(piezzopin, OUTPUT);

  // Servo koppelen aan de juiste pin
  slotServo.attach(servoMotorPin);
  slotServo.write(0);  // Servo startpositie (gesloten)
}

//LOOP 

void loop()
{
  // Als het systeem bezig is met controleren, doe niets
  if (bezig) return;

  // Lees alle drie de knoppen uit
  leesKnop(button1, laatste1, 1);
  leesKnop(button2, laatste2, 2);
  leesKnop(button3, laatste3, 3);
}

//KNOP UITLEZEN

// Deze functie controleert of een knop net is ingedrukt
void leesKnop(int pin, int &laatsteStatus, int knopWaarde)
{
  int huidigeStatus = digitalRead(pin);

  // Controleert of de knop net is ingedrukt van HIGH naar LOW
  if (huidigeStatus == LOW && laatsteStatus == HIGH)
  {
    tone(piezzopin, 2000, 80);   // Kort piepje bij indrukken
    verwerkInvoer(knopWaarde);   // Sla de knop op als invoer
    delay(200);                  // Kleine vertraging tegen dubbel indrukken
  }

  // Sla huidige status op voor de volgende loop
  laatsteStatus = huidigeStatus;
}

//INVOER VERWERKEN

void verwerkInvoer(int knop)
{
  // Stop als er al 3 knoppen zijn ingevoerd
  if (invoerIndex >= 3) return;

  // Sla de knop op in de invoer array
  invoer[invoerIndex] = knop;
  invoerIndex++;

  Serial.print("Ingedrukt: ");
  Serial.println(knop);

  // Als er 3 knoppen zijn ingevoerd, controleer de code
  if (invoerIndex == 3)
  {
    bezig = true;   // Blokkeer verdere invoer

    // Controleer of de ingevoerde code gelijk is aan de juiste code
    if (invoer[0] == codeJuist[0] &&
        invoer[1] == codeJuist[1] &&
        invoer[2] == codeJuist[2])
    {
      // JUISTE CODE
      digitalWrite(groenLED, HIGH);   // Groen LED aan
      slotServo.write(180);           // Servo draait (slot open)
      tone(piezzopin, 1500, 500);     // Lange piep
      Serial.println("GOED");
    }
    else
    {
      // VERKEERDE CODE
      digitalWrite(roodLED, HIGH);    // Rood LED aan

      // Drie korte piepjes
      for (int i = 0; i < 3; i++)
      {
        tone(piezzopin, 400, 200);
        delay(250);
      }

      Serial.println("FOUT");
    }

    delay(3000);   // Wacht 3 seconden
    resetAlles();  // Reset het systeem
  }
}

//RESET FUNCTIE

void resetAlles()
{
  // Reset invoer
  invoerIndex = 0;
  invoer[0] = invoer[1] = invoer[2] = 0;

  // LEDs uit
  digitalWrite(roodLED, LOW);
  digitalWrite(groenLED, LOW);

  // Servo terug naar startpositie
  slotServo.write(0);

  // Systeem weer klaar voor nieuwe invoer
  bezig = false;

  Serial.println("Systeem gereset");
}

 
 
 