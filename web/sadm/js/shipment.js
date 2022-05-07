"use strict";

if ( document.getElementById('add_img') )
{

    document.getElementById('add_img').addEventListener('click',function () {

        let uploadInput = document.querySelector('.uploadImagesInput');

        uploadInput.click();
        uploadInput.onchange = function() {
            console.log(this.files);

            let machineForm = document.createElement('form');
            machineForm.setAttribute('enctype',"multipart/form-data");

            let shipmentID = document.getElementById('shipmentID').value;
            let formData = new FormData( machineForm );
            formData.append('shipmentID', shipmentID);

            $.each(this.files, function (i, file) {
                formData.append('images[]',file);
            });

            $.ajax({
                url: '/stan-admin/shipment/' . shipmentID,
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                //dataType: 'json',
                beforeSend: function()
                {
                    $('#uploadImgModal').modal({
                        keyboard: false,
                        backdrop: 'static',
                    });
                },
                success: function(resp)
                {
                    resp = JSON.parse(resp);
                    console.log(resp);

                    if ( resp.debug )
                        console.log(resp.debug);

                    if ( resp.files )
                    {
                        // $.each(resp.files, function (i, file) {
                        //     preview(file, i);
                        // });
                        reload();
                        $('#uploadImgModal').modal('hide');
                    }

                    if ( resp.errors )
                    {
                        $('#uploadImgModal').modal('hide');
                        alert(resp.errors);
                    }
                },
                error: function(e)
                {
                    $('#uploadImgModal').modal('hide');
                    alert('Ошибка! Попробуйте снова.');
                    console.log(e);
                }
            });

        };
    });
}

function preview(file, i) {

    let newImgRow = document.querySelector('.protoImgRow').cloneNode(true);
    newImgRow.classList.remove('protoImgRow');
    newImgRow.classList.remove('hidden');
    newImgRow.setAttribute('data-file-id', i);

    let imgTag = newImgRow.querySelector('img');
    imgTag.setAttribute('src', file);

    // вставляем картинку только после всех изменений
    let add_bef_this = document.getElementById('add_bef_this');

    document.getElementById('picts').insertBefore(newImgRow, add_bef_this);
}

function dellImgPreview(self)
{
    let dell = confirm('Удалить превью?');

    if ( !dell ) return;

    let fileID = +self.parentElement.getAttribute('data-file-id');
    let _Files = document.querySelector('.uploadImagesInput').files;
    //console.log(_Files);
    $.each(_Files, function (i, file) {
        if ( i === fileID )
            console.log(file);
    });

    //self.parentElement.remove();
}

function removeImgFromPos(self, rowID, imgName)
{
    let dell = confirm('Убрать картинку из этой позиции?');
    if ( !dell ) return;

    $.ajax({
        url: '/stan-admin/delete',
        data: {
            rowID: rowID,
            removeImageSp: imgName,
        },
        type: 'POST',
        dataType: 'json',
        success: function(res)
        {
            if ( res.debug )
                console.log(res.debug);

            if ( res.ok )
                self.parentElement.remove();

            if ( res.error )
                alert('Ошибка при удалении. Попробуйте позже.');
        },
        error: function(e)
        {
            alert('Ошибка! Попробуйте снова.');
            console.log(e);
        }
    });

}

function dellPosition(id)
{
    let dell = confirm('Удалить позицию целиком?');

    if (!dell) return;

    location.href = '/stan-admin/deleteshipment/' + id;
}