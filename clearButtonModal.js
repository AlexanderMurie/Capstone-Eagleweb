// Get modal element
var modalclear = document.getElementById('clearModal');
// get open
var modalButton = document.getElementById('buttonClear');
// get close
var modalCloseButton = document.getElementsByClassName('closeButtonClear')[0];

// listen for open click
buttonClear.addEventListener('click', openModal);

//listen for close click
modalCloseButton.addEventListener('click', closeModal);

// listen for outside click

window.addEventListener('click', clickOutside);

//function to open modal



function openModal() {
	modalclear.style.display = 'block';
}

function closeModal() {
	modalclear.style.display = 'none';
}

function clickOutside(e) {
	if (e.target == modalclear){
		modalclear.style.display = 'none';
	}
}