(function () {
  ("use strict");
  // HTML Root Element
  const rootHtml = document.documentElement;
  var deviceWidth =
    window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth;

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

  // Sidebar mobile menu
  const sidebarTrigger = document.querySelector(".sidebar-trigger");
  if (sidebarTrigger != null) {
    var sidebaroverlay = document.querySelector(".sidebaroverlay");
    const sidebars = document.querySelector(".aside");

    // Create Overlay
    sidebaroverlay = document.createElement("div");
    sidebaroverlay.setAttribute("class", "sidebaroverlay");

    sidebarTrigger.addEventListener("click", () => {
      sidebars.classList.toggle("show-side-bar");
      if (sidebars.classList.contains("show-side-bar")) {
        document.body.appendChild(sidebaroverlay);
      } else {
        sidebaroverlay.remove();
      }
    });

    sidebaroverlay.addEventListener("click", () => {
      sidebaroverlay.remove();
      if (sidebars.classList.contains("show-side-bar")) {
        sidebars.classList.remove("show-side-bar");
      }
    });
  }

  // Sidebar Menu
  const sideMenuItem = document.querySelectorAll(".sidemenu-item");
  if (sideMenuItem !== null) {
    var hiddenOverlay = document.querySelector(".hidden-overlay");
    const main = document.querySelector(".main");

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
                if (otherSideBarDropdown !== sideBarDropdown) {
                  otherSideBarDropdown.classList.remove("show-sideMenu");
                  hiddenOverlay.remove();
                }
              }
            });

            sideBarDropdown.classList.toggle("show-sideMenu");
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
    } else {
      sidebaroverlay.remove();
    }
  }
  window.addEventListener("resize", checkDeviceWidth);
  checkDeviceWidth();


})();
