/*
Alexander Murie.
Eagleweb, Aug 2018.
Purpose: Drives the Clear button (modal), handles open and close triggers (clicks).
*/


var modalclear = document.getElementById('clearModal');
var modalButton = document.getElementById('buttonClear');
var modalCloseButton = document.getElementsByClassName('closeButtonClear')[0];

// Listeners
buttonClear.addEventListener('click', openModal);
modalCloseButton.addEventListener('click', closeModal);
window.addEventListener('click', clickOutside);
//


//openModal() switches the style element "display" to 'block' (from 'none'), which will cause the modal clear menu to be shown. 
// It triggers on click of the Clear button.
function openModal() {
	modalclear.style.display = 'block';
}

//closeModal switches the style element "display" to 'none' (after it was changed via openModal()), which will cause the modal clear menu to become hidden. 
// It triggers on click of the exit ("x") in the top right corner of modal menus.
function closeModal() {
	modalclear.style.display = 'none';
}

//clickOutside(e) performs the same function as closeModal.
// However, it triggers on click anywhere outside of the modal clear menu.
function clickOutside(e) {
	if (e.target == modalclear){
		modalclear.style.display = 'none';
	}
}