"use strict";

function StanSlider( wrapper )
{
    this.debug = {};
    if ( !(wrapper instanceof HTMLElement) )
    {
        this.debug.wrapper = "Wrong warpper found!";
        return;
    }

    this.initialized = false;

    this.wrapper = wrapper;
    this.pauseButton = this.wrapper.querySelector('#pause');
    this.nextButton = this.wrapper.querySelector('#next');
    this.previousButton = this.wrapper.querySelector('#previous');

    this.currentSlide = randomInteger(0, 5);
    this.playing = false;
    this.slideInterval = false;

    this.init();
}
StanSlider.prototype.init = function () {

    if ( this.initialized )
        return;
    this.initialized = true;

    this.initImages(_sliderImages_);


    this.wrapper.classList.add('slide' + this.currentSlide);
    this.wrapper.setAttribute('data-current-slide','slide' + this.currentSlide);

    let that = this;
    this.pauseButton.addEventListener("click",function () {

        if ( that.playing ) {
            that.pause();
            return;
        }
        that.play();

    },false);
    this.nextButton.addEventListener("click",function () {
        that.pause();
        that.changeSlide("next");
    },false);
    this.previousButton.addEventListener("click",function () {
        that.pause();
        that.changeSlide("previous");
    },false);

    this.debug.init = "--ok!";
    debug(this.debug,"Stanimex Slider");
};
StanSlider.prototype.initImages = function(_sliderImages_) {

    if ( typeof _sliderImages_ !== 'object' )
        return;

    let imagesLoaded = new Array(_sliderImages_.length);
    for ( let i = 0; i < _sliderImages_.length; i++ )
    {
        imagesLoaded[i] = new Image(); // создаем картинку
        imagesLoaded[i].src = "/web/img/sliderImages/" + _sliderImages_[i];
        imagesLoaded[i].onload = function() {
            //imagesLoaded[i] = "Image " + _sliderImages_[i] + " is loaded!";
            //debug("Image " + imagesLoaded[i].src + " is loaded!");
        };
    }
    //debug(imagesLoaded);
};
StanSlider.prototype.play = function (slideInterval)
{
    this.pauseButton.innerHTML = '&#10074;&#10074;'; // pause character
    this.run(slideInterval);
};
StanSlider.prototype.pause = function ()
{
    this.playing = false;
    this.pauseButton.innerHTML = '&#9658;'; // play character
    clearInterval(this.slideInterval);
};
StanSlider.prototype.changeSlide = function ( whatSlide = "next", slideNumber )
{
    let that = this;
    if ( !slideNumber )
        slideNumber = this.currentSlide;

    switch (whatSlide)
    {
        case "next":
            goToSlide(slideNumber+1);
            break;
        case "previous":
            goToSlide(slideNumber-1);
            break;
        case "goto":
            goToSlide(slideNumber);
            break;
    }

    function goToSlide(n)
    {
        that.currentSlide = (n+6)%6;

        that.wrapper.classList.remove(that.wrapper.getAttribute('data-current-slide'));
        that.wrapper.classList.add('slide' + that.currentSlide);
        that.wrapper.setAttribute('data-current-slide','slide' + that.currentSlide);
    }
};
StanSlider.prototype.run = function ( slideInterval )
{
    if ( !slideInterval )
        slideInterval = 10000;

    this.playing = true;
    let that = this;
    this.slideInterval = setInterval(function () {
        that.changeSlide("next");
    }, slideInterval);
};
StanSlider.prototype.open = function ()
{
    this.wrapper.classList.remove('slidr-small');
};
StanSlider.prototype.carouselDeSync = function ()
{
    let carousels = this.wrapper.querySelectorAll('.carousel');

    let ms = [1000,2000,2500,3000,3500];

    $.each(carousels, function (i,carousel) {
        $(carousel).carousel({
            interval: 5000,
        });

        $(carousel).carousel('pause');

        setTimeout(function () {
            $(carousel).carousel('cycle');
        },ms[randomInteger(0,4)]);
    });
};


let stanSlider = new StanSlider( document.getElementById('slidr') );
stanSlider.play(50);
setTimeout(function () {
    stanSlider.carouselDeSync();
    stanSlider.pause();
    stanSlider.open();
    stanSlider.play(30000);
},500);