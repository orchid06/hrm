(function () {
  "use strict";

  // Preloader
  const preloader = document.querySelector(".preloader");
  window.addEventListener("load", () => {
    if (preloader) {
      preloader.remove();
    }
  });

  // Sticky Header
  const header = document.querySelector(".header");
  if (header) {
    const checkScroll = () => {
      if (window.scrollY > 0) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    };

    window.addEventListener("scroll", checkScroll);

    window.addEventListener("load", checkScroll);
  }

  // Back to Top
  const backToTop = document.querySelector(".back-to-top");
  if (backToTop != null) {
    backToTop.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }

  // Venobox
  new VenoBox({
    selector: "#video-link",
    numeration: false,
    infinigall: true,
    ratio: "16x9",
    spinner: "wave",
    maxWidth: "100%",
    overlayColor: "rgba(0,0,0,0.5)",
    toolsColor: "#000",
  });

  // sponsor slider
    // Review Slider
    const sponsor = document.querySelector(".sponsor-slider");
    if (sponsor) {
      new Swiper(sponsor, {
        slidesPerView: 1,
        spaceBetween: 15,
        speed: 1000,
        loop: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        autoplay: {
          delay:4000,
        },
  
        breakpoints: {
          0: {
            spaceBetween: 15,
            slidesPerView: 2,
          },
          768: {
            spaceBetween: 20,
            slidesPerView: 3,
          },
          1200: {
            spaceBetween: 25,
            slidesPerView: 4,
          },
        },
      });
    }

  // Review Slider
  const reviewSlider = document.querySelector(".review-slider");
  if (reviewSlider) {
    new Swiper(reviewSlider, {
      slidesPerView: 1,
      spaceBetween: 15,
      loop: true,
      navigation: {
        nextEl: '.review-button-next',
        prevEl: '.review-button-prev',
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      // autoplay: {
      //   delay:4000,
      //   disableOnInteraction: false,
      // },
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
    });
  }

  // Blog Slider
  const blogSlider = document.querySelector(".blog-slider");
  if (blogSlider) {
    new Swiper(blogSlider, {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      navigation: {
        nextEl: ".blog-button-next",
        prevEl: ".blog-button-prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        577: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 2,
          spaceBetween: 25,
        },
        1200: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
      },
    });
  }

  // Auth Page slider
  const authSlider = document.querySelectorAll(".auth-slider");
  if (authSlider) {
    authSlider.forEach((item) => {
      new Swiper(item, {
        slidesPerView: 1,
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
      });
    });
  }

  // Cookie
  const cookie = document.querySelector(".cookie");
  if (cookie) {
    const cookieBtns = cookie.querySelectorAll(".cookie-action button");
    cookieBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        cookie.classList.add("d-none");
      });
    });
  }

  // Sidebar
  const sidebarTrigger = document.querySelectorAll(".sidebar-trigger");
  if (sidebarTrigger != null) {
    Array.from(sidebarTrigger).forEach((item) => {
      item.addEventListener("click", (ele) => {
        var attr = item.getAttribute("data-trigger");
        const sidebars = document.querySelectorAll(".sidebar");
        Array.from(sidebars).forEach((sidebar) => {
          const overlay = sidebar.querySelector(".sidebar-overlay");
          if (attr == sidebar.getAttribute("id")) {
            sidebar.classList.add("show-sidebar");
            if (sidebar.classList.contains("show-sidebar")) {
              overlay.addEventListener("click", () => {
                sidebar.classList.remove("show-sidebar");
              });
            }
            if (sidebar.classList.contains("show-sidebar")) {
              var sideBarDissmis = sidebar.querySelector(".closer-sidebar");
              sideBarDissmis.addEventListener("click", () => {
                sidebar.classList.remove("show-sidebar");
              });
            }
          }
        });
      });
    });
  }

  // Mega Menu Click on mobile Device
  const menuList = document.querySelector(".menu-list");
  if (menuList) {
    const menu = menuList.querySelectorAll(".menu-link");
    menu.forEach((menuItem) =>
      menuItem.addEventListener("click", () => {
        menuItem.classList.toggle("active");
      })
    );

    const menuFeatureItem = document.querySelectorAll(".menu-feature-item");
    menuFeatureItem.forEach((item) => {
      item.addEventListener("click", () => {
        menuFeatureItem.forEach((otherItem) => {
          if (otherItem !== item) {
            otherItem.classList.remove("hover");
          }
        });

        item.classList.toggle("hover");
      });

      const megaMenu = document.querySelector(".mega-menu");
      if (megaMenu) {
        megaMenu.addEventListener("mouseleave", () => {
          item.classList.remove("hover");
        });
      }
    });
  }

  // Select 2 Initialized
  const selectTwo = document.querySelector(".select-two");
  $(document).ready(function () {
    if (selectTwo) {
      $(selectTwo).select2();
    }
  });

  // Otp Input form
  const inputs = document.querySelectorAll(".otp-field >input");
  inputs.forEach((input, index) => {
    input.dataset.index = index;
    input.addEventListener("keyup", handleOtp);
    input.addEventListener("paste", handleOnPasteOtp);
  });

  function handleOtp(e) {
    const input = e.target;
    let value = input.value;
    let isValidInput = value.match(/[0-9a-z]/gi);
    input.value = "";
    input.value = isValidInput ? value[0] : "";

    let fieldIndex = input.dataset.index;
    if (fieldIndex < inputs.length - 1 && isValidInput) {
      input.nextElementSibling.focus();
    }

    if (e.key === "Backspace" && fieldIndex > 0) {
      input.previousElementSibling.focus();
    }

    if (fieldIndex == inputs.length - 1 && isValidInput) {
      submit();
    }
  }

  function handleOnPasteOtp(e) {
    const data = e.clipboardData.getData("text");
    const value = data.split("");
    if (value.length === inputs.length) {
      inputs.forEach((input, index) => (input.value = value[index]));
      submit();
    }
  }

  function submit() {
    let otp = "";
    inputs.forEach((input) => {
      otp += input.value;
      input.disabled = true;
      input.classList.add("disabled");
    });

    const otpField = document.querySelector("#otpCode");
    otpField.value = otp;

    var form = document.getElementById("otpForm");

    form.submit();
  }

  function hasClass(element, className) {
    return element.classList.contains(className);
  }

  // Drag and Drop Section
  function hasClass(element, className) {
    return element && element.classList.contains(className);
  }

  const sectionList = document.querySelectorAll("section");
  sectionList.forEach((sectionListItem) => {
    window.addEventListener("DOMContentLoaded", () => {
      const current = sectionListItem;
      const prevEl = current.previousElementSibling;
      const nextEl = current.nextElementSibling;

      const platform = current.classList.contains("platform");
      const integration = current.classList.contains("integration");

      const prevBg = hasClass(prevEl, "sectionWithBg");
      const currentBg = hasClass(current, "sectionWithBg");
      const nextBg = hasClass(nextEl, "sectionWithBg");

      if (prevBg && !currentBg) {
        current.classList.add("pt-110");
      }

      if (integration && !currentBg) {
        nextEl.classList.add("pt-110");
      }

      if (platform && !currentBg) {
        nextEl.classList.add("pt-110");
      }

      if (prevBg && platform) {
        current.classList.add("pt-110");
      }
      if (prevBg && currentBg) {
        current.classList.remove("pt-110");
      }
    });
  });

  // $(".counter-single").each(function () {
  //   $(this).isInViewport(function (status) {
  //   if (status === "entered") {
  //       for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
  //       var el = document.querySelectorAll('.odometer')[i];
  //       el.innerHTML = el.getAttribute("data-odometer-final");
  //       }
  //   }
  //   });
  // });

  var swiper = new Swiper(".team-slider", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    pagination: {
      el: ".swiper-pagination",
    },
  });

  const service = document.querySelector(".service-slider-one");
  if (service) {
    new Swiper(service, {
      slidesPerView: 1,
      spaceBetween: 15,
      speed: 1000,
      autoplay: true,
      loop: false,
      mousewheel: {
        invert: false,
      },
      grabCursor: true,
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      autoplay: {
        delay:4000,
      },

      breakpoints: {
        0: {
          spaceBetween: 15,
          slidesPerView: 1,
        },
        768: {
          spaceBetween: 20,
          slidesPerView: 2,
        },
        1200: {
          spaceBetween: 25,
          slidesPerView: 3,
        },
      },
    });
  }

  const service2 = document.querySelector(".service-slider-two");
  if (service2) {
    new Swiper(service2, {
      slidesPerView: 1,
      spaceBetween: 15,
      speed: 1000,
      autoplay: true,
      loop: false,
      grabCursor: true,
      mousewheel: {
        invert: false,
      },
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      autoplay: {
        delay:4000,
      },

      breakpoints: {
        0: {
          spaceBetween: 15,
          slidesPerView: 1,
        },
        768: {
          spaceBetween: 20,
          slidesPerView: 2,
        },
        1200: {
          spaceBetween: 25,
          slidesPerView: 3,
        },
      },
    });
  }

  // function updateTabFunctionality() {
  //   const tabItems = document.querySelectorAll(".nav-item");
  //   const maxWidth = 991;

  //   tabItems.forEach((item) => {
  //     const tabLink = item.querySelector(".nav-link");
  //     if (tabLink) {
  //       var tabTrigger = new bootstrap.Tab(tabLink);

  //       item.removeEventListener("mouseenter", tabTrigger.show);
  //       item.removeEventListener("click", tabTrigger.show);

  //       if (window.innerWidth <= maxWidth) {
  //         item.addEventListener("click", function () {
  //           tabTrigger.show();
  //         });
  //       } else {
  //         item.addEventListener("mouseenter", function () {
  //           tabTrigger.show();
  //         });
  //       }
  //     }
  //   });
  // }

  // updateTabFunctionality();

  // window.addEventListener("resize", updateTabFunctionality);


})();
