"use strict";
	
let add = document.getElementById('addWebuy');
let addBeforeThis = document.getElementById('addBeforeThis');
let webuy_form = document.getElementById('webuy_form');


add.addEventListener('click', function() {
	
	let newRow = document.getElementById('protorow').cloneNode(true);

		//newRow.children[0].lastElementChild.setAttribute('name','webuy' + uplF);

    webuy_form.insertBefore(newRow, addBeforeThis);

});



