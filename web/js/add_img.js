"use strict"

Node.prototype.remove = function() {  // - полифил для elem.remove(); document.getElementById('elem').remove();
	this.parentElement.removeChild(this);
	}; 
	
var add_img = document.getElementById('add_img');
var picts = document.getElementById('picts');
var image_rows = picts.querySelectorAll('.image_row') || 0;

var renewdate = document.getElementById('renewdate') || null;

var imgrowProto = document.querySelector('.image_row_proto');
var uplF = 0 || image_rows.length;

if ( renewdate ) {
  renewdate.addEventListener('click', function(){
	
	var date = document.getElementById('date');
	var today = new Date();
	var year = today.getFullYear();
	var month = today.getMonth();
	var day = today.getDate();
	month++;
	date.value = year + '-' + month + '-' + day;
	date.previousElementSibling.innerHTML = day + '.' + month + '.' + year;
	
  });
};

add_img.addEventListener('click', function(){
	
	var img_count = document.getElementById('img_count');
	var add_img = document.getElementById('add_img');
	var newImgrow = imgrowProto.cloneNode(true);
	var picts = document.getElementById('picts');
	
	newImgrow.setAttribute('class','image_row');
	newImgrow.setAttribute('id','img_' + uplF);
	newImgrow.children[0].setAttribute('name','upload_file_img' + uplF++);
	newImgrow.children[2].setAttribute('name','img_row_id_' + uplF);
	
	picts.insertBefore(newImgrow, add_img);
	
	img_count.setAttribute('value',uplF);
    });

var makeHot = document.getElementById('makeHot');
var makeSold = document.getElementById('makeSold');

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
		
		makeHot.value = 'Удалить Хот';
	    makeHot.setAttribute('class','btn btn-default');
	}
	if ( sold.value < 0 ) {
		var span = document.createElement('span');
		
	    span.setAttribute('class','label label-danger hotLable');
		span.setAttribute('id','spansold');
	    span.innerHTML = 'SOLD';
		
		topName.appendChild(span);
		makeSold.value = 'Удалить SOLD';
	    makeSold.setAttribute('class','btn btn-default');
	}
	
}

makeHot.addEventListener('click', function() {
	
	var topName =  document.getElementById('topName');
	var hot = document.getElementById('hot');
	
	if ( hot.value == 0 ) { //если нет хот - ставим его
	
	    hot.setAttribute('value', 1);
		
		var span = document.createElement('span');
		var spanfire = document.createElement('span');
		spanfire.setAttribute('class','glyphicon glyphicon-fire');
		
	    span.setAttribute('class','label label-success hotLable');
		span.setAttribute('id','spanhot');
	    var stext = document.createTextNode(' HOT');
		
		span.appendChild(spanfire);
		span.appendChild(stext);
	    
	    topName.appendChild(span);
		
	    makeHot.value = 'Удалить Хот';
	    makeHot.setAttribute('class','btn btn-default');
		return;
	}
	if ( hot.value > 0 ) { //если поставлен хот - убираем его
		hot.setAttribute('value', 0);
		var spanHot = topName.querySelector('#spanhot');
		spanHot.remove();

	    makeHot.value = 'Сделать HOT';
	    makeHot.setAttribute('class','btn btn-success');
		return;
	}
	
    });
	
makeSold.addEventListener('click', function() {
	
	var topName =  document.getElementById('topName');
	var sold = document.getElementById('sold');
	
	if ( sold.value == 0 ) {//если нет sold - ставим его
		var span = document.createElement('span');
	    var h4 = document.createElement('h4');
		
		sold.setAttribute('value', -1);
	    span.setAttribute('class','label label-danger hotLable');
		span.setAttribute('id','spansold');
	    span.innerHTML = 'SOLD';
	
	    topName.appendChild(span);
	    makeSold.value = 'Удалить SOLD';
	    makeSold.setAttribute('class','btn btn-default');
		return;
	}
	if ( sold.value < 0 ) {//если поставлен sold - убираем его
		sold.setAttribute('value', 0);
		var spanSold = topName.querySelector('#spansold');
		spanSold.remove();

	    makeSold.value = 'Сделать SOLD';
	    makeSold.setAttribute('class','btn btn-danger');
		return;
	}
	
    });
