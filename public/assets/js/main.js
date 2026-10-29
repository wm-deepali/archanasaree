$(function () {
  if (!$("header").is(".header-fixed")) {
    $(window).on("scroll", function () {
      $(this).scrollTop() > 100
        ? $("header").addClass("header-fixed")
        : $("header").removeClass("header-fixed");
    });

    $(window).scrollTop() > 100
      ? $("header").addClass("header-fixed")
      : $("header").removeClass("header-fixed");
  }

  //

  const formControls = $(".form-control");

  formControls.on("focus input change blur", throttle(handleForm));

  formControls.each(function () {
    handleForm.call(this);
  });

  //

  niceSelect($);

  $("select").niceSelect();

  // Data-animate function call

  handleAnimations();

  //

  adjustWhatsAppUrls();

  $(window).resize(function () {
    adjustWhatsAppUrls();
  });

  //

  startCountAnimation();

  $(window).scroll(function () {
    startCountAnimation();
  });

  $(".tab-nav li").on("click", function () {
    var tab = $(this).data("tab");
    var $nav = $(this).closest(".tab-nav");
    var $content = $nav.next(".tab-nav-content");
    var $target = $content.children('.tabs[data-tab="' + tab + '"]');

    $(this).addClass("active").siblings().removeClass("active");

    if ($target.length) {
      $target.addClass("active").siblings(".tabs").removeClass("active");
      $target.find(".swiper").each(function () {
        if (this.swiper) {
          this.swiper.update();
          this.swiper.slideTo(0, 0);
        }
      });
    } else {
      $content.children(".tabs").removeClass("active");
    }
  });

  $(document).on("click", "[data-scrollTo]", function () {
    var headerheight =
      parseInt($(":root").css("--headerpadding")) +
      parseInt($(":root").css("--headerfixed"));

    var section = $(this).attr("data-scrollTo");

    if (section) {
      $("html, body")
        .stop()

        .animate(
          {
            scrollTop: $(section).offset().top - headerheight,
          },

          1000,
        );
    }
  });

  $(document).on("click", "[data-model]", function () {
    var model = $(this).attr("data-model");
    var type = $(this).attr("data-type");
    openModel(model, type);
  });

  $(document).on("click", ".overlay, .close", function () {
    closeModel();
  });

  function closeModel() {
    $(".overlay, .model, .ham-pop").removeClass("is-open");
    $("body, html").removeClass("overflow-hidden");

    setTimeout(function () {
      $(".model, .ham-pop").removeClass("is-booking is-enquire");
    }, 500);
  }

  // ============ SCROLL TO SECTION START ================>>>>

  function scrollToHash(hash) {
    const headerHeight = parseInt($(":root").css("--headerheight")) || 0;
    const $target = $(hash);

    if (!$target.length) return;

    $("html, body")
      .stop()
      .animate(
        {
          scrollTop: $target.offset().top - headerHeight,
        },
        600,
      );
  }

  // On page load
  $(document).ready(function () {
    if (window.location.hash) {
      scrollToHash(window.location.hash);
    }
  });

  // On hash change
  $(window).on("hashchange", function () {
    scrollToHash(window.location.hash);

    if (typeof closeModel === "function") {
      closeModel();
    }
  });

  // For all internal anchor links
  $(document).on("click", 'a[href^="#"]', function (e) {
    const hash = $(this).attr("href");

    if (hash.length > 1 && $(hash).length) {
      e.preventDefault();

      history.pushState(null, null, hash);
      scrollToHash(hash);

      if (typeof closeModel === "function") {
        closeModel();
      }
    }
  });

  // ============ SCROLL TO SECTION END ================>>>>

  // ===========================================================================================================
  $(".hasDropdown").click(function (e) {
    e.stopPropagation(); // Prevents event bubbling

    var slideMenu = $(this).find(".dropdown-menu-ham");
    var plusIcon = $(this).find(".plu-ico");

    $(".dropdown-menu-ham").not(slideMenu).slideUp();
    $(".hasDropdown").not(this).removeClass("active");
    $(".plu-ico").not(plusIcon).removeClass("active");

    $(this).toggleClass("active");
    plusIcon.toggleClass("active");

    slideMenu.stop().slideToggle();
  });
  // ===========================================================================================================
  $(document).ready(function () {
    $(".accordion-wrapper").each(function () {
      const $wrapper = $(this);

      $wrapper.find(".accordion-item").removeClass("active");
      $wrapper.find(".accordion-content").hide();
      $wrapper.find(".accordion-icon").text("+");

      const $firstItem = $wrapper.find(".accordion-item").first();
      $firstItem.addClass("active");
      $firstItem.find(".accordion-content").show();
      $firstItem.find(".accordion-icon").text("−");

      $wrapper.on("click", ".accordion-header", function () {
        const $item = $(this).closest(".accordion-item");
        const $content = $(this).siblings(".accordion-content");
        const isActive = $item.hasClass("active");

        $wrapper.find(".accordion-item").removeClass("active");
        $wrapper.find(".accordion-content").slideUp(300);
        $wrapper.find(".accordion-icon").text("+");

        if (!isActive) {
          $item.addClass("active");
          $content.slideDown(300);
          $item.find(".accordion-icon").text("−");
        }
      });
    });

    $(".expand-toggle input[type='checkbox']").on("change", function () {
      const $wrapper = $(this)
        .closest(".Itinerary, .listing-secI")
        .find(".accordion-wrapper");

      if ($(this).is(":checked")) {
        $wrapper.find(".accordion-item").addClass("active");
        $wrapper.find(".accordion-content").slideDown(300);
        $wrapper.find(".accordion-icon").text("−");
      } else {
        $wrapper.find(".accordion-item").removeClass("active");
        $wrapper.find(".accordion-content").slideUp(300);
        $wrapper.find(".accordion-icon").text("+");

        const $firstItem = $wrapper.find(".accordion-item").first();
        $firstItem.addClass("active");
        $firstItem.find(".accordion-content").show();
        $firstItem.find(".accordion-icon").text("−");
      }
    });
  });

  $("[data-video]").on("click", function (e) {
    e.preventDefault();

    e.stopPropagation();

    $(".video-pop").addClass("is-open");

    var src = $(this).attr("data-video");

    if (src.includes("youtube.com/embed/")) {
      var videoId = src.split("embed/")[1].split("?")[0];

      src += "&autoplay=1&loop=1&playlist=" + videoId;
    }

    $("#iframe1").attr("src", src);

    $("body,html").addClass("overflow-hidden");
  });

  // ============ HEADER ANNOUNCEMENT (vertical) ============
  // FIX: header HTML class now matches (.announcement-swiper)
  new Swiper(".announcement-swiper", {
    direction: "vertical",
    slidesPerView: 1,
    loop: true,
    speed: 700,
    allowTouchMove: false,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
  });

  // ============ HERO ============
  // FIX: pagination was missing, speed 4000 made the slide crawl
  new Swiper(".singleSlider", {
    loop: true,
    spaceBetween: 10,
    slidesPerView: 1,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    speed: 1200,
    allowTouchMove: false,
    pagination: {
      el: ".singleSlider .swiper-pagination",
      clickable: true,
    },
  });

  new Swiper(".thirdSilder", {
    navigation: {
      nextEl: ".thirdSilder-next",
      prevEl: ".thirdSilder-prev",
    },
    loop: true,
    speed: 1000,
    breakpoints: {
      0: {
        slidesPerView: 1.2,
        spaceBetween: 20,
      },
      640: {
        slidesPerView: 1.2,
        spaceBetween: 10,
      },
      768: {
        slidesPerView: 2.2,
        spaceBetween: 20,
      },
      991: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    
    },
  });

  new Swiper(".twoSlider", {
    navigation: {
      nextEl: ".twoSlider-next",
      prevEl: ".twoSlider-prev",
    },
    speed: 1000,
    breakpoints: {
      0: {
        slidesPerView: 1.2,
        spaceBetween: 20,
      },
      640: {
        slidesPerView: 1.2,
        spaceBetween: 10,
      },
      1280: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
    },
  });

  // =====================================================
  // COMMON SLIDER: .fourSlider
  // Used in: categories, product tabs, saree subcategories,
  //          lehenga occasions, bridal cards, reels, reviews.
  //
  // Cards per view (override with data attributes on .fourSlider):
  //   phone (up to 540)  -> data-mob  (default 2)
  //   541 - 991          -> data-sm   (default 2)
  //   992 - 1199         -> data-lg   (default 3)
  //   1200 and up        -> data-xl   (default 4)
  //
  // Markup rule (same everywhere):
  //   .swiper-wrap
  //     .swiper.fourSlider
  //     .swiper-group > .btn-prev + .btn-next
  //   (optional, sibling of .swiper-wrap)
  //   .slider-foot > .sliderCurrent + .sliderProgress + .sliderTotal
  // Every slider only looks inside its OWN .swiper-wrap, so
  // sliders never pick up each other's arrows.
  // =====================================================
  function padNum(n) {
    return n < 10 ? "0" + n : "" + n;
  }

  $(".fourSlider").each(function () {
    var $slider = $(this);
    var $wrap = $slider.closest(".swiper-wrap");
    var $foot = $wrap.siblings(".slider-foot");
    var $current = $foot.find(".sliderCurrent");
    var $total = $foot.find(".sliderTotal");
    var $progress = $foot.find(".sliderProgress");

    var mob = parseFloat($slider.attr("data-mob")) || 2;
    var sm = parseFloat($slider.attr("data-sm")) || 2;
    var lg = parseFloat($slider.attr("data-lg")) || 3;
    var xl = parseFloat($slider.attr("data-xl")) || 4;

    function updateCount(swiper) {
      if (!$current.length) return;
      $current.text(padNum(swiper.snapIndex + 1));
      $total.text(padNum(swiper.snapGrid.length));
    }

    new Swiper(this, {
      slidesPerView: mob,
      spaceBetween: 12,
      speed: 700,
      grabCursor: true,
      observer: true,
      observeParents: true,
      navigation: {
        prevEl: $wrap.find(".btn-prev")[0],
        nextEl: $wrap.find(".btn-next")[0],
        disabledClass: "disabled",
        lockClass: "swiper-button-lock",
      },
      pagination: $progress.length
        ? { el: $progress[0], type: "progressbar" }
        : false,
      breakpoints: {
        541: { slidesPerView: sm, spaceBetween: 18 },
        992: { slidesPerView: lg, spaceBetween: 22 },
        1200: { slidesPerView: xl, spaceBetween: 24 },
      },
      on: {
        init: function (swiper) {
          updateCount(swiper);
        },
        snapIndexChange: function (swiper) {
          updateCount(swiper);
        },
        breakpoint: function (swiper) {
          updateCount(swiper);
        },
        resize: function (swiper) {
          updateCount(swiper);
        },
      },
    });
  });

  new Swiper(".centerSlider", {
    centeredSlides: true,
    centeredSlidesBounds: true,
    slidesOffsetAfter: 120,
    loop: true,
    navigation: {
      nextEl: ".centerSlider-next",
      prevEl: ".centerSlider-prev",
    },

    breakpoints: {
      0: {
        slidesPerView: 1.2,
        spaceBetween: 10,
        speed: 1000,
      },
      520: {
        slidesPerView: 1.2,
        spaceBetween: 10,
        speed: 1000,
      },
      769: {
        slidesPerView: 2.3,
        spaceBetween: 20,
        speed: 1000,
      },
      991: {
        slidesPerView: 2.3,
        spaceBetween: 60,
        speed: 1000,
      },
      1100: {
        slidesPerView: 2.3,
        spaceBetween: 60,
        speed: 1000,
      },
    },
  });
});

$(function () {
  Fancybox.bind("[data-fancybox]", {
    autoStart: false,
    contentClick: "iterateZoom",
    Images: {
      Panzoom: {
        maxScale: 3,
      },
    },
    keyboard: true,
    Thumbs: true,
    Toolbar: {
      display: {
        left: ["infobar"],
        middle: ["toggle1to1", "rotateCCW", "rotateCW"],
        right: ["close"],
        bottom: [],
      },
    },
  });
});


var $floatMenu = $(".float-menu");

function toggleFloatMenu() {
  var scrolled = $(window).scrollTop() > 200;
  var popupOpen = $(".ham-pop").hasClass("is-open");
  $floatMenu.toggleClass("show", scrolled && !popupOpen);
}

$(window).on("scroll resize", toggleFloatMenu);

$(document).on("click", "[data-model], .overlay, .close", function () {
  setTimeout(toggleFloatMenu, 50);
});

toggleFloatMenu();


$(function () {
  new Swiper(".cartRelatedSlider", {
    slidesPerView: 2,
    spaceBetween: 12,
    navigation: {
      nextEl: ".cart-secB .btn-next",
      prevEl: ".cart-secB .btn-prev",
      disabledClass: "disabled",
    },
    breakpoints: {
      769: { slidesPerView: 3, spaceBetween: 16 },
      1025: { slidesPerView: 4, spaceBetween: 24 },
    },
  });

  $(".cart-qty").on("click", ".qty-plus, .qty-minus", function () {
    var $i = $(this).siblings(".qty-input"),
      v = parseInt($i.val(), 10) || 1;
    $i.val($(this).hasClass("qty-plus") ? Math.min(v + 1, 10) : Math.max(1, v - 1));
  });
});



$(function () {
  $(".searchInput").on("input", function () {
    var val = $.trim($(this).val()).toLowerCase()
    var $box = $(this).closest(".formField").find(".search-results")

    if (!val) {
      $box.removeClass("show")
      return
    }

    var found = 0

    $box.find(".res-list li").each(function () {
      var match = $(this).data("name").indexOf(val) > -1
      $(this).toggle(match)
      if (match) found++
    })

    $box.find(".res-empty").toggle(found === 0)
    $box.find(".res-all").toggle(found > 0)
    $box.addClass("show")
  })
})
function runCount($el) {
  var end = parseFloat($el.attr("data-num")) || 0;
  var icon = $el.attr("data-num-icon") || "";

  $({ n: 0 }).animate(
    { n: end },
    {
      duration: 2000,
      easing: "swing",
      step: function (now) {
        $el.text(Math.floor(now).toLocaleString("en-IN") + icon);
      },
      complete: function () {
        $el.text(end.toLocaleString("en-IN") + icon);
      },
    },
  );
}

if ("IntersectionObserver" in window) {
  var countObserver = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          runCount($(entry.target));
          countObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 },
  );

  $(".countNum").each(function () {
    countObserver.observe(this);
  });
} else {
  $(".countNum").each(function () {
    runCount($(this));
  });
}

