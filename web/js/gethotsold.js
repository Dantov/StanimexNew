"use strict"
window.onload = function() {

identifyHotSold();

function identifyHotSold() {
	var hot = document.getElementById('hot');
    var sold = document.getElementById('sold');
	var topName =  document.getElementById('topName');
	
	if ( hot.value > 0 ) {
		var span = document.createElement('span');
	    
		var spanfire = document.createElement('span');
		spanfire.setAttribute('class','glyphicon glyphicon-fire');
		
	    span.setAttribute('class','label label-success hotLable');
		span.setAttribute('id','spanhot');
		
	    var stext = document.createTextNode(' HOT');
		
		span.appendChild(spanfire);
		span.appendChild(stext);
		
		topName.appendChild(span);
	}
	if ( sold.value < 0 ) {
		var span = document.createElement('span');
	    var h4 = document.createElement('h4');
		
	    span.setAttribute('class','label label-danger hotLable');
		span.setAttribute('id','spansold');
	    span.innerHTML = 'ПРОДАН';
		
		topName.appendChild(span);
	}
  }
}



