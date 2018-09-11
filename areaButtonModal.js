/*
Alexander Murie.
Eagleweb, Aug 2018.
Purpose: Drives the Area button (modal), handles open and close triggers (clicks).
*/


var modalarea = document.getElementById('areaModal');
var modalButton = document.getElementById('buttonArea');
var modalCloseButton = document.getElementsByClassName('closeButtonArea')[0];


// Listeners
buttonArea.addEventListener('click', openModal);
modalCloseButton.addEventListener('click', closeModal);
//


//openModal() switches the style element "display" to 'block' (from 'none'), which will cause the modal Area menu to be shown. 
// It triggers on click of the Area button.
function openModal() {
	modalarea.style.display = 'block';
}

//closeModal switches the style element "display" to 'none' (after it was changed via openModal()), which will cause the modal Area menu to become hidden. 
// It triggers on click of the exit ("x") in the top right corner of modal menus.
function closeModal() {
	modalarea.style.display = 'none';
}

//clickOutside(e) performs the same function as closeModal.
// However, it triggers on click anywhere outside of the modal Area menu.
