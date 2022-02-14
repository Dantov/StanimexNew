"use strict";
putsort();
function putsort() {
	
	var sorttype = document.getElementById('sorttype');
	var sorttype_str = sorttype.value.toLowerCase();
	
	var arr = sorttype_str.split(' ');

	var span = document.createElement('span');
	span.setAttribute('class','glyphicon glyphicon-ok-sign');
	
	if ( arr[7] == 'date' ) {
		var to_sort = document.getElementById('sortdate');
		to_sort.setAttribute('class','minusMargbottom well well-sm');
		//to_sort.insertBefore( span, to_sort.firstChild );
	}
	if ( arr[7] == 'id' ) {
		var to_sort = document.getElementById('sortdef');
		to_sort.setAttribute('class','minusMargbottom well well-sm');
		//to_sort.insertBefore( span, to_sort.firstChild );
	}
	if ( arr[7] == 'hot' ) {
		var to_sort = document.getElementById('sorthot');
		to_sort.setAttribute('class','minusMargbottom well well-sm');
		//to_sort.insertBefore( span, to_sort.firstChild );
	}
	if ( arr[7] == 'sold' && arr[8] == 'asc' ) {
		var to_sort = document.getElementById('sortsold');
		to_sort.setAttribute('class','minusMargbottom well well-sm');
		//to_sort.insertBefore( span, to_sort.firstChild );
	}
	if ( arr[7] == 'sold' && arr[8] == 'desc' ) {
		var to_sort = document.getElementById('sortsolddown');
		to_sort.setAttribute('class','minusMargbottom well well-sm');
		//to_sort.insertBefore( span, to_sort.firstChild );
	}
	
}