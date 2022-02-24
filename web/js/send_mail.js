"use strict";

function MailSender( formTag )
{
	this.formTag = formTag;
	if ( !this.formTag )
		return;

    this.alertOK = document.querySelector('.alertOKSend');
    this.alertErrors = document.querySelector('.alertErrorSend');

    this.sendMailButton = this.formTag.querySelector('.sendMail');

	this.init();
}

MailSender.prototype.init = function () {

    if ( !this.sendMailButton ) return;
    let that = this;

    this.sendMailButton.addEventListener('click',function () {
    	that.send();
    });

    debug("MailSender init");
};

MailSender.prototype.send = function () {

    let that = this;
    let formData = new FormData( this.formTag );
    	formData.append('contactMail',"1");
    	formData.append('phone',"0-0-0");

    $('.sendMail').button('loading');

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
                that.alertOK.classList.remove('hidden');
                that.sendMailButton.classList.add('hidden');

                //$('.sendMail').button('reset');
            }

            if ( resp.errors )
            {
                let someErrors = that.alertErrors.querySelector('.alert-link');
                someErrors.innerHTML = "";
                $.each(resp.errors, function(fieldName, errors) {
                    $.each(errors, function(i, errorText) {
                        someErrors.innerHTML += "<span>"+ errorText +"</span>";
                    });
                    someErrors.innerHTML += "<br/>";
                });
                that.alertErrors.classList.remove('hidden');
                debug(resp.errors);

                $('.sendMail').button('reset');
            }
        },
        error: function(e)
        {
            alert('Ошибка! Попробуйте снова.');
            console.log(e);
        }
    });

};

let mails = new MailSender( document.querySelector('#send_mail_form') );