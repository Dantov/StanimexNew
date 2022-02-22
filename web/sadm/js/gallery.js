
function removeImg(self, name, folder)
{
    let dell = confirm('Удалить картинку совсем?');

    if ( dell )
    {
        $.ajax({
            url: _ROOT_ + '/almadmin/gallery/remove/1',
            data: {
                name: name,
                folder: folder,
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


