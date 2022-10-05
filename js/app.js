//START NAVBAR SCRIP
	const food_btn = document.getElementById("food-btn");
	const health_btn = document.getElementById("health-btn");
	const health_info = document.querySelector("#health-info");
	const food_info = document.querySelector("#food-info")

	health_btn.addEventListener('click', ()=>{
		health_info.classList.add("info-active");
		health_info.classList.remove("avoid-clicks");
		food_info.classList.remove("info-active");
		food_info.classList.add("avoid-clicks");
	});


	food_btn.addEventListener('click', ()=>{
		food_info.classList.add("info-active");
		food_info.classList.remove("avoid-clicks");
		health_info.classList.remove("info-active");
		health_info.classList.add("avoid-clicks");
	});

//END NAVBAR SCRIPT

//START PLOT SCRIPT
var values = [0];
var labels = [0];

function pickAndPlotValues(idValue, idLabel) {
	let field_value = document.getElementById(idValue);
	let field_label = document.getElementById(idLabel);
	console.log(field_label.value);

	if(field_value.value != "" && field_label.value != "") {
		if (values[0]==0) 
			values[0] = field_value.value;
		else 
			values.push(eval(field_value.value));
		if(labels[0] == 0) 
			labels[0] = field_label.value;
		else 
			labels.push(field_label.value);
		
		new Chart("plotPeso", {
		  type: "line",
		  data: {
		    labels: labels,
		    datasets: [{
		      data: values,
		      borderColor: "#577590",
		      fill: false
		    }]
		  },
		  options: {
		    legend: {display: false}
		  }
		});
	}
	else return;
}
//END PLOT SCRIPT