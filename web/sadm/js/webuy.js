"use strict";

let add = document.querySelectorAll('.addWebuy');
let addBeforeThisTop = document.getElementById('addBeforeThisTop');
let addBeforeThisBottom = document.getElementById('addBeforeThisBottom');
let webuy_form = document.getElementById('webuy_form');

$.each(add, function (i, input) {
    input.addEventListener('click', function() {

        let pos = input.getAttribute('data-position');
        $.ajax({
            url: '/stan-admin/webuy',
            data: {
                addNewRow: 1,
            },
            type: 'POST',
            dataType: 'json',
            success: function(resp)
            {
                if ( resp.debug )
                    debug(resp.debug);

                if ( resp.id )
                    drawPos(resp.id, pos);

                if ( resp.errors )
                    alert(resp.errors);
            },
            error: function(e)
            {
                alert('Ошибка! Попробуйте снова.');
                console.log(e);
            }
        });
    });
});

function drawPos(id , position) {
    let newRow = document.querySelector('.protorow').cloneNode(true);
        newRow.classList.remove('hidden');
        newRow.classList.remove('protorow');

    newRow.querySelector('input').setAttribute('onclick','removePos(this,'+ id +')');

    let labels = newRow.querySelectorAll('label');
    let textAreas = newRow.querySelectorAll('textarea');

    $.each(labels, function (i, label) {
        label.for += id;
    });

    $.each(textAreas, function (i, textarea) {
        textarea.id += id;
        textarea.name += id;
    });

    let addBeforeThis = position === 'top' ? addBeforeThisTop : addBeforeThisBottom;

    webuy_form.insertBefore(newRow, addBeforeThis);
}

function removePos(self,id)
{
    let conf = confirm('Удалить позицию');
    if ( conf )
    {
        $.ajax({
            url: '/stan-admin/webuy',
            data: {
                removePosId: id,
            },
            type: 'POST',
            dataType: 'json',
            success: function(res)
            {
                if ( res.ok ) self.parentElement.remove();
                if ( res.errors ) alert(res.errors);
            },
            error: function()
            {
                alert('Ошибка! Попробуйте снова.');
            }
        });
    }
}

