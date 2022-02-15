"use strict";

function ImageViewer( machineName )
{

    this.machineName = machineName;
    this.showImageModal = null;
    this.images = null;

    this.init();
}

ImageViewer.prototype.init = function()
{
    this.images = document.querySelectorAll('.machinePicture');
    this.showImageModal = document.querySelector('#ShowImageModal');

    if ( !this.images ) return;
    if ( !this.showImageModal ) return;

    this.showImageModal.querySelector('.modal-title').innerHTML = this.machineName;

    this.addListeners();

    //console.log(this.images);
    //console.log(this.showImageModal);
};


ImageViewer.prototype.addListeners = function()
{
    let modalImg = this.showImageModal.querySelector('img');

    $.each(this.images, function(id, image) {

        image.addEventListener('click', function () {
            //modalImg.src = image.src;

            let dataNum = this.getAttribute('data-num');
            $('#ShowImageModal').modal('show');

            let c = $('.carousel');
                c.carousel(+dataNum);
                c.carousel('pause');
        })
    });
};
ImageViewer.prototype.onLoad = function()
{
    /*
    //let allImages = document.querySelectorAll('.machinePicture');
    $.each(this.images, function(id, image) {

        image.onload = function (e) {
            this.classList.remove('hidden');
            this.previousElementSibling.classList.add('hidden');
            console.log(this);
        };
        console.log("loaded123");
    });
    */
};
let imageViewer = new ImageViewer( document.querySelector('#topName').innerHTML );


//imageViewer.onLoad();
