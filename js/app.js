/*const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener('click', () => {
	container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener('click', () => {
	container.classList.remove("sign-up-mode");
});*/

//START POP-UP SCRIPT

const openModalButtons = document.querySelectorAll('[data-modal-target]')
const closeModalButtons = document.querySelectorAll('[data-close-button]')
const overlay = document.getElementById('overlay')

const addFieldButton = document.querySelectorAll('[data-add-time-field]')

openModalButtons.forEach(button =>{
	button.addEventListener('click', ()=>{
		const modal = document.querySelector(button.dataset.modalTarget)
		openModal(modal)
	})
})

overlay.addEventListener('click', ()=>{
	const modals = document.querySelectorAll('.modal.active')
	modals.forEach(modal => {
		closeModal(modal)
	})
})

closeModalButtons.forEach(button =>{
	button.addEventListener('click', ()=>{
		const modal = button.closest('.modal')
		closeModal(modal)
	})
})

addFieldButton.forEach(button =>{
	button.addEventListener('click', ()=>{
		let html = 	"<div id=\"time\"><input id=\"time-field\" type=\"time\" value=\"00:00\"><button onclick=\"closeField(this)\" class=\"edit remove\"><i class=\"fa-solid fa-minus\"></i></button></div>";
		const object = document.getElementById('newFoodTimes');
		object.insertAdjacentHTML("beforeend", html);
	})
})

function openModal(modal){
	if (modal == null) return 

	modal.classList.add('active')
	overlay.classList.add('active')
}

function closeModal(modal){
	if (modal == null) return

	//salva nuovi orari	
	var form = document.getElementById("newFoodTimes");
	var text = "";
	var i=0;
	while(i<form.length){
		if (form.elements[i].getAttribute("id") == "time-field")
			text += "<li>" + form.elements[i].value+"</li>";
		i++;
	}

	modal.classList.remove('active')
	overlay.classList.remove('active')
	document.getElementById('foodTimes').innerHTML = text;
}

function closeField(button){
	let field = button.closest('#time')
	field.remove()
}

//END SCRIPT FOR POP-UP

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