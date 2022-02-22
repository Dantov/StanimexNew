
let add = document.getElementById('add_img');

document.getElementById('add_img').addEventListener('click',function (){

    let newImgrow = document.querySelector('.protorow').cloneNode(true);
    let uploadInput = newImgrow.children[0];

    uploadInput.click();

    uploadInput.onchange = function() { // запускаем по событию change
        preview(this.files[0]);
    };

    function preview(file) {
        //вставляем новые
        let reader = new FileReader();

        reader.addEventListener("load", function(event) {

            newImgrow.classList.remove('protorow');
            newImgrow.classList.remove('hidden');
            newImgrow.children[0].name = "shipments_new[]";
            newImgrow.children[1].lastElementChild.name = "shipments_new[descr][]";

            let imgPrewiev = newImgrow.children[1].firstElementChild;
            let srcPrew = event.target.result;
            imgPrewiev.setAttribute('src', srcPrew);

            // вставляем картинку только после всех изменений
            document.getElementById('griid').insertBefore(newImgrow, document.getElementById('insBef'));

        });

        reader.readAsDataURL(file);
    }

} );

function removePos(self)
{
    self.parentElement.parentElement.remove();
}

function removePosfromServ(self,id)
{
    let conf = confirm('Удалить картинку?');
    if ( conf )
    {
        $.ajax({
            url: _ROOT_ + '/almadmin/shipments',
            data: {
                removeposId: id,
            },
            type: 'POST',
            dataType: 'json',
            success: function(res)
            {
                if ( res.ok ) self.parentElement.parentElement.remove();
            },
            error: function()
            {
                alert('Ошибка! Попробуйте снова.');
            }
        });
    }
}



