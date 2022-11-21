const tabTitles = [
    {
        title: "Portfolio",
        description: "PORTARO Lucas"
    },
    {
        title: "Développeur Web",
        description: "Front & Back End"
    }
];
let titlesIndex = -1;

// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// TweenMax
function loadingEffect() {
    var titleWidth = $('#_title').outerWidth() + $( window ).width();
    var logoWidth = $('#_createLogo').outerWidth() + $( window ).width();

    var tl = new TimelineLite();
    TweenMax.staggerFrom("#_nav", 0.9, {
        delay: 1.4, opacity: 0, height: 0, ease: Expo.easeInOut, clearProps:"all"
    }, 0.2);

    TweenMax.from("#_createLogo", 1, {
        delay: 1,
        opacity: 0,
        x: logoWidth * -1,
        ease: Expo.ease, clearProps:"all"
    })

    TweenMax.staggerFrom("#_nav ul li", 1, {
        delay: 0.6, opacity: 0, y: 20, ease: Expo.easeInOut, clearProps:"all"
    }, 0.2);

    TweenMax.staggerFrom(".barMenu", 1, {
        delay: 0.6, opacity: 0, y: 20, ease: Expo.easeInOut, clearProps:"all"
    }, 0.2);

    tl.from("#_title", 3, {opacity: 0, x: titleWidth * -1, clearProps:"all"});
    tl.from("#_title h2, #_title h1, #_arrowsAnim", 2, {opacity:0, clearProps:"all"}, '-=1');

};

const controller = new ScrollMagic.Controller();

var tlC2 = new TimelineMax();
tlC2.from('#_firstCart-C2', .8, {x: -460, opacity: 0, clearProps:"all"});
tlC2.from('#_secondCart-C2', .8, {x: 260, opacity: 0, clearProps:"all"}, '-=.8');
tlC2.from('#_content2 button', .4, {y: 70, opacity: 0, clearProps:"all"}, '+=0.5');
const sceneC2 = new ScrollMagic.Scene({
    triggerElement: '#_content2',
    reverse: false
}).setTween(tlC2).addTo(controller);

var tlC3 = new TimelineMax();
tlC3.from('.card-C3', .8, {opacity: 0});
tlC3.from('.base-line', 1.2, {width: 0, opacity: 0, clearProps:"width"});
tlC3.staggerFrom('.line', 1, {height: 0, opacity: 0, clearProps:"height"}, 0.16, '-=0.6');
tlC3.from('.circle-img', 0.5, {opacity: 0}, '-=0.4');
const sceneC3 = new ScrollMagic.Scene({
    triggerElement: '#_content3',
    reverse: false
}).setTween(tlC3).addTo(controller);

var tlC4 = new TimelineMax();
tlC4.from('#_content4 h1', .8, {opacity: 0});
tlC4.from('#_skill-C4', 1.5, {opacity: 0}, '-=0.5');
const sceneC4 = new ScrollMagic.Scene({
    triggerElement: '#_content4',
    reverse: false
}).setTween(tlC4).addTo(controller);

var sizeLeftC5 = $('#_left-C5').width();
var sizeRightC5 = $('#_right-C5').width();
var tlC5 = new TimelineMax();
tlC5.from('#_left-C5', 1.5, {x: sizeLeftC5 * -1, opacity: 0});
tlC5.from('#_right-C5', 1.5, {x: sizeRightC5, opacity: 0}, '-=1.5');
const sceneC5 = new ScrollMagic.Scene({
    triggerElement: '#_content5',
    reverse: false
}).setTween(tlC5).addTo(controller);

var tlC6 = new TimelineMax();
tlC6.staggerFrom('.step', 1.2, {
    cycle: {
        y: function (index) {
            if (index % 2 == 0) {
                return 30 * -1;
            } else {
                return 30;
            }
        }
    },
    opacity: 0
    }, 0.2);
const sceneC6 = new ScrollMagic.Scene({
    triggerElement: '#_content6',
    triggerHook: 0.7,
    reverse: false
}).setTween(tlC6).addTo(controller);

const controller2 = new ScrollMagic.Controller();
const anchorC1 = new ScrollMagic.Scene({
    triggerElement: '#_content1',
    reverse: true
}).on('enter', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#' + this.triggerElement().id + '"]').addClass('active');
}).addTo(controller2);
const anchorC2 = new ScrollMagic.Scene({
    triggerElement: '#_content2',
    reverse: true
}).on('enter', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#' + this.triggerElement().id + '"]').addClass('active');
}).on('leave', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#_content1"]').addClass('active');
}).addTo(controller2);
const anchorC4 = new ScrollMagic.Scene({
    triggerElement: '#_content4',
    reverse: true
}).on('enter', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#' + this.triggerElement().id + '"]').addClass('active');
}).on('leave', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#_content2"]').addClass('active');
}).addTo(controller2);
const anchorC5 = new ScrollMagic.Scene({
    triggerElement: '#_content5',
    reverse: true
}).on('enter', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#' + this.triggerElement().id + '"]').addClass('active');
}).on('leave', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#_content4"]').addClass('active');
}).addTo(controller2);
const anchorC6 = new ScrollMagic.Scene({
    triggerElement: '#_content6',
    reverse: true
}).on('enter', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#' + this.triggerElement().id + '"]').addClass('active');
}).on('leave', function () {
    $('#_nav a.active').removeClass('active');
    $('#_nav a[href="#_content5"]').addClass('active');
}).addTo(controller2);

let unOk = false;
function updateText(){
    if(unOk){
        var title = $("#titles_groups h2");
        var desc = $("#titles_groups h1");

        if(tabTitles[titlesIndex + 1]){
            titlesIndex++;
            title.text(tabTitles[titlesIndex].title);
            desc.text(tabTitles[titlesIndex].description);
        }
        else{
            titlesIndex = 0;
            title.text(tabTitles[titlesIndex].title);
            desc.text(tabTitles[titlesIndex].description);
        }
        title.html(title.text().replace(/[0-9a-zA-Z\s-&àâäãçéèêëìîïòôöõùûüñ'-]/g, "<span style='transform: scale(1, 0);transform-origin: top;opacity:0;display: inline-block;'>$&</span>"));
        desc.html(desc.text().replace(/[0-9a-zA-Z\s-&àâäãçéèêëìîïòôöõùûüñ'-]/g, "<span style='transform: scale(1, 0);transform-origin: top;opacity:0;display: inline-block;'>$&</span>"));

        TweenMax.staggerTo("#titles_groups h2 span", 0.4, {scaleY: 1, force3D:true, opacity: titlesOpacity}, 0.1);
        TweenMax.staggerTo("#titles_groups h1 span", 0.4, {scaleY: 1, force3D:true, opacity: titlesOpacity}, 0.1, function () {
            setTimeout(changeText, 5000);
        });
        unOk = false;
    }
    else{
        unOk = true;
    }
}

function changeText(){
    TweenMax.staggerTo("#titles_groups h2 span", 0.4, {scaleY: 0, force3D:true, opacity: 0}, 0.1, function(){
        updateText();
    });

    TweenMax.staggerTo("#titles_groups h1 span", 0.4, {scaleY: 0, force3D:true, opacity: 0}, 0.1, function(){
        updateText();
    });
}

function openMenu(){
    TweenMax.staggerFrom("#_nav ul li", 0.8, {x: $(window).width() + 200, opacity:0, ease: Expo.ease, clearProps:"all"}, 0.1);
    TweenMax.to("#_navExpends", 0.1, {opacity: 1, ease: Expo.ease});
}

function closeMenu(){
    TweenMax.to(["#_navExpends", "#_nav ul li"], 0.2, {opacity: 0, ease: Expo.easeInOut, clearProps:"all", onComplete: function ()
        {
            $('#_navExpends').css('display', 'none');
            $('#_nav').removeClass('open').addClass('close');
            //enable scrolling
            $('body').removeClass('stop-scrolling');
            $('body').unbind('touchmove');
        }});
}

var bgColorC2Index = 0;
var bgColorC2Bool = true;
const tabBgColorC2 = [ "rgba(217, 217, 217, 0.2)", "rgba(204, 102, 0, 0.2)", "rgba(129, 52, 52, 0.2)" ];
function changeBgColorC2(){
    var c2 = $('#_content2');
    setTimeout(function () {
        if(bgColorC2Bool){
            if(tabBgColorC2[bgColorC2Index + 1]) {
                bgColorC2Index++;
                TweenMax.to(".card-C2", 1, {borderColor: tabBgColorC2[bgColorC2Index], ease: Expo.ease, onComplete: changeBgColorC2});
            }
            else{
                bgColorC2Bool = false;
                bgColorC2Index - 1;
                TweenMax.to(".card-C2", 1, {borderColor: tabBgColorC2[bgColorC2Index], ease: Expo.ease, onComplete: changeBgColorC2});
            }
        }
        else{
            if(tabBgColorC2[bgColorC2Index - 1]) {
                bgColorC2Index--;
                TweenMax.to(".card-C2", 1, {borderColor: tabBgColorC2[bgColorC2Index], ease: Expo.ease, onComplete: changeBgColorC2});
            }
            else{
                bgColorC2Bool = true;
                bgColorC2Index + 1;
                TweenMax.to(".card-C2", 1, {borderColor: tabBgColorC2[bgColorC2Index], ease: Expo.ease, onComplete: changeBgColorC2});
            }
        }

    }, 2000);
}

var actualContentC4 = '#_skills-langage';
function changeContentC4(content){
    if(content == "langage"){
        let oldContent = actualContentC4;
        TweenMax.staggerTo(oldContent + " .skill", 0.2, {opacity: 0}, 0.1, function(){
            $(oldContent).css('display', 'none');
            $('#_skills-langage').css('display', 'flex');
            TweenMax.staggerFromTo("#_skills-langage .skill", 0.4, {opacity: 0}, {opacity: 1}, 0.2);
        });
        actualContentC4 = '#_skills-langage';
    }
    else if(content == "logiciel"){
        let oldContent = actualContentC4;
        TweenMax.staggerTo(oldContent + " .skill", 0.2, {opacity: 0}, 0.1, function(){
            $(oldContent).css('display', 'none');
            $('#_skills-logiciel').css('display', 'flex');
            TweenMax.staggerFromTo("#_skills-logiciel .skill", 0.4, {opacity: 0}, {opacity: 1}, 0.2);
        });
        actualContentC4 = '#_skills-logiciel';
    }
    else if(content == "outil"){
        let oldContent = actualContentC4;
        TweenMax.staggerTo(oldContent + " .skill", 0.2, {opacity: 0}, 0.1, function(){
            $(oldContent).css('display', 'none');
            $('#_skills-outil').css('display', 'flex');
            TweenMax.staggerFromTo("#_skills-outil .skill", 0.4, {opacity: 0}, {opacity: 1}, 0.2);
        });
        actualContentC4 = '#_skills-outil';
    }
}

var actualContentIDC5 = 0;
var nbContent = $('.project-C5').length;
function nextContentC5(content){
    let oldID = actualContentIDC5;
    let oldElem = $(".project-C5[data-id='" + oldID + "']");
    let oldElemW = oldElem.width();
    let newElem = $(".project-C5[data-id='" + content + "']");

    TweenMax.to(oldElem, 0.6, {
        left: -30,
        onComplete: function () {
            TweenMax.to(oldElem, 0.5, {
                delay: 0.3,
                left: oldElemW,
                opacity:0,
                onComplete: function () {
                    oldElem.css('display', 'none');
                    oldElem.css('left', '0px');
                    TweenMax.fromTo(newElem, 1, {
                        opacity: 0,
                        x: -50//100
                    },{
                        onStart: function(){
                            newElem.css('display', 'flex');
                        },
                        opacity: 1,
                        x: 0
                    })
                }
            });
        }
    });
    actualContentIDC5 = content;
}
function prevContentC5(content){
    let oldID = actualContentIDC5;
    let oldElem = $(".project-C5[data-id='" + oldID + "']");
    let oldElemW = oldElem.width();
    let newElem = $(".project-C5[data-id='" + content + "']");

    /*TweenMax.to(oldElem, 0.6, {
        //right: -30,
        onComplete: function () {
            */TweenMax.to(oldElem, 0.5, {
                //right: oldElemW,
                opacity:0,
                onComplete: function () {
                    oldElem.css('display', 'none');
                    oldElem.css('right', '0px');
                    TweenMax.fromTo(newElem, 1, {
                        opacity: 0,
                        x: 100
                    },{
                        onStart: function(){
                            newElem.css('display', 'flex');
                        },
                        opacity: 1,
                        x: 0
                    })
                }
            });
        /*}
    });*/
    actualContentIDC5 = content;
}