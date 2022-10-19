<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/foodStyle.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
	</script>
	<script src="https://kit.fontawesome.com/13645b992e.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/times_plugin_init.js"></script>
	<script type="text/javascript" src="js/times_plugin.js"></script>
	<script defer type="text/javascript" src="js/app.js"></script>
	<title>food</title>
</head>

<body>
	<div class="container">

		<div class="menu-container">
			<div class="menu">
				<button id="food-btn" class="btn transparent">Cibo</button>
				<button id="health-btn" class="btn transparent">Salute</button>
				<button id="sos-btn" class="btn">SOS</button>
			</div>

			<img src="images/register.svg">
		</div>

		<section id="food-info" class="info-left info-active">

			<div class="info-container">

				<!-- cibo-->
				<div class="orari sezioneOrari">
					<h2>Orari Cibo</h2>
					<ul class="times">
						
					</ul>
				</div>

				<!--acqua-->

				<div class="acqua">
					<h2>Erogazione Acqua</h2>
					<div class="erogazioneAcqua">
						<span>Eroga l'acqua se il cane è vicino</span>
						<label class="switch">
						  	<input type="checkbox">
						 	<span class="slider"></span>
						</label>
					</div>
				</div>

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

				<div class="uscite sezioneOrari">
					<h2>Programma uscite</h2>
					<ul class="times">
						
					</ul>
				</div>
			</div>
		</section>

	</div>

</body>
</html>
