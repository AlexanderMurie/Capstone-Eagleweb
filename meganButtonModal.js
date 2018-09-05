/*
Alexander Murie.
Eagleweb, Aug 2018.
Purpose: Drives the Megan button (modal), handles open and close triggers (clicks).
*/


var modalmegan = document.getElementById('meganModal');
var modalButton = document.getElementById('buttonMegan');
var modalCloseButton = document.getElementsByClassName('closeButtonArea')[0];

// Listeners
buttonModal.addEventListener('click', openModal);
modalCloseButton.addEventListener('click', closeModal);
window.addEventListener('click', clickOutside);
//



//openModal() switches the style element "display" to 'block' (from 'none'), which will cause the modal Megan menu to be shown. 
// It triggers on click of the Megan button.
function openModal() {
	modalmegan.style.display = 'block';
}


//closeModal switches the style element "display" to 'none' (after it was changed via openModal()), which will cause the modal Megan menu to become hidden. 
// It triggers on click of the exit ("x") in the top right corner of modal menus.
function closeModal() {
	modalmegan.style.display = 'none';
}


//clickOutside(e) performs the same function as closeModal.
// However, it triggers on click anywhere outside of the modal Megan menu.
function clickOutside(e) {
	if (e.target == modalmegan){
		modalmegan.style.display = 'none';
	}
}