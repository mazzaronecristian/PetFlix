# PetFlix
> ### Progetto con Arduino - Progettazione e produzione multimediale
> ###### Università degli studi di Firenze

**PETFLIX** è una stazione automatica per l'erogazione di croccantini per animali domestici, controllata tramite un microcontrollore **ESP32** (con modulo WIFI) e gestita da remoto tramite un'**applicazione web** raggiungibile a questo [Link](http://petflix.altervista.org "PETFLIX").

Questa **repository** contiene il codice sorgente per **l'applicazione web** (al momento hostata su Altervista) e lo **sketch Arduino**.

## Applicazione WEB
- Dopo essersi registrati tramite **Username** e **Password** bisogna selezionare (o registrare) un dispositivo tramite **ID SCHEDA** e **Nome del proprio animale** 

![gif ingresso](http://g.recordit.co/TpauFryWwc.gif)

## Sezione CIBO

- Prima di tutto si seleziona la taglia del proprio animale e gli orari di erogazione dei croccantini. 

![gif orari cibo]()

-Possibilità di escludere gli orari tramite switch ed erogarlo manualmente attraverso pulsante **CIBO!**

## Sezione SALUTE

- In questa sezione è possibile tenere sotto controllo il peso dell'animale nel tempo attraverso un grafico.

![gif GRAFICO PESI]()

- E Programmare gli orari di uscita o momenti di svago tramite notifiche acustiche emesse dalla stazione tramite un Buzzer passivo integrato. 

![gif orari USCITE]()

## Pulsante SOS

- Consente di accedere rapidamente ai veterinari nella zona con un reindirizzamento automatico su google maps, per agire tempestivamente di caso di emergenze.

![gif SOS]()

