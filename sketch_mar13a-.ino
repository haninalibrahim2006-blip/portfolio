const int joyX = A0;
const int joyY = A1;
 
int valJoyX = 0;
int valJoyY = 0;
 
int mappedValJoyX = 0;
int mappedValJoyY = 0;
 
void setup()
{
Serial.begin(9600);
}
 
void loop()
{
valJoyX = analogRead(joyX);
valJoyY = analogRead(joyY);
 
Serial.print("Position JoyX: ");
Serial.print(valJoyX);
Serial.print("- ");
Serial.print("Position JoyY: ");
Serial.println(valJoyY);
 
mappedValJoyX = map(valJoyX, 0, 1023, 0, 255);
mappedValJoyY = map(valJoyY, 0, 1023, 0, 255);
 
Serial.print("- ");
Serial.print("Mapped JoyX: ");
Serial.print(mappedValJoyX);
Serial.print("- ");
Serial.print("Mapped JoyY: ");
Serial.println(mappedValJoyY);
 
 
}