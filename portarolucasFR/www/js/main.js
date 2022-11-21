function disableScroll() {
    // Get the current page scroll position
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,

        // if any scroll is attempted, set this to the previous value
        window.onscroll = function() {
            window.scrollTo(scrollLeft, scrollTop);
        };
}

function enableScroll() {
    window.onscroll = function() {};
}
/*
var oneOfLoaded = false;

$('<img style="display: none;"/>').attr('src', './img/content_1/banner_header.jpg').on('load', function()
{
    $(this).remove();
    //$('header').css('background-image', "url('./img/banner_header.png')");
    if(oneOfLoaded)
    {
        $('#body_loaded').css('display', 'block');
        $('#loaderAnim').css('display', 'none');
        var elem = document.getElementById('body_loaded');
        var actually = 0;
        function transition()
        {
            if(actually < 1)
            {
                actually += 0.1;
                elem.style.opacity = actually;
                setTimeout(transition, 50);
            }
        }
        transition();
    }
    oneOfLoaded = true;
});
*/

$(window).on('load', function () {
    $( '#_loadingContent' ).animate({
        opacity: 0
    }, 1500, function(){
        $( '#_loadingContent' ).css('display', 'none');
        $('body').css('overflow', 'initial');
        $( '#_loadedContent' ).css('display', 'block');
        $( '#_loadedContent' ).css('opacity', '1');
        loadingEffect();
        changeText();
        $('#_streetVid').attr('poster', 'img/content_5/street_view.png');
        $('#_streetVid source').attr('src', 'img/content_5/street_view.mp4');//load video quand le chargement de la page est fini + faster loading
        $("#_streetVid")[0].load();
        $("#_streetVid")[0].play();
    });
});

$(document).ready(function () {
    const btnUPOpacity = $('#_goUp').css('opacity');
    $('#_goUp').css('opacity', '0');

    $('a[href^="#"]').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
            $target = $(target);

        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            //window.location.hash = target;
        } );
    } );

    //navigation && goUp
    var btnUPOpen = false;
    $(window).on("scroll", function () {
        if($(window).scrollTop() >= 20){
            $('#_nav').addClass('scrolled');
            $('#_nav li a').removeClass('white');
            $('#_nav li a').addClass('black');
        }
        else{
            $('#_nav').removeClass('scrolled');
            /*$('#_nav').removeClass('open');
            $('#_nav').addClass('close');*/
            $('#_nav li a').removeClass('black');
            $('#_nav li a').addClass('white');
        }
        if(!btnUPOpen && $(window).scrollTop() >= ($(document).height() - 2000)){
            btnUPOpen = true;
            $('#_goUp').css('display', 'block');
            setTimeout(function () {
                $('#_goUp').css('opacity', btnUPOpacity);
            }, 500);
        }
        else if(btnUPOpen && $(window).scrollTop() < ($(document).height() - 2000)){
            btnUPOpen = false;
            $('#_goUp').css('opacity', '0');
            setTimeout(function () {
                $('#_goUp').css('display', 'none');
            }, 500);
        }
    });
    $("#_btnMenuDesk").click(function () {
        if($(this).parents('#_nav.open').length > 0){
            $('#_navExpends').css('display', 'none');
            $('#_nav').removeClass('open').addClass('close');
        }
        else if($(this).parents('#_nav.close').length > 0){
            $('#_navExpends').css('display', 'block');
            $('#_nav').removeClass('close').addClass('open');
        }

    });
    $( "#_createLogo" ).hover(
        function() {
            $("#_createLogo *").addClass( "isHover" );
        }, function() {
            $("#_createLogo *").removeClass( "isHover" );
        }
    );
    $( "#_createLogo" ).click(
        function() {
            $("#_createLogo *").addClass( "isHover" );
            setTimeout(function () {
                $("#_createLogo *").removeClass( "isHover" );
            }, 1000);
        }
    );
    $("#_btnMenu").click(function(){
        if($(this).parents('#_nav.close').length > 0){
            let navExp = $('#_navExpends');
            navExp.css('display', 'block');
            navExp.css('position', 'fixed');

            $('#_nav').removeClass('close').addClass('open');
            openMenu();
            $('body').addClass('stop-scrolling');
            $('body').bind('touchmove', function(e){e.preventDefault()})
        }
        else if($(this).parents('#_nav.open').length > 0){
            closeMenu();
        }
    });
    $('.linkToContact').click(function () {
        setTimeout(function () {
            let heightBtn = $('.big-btn-C6').outerHeight();
            $('.big-btn-C6').css('height', heightBtn + 'px');

            $('.big-btn-C6').css('transform', 'rotateY(180deg)');
            $('.big-btn-C6 h3').css('display', 'none');
            $('.big-btn-C6 h3').css('opacity', '0');

            $('.big-btn-C6').addClass("disable");
            setTimeout(function () {
                $('.big-btn-C6 h6').css('display', 'block');
                $('.big-btn-C6 h6').css('opacity', '1');

                $('.big-btn-C6').removeClass("disable");
            },1400);
            $('#_contactBlock').show(600, function () {
                $('#_contactBlock').css('opacity', '1');
                $('#_name-tb').focus();
            });
            openContactForm = true;
        }, 900);
    });
    $('#_nav a').click(function () {
        if($('#_btnMenuDesk').parents('#_nav.open').length > 0){
            closeMenu();
        }
    });

    //content 2
    $('#_firstCart-C2').mouseenter(function () {
        let leftP = parseInt($('#_firstCart-C2').css("left"));
        if(leftP != 0){
            $(this).css("left", (leftP + 10) + "px");
        }
    });
    $('#_firstCart-C2').mouseleave(function () {
        $(this).removeAttr('style');
    });
    $('#_secondCart-C2').mouseenter(function () {
        let rightP = parseInt($('#_secondCart-C2').css("right"));
        if(rightP != 0){
            $(this).css("right", (rightP + 10) + "px");
        }
    });
    $('#_secondCart-C2').mouseleave(function () {
        $(this).removeAttr('style');
    });

    //content-3
    var lastOpenCircle = false;
    $('.circle-img').click(function(){
        if(!lastOpenCircle){
            lastOpenCircle = this;
            $(this).addClass('circleOpen');
            let elem = this;
            setTimeout(function(){
                $('p', elem).addClass('show');
                $('h3', elem).addClass('show');
            }, 500);

        }
        else{
            if(lastOpenCircle == this){
                lastOpenCircle = false;
                $(this).removeClass('circleOpen');
                $('p', this).removeClass('show');
                $('h3', this).removeClass('show');
            }
            else{
                $(lastOpenCircle).removeClass('circleOpen');
                $('p', lastOpenCircle).removeClass('show');
                $('h3', lastOpenCircle).removeClass('show');

                lastOpenCircle = this;
                $(this).addClass('circleOpen');

                let elem = this;
                setTimeout(function(){
                    $('p', elem).addClass('show');
                    $('h3', elem).addClass('show');
                }, 500);
            }
        }
        $('.circle-img').addClass("disable");
        setTimeout(function(){
            $('.circle-img').removeClass("disable");
        }, 600);
    });

    //content-4
    $('#_showLogi-C4').click(function(){
        changeContentC4('logiciel');
        $("#_skill-C4 .title-domaine .select").removeClass("select");
        $('#_showLogi-C4').addClass("select");

        $('#_skill-C4 .title-domaine h2').addClass("disable");
        setTimeout(function(){
            $('#_skill-C4 .title-domaine h2').removeClass("disable");
        }, 1000);
    });
    $('#_showLang-C4').click(function(){
        changeContentC4('langage');
        $("#_skill-C4 .title-domaine .select").removeClass("select");
        $('#_showLang-C4').addClass("select");

        $('#_skill-C4 .title-domaine h2').addClass("disable");
        setTimeout(function(){
            $('#_skill-C4 .title-domaine h2').removeClass("disable");
        }, 1000);
    });
    $('#_showOutil-C4').click(function(){
        changeContentC4('outil');
        $("#_skill-C4 .title-domaine .select").removeClass("select");
        $('#_showOutil-C4').addClass("select");

        $('#_skill-C4 .title-domaine h2').addClass("disable");
        setTimeout(function(){
            $('#_skill-C4 .title-domaine h2').removeClass("disable");
        }, 1000);
    });

    //content-5
    $('#_prevArrow-C5').click(function () {
        if((actualContentIDC5 - 1) >= 0){
            prevContentC5(actualContentIDC5 - 1);
        }
        else{
            prevContentC5(nbContent - 1);
        }
    });
    $('#_nextArrow-C5').click(function () {
        if((nbContent - 1) >= (actualContentIDC5 + 1)){
            nextContentC5(actualContentIDC5 + 1);
        }
        else{
            nextContentC5(0);
        }
    });

    //content-6
    var openContactForm = false;
    $('.big-btn-C6').click(function () {
        if(!openContactForm){
            let heightBtn = $('.big-btn-C6').outerHeight();
            $('.big-btn-C6').css('height', heightBtn + 'px');

            $('.big-btn-C6').css('transform', 'rotateY(180deg)');
            $('.big-btn-C6 h3').css('display', 'none');
            $('.big-btn-C6 h3').css('opacity', '0');

            $('.big-btn-C6').addClass("disable");
            setTimeout(function () {
                $('.big-btn-C6 h6').css('display', 'block');
                $('.big-btn-C6 h6').css('opacity', '1');

                $('.big-btn-C6').removeClass("disable");
            },1400);
            $('#_contactBlock').show(600, function () {
                $('#_contactBlock').css('opacity', '1');
                $('#_name-tb').focus();
            });
            openContactForm = true;
        }
        else{
            $('.big-btn-C6').css('transform', 'rotateY(0deg)');

            $('.big-btn-C6 h6').css('display', 'none');
            $('.big-btn-C6 h6').css('opacity', '0');

            $('.big-btn-C6').addClass("disable");
            setTimeout(function () {
                $('.big-btn-C6 h3').css('display', 'block');
                $('.big-btn-C6 h3').css('opacity', '1');

                $('.big-btn-C6').removeClass("disable");
                $('.big-btn-C6').removeAttr("style");
            },1400);

            $('#_contactBlock').css('opacity', '0');
            setTimeout(function () {
                $('#_contactBlock').hide(500);
            }, 1000);
            openContactForm = false;
        }
    });
    //random calcul
    var numbersSpi = randomAddition();
    $('#_verifBot-C6').attr("placeholder", numbersSpi[0] + ' + ' + numbersSpi[1] + ' ?');

    //send message
    $('#_sendMessage').click(function () {
        if(UserError === true || EmailError === true || SubError === true || MsgError === true){
            $('#_senderResponse').html('<span style="color: #865757">Erreur rencontrée : Des champs sont manquants, incomplets ou invalides.</span>');
        }
        else{
            if(parseInt($('#_verifBot-C6').val()) === (numbersSpi[0] + numbersSpi[1])){
                sendMail($("#_name-tb").val(), $("#_mail-tb").val(), $("#_subject-tb").val(), $("#_message-tb").val(), numbersSpi[0], numbersSpi[1], parseInt($('#_verifBot-C6').val()));
            }
            else{
                $('#_verifBot-C6').val('').focus();
                $('#_senderResponse').html('<span style="color: #865757">Erreur rencontrée : Champs de vérification invalide, veuillez réessayer..</span>');
            }
        }
    });
});
