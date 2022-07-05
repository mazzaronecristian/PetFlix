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
		let html = 	"<div class=\"time\" id=\"time\"><input id=\"time-field\" type=\"time\" value=\"16:30\"><button onclick=\"closeField(this)\" class=\"edit remove\"><i class=\"fa-solid fa-minus\"></i></button></div>"
		button.insertAdjacentHTML("beforebegin", html)
	})
})
function openModal(modal){
	if (modal == null) return 

	modal.classList.add('active')
	overlay.classList.add('active')

}

function closeModal(modal){
	if (modal == null) return

	modal.classList.remove('active')
	overlay.classList.remove('active')
}

function closeField(button){
	let field = button.closest('#time')
	field.remove()
}


//END SCRIPT FOR POP-UP