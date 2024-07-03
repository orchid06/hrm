(function () {
  "use strict";
  // HTML Root Element
  var rootHtml = document.documentElement;
  var deviceWidth =
    window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth;

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

  // Sidebar mobile menu
  const sidebarTrigger = document.querySelector(".sidebar-trigger");
  if (sidebarTrigger != null) {
    var sidebaroverlay = document.querySelector(".sidebaroverlay");
    const sidebars = document.querySelector(".aside");

    // Create Overlay
    sidebaroverlay = document.createElement("div");
    sidebaroverlay.setAttribute("class", "sidebaroverlay");

    sidebarTrigger.addEventListener("click", () => {
      // Sidebar Toggle Class
      sidebars.classList.toggle("show-side-bar");
      sidebarTrigger.classList.toggle("clicked");

      if (sidebars.classList.contains("show-side-bar")) {
        document.body.appendChild(sidebaroverlay);
      } else {
        sidebaroverlay.remove();
      }
    });

    sidebaroverlay.addEventListener("click", () => {
      sidebaroverlay.remove();
      if (
        sidebars.classList.contains("show-side-bar") &&
        sidebarTrigger.classList.contains("clicked")
      ) {
        sidebars.classList.remove("show-side-bar");
        sidebarTrigger.classList.remove("clicked");
      }
    });
  }

  // Sidebar Menu
  const sideMenuItem = document.querySelectorAll(".sidemenu-item");
  if (sideMenuItem !== null) {
    const main = document.querySelector(".main");

    var hiddenOverlay = document.querySelector(".hidden-overlay");
    if (hiddenOverlay === null) {
      hiddenOverlay = document.createElement("div");
      hiddenOverlay.setAttribute("class", "hidden-overlay");
    }

    sideMenuItem.forEach((item) => {
      const sideMenuLink = item.querySelector(".sidemenu-link");
      const sideBarDropdown = item.querySelector(".side-menu-dropdown");

      if (sideBarDropdown !== null) {
        sideBarDropdown.classList.remove("show-sideMenu");

        sideMenuLink.addEventListener("click", () => {
          if (sideBarDropdown !== null) {
            sideMenuItem.forEach((otherItem) => {
              const otherSideBarDropdown = otherItem.querySelector(
                ".side-menu-dropdown"
              );

              const otherSideMenuLink =
                otherItem.querySelector(".sidemenu-link");
              if (otherSideBarDropdown !== null && otherSideMenuLink !== null) {
                const rotateIcon = otherSideMenuLink.querySelector(
                  ".sidemenu-link small"
                );
                if (otherSideBarDropdown !== sideBarDropdown) {
                  rotateIcon.style.transform = "";
                  otherSideBarDropdown.classList.remove("show-sideMenu");
                  hiddenOverlay.remove();
                }
              }
            });

            sideBarDropdown.classList.toggle("show-sideMenu");

            // Rotate Icons
            const rotateIcon = sideMenuLink.querySelector(
              ".sidemenu-link small"
            );

            if (
              !rotateIcon.style.transform ||
              rotateIcon.style.transform !== "rotate(-180deg)"
            ) {
              rotateIcon.style.transform = "rotate(-180deg)";
            } else {
              rotateIcon.style.transform = "";
            }

            if (main.contains(hiddenOverlay)) {
              hiddenOverlay.remove();
            } else {
              main.appendChild(hiddenOverlay);
            }
          }

          if (!sideBarDropdown.classList.contains("show-sideMenu")) {
            hiddenOverlay.remove();
          } else {
            hiddenOverlay.addEventListener("click", () => {
              sideBarDropdown.classList.remove("show-sideMenu");
              hiddenOverlay.remove();
            });
          }
        });
      }
    });
  }

  // Check Devices
  function checkDeviceWidth() {
    if (deviceWidth <= 992) {
      hiddenOverlay.remove();
    }
  }
  window.addEventListener("resize", checkDeviceWidth);
  checkDeviceWidth();


  const rightBtn = document.getElementById('right-sidebar-btn');
  const rightSidebar = document.querySelector('.right-side-col');
  const overlay = document.querySelector('.overlay');

  if(rightBtn){
    rightBtn.addEventListener('click', () => {
      rightSidebar.classList.toggle('show');
      overlay.classList.toggle('show');
    });
  
  }
  if(overlay){
    overlay.addEventListener('click', ()=>{
      overlay.classList.toggle('show');
      rightSidebar.classList.toggle('show');
    })
  }

  var paymentCards = document.querySelectorAll('.payment-card-item');

  var balanceCard = document.querySelector('#balanceCard');
  var formStepOne = document.querySelector('#formStepOne');

  paymentCards.forEach((paycard)=>{
    paycard.addEventListener('click', ()=>{
      balanceCard.style.display = 'none';
      formStepOne.classList.add('show');
    })
  })



  // var paymentCardItems = document.querySelectorAll('.payment-card-item');

  //   var form = document.getElementById('payment-form');


  //   paymentCardItems.forEach(function (card) {
  //       card.addEventListener('click', function () {

  //           form.classList.remove('highlight');

  //           form.classList.add('highlight');
  //       });
  //   });
  


})();
