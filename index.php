<?php 
  if(isset($_GET['device'])){
    session_start();
    $_SESSION['device'] = $_GET['device'];
  }
  require("server/session.php");

?>
<!DOCTYPE html>
<html lang="it">

<head>
  <?php include('header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/foodStyle.css" />
  <script type="text/javascript" src="js/times_plugin_init.js"></script>
  <script type="text/javascript" src="js/times_plugin.js"></script>
  <script defer type="text/javascript" src="js/app.js"></script>
  <script type="text/javascript" src="js/options_init.js"></script>
  <script type="text/javascript" src="js/device.js"></script>
  <script type="text/javascript" src="js/popup_init.js"></script>
  <script type="text/javascript" src="js/popup.js"></script>
  <script type="text/javascript" src="js/options.js"></script>
  <script type="text/javascript" src="js/plot_init.js"></script>
  <script type="text/javascript" src="js/plot.js"></script>
  <title>PetFlix</title>
</head>

<body>
  <div alt="logout" name="logout" class="logout-container">
    <a href="server/closeSession.php"><i class="fa-solid fa-right-from-bracket"></i></a>
  </div>
  <div class="container">


    <div name="barra navigazione" class="menu-container">
      <div class="menu">
        <button alt="cibo" name="cibo" id="food-btn" class="btn transparent">Cibo</button>
        <button alt="salute" name="salute" id="health-btn" class="btn transparent">Salute</button>
        <button alt="SOS" name="s.o.s." id="sos-btn" class="btn"
          onclick="location.href='https://www.google.com/maps/search/veterinario+vicino+a+me'">
          SOS
        </button>
      </div>

      <img alt="logo" name="logo" src="images/navbar.svg" />
    </div>

    <div id="info-body">
    <section name="informazioni cibo" id="food-info" class="info-left info-active">
      <div class="info-container">
        <!-- cibo-->
        <div name="taglia animale" class="taglia">
          <h2>Seleziona la taglia del tuo animale</h2>
          <form name="selettore taglia" action="server/actionsSize.php" method="post">
            <select alt="seleziona taglia" id="101" class="selector">
              <option value="0">seleziona taglia</option>
              <option value="1">Piccola</option>
              <option value="2">Media</option>
              <option value="3">Grande</option>
            </select>
          </form>
        </div>
        <div name="orari pasti" id="cibo" class="food sezioneOrari">
          <div class="serviceAbilitator">
            <h2>Pianifica orari</h2>
            <label name="switch pasti automatici" class="switch">
              <input class="switch" id="102" type="checkbox">
              <span class="slider"></span>
            </label>
          </div>

          <ul class="times"></ul>
        </div>

        <div name="erogazione cibo" style="width: 100%; position: unset; text-align: center">
          <button alt="erogazione cibo" id="103" class="btn instant-food-btn" onclick="sendOptionConfiguration(this.id,1)">CIBO!</button>
        </div>
      </div>
    </section>

    <section id="health-info" class="info-right">
      <div name="informazioni salute" class="info-container">
        <div name="invio pesi" class="peso plot-peso">
          <h2>Controllo peso</h2>
          <div class="nuovi-pesi">
            <form name="dati pesata">
              <label>inserisci peso: </label>
              <input alt="peso" class="nuovoPeso" type="text" name="peso" placeholder="kg" />
              <input alt="data" class="nuovaData" type="date" name="data" />
            </form>
            <button alt="invio peso" class="invio-peso edit">
              <i class="fa-solid fa-file-import"></i>
            </button>
          </div>

          <div class="pesi">
            <h2>Andamento del peso</h2>
          </div>

          <canvas alt="andamento peso" name="grafico andamento peso" id="plotPeso" style="width: 100%; max-width: 700px"></canvas>
        </div>

        <div name="orari uscite" id="uscite" class="walk sezioneOrari">
          <div class="serviceAbilitator">
            <h2>Programma uscite</h2>
            <label class="switch">
              <input class="switch" id="202" type="checkbox">
              <span class="slider"></span>
            </label>
          </div>
          <ul class="times"></ul>
        </div>
      </div>
    </section>


    </div>

  </div>
  <div data-modal-target="modal-device" class="popup-parent">
    <div id="modal-devices" class="modal">
        <div class="modal-header">
          <div class="title">Aggiungi dispositivo</div>
          <button data-close-button class="close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body" id="modal" >
          <form class="newDevice">
            <input type="text" name="id" placeholder="codice scheda">
            <input type="text" name="nome" placeholder="nome scheda">
            <button type="button" id="add-device" class="btn">aggiungi</button>

          </form>

        </div>
      </div>
  </div>

  <div data-modal-target="modal-device-info" class="popup-parent">
    <div id="modal-devices" class="modal">
        <div class="modal-header">
          <div class="title">Codice stazione</div>
          <button data-close-button class="close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body" id="modal" >
          <p>ogni stazione è identificata da un codice da 4 cifre, controlla la scatola del tuo dispositivo per scoprire l'identificativo, oppure inserisci il codice di una stazione già presente in casa tua</p>
        </div>
      </div>
  </div>

    <div name="device registrati" class="device-container">
      <button id="modal-device-info" alt="info device" name="info device" class="edit open-popup"><i class="fa-solid fa-circle-info"></i></button>
      <nav class="devices">
        
      </nav>
      <button id="modal-device" alt="aggiungi device" name="aggiungi device" class="edit add open-popup"><i class="fa-solid fa-plus"></i></button>
    </div>
 

  <div class="overlay"></div>
  <?php 
    if ( isset($_SESSION['device']) ){
      ?>
      <script>
        $('#info-body').removeClass('avoid-clicks');
        $('#info-body').removeClass('invisible');
        $('#device-msg').remove();

      </script>
      <?php
    }
    else {
      ?>
      <script>
        $('#info-body').addClass('avoid-clicks');
        $('#info-body').addClass('invisible');
        let html = '<h3 id="device-msg">Seleziona un dispositivo</h3>';
        $('body').prepend(html);
      </script>
      <?php
    }

  ?>


</body>

</html>