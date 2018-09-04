// Get modal element
var modalmegan = document.getElementById('meganModal');
// get open
var modalButton = document.getElementById('buttonMegan');
// get close
var modalCloseButton = document.getElementsByClassName('closeButtonArea')[0];

// listen for open click
buttonModal.addEventListener('click', openModal);

//listen for close click
modalCloseButton.addEventListener('click', closeModal);

// listen for outside click

window.addEventListener('click', clickOutside);

//function to open modal



function openModal() {
	modalmegan.style.display = 'block';
}

function closeModal() {
	modalmegan.style.display = 'none';
}

function clickOutside(e) {
	if (e.target == modalmegan){
		modalmegan.style.display = 'none';
	}
}