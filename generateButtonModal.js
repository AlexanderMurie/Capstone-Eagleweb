// Get modal element
var modalgen = document.getElementById('genModal');
// get open
var modalButton = document.getElementById('buttonGenerate');
// get close
var modalCloseButton = document.getElementsByClassName('closeButtonGen')[0];

// listen for open click
buttonGenerate.addEventListener('click', openModal);

//listen for close click
modalCloseButton.addEventListener('click', closeModal);

// listen for outside click

window.addEventListener('click', clickOutside);

//function to open modal



function openModal() {
	modalgen.style.display = 'block';
}

function closeModal() {
	modalgen.style.display = 'none';
}

function clickOutside(e) {
	if (e.target == modalgen){
		modalgen.style.display = 'none';
	}
}