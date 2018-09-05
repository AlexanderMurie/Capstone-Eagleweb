/*
Alexander Murie.
Eagleweb, Aug 2018.
Purpose: Drives the Export button (modal), handles open and close triggers (clicks).
*/
var modalexport = document.getElementById('exportModal');
var modalButton = document.getElementById('buttonExport');
var modalCloseButton = document.getElementsByClassName('closeButtonExport')[0];


// Listeners
buttonExport.addEventListener('click', openModal);
modalCloseButton.addEventListener('click', closeModal);
window.addEventListener('click', clickOutside);
//



//openModal() switches the style element "display" to 'block' (from 'none'), which will cause the modal export menu to be shown. 
// It triggers on click of the Export button.
function openModal() { 
	modalexport.style.display = 'block';
}



//closeModal switches the style element "display" to 'none' (after it was changed via openModal()), which will cause the modal export menu to become hidden. 
// It triggers on click of the exit ("x") in the top right corner of modal menus.
function closeModal() {
	modalexport.style.display = 'none';
}

//clickOutside(e) performs the same function as closeModal.
// However, it triggers on click anywhere outside of the modal export menu.
function clickOutside(e) {
	if (e.target == modalexport){
		modalexport.style.display = 'none';
	}
}