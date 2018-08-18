// Get modal element
var modalarea = document.getElementById('areaModal');
// get open
var modalButton = document.getElementById('buttonArea');
// get close
var modalCloseButton = document.getElementsByClassName('closeButtonArea')[0];

// listen for open click
buttonArea.addEventListener('click', openModal);

//listen for close click
modalCloseButton.addEventListener('click', closeModal);

// listen for outside click

window.addEventListener('click', clickOutside);

//function to open modal



function openModal() {
	modalarea.style.display = 'block';
}

function closeModal() {
	modalarea.style.display = 'none';
}

	if (e.target == modalarea){
		modalarea.style.display = 'none';
	}
}