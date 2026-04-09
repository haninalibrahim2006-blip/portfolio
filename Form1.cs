using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Media;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using NAudio.Wave;
namespace WindowsFormsApp1
{
    public partial class MysteryNumberhanin91501 : Form
    {

        // Variabelen //
        public IWavePlayer outputDevice = null;
        public AudioFileReader audioFile = null;
        public string sound1 = @"..\..\Music1.Wav";

        int LogLine = 0;
        int secretNumber = 0;
        int triesLeft = 10;
        int userStartAt = 0;
        int userEndAt = 0;
        int userNrTries = 0;
        int userGuess = 0;
        Random rnd = new Random(); //secretNumber wordt gemaakt met behulp van een random getalgenerator//

        public MysteryNumberhanin91501()
        {
            InitializeComponent();
        }

        private void From1_load_LoaMysteryNumberhanin91501_Loadd(object sender, EventArgs e) // Wanneer het programma start//
        {
            // Wanneer de game start //
            this.Text = "MysteryNumber by: Hanin Al Ibrahim";

            // zet de afbeelding en knoppen op de juiste plaats//

            pbxStartScreenHai.Left = groupBox1.Left;
            btnShowHai.Left = btnCheatHai.Left + 60;
            this.Width = pbxStartScreenHai.Width + 60;

            updateLoggingText("Program started.", "B");

        }
        private void btnShowHai_Click(object sender, EventArgs e) // Verberg het startscherm//
        {
            // Startscherm laten verdwijnen //
            pbxStartScreenHai.Visible = false;
            btnShowHai.Visible = false;

            updateLoggingText("Start screen hidden, game visible.", "G");
        }
        private void btnGoHai_Click(object sender, EventArgs e)
        {
            try
            {
                // Verberg het startscherm
                pbxStartScreenHai.Visible = false;
                btnShowHai.Visible = false;

                // Startknop: hiermee begint het spel
                userStartAt = Convert.ToInt32(txtStartHai.Text);
                userEndAt = Convert.ToInt32(txtStopHai.Text);
                userNrTries = Convert.ToInt32(cmbAttemptsHai.Text);

                secretNumber = rnd.Next(userStartAt, userEndAt + 1);
                triesLeft = userNrTries;

                updateLoggingText("Start value = " + userStartAt, "");
                updateLoggingText("Stop value = " + userEndAt, "");
                updateLoggingText("Secret number is generated.", "");

                prgAttemptsHai.Maximum = triesLeft;
                prgAttemptsHai.Value = 0;

                lblLeft2Hai.Text = triesLeft.ToString();
                lblWrong2Hai.Text = "-";
                PlaySound(sound1);

                MessageBox.Show("Game started! Try to guess the secret number.");
            }
            catch
            {
            }
        }
        private void updateLoggingText(string a_text, string a_colorCode)
        {
            // bepaal de kleur van de tekst//
            Color m_logColor = Color.Black;

            // Kijk welke kleurcode is meegegeven en zet de juiste kleur //
            if (a_colorCode == "R") m_logColor = Color.Red; // R = rood
            else if (a_colorCode == "G") m_logColor = Color.Green; // G = groen
            else if (a_colorCode == "B") m_logColor = Color.Blue; //B = blauw

            LogLine++;
            // Maakt een tekstregel klaar //
            string prefix = ""; LogLine.ToString("D4");
            rtbInformationHai.SelectionStart = rtbInformationHai.TextLength;
            rtbInformationHai.SelectionLength = 0;
            rtbInformationHai.SelectionColor = m_logColor;
            rtbInformationHai.AppendText(prefix + " " + a_text + Environment.NewLine);
            rtbInformationHai.SelectionColor = rtbInformationHai.ForeColor;
            rtbInformationHai.ScrollToCaret();
        }


        private void PlaySound(string path)
        {
            try
            {

                audioFile = new AudioFileReader(path);// Lees het muziekbestand in (het pad wordt meegegeven)//
                outputDevice = new WaveOutEvent(); // Maak een nieuw audioapparaat om het geluid af te spelen//

                outputDevice.Init(audioFile);// Koppel het muziekbestand aan het afspeelapparaat//
                outputDevice.Play();

                {
                    if (audioFile != null)// Kijk of er is een muziekbestand is //
                    {
                        audioFile.Position = 0;
                        outputDevice.Play();
                    }
                }
;
            }
            catch (Exception ex)// Als er iets fout gaat tijdens het afspelen //
            {
                {
                    MessageBox.Show("Error playing " + path + "\n" + ex.Message,
                        "Audio Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }
            // Deze functie stopt de muziek//
        private void StopSound()
        {
            // Controleer of er geluid wordt afgespeeld//
            if (outputDevice != null)
            {
                outputDevice.Stop();
                outputDevice.Dispose();// Maak het geluidssysteem leeg//
                outputDevice = null;
            }
            if (audioFile != null)
            {
                audioFile.Dispose();
                audioFile = null;
            }
        }

        // Guess knop//
        private void btnGuessHai_Click(object sender, EventArgs e)
        {
            {
                try
                {
                    userGuess = Convert.ToInt32(txtGuessHai.Text); // Lees wat de speler gokt //

                    triesLeft--;
                    lblLeft2Hai.Text = triesLeft.ToString(); // Laat de goken over zien //
                    prgAttemptsHai.Value = prgAttemptsHai.Maximum - triesLeft;

                    int difference = Math.Abs(userGuess - secretNumber);// Bereken het verschil tussen de gok en het geheime nummer//


                    // Controleer of de gok juist is //
                    if (userGuess == secretNumber)
                    {
                        MessageBox.Show("You guessed it right!");
                        lblWrong2Hai.Text = "0";
                        updateLoggingText($"Correct guess! Secret number was {secretNumber}", "G");
                        return;
                    }
                    else
                    {
                        // Als het fout is, tel een fout op //
                        lblWrong2Hai.Text = (Convert.ToInt32(lblWrong2Hai.Text == "-" ? "0" : lblWrong2Hai.Text) + 1).ToString();
                        updateLoggingText($"Wrong guess: {userGuess}", "R");
                    }

                    // Warm/koud logica
                    // Controleer hoe dicht de gok bij het geheime nummer is
                    // en verander de temperatuur (HOT, WARM of COLD)
                    if (difference <= 2)
                    {
                        trkTempHai.Value = 100;
                        lblHotHai.Text = "HOT";
                        lblColdHai.Text = "";
                        updateLoggingText("Guess is HOT.", "G");
                    }
                    else if (difference <= 5)
                    {
                        trkTempHai.Value = 60;
                        lblHotHai.Text = "WARM";
                        lblColdHai.Text = "";
                        updateLoggingText("Guess is WARM.", "B");
                    }
                    else
                    {
                        trkTempHai.Value = 10;
                        lblColdHai.Text = "COLD";
                        lblHotHai.Text = "";
                        updateLoggingText("Guess is COLD.", "R");
                    }

                    // Controleer of er geen pogingen meer zijn //
                    if (triesLeft <= 0)
                    {
                        MessageBox.Show($"No attempts left. The secret number was {secretNumber}");
                        updateLoggingText("Game over - no tries left.", "R");
                    }
                    // Maak het gokveld leeg en zet de cursor er weer in //
                    txtGuessHai.Clear();
                    txtGuessHai.Focus();
                }
                catch
                {
                    // Als de gebruiker iets ongeldig invoert //
                    MessageBox.Show("Invalid input!");
                    updateLoggingText("Invalid guess input.", "R");
                    return;
                }
            }
        }

        private void btnAboutHai_Click(object sender, EventArgs e)
        {
            MessageBox.Show(
        "Mystery Number Game\n" +
        "Made by: Hanin Al Ibrahim\n" +
        "ROC Ter AA - 2025",
        "About",
        MessageBoxButtons.OK,
        MessageBoxIcon.Information

      );
            updateLoggingText("About button clicked", "B");

        }

        private void btnCheatHai_Click(object sender, EventArgs e)
        {
            // Controleer of er al een geheim nummer is gemaakt //
            if (secretNumber == 0)
            {
                updateLoggingText("SecretNumber has n", "R");
            }
            else
            {
                // Laat een berichtvenster zien met het geheime nummer //
                MessageBox.Show(
           $"The secret number is: {secretNumber}", // Tekst die het nummer laat zien //
           "Cheat Mode",
           MessageBoxButtons.OK,
           MessageBoxIcon.Warning);

                updateLoggingText($"Cheat used! Secret number = {secretNumber}", "R");

            }
        }

        private void btnClearHai_Click(object sender, EventArgs e)
        {


            txtStartHai.Clear();
            txtStopHai.Clear();
            txtGuessHai.Clear();
            cmbAttemptsHai.Text = "";


            lblLeft2Hai.Text = "-";
            lblWrong2Hai.Text = "-";
            lblHotHai.Text = "";
            lblColdHai.Text = "";
            prgAttemptsHai.Value = 0;
            trkTempHai.Value = trkTempHai.Minimum;
            triesLeft = 0;
            secretNumber = 0;
            rtbInformationHai.Clear();
            updateLoggingText("Game has been reset", "G");


            MessageBox.Show("All fields have been cleared. You can start a new game.", "Reset Done",
                MessageBoxButtons.OK, MessageBoxIcon.Information);
        }

        private void btnLocateHai_Click(object sender, EventArgs e)
        {
            try
            {
                // Pad naar projectmap //
                string locatie = @"C:\Users\Hanin\OneDrive - Ter AA\visual studio2022\MysteryNumber-Hanin91501";

                // Open de map in Verkenner //
                System.Diagnostics.Process.Start("explorer.exe", locatie);
            }
            catch (Exception ex)
            {
                // Als het niet lukt laat een foutmelding zien //
                MessageBox.Show("Kon de map niet openen.\n\n" + ex.Message,
                    "Foutmelding", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnDefaultHai_Click(object sender, EventArgs e)
        {
            // Zet het begingetal op 1
            txtStartHai.Text = "1";
            // Zet het eindgetal op 50
            txtStopHai.Text = "50";
            // Zet het aantal pogingen op 10
            cmbAttemptsHai.Text = "10";

            secretNumber = rnd.Next(1, 50);

            updateLoggingText("Default values loaded (1–50, 10 attempts)", "G");
        }

        private void btnMusicHai_Click(object sender, EventArgs e)
        {

            StopSound();
        }

    }
}


