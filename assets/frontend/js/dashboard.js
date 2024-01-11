(function () {
  ("use strict");
  // HTML Root Element
  var rootHtml = document.documentElement;
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


    // By default Set attributes
    // rootHtml.setAttribute("data-sidebar", "open-sidebar");

    sidebarTrigger.addEventListener("click", () => {
      // Set attributes
      // var currentAttribute = rootHtml.getAttribute("data-sidebar");
      // rootHtml.setAttribute(
      //   "data-sidebar",
      //   currentAttribute === "open-sidebar" ? "" : "open-sidebar"
      // );

      // Sidebar Toggle Class
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
    } else {
      sidebaroverlay.remove();
    }
  }
  window.addEventListener("resize", checkDeviceWidth);
  checkDeviceWidth();
})();
