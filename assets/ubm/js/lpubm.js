document.addEventListener('click', (event) =>{
    const clickOnOpenBlockBtn = event.target.closest('[data-openBlock-btn]');
    if(clickOnOpenBlockBtn){
        const openBlockWrapper  = event.target.closest('[data-open-block-wrapper]');
        const openingBlock = openBlockWrapper.querySelector('[data-opening-block]');
        openBlockWrapper.classList.toggle('active-block')
        if (openingBlock.style.maxHeight){
            openingBlock.style.maxHeight = null;
        }else {
            openingBlock.style.maxHeight = openingBlock.scrollHeight + 'px';
        }

    }
})



document.addEventListener('click', (event) => {
    const burgerMenu = event.target.closest('[data-burger-menu]')
    if (burgerMenu){
        console.log('barev');
    }
})






      document.addEventListener('click', (e) =>{
          const advantagesItem = e.target.closest('[data-advantages-item]');
          if(advantagesItem){
              let screenWidth = window.innerWidth;
              if (screenWidth >= 1000) {
                  const advantagesWrappers = e.target.closest('[data-advantages-wrapper]');
                  let advantagesItemGroup = advantagesWrappers.querySelectorAll('[data-advantages-item]');
                  for (let i = 0; i < advantagesItemGroup.length; i++) {
                      advantagesItemGroup[i].classList.remove('active')
                  }
                  advantagesItem.classList.add('active');
              }
          }
      })









$(document).ready(function(){
    const slider = $("#about-page-slider").owlCarousel({
        loop:true,
        margin:10,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1200:{
                items:3.2
            }
        },
        nav: true,
        navText: [
            '<div class="slider-btn"></div>',
            '<div class="slider-btn slider-btn-right"></div>'
        ]
    });
});



new Swiper('#completed-works', {
    //стрелки
    navigation: {
        nextEl: '.slide-to-left',
        prevEl: '.slide-to-right'
    },
    keyboard:{
        enabled:true,
        onlyInViewport: true,
    },
    spaceBetween:24,


    breakpoints: {
        320:{
            slidesPerView: 1,
        },
        1000:{
            slidesPerView:2,

        },
    },

});
new Swiper('#certification', {
    //стрелки
    navigation: {
        nextEl: '.certification-slide-to-left',
        prevEl: '.certification-slide-to-right'
    },
    keyboard:{
        enabled:true,
        onlyInViewport: true,
    },



    breakpoints: {
        320:{
            slidesPerView: 1.3,
            spaceBetween:20,
        },
        1000:{
            slidesPerView:3,
            spaceBetween:24,

        },
    },

});
new Swiper('#news', {
    //стрелки
    navigation: {
        nextEl: '.news-slide-to-left',
        prevEl: '.news-slide-to-right'
    },
    keyboard:{
        enabled:true,
        onlyInViewport: true,
    },

    breakpoints: {
        320:{
            slidesPerView: 1,
            spaceBetween:10,
        },
        1000:{
            slidesPerView:3,
            spaceBetween:24,
        },
    },

});
