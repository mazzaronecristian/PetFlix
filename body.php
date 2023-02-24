<body>
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

      <img src="images/register.svg" />
    </div>

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

          <h2>Grafico</h2>
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

  <div class="overlay"></div>
</body>