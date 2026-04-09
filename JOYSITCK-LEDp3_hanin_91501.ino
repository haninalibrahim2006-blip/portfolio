//HANIN 91501 P3//

#include <Arduino_LED_Matrix.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

// =========================
// Objecten
// =========================
ArduinoLEDMatrix matrix;
LiquidCrystal_I2C lcd(0x27, 16, 2);

// =========================
// Joystick pinnen
// =========================
const int joyX = A0;
const int joyY = A1;
const int joySW = 2;

// =========================
// Variabelen
// =========================
int valX, valY;
int keyW, keyA, keyS, keyD;

// =========================
// FRAMES (GEEN CONST ❗)
// =========================

uint8_t FRAME_H[8][12] = {
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,1,1,1,1,1,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_A[8][12] = {
  {0,0,0,1,1,1,1,1,0,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,1,1,1,1,1,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_N[8][12] = {
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,1,0,0,0,0,1,0,0,0},
  {0,0,1,0,1,0,0,0,1,0,0,0},
  {0,0,1,0,0,1,0,0,1,0,0,0},
  {0,0,1,0,0,0,1,0,1,0,0,0},
  {0,0,1,0,0,0,0,1,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_I[8][12] = {
  {0,0,1,1,1,1,1,1,1,0,0,0},
  {0,0,0,0,0,1,0,0,0,0,0,0},
  {0,0,0,0,0,1,0,0,0,0,0,0},
  {0,0,0,0,0,1,0,0,0,0,0,0},
  {0,0,0,0,0,1,0,0,0,0,0,0},
  {0,0,0,0,0,1,0,0,0,0,0,0},
  {0,0,1,1,1,1,1,1,1,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_DASH[8][12] = {
  {0,0,0,0,0,0,0,0,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0},
  {0,0,0,1,1,1,1,1,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_9[8][12] = {
  {0,0,0,1,1,1,1,1,0,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,0,1,1,1,1,1,1,0,0,0},
  {0,0,0,0,0,0,0,0,1,0,0,0},
  {0,0,0,0,0,0,0,1,0,0,0,0},
  {0,0,1,1,1,1,1,0,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_1[8][12] = {
  {0,0,0,0,1,1,0,0,0,0,0,0},
  {0,0,0,1,1,1,0,0,0,0,0,0},
  {0,0,0,0,1,1,0,0,0,0,0,0},
  {0,0,0,0,1,1,0,0,0,0,0,0},
  {0,0,0,0,1,1,0,0,0,0,0,0},
  {0,0,0,0,1,1,0,0,0,0,0,0},
  {0,0,1,1,1,1,1,1,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_5[8][12] = {
  {0,0,1,1,1,1,1,1,0,0,0,0},
  {0,0,1,0,0,0,0,0,0,0,0,0},
  {0,0,1,0,0,0,0,0,0,0,0,0},
  {0,0,1,1,1,1,1,1,0,0,0,0},
  {0,0,0,0,0,0,0,1,0,0,0,0},
  {0,0,0,0,0,0,0,1,0,0,0,0},
  {0,0,1,1,1,1,1,0,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

uint8_t FRAME_0[8][12] = {
  {0,0,0,1,1,1,1,1,0,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,1,0,0,0,0,0,1,0,0,0},
  {0,0,0,1,1,1,1,1,0,0,0,0},
  {0,0,0,0,0,0,0,0,0,0,0,0}
};

// =========================
// SETUP
// =========================
void setup() {
  Serial.begin(9600);
  pinMode(joySW, INPUT_PULLUP);

  matrix.begin();

  lcd.init();
  lcd.backlight();
  lcd.clear();

  // start: 501
  
  delay(2000);
}

// =========================
// LOOP
// =========================
void loop() {
  showFrames();

  readJoystick();
  showLCD();
}

// =========================
// LED MATRIX ANIMATIE
// =========================
void showFrames() {
  static int i = 0;
  static unsigned long t = 0;

  if (millis() - t < 300) return;
  t = millis();

  switch(i){
    case 0: matrix.renderBitmap(FRAME_H,8,12); break;
    case 1: matrix.renderBitmap(FRAME_A,8,12); break;
    case 2: matrix.renderBitmap(FRAME_N,8,12); break;
    case 3: matrix.renderBitmap(FRAME_I,8,12); break;
    case 4: matrix.renderBitmap(FRAME_N,8,12); break;
    case 5: matrix.renderBitmap(FRAME_DASH,8,12); break;
    case 6: matrix.renderBitmap(FRAME_9,8,12); break;
    case 7: matrix.renderBitmap(FRAME_1,8,12); break;
    case 8: matrix.renderBitmap(FRAME_5,8,12); break;
    case 9: matrix.renderBitmap(FRAME_0,8,12); break;
    case 10: matrix.renderBitmap(FRAME_1,8,12); break;
  }

NEW SKETCH

  i++;
  if(i > 10) i = 0;
}

// =========================
// JOYSTICK + LCD (ONVERANDERD)
// =========================
void readJoystick() {
  valX = analogRead(joyX);
  valY = analogRead(joyY);

  keyA = map(valX, 0, 500, 0, 100);
  keyD = map(valX, 505, 1023, 100, 0);
  keyW = map(valY, 0, 525, 0, 100);
  keyS = map(valY, 530, 1023, 100, 0);

  keyA = constrain(keyA, 0, 100);
  keyD = constrain(keyD, 0, 100);
  keyW = constrain(keyW, 0, 100);
  keyS = constrain(keyS, 0, 100);
}

void showLCD() {
  String direction = "CENTER";
  int percentage = 0;

  if (keyW <= 95) { direction = "UP"; percentage = 100 - keyW; }
  else if (keyS <= 95) { direction = "DOWN"; percentage = 100 - keyS; }
  else if (keyA <= 95) { direction = "LEFT"; percentage = 100 - keyA; }
  else if (keyD <= 95) { direction = "RIGHT"; percentage = 100 - keyD; }

  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print(direction);
  lcd.setCursor(0,1);
  lcd.print(percentage);
  lcd.print("%");

  delay(150);
}