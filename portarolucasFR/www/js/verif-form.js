// error variables
var UserError = true,
    EmailError = true,
    VerifError = true,
    SubError = true,
    MsgError = true;

$(function () {

    $("#_name-tb").blur(function () {

        if ($(this).val() === '') {

            $(this).closest('.tb-contact').css('border', '1px solid #F00');
            //$(this).parent().find('.custom-alert').fadeIn(300);
            UserError = true;
        } else {

            $(this).closest('.tb-contact').css('border', '1px solid #080');
            //$(this).parent().find('.custom-alert').fadeOut(300);

            UserError = false;
        }
    });


    $("#_mail-tb").blur(function () {

        if ($(this).val() === '') {

            $(this).closest('.tb-contact').css('border', '1px solid #F00');
            //$(this).parent().find('.custom-alert').fadeIn(300);
            EmailError = true;
        } else {

            $(this).closest('.tb-contact').css('border', '1px solid #080');
            //$(this).parent().find('.custom-alert').fadeOut(300);

            EmailError = false;
        }
    });

    $("#_verifBot-C6").blur(function () {

        if ($(this).val() === '') {

            $(this).closest('.tb-contact').css('border', '1px solid #F00');
            //$(this).parent().find('.custom-alert').fadeIn(300);
            VerifError = true;
        } else {

            $(this).closest('.tb-contact').css('border', '1px dashed #080');
            //$(this).parent().find('.custom-alert').fadeOut(300);

            VerifError = false;
        }
    });


    $("#_subject-tb").blur(function () {

        if ($(this).val() === '') {

            $(this).closest('.tb-contact').css('border', '1px solid #F00');
            //$(this).parent().find('.custom-alert').fadeIn(300);
            SubError = true;
        } else {


            $(this).closest('.tb-contact').css('border', '1px solid #080');
            //$(this).parent().find('.custom-alert').fadeOut(300);

            SubError = false;
        }
    });


    $("#_message-tb").blur(function () {

        if ($(this).val().length < 5) {

            $(this).closest('.tb-contact').css('border', '1px solid #F00');
            //$(this).parent().find('.custom-alert').fadeIn(300);
            MsgError = true;
        } else {

            $(this).closest('.tb-contact').css('border', '1px solid #080');
            //$(this).parent().find('.custom-alert').fadeOut(300);
            MsgError = false;
        }
    });
})
