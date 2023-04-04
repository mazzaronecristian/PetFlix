<?php 
  if(isset($_GET['device'])){
    session_start();
    $_SESSION['device'] = $_GET['device'];
  }
  require("server/session.php");

?>
<!DOCTYPE html>
<html>

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
  <div class="logout-container">
    <a href="server/closeSession.php"><i class="fa-solid fa-right-from-bracket"></i></a>
  </div>
  <div class="container">


    <div class="menu-container">
      <div class="menu">
        <button id="food-btn" class="btn transparent">Cibo</button>
        <button id="health-btn" class="btn transparent">Salute</button>
        <button id="sos-btn" class="btn"
          onclick="location.href='https://www.google.com/maps/search/veterinario+vicino+a+me'">
          SOS
        </button>
      </div>

      <img src="images/navbar.svg" />
    </div>

    <div id="info-body">
    <section id="food-info" class="info-left info-active">
      <div class="info-container">
        <!-- cibo-->
        <div class="taglia">
          <h2>Seleziona la taglia del tuo animale</h2>
          <form action="server/actionsSize.php" method="post">
            <select id="101" class="selector">
              <option value="0">seleziona taglia</option>
              <option value="1">Piccola</option>
              <option value="2">Media</option>
              <option value="3">Grande</option>
            </select>
          </form>
        </div>
        <div id="cibo" class="food sezioneOrari">
          <div class="serviceAbilitator">
            <h2>Pianifica orari</h2>
            <label class="switch">
              <input class="switch" id="102" type="checkbox">
              <span class="slider"></span>
            </label>
          </div>

          <ul class="times"></ul>
        </div>

        <div style="width: 100%; position: unset; text-align: center">
          <button id="103" class="btn instant-food-btn" onclick="sendOptionConfiguration(this.id,1)">CIBO!</button>
        </div>
      </div>
    </section>

    <section id="health-info" class="info-right">
      <div class="info-container">
        <div class="peso plot-peso">
          <h2>Controllo peso</h2>
          <div class="nuovi-pesi">
            <form>
              <label>inserisci peso: </label>
              <input class="nuovoPeso" type="text" name="peso" placeholder="kg" />
              <input class="nuovaData" type="date" name="data" />
            </form>
            <button class="invio-peso edit">
              <i class="fa-solid fa-file-import"></i>
            </button>
          </div>

          <div class="pesi">
            <h2>Grafico</h2>
            <button class="edit-peso edit">
              <i class="fa-solid fa-pencil"></i>
            </button>
          </div>

          <canvas id="plotPeso" style="width: 100%; max-width: 700px"></canvas>
        </div>

        <div id="uscite" class="walk sezioneOrari">
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
  <div class="popup-parent">
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
    <div class="device-container">
      <button class="edit"><i class="fa-solid fa-circle-info"></i></button>
      <nav class="devices">
        
      </nav>
      <button class="edit add open-popup"><i class="fa-solid fa-plus"></i></button>
    </div>
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