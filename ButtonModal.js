// Get modal element
var modal = document.getElementById('nestModal');
// get open
var modalButton = document.getElementById('buttonNest');
// get close
var modalCloseButton = document.getElementsByClassName('closeButton')[0];

// listen for open click
buttonNest.addEventListener('click', openModal);

//listen for close click
modalCloseButton.addEventListener('click', closeModal);

// listen for outside click

window.addEventListener('click', clickOutside);

//function to open modal



function openModal() {
	modal.style.display = 'block';
}

function closeModal() {
	modal.style.display = 'none';
}

function clickOutside(e) {
	if (e.target == modal){
		modal.style.display = 'none';
	}
}