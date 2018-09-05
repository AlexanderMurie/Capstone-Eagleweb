/*
Alexander Murie.
Eagleweb, Aug 2018.
Purpose: Drives the Nest button (modal), handles open and close triggers (clicks).
*/


var modalnest = document.getElementById('nestModal');
var modalButton = document.getElementById('buttonNest');
var modalCloseButton = document.getElementsByClassName('closeButtonNest')[0];

// Listeners
buttonNest.addEventListener('click', openModal);
modalCloseButton.addEventListener('click', closeModal);
window.addEventListener('click', clickOutside);
//


//openModal() switches the style element "display" to 'block' (from 'none'), which will cause the modal nest menu to be shown. 
// It triggers on click of the Nest button.
function openModal() {
	modalnest.style.display = 'block';
}


//closeModal switches the style element "display" to 'none' (after it was changed via openModal()), which will cause the modal nest menu to become hidden. 
// It triggers on click of the exit ("x") in the top right corner of modal menus.
function closeModal() {
	modalnest.style.display = 'none';
}


//clickOutside(e) performs the same function as closeModal.
// However, it triggers on click anywhere outside of the modal nest menu.
function clickOutside(e) {
	if (e.target == modalnest){
		modalnest.style.display = 'none';
	}
}