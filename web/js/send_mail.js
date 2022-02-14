"use strict";

function validall(self) {
	
	var nV = name_valid();
	var eV = email_valid();
	var sV = subject_valid();
	var mV = message_valid();
	
	if ( nV || eV || sV || mV ) return;

	self.setAttribute('type','submit');
	self.removeAttribute('onclick');
	self.click;
}

function valids( inptStr ) {
	
	function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
	
	function isasllspace( str ) {
		var arr = str.split('');
		for ( var i = 0; i < arr.length; i++ ) {
			if ( arr[i] !== ' ' ) return false;
		}
		return true;
	};
	
	if ( inptStr == '' || isNumeric( inptStr ) ||  isasllspace( inptStr ) ) {
		return true;
	} else {
		return false;
	}
};

function name_valid() {
	var name = document.getElementById('your-name');
	var nameValid = document.getElementById('nameValid');
	
	if ( valids( name.value ) ) {
		nameValid.removeAttribute('class');
		nameValid.innerHTML = "* Не верное имя!";
		return true;
	} else {
		nameValid.innerHTML = "";
		nameValid.setAttribute('class','glyphicon glyphicon-ok-sign');
		return false;
	}
}

function email_valid() {
	var email = document.getElementById('your-email');
	var emailValid = document.getElementById('emailValid');
	
	if ( valids( email.value ) ) {
		emailValid.removeAttribute('class');
		emailValid.innerHTML = "* Не верный Email!";
		return true;
	} else {
		emailValid.innerHTML = "";
		emailValid.setAttribute('class','glyphicon glyphicon-ok-sign');
		return false;
	}
};
function subject_valid() {
	var subject = document.getElementById('your-subject');
	var subjectValid = document.getElementById('subjectValid');
	
	if ( valids( subject.value ) ) {
		subjectValid.removeAttribute('class');
		subjectValid.innerHTML = "* Напишите тему сообщения!";
		return true;
	} else {
		subjectValid.innerHTML = "";
		subjectValid.setAttribute('class','glyphicon glyphicon-ok-sign');
		return false;
	}
};

function message_valid() {
	var message = document.getElementById('your-message');
	var messageValid = document.getElementById('messageValid');
	
	function isasllspace( str ) {
		var arr = str.split('');
		for ( var i = 0; i < arr.length; i++ ) {
			if ( arr[i] !== ' ' ) return false;
		}
		return true;
	};
	
	if ( isasllspace( message.value ) ) {
		messageValid.removeAttribute('class');
		messageValid.innerHTML = "* Напишите сообщение здесь!";
		return true;
	} else {
		messageValid.innerHTML = "";
		messageValid.setAttribute('class','glyphicon glyphicon-ok-sign');
		return false;
	}
};
