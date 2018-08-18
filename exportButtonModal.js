// Get modal element
var modalexport = document.getElementById('exportModal');
// get open
var modalButton = document.getElementById('buttonExport');
// get close
var modalCloseButton = document.getElementsByClassName('closeButtonExport')[0];

// listen for open click
buttonExport.addEventListener('click', openModal);

//listen for close click
modalCloseButton.addEventListener('click', closeModal);

// listen for outside click

window.addEventListener('click', clickOutside);

//function to open modal



function openModal() {
	modalexport.style.display = 'block';
}

function closeModal() {
	modalexport.style.display = 'none';
}

function clickOutside(e) {
	if (e.target == modalexport){
		modalexport.style.display = 'none';
	}
}