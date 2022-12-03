<body>
	<div class="container">


		<div class="menu-container">
			<div class="menu">
				<button id="food-btn" class="btn transparent">Cibo</button>
				<button id="health-btn" class="btn transparent">Salute</button>
				<button id="sos-btn" class="btn" 
				onclick="location.href='https://www.google.com/maps/search/veterinario+vicino+a+me'">SOS</button>
			</div>

			<img src="images/register.svg">
		</div>

		<section id="food-info" class="info-left info-active">

			<div class="info-container">

				<!-- cibo-->
				<div class="taglia">
					<h2>Taglia del tuo animale</h2>
					<form>
						<select name="taglia" class="">
							<option value="1" selected="selected">Da borsetta</option>
							<option value="2">Taglia media</option>
							<option value="3">Dinosauro</option>
						</select>
					</form>
				</div>
				<div id="cibo" class="food sezioneOrari">
					<h2>Pianifica orari</h2>
					<ul class="times">
						
					</ul>
				</div>

				<!--acqua-->

				<!--<div class="acqua">
					<h2>Erogazione Acqua</h2>
					<div class="erogazioneAcqua">
						<span>Eroga l'acqua se il cane è vicino</span>
						<label class="switch">
						  	<input type="checkbox">
						 	<span class="slider"></span>
						</label>
					</div>
				</div>-->

			</div>
			
		</section>

		<section id="health-info" class="info-right">
			<div class="info-container">
				<div class="peso">
					<h2>Controllo peso</h2>
					<form>
						<label>inserisci peso: </label>
						<input id="peso" type="text" name="peso" placeholder="kg">
						<input id="data" type="date" name="data">
					</form>
					<button onclick='pickAndPlotValues("peso", "data")' class="edit">
						<i class="fa-solid fa-file-import"></i>
					</button>
				</div>
				<div class="plot-peso">
					<h2>Grafico</h2>
					<canvas id="plotPeso" style="width:100%;max-width:700px"></canvas>
				</div>

				<div id="uscite"class="walk sezioneOrari">
					<h2>Programma uscite</h2>
					<ul class="times">
						
					</ul>
				</div>
			</div>
		</section>

	</div>

	<div class="overlay"></div>
</body>

