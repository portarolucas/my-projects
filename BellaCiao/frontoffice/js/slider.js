let slideStarted = false
let slideStartedPosX = null
let slideRadius = null
let slideRadiusRatio = 200 / 1280
let slides = $('.section1 .slides__container .slide')
let slidesLength = $(slides).length
let activeSlide = 0
let activeSlideHeight = null
let activeSlideDefaultOffsetLeft = null // COMBAK: Changer les noms à rallonge
let activeSlideDefaultOffsetRight = null
let paginationContainer = $('.section1 .pagination')

function checkSlideRadius(){
  slideRadius = window.innerWidth * slideRadiusRatio
}

function checkSliderPagination(){
  paginationContainer.find('.pagination__btn').removeClass('active')
  paginationContainer.find('.pagination__btn:eq(' + activeSlide + ')').addClass('active')
}

function createSliderPagination(){
  for (var i = 0; i < slidesLength; i++) {
    let button = document.createElement("button");

    if(i == 0) button.className = "pagination__btn active"
    else button.className = "pagination__btn"
    button.dataset.nav = i;

    button.onclick = (e) => { switchSlideTo(e.target.dataset.nav)}

    paginationContainer.append(button);
  }
}

function startSlide(e){
  if(!slideStarted){
    slideStarted = true
    slideStartedPosX = e.x
    clearInterval(sliderAuto)
  }
}
function moveSlide(e){

  if(slideStarted && e.x < slideStartedPosX){
    let offsetLeft = $(slides[activeSlide]).find('.left').offset()
    $(slides[activeSlide]).find('.left').offset({ top: offsetLeft.top - 1 })

    let offsetRight = $(slides[activeSlide]).find('.right').offset()
    $(slides[activeSlide]).find('.right').offset({ top: offsetRight.top + 1 })
  }
  else if(slideStarted && e.x > slideStartedPosX){
    let offsetLeft = $(slides[activeSlide]).find('.left').offset()
    $(slides[activeSlide]).find('.left').offset({ top: offsetLeft.top + 1 })

    let offsetRight = $(slides[activeSlide]).find('.right').offset()
    $(slides[activeSlide]).find('.right').offset({ top: offsetRight.top - 1 })
  }

}

let waitingLastDrop = false
function switchSlide(direction, num = null){
  activeSlideDefaultOffsetLeft = $(slides[activeSlide]).find('.left').offset()
  activeSlideDefaultOffsetRight = $(slides[activeSlide]).find('.right').offset()
  activeSlideHeight = $(slides[activeSlide]).height()

  if(waitingLastDrop) {
    //display none older slide
    $(slides[activeSlide]).css('display', 'none')

    //get the new active slide
    if(num){
      activeSlide = num
    }
    else if(direction == 'next' && activeSlide + 1 > slidesLength - 1){
      activeSlide = 0
    }
    else if(direction == 'prev' && activeSlide - 1 < 0){
      activeSlide = slidesLength - 1
    }
    else if(direction == 'next'){
      activeSlide++
    }
    else if(direction == 'prev'){
      activeSlide--
    }

    //set to top & bottom the new slide left and right container
    if(direction == 'next'){
      $(slides[activeSlide]).find('.left').offset({ top: activeSlideHeight * -1 })
      $(slides[activeSlide]).find('.right').offset({ top: activeSlideHeight })
    }
    else if(direction == 'prev'){
      $(slides[activeSlide]).find('.left').offset({ top: activeSlideHeight })
      $(slides[activeSlide]).find('.right').offset({ top: activeSlideHeight * -1  })
    }

    //display the new slide
    $(slides[activeSlide]).css('display', 'inherit')

    //do the appear animation
    TweenMax.to($(slides[activeSlide]).find('.left'), 1, { top: 0, opacity: 1, ease:Expo.easeOut})
    TweenMax.to($(slides[activeSlide]).find('.right'), 1, { top: 0, opacity: 1, ease:Expo.easeOut})
    waitingLastDrop = false
    checkSliderPagination()
    resetSliderInterval()
  }
  else{
    waitingLastDrop = true
  }
}

function switchSlideTo(num){
  if(activeSlide != num && num > activeSlide){
    TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('next', num) })
    TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('next', num) })
  }else if(activeSlide != num && num < activeSlide){
    TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('prev', num) })
    TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('prev', num) })
  }
}

function endSlide(e){
  if(slideStarted){
    if(e.x < (slideStartedPosX - slideRadius)){
      TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('next') })
      TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('next') })
    }
    else if(e.x > (slideStartedPosX + slideRadius)){
      TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('prev') })
      TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('prev') })
    }
    else{
      TweenMax.to($(slides[activeSlide]).find('.left'), { top: 0 });
      TweenMax.to($(slides[activeSlide]).find('.right'), { top: 0 });
    }
    slideStarted = false
    slideStartedPosX = null
    activeSlideHeight = null
    resetSliderInterval()
  }
}

const sliderAutoInterval = 6000

var sliderAuto = setInterval(() => {
  TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('next') })
  TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('next') })
}, sliderAutoInterval)

function resetSliderInterval(){
  clearInterval(sliderAuto)
  sliderAuto = setInterval(() => {
    TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('next') })
    TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('next') })
  }, sliderAutoInterval)
}
