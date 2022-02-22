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


function Orders( orderButton ) {
    if ( orderButton )
    {
        this.orderButton = orderButton;
        this.init();
    }

    this.sendButton = null;
}

Orders.prototype.init = function()
{
    if ( !this.orderButton )
        return;

    this.ordersModal = document.querySelector('#ShowOrderModal');
    if ( !this.ordersModal ) return;

    this.ordersModal.querySelector('.modal-title').innerHTML += imageViewer.machineName;
    this.sendButton = this.ordersModal.querySelector('.subbtn');

    this.addListeners();

    //console.log(this.images);
    //console.log(this.showImageModal);
};

Orders.prototype.addListeners = function()
{
    this.orderButton.addEventListener('click', function () {
        $('#ShowOrderModal').modal('show');
    });

    let that = this;
    this.sendButton.addEventListener('click', function () {

        let form = that.ordersModal.querySelector('form');
        let formData = new FormData( form );

        $.ajax({
            url: '/orders',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(resp)
            {
                resp = JSON.parse(resp);
                if ( resp.debug ) debug(resp.debug);

                if ( resp.ok )
                {
                    debug("OK");

                    that.ordersModal.querySelector('#send_order_form').remove();
                    that.ordersModal.querySelector('#orderOK').classList.remove('hidden');
                }

                if ( resp.errors )
                {
                    debug(resp.errors);
                }
            },
            error: function(e)
            {
                alert('Ошибка! Попробуйте снова.');
                console.log(e);
            }
        });

    });
};

let orders = new Orders( document.querySelector('#makeOrder') );



