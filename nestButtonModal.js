// Get modal element
var modalnest = document.getElementById('nestModal');
// get open
var modalButton = document.getElementById('buttonNest');
// get close
var modalCloseButton = document.getElementsByClassName('closeButtonNest')[0];

// listen for open click
buttonNest.addEventListener('click', openModal);

//listen for close click
modalCloseButton.addEventListener('click', closeModal);

// listen for outside click

window.addEventListener('click', clickOutside);

//function to open modal



function openModal() {
	modalnest.style.display = 'block';
}

function closeModal() {
	modalnest.style.display = 'none';
}

function clickOutside(e) {
	if (e.target == modalnest){
		modalnest.style.display = 'none';
	}
}