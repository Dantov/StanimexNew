"use strict";

Node.prototype.remove = function() {  // - полифил для elem.remove(); document.getElementById('elem').remove();
	this.parentElement.removeChild(this);
	}; 
	
var add = document.getElementById('add');
var form_webuy = document.getElementById('form_webuy');
var txtAreas = form_webuy.querySelectorAll('.form-control') || 0;


var uplF = 0 || txtAreas.length;

add.addEventListener('click', function(){
	
	var count = document.getElementById('count');
	var txtAreaProto = document.getElementById('txtArea_proto');
	var nxt = document.getElementById('nxt');
	
	var newTXTrow = txtAreaProto.cloneNode(true);
	var form_webuy = document.getElementById('form_webuy');
	newTXTrow.setAttribute('class','col-xs-12');
	newTXTrow.children[0].lastElementChild.setAttribute('id','descr' + ++uplF);
	newTXTrow.children[0].lastElementChild.setAttribute('name','webuy' + uplF);
	
	newTXTrow.children[0].children[0].innerHTML = uplF;
	newTXTrow.children[1].setAttribute('name','this' + uplF);
	
	form_webuy.insertBefore(newTXTrow, nxt);
	count.setAttribute('value', uplF);
    });



