"use strict";

function ImageViewer( shipmentsBlock )
{
    if ( !shipmentsBlock )
        return;

    this.shipmentsBlock = shipmentsBlock;
    this.machineName = null;
    this.showImageModal = null;

    this.init();
}

ImageViewer.prototype.init = function()
{
    this.showImageModal = document.querySelector('#ShowImageModal');
    if ( !this.showImageModal ) return;

    this.addListeners();

    let that = this;
    $('#ShowImageModal').on('hidden.bs.modal', function (e) {
        that.showImageModal.querySelector('.carousel-inner').innerHTML ="";
        that.showImageModal.querySelector('.carousel-indicators').innerHTML ="";
    })

};

ImageViewer.prototype.addListeners = function()
{
    let that = this;

    this.shipmentsBlock.addEventListener('click',function (e) {
        if ( !e.path ) return;

        let id,images,name;
        let elems = e.path;

        for ( let i = 0; i < elems.length; i++ )
        {
            if ( !elems[i].classList ) continue;
            if ( elems[i].classList.contains('openImgModal') )
            {
                name = elems[i].getAttribute('data-shipment-name');
                images = elems[i].getAttribute('data-shipment-images').split('-;!');
                id = elems[i].getAttribute('data-shipment-id');
                break;
            }
        }
        if ( !id ) return;

        that.showImageModal.querySelector('.modal-title').innerHTML = name;
        that.setCarousel(id, images);

        $('#ShowImageModal').modal('show');

        debug(id);
        debug(images);
    });
};
ImageViewer.prototype.setCarousel = function(id, images)
{
    let that = this;
    let c_indicators = this.showImageModal.querySelector('.carousel-indicators');

    $.each(images, function(k, image) {
        let slideLI = that.showImageModal.querySelector('.protoLI').cloneNode(true);
            slideLI.setAttribute('data-slide-to',k);
            slideLI.setAttribute('class', k===0?"active":"" );

        c_indicators.appendChild(slideLI);
    });

    let carouselInner = this.showImageModal.querySelector('.carousel-inner');
    $.each(images, function(k, image) {
        let slide = that.showImageModal.querySelector('.itemProto').cloneNode(true);
            slide.setAttribute('class', k===0?"item active":"item" );

        slide.querySelector('img').src = "/web/shipments/" + image;

        carouselInner.appendChild(slide);
    });

};


let imageViewer = new ImageViewer( document.querySelector('.shipmentsBlock') );



