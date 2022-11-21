function sendMail(nameSender, mailSender, subject, message, verifNb1, verifNb2, verifRep){
    $.ajax({
        method: "POST",
        url: "./php/sendmail.php",
        data: { nameSender: nameSender, mailSender: mailSender, subject: subject, message: message, verifNb1 : verifNb1, verifNb2 : verifNb2, verifRep : verifRep }
    }).done(function( msg ) {
        $('#_senderResponse').html(msg);
    });
}

function getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
}

function randomAddition(){
    let nb1 = getRandomInt(10);
    let nb2 = getRandomInt(10);
    return [nb1, nb2];
}