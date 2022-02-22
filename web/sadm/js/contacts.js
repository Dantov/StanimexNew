
let add = document.getElementById('addContact');

add.addEventListener('click',function(){
    let vali_form = document.getElementById('vali_form');
    
    let newrow = document.querySelector('.protorow').cloneNode(true);
    newrow.classList.remove('hidden');
    newrow.classList.remove('protorow');
    newrow.children[0].children[2].name = "contacts_en_new[name][]";
    newrow.children[0].children[4].name = "contacts_en_new[descr][]";
    newrow.children[2].children[0].name = "contacts_en_new[img][]";
    
    vali_form.appendChild(newrow);
});

function removePos(self)
{
    self.parentElement.parentElement.parentElement.remove();
}

function removePosfromServ(self,id)
{
    let conf = confirm('Удалить блок?');
    if ( conf )
    {
        $.ajax({
            url: _ROOT_ + '/almadmin/contacts',
            data: {
                removeposId: id,
            },
            type: 'POST',
            dataType: 'json',
            success: function(res)
            {
                if ( res.ok ) self.parentElement.parentElement.parentElement.remove();
            },
            error: function()
            {
                alert('Ошибка! Попробуйте снова.');
            }
        });
    }
}

