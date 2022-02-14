let slidr_wrapp = document.getElementById('slidr');

let currentSlide = randomInteger(0, 7);
slidr_wrapp.classList.add('slide' + currentSlide);

let slideInterval = setInterval(nextSlide, 4000);

function nextSlide(){
    goToSlide(currentSlide+1);
}
function previousSlide(){
    goToSlide(currentSlide-1);
}
function goToSlide(n){
	
	currentSlide = (n+8)%8;
    slidr_wrapp.className = 'slidr slide' + currentSlide;
	
}


let playing = true;
let pauseButton = document.getElementById('pause');

function pauseSlideshow()
{
    pauseButton.innerHTML = '&#9658;'; // play character
    playing = false;
    clearInterval(slideInterval);
}

function playSlideshow()
{
    pauseButton.innerHTML = '&#10074;&#10074;'; // pause character
    playing = true;
    slideInterval = setInterval( nextSlide, 4000 );
}

pauseButton.onclick = function(){
    if ( playing ) {
    	pauseSlideshow(); 
	} else {
    	playSlideshow(); 
	}
};

let next = document.getElementById('next');
let previous = document.getElementById('previous');

next.onclick = function(){
    pauseSlideshow();
    nextSlide();
};
previous.onclick = function(){
    pauseSlideshow();
    previousSlide();
};


function randomInteger(min, max) {
    let rand = min - 0.5 + Math.random() * (max - min + 1);
    rand = Math.round(rand);
    return rand;
  }

  
  