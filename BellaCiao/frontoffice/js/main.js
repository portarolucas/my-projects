

  //LINK ANCHOR
  //PLATFORM : ALL
  $(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top - $(NAV).height()
    }, 500);
});

  //NAVBAR CHANGE HEIGHT ON SCROLL
  //PLATFORM : COMPUTER (mediascreen > 960px)
  var navbar_xs = false
  const NAV = $('.nav')
  const NAV_CONTAINER = $('.nav .nav__container')
  const NAV_IMG = $('.nav .nav__container img')

  checkNavScrolled()
  $(window).scroll(checkNavScrolled)
  $(window).resize(checkNavScrolled)

  function checkNavScrolled(){
    if(!navbar_xs && window.matchMedia('(min-width: 960px)').matches && this.scrollY > 0){
      NAV_CONTAINER.css('height', 'calc(10vh - 7.5px)')
      NAV_CONTAINER.css('padding-top', '7.5px')
      NAV_IMG.css('width', '5rem')
      NAV_IMG.css('left', 'calc(50% - 2.5rem)')
      $('body').css('padding-top', '10vh')
      navbar_xs = true
    }else if(navbar_xs && ((window.matchMedia('(min-width: 960px)').matches && this.scrollY <= 0) || !window.matchMedia('(min-width: 960px)').matches)){
      NAV_CONTAINER.css('height', '')
      NAV_CONTAINER.css('padding-top', '')
      NAV_IMG.css('width', '')
      NAV_IMG.css('left', '')
      $('body').css('padding-top', '')
      navbar_xs = false
    }
  }

  // CATEGORIE SCROLLER (draggable)
  // PLATFORM : MOBILE
  const CATEGORIE_LIST = $('.notre-carte__categories ul')
  const ARROW_SCROLL_LEFT_ELEM = $('.notre-carte__categories .arrow-scroll.left')[0]
  const ARROW_SCROLL_RIGHT_ELEM = $('.notre-carte__categories .arrow-scroll.right')[0]

  CATEGORIE_LIST.scroll(function() {
    let categorieScrollWidth = CATEGORIE_LIST[0].scrollWidth
    let categorieElemWidth = CATEGORIE_LIST[0].offsetWidth
    let scrollbarSize = categorieScrollWidth - categorieElemWidth;

    if(CATEGORIE_LIST.scrollLeft() >= scrollbarSize){
      //scrollbar 100% right
      $(ARROW_SCROLL_RIGHT_ELEM).css('display', 'none')
      $(ARROW_SCROLL_LEFT_ELEM).css('display', 'block')
    }
    else if(CATEGORIE_LIST.scrollLeft() < scrollbarSize && CATEGORIE_LIST.scrollLeft() > 0) {
      //scrollbar between left and right
      $(ARROW_SCROLL_RIGHT_ELEM).css('display', 'block')
      $(ARROW_SCROLL_LEFT_ELEM).css('display', 'block')
    }
    else{
      //scrollbar 100% left
      $(ARROW_SCROLL_LEFT_ELEM).css('display', 'none')
      $(ARROW_SCROLL_RIGHT_ELEM).css('display', 'block')
    }
  });

  // DRAGGABLE SLIDER
  // PLATFORM : ALL
  checkSlideRadius()
  createSliderPagination()
  window.addEventListener('resize', checkSlideRadius);

  const SLIDER = $('.section1 .slides__container')[0];
  SLIDER.addEventListener('mousedown', startSlide);
	SLIDER.addEventListener('touchstart', startSlide);

	SLIDER.addEventListener('mousemove', moveSlide);
	SLIDER.addEventListener('touchmove', moveSlide);

	SLIDER.addEventListener('mouseleave', endSlide);
	SLIDER.addEventListener('mouseup', endSlide);
	SLIDER.addEventListener('touchend', endSlide);

  $('.section1 .btn-slide.btn-right').click(()=>{
    TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('next') })
    TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('next') })
  })
  $('.section1 .btn-slide.btn-left').click(()=>{
    TweenMax.to($(slides[activeSlide]).find('.left'), { top: activeSlideHeight, opacity: 0,onComplete: switchSlide('prev') })
    TweenMax.to($(slides[activeSlide]).find('.right'), { top: activeSlideHeight * -1, opacity: 0,onComplete: switchSlide('prev') })
  })

  // SWITCH CATEGORIE
  // PLATFORM : ALL
  $('.section2 .notre-carte__categories ul li').click((e)=>{
    if(!changeCategorieStarted) changeCategorie(e.target.dataset.id)
  })

  const CATEGORIE_CONTAINERS = $('.notre-carte .categorie')
  let changeCategorieStarted = false
  function changeCategorie(id){
    let actualContainer = $('.notre-carte .categorie.active')[0]
    let nextContainer = CATEGORIE_CONTAINERS.filter(function(){
      return $(this).data("id") == id;
    })

    if($(actualContainer).data("id") != id){
      changeCategorieStarted = true
      let nextContainerFav = $(nextContainer).find('.categorie__best-sell .items .item')
      let nextContainerFavImg = $(nextContainerFav).find('.item__image img')
      $(nextContainerFavImg).css('opacity', '0')
      TweenMax.to($(actualContainer), { height: 0, opacity: 0,onComplete: ()=>{

        $(actualContainer).css('display', 'none')
        $(actualContainer).css('height', '')
        $(actualContainer).css('opacity', '')
        $(actualContainer).removeClass('active')
        $(CATEGORIE_LIST).find('li.selected').removeClass('selected')

          $(nextContainer).css('display', '')
          $(CATEGORIE_LIST).find('li[data-id="' + id + '"]').addClass('selected')
          gsap.from(nextContainer, {opacity: 0, height: 0, onComplete: ()=>{

            if(nextContainerFav.length > 0){
              let heightImgs = $(nextContainerFavImg[0]).height()
              $(nextContainerFavImg).css('opacity', '1')
              gsap.from(nextContainerFavImg, {opacity: 0, x: heightImgs / 4, stagger: 0.2, onComplete: ()=>{
                $(nextContainer).css('opacity', '')
                $(nextContainer).css('height', '')
                $(nextContainerFavImg).css('transform', '')
                $(nextContainerFavImg).css('opacity', '')
                $(nextContainer).addClass('active')
                changeCategorieStarted = false
              }})
            }else{
              $(nextContainer).css('opacity', '')
              $(nextContainer).css('height', '')
              $(nextContainer).addClass('active')
              changeCategorieStarted = false
            }
          }})
      }})
    }
  }

  //NAVIGATION MENU
  //PLATFORM : PHONE (mediascreen <= 599px)
  const MENU_BTN = $('ul.nav__menu')
  const MENU_LIST = $('ul.nav__menu li')

  window.addEventListener('resize', ()=>{ $(NAV_CONTAINER).removeClass("menu--open") });

  MENU_BTN.click(() => {
    if(window.matchMedia('(max-width: 599px)').matches){
      if($(NAV_CONTAINER).hasClass("menu--open")){
        $(NAV_CONTAINER).removeClass("menu--open")
      }else{
        $(NAV_CONTAINER).addClass("menu--open")
      }
    }
  })

  //SCROLLMAGIC
  //PLATFORM : ALL
  let clientWidth = document.body.clientWidth
  let scrollController = new ScrollMagic.Controller()

  new ScrollMagic.Scene({
        triggerElement: "#section4 .article-delivery",
        triggerHook: "onEnter",
        reverse: false
  })
  .on('start', function () {
    TweenMax.from($('.article-delivery .article__image'), 1, { x: clientWidth + 500})
  })
  //.addIndicators() // add indicators (requires plugin)
  .addTo(scrollController);

  new ScrollMagic.Scene({
        triggerElement: "#section4 .article-phone",
        triggerHook: "onEnter",
        reverse: false
  })
  .on('start', function () {
    TweenMax.from($('.article-phone .article__image'), 1, { x: -500})
  })
  //.addIndicators() // add indicators (requires plugin)
  .addTo(scrollController);
