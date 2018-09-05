/*
Alexander Murie.
Eagleweb, Aug 2018.
Purpose: Drives the Generate button (modal), handles open and close triggers (clicks).
*/





var modalgen = document.getElementById('genModal');
var modalButton = document.getElementById('buttonGenerate');
var modalCloseButton = document.getElementsByClassName('closeButtonGen')[0];



// Listeners
buttonGenerate.addEventListener('click', openModal);
modalCloseButton.addEventListener('click', closeModal);
window.addEventListener('click', clickOutside);
//


//openModal() switches the style element "display" to 'block' (from 'none'), which will cause the modal Generate menu to be shown. 
// It triggers on click of the Generate button.
function openModal() {
	modalgen.style.display = 'block';
}

//closeModal switches the style element "display" to 'none' (after it was changed via openModal()), which will cause the modal Generate menu to become hidden. 
// It triggers on click of the exit ("x") in the top right corner of modal menus.
function closeModal() {
	modalgen.style.display = 'none';
}


//clickOutside(e) performs the same function as closeModal.
// However, it triggers on click anywhere outside of the modal Generate menu.
function clickOutside(e) {
	if (e.target == modalgen){
		modalgen.style.display = 'none';
	}
}