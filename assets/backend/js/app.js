(function () {
  ("use strict");

  // HTML Root Element
  const rootHtml = document.documentElement;
  // Layout design
  const verticalMenuBtn = document.querySelector(".vertical-menu-btn");
  if (verticalMenuBtn != null) {
    const dashboardWrapper = document.querySelector(".dashboard-wrapper");
    // Create overlay
    const overlay = document.createElement("div");
    overlay.setAttribute("class", "overlay-bg");

    function checkDeviceWidth() {
      const deviceWidth = window.innerWidth;
      if (deviceWidth <= 992) {
        setSidebarAttribute("close");
        verticalMenuBtn.addEventListener("click", toggleSidebar);
        dashboardWrapper.appendChild(overlay);
      } else {
        setSidebarAttribute("open");
        verticalMenuBtn.addEventListener("click", toggleSidebar);
        overlay.remove();
      }
    }

    function setSidebarAttribute(value) {
      rootHtml.setAttribute("data-sidebar", value);
    }

    function toggleSidebar() {
      const currentAttribute = rootHtml.getAttribute("data-sidebar");
      const newAttribute = currentAttribute === "open" ? "close" : "open";
      setSidebarAttribute(newAttribute);
      if (newAttribute === "open") {
        overlay.addEventListener("click", function () {
          overlay.style.display = "none";
          setSidebarAttribute("close");
        });
      }

      overlay.style.display = newAttribute === "open" ? "block" : "none";
    }

    window.addEventListener("resize", checkDeviceWidth);
    checkDeviceWidth();
  }

  // Sidebar Menu
  if (document.querySelectorAll(".sidebar-menu .collapse")) {
    var collapses = document.querySelectorAll(".sidebar-menu .collapse");
    Array.from(collapses).forEach(function (collapse) {
      // Init collapses
      var collapseInstance = new bootstrap.Collapse(collapse, {
        toggle: false,
      });
      // Hide sibling collapses on `show.bs.collapse`
      collapse.addEventListener("show.bs.collapse", function (e) {
        e.stopPropagation();
        var closestCollapse = collapse.parentElement.closest(".collapse");
        if (closestCollapse) {
          var siblingCollapses = closestCollapse.querySelectorAll(".collapse");
          Array.from(siblingCollapses).forEach(function (siblingCollapse) {
            var siblingCollapseInstance =
              bootstrap.Collapse.getInstance(siblingCollapse);
            if (siblingCollapseInstance === collapseInstance) {
              return;
            }
            siblingCollapseInstance.hide();
          });
        } else {
          var getSiblings = function (elem) {
            // Setup siblings array and get the first sibling
            var siblings = [];
            var sibling = elem.parentNode.firstChild;
            // Loop through each sibling and push to the array
            while (sibling) {
              if (sibling.nodeType === 1 && sibling !== elem) {
                siblings.push(sibling);
              }
              sibling = sibling.nextSibling;
            }
            return siblings;
          };
          var siblings = getSiblings(collapse.parentElement);
          Array.from(siblings).forEach(function (item) {
            if (item.childNodes.length > 2)
              item.firstElementChild.setAttribute("aria-expanded", "false");
            var ids = item.querySelectorAll("*[id]");
            Array.from(ids).forEach(function (item1) {
              item1.classList.remove("show");
              if (item1.childNodes.length > 2) {
                var val = item1.querySelectorAll("ul li a");
                Array.from(val).forEach(function (subitem) {
                  if (subitem.hasAttribute("aria-expanded"))
                    subitem.setAttribute("aria-expanded", "false");
                });
              }
            });
          });
        }
      });

      // Hide nested collapses on `hide.bs.collapse`
      collapse.addEventListener("hide.bs.collapse", function (e) {
        e.stopPropagation();
        var childCollapses = collapse.querySelectorAll(".collapse");
        Array.from(childCollapses).forEach(function (childCollapse) {
          childCollapseInstance = bootstrap.Collapse.getInstance(childCollapse);
          childCollapseInstance.hide();
        });
      });
    });
  }

  // Full Screen Viewer With browser support
  let fullscreenBtn = document.querySelector(".fullscreen-btn");
  if (fullscreenBtn != null) {
    fullscreenBtn.innerHTML = `<i class="las la-expand"></i>`;
    fullscreenBtn.addEventListener("click", () => {
      if (fullscreenBtn.innerHTML == `<i class="las la-expand"></i>`) {
        if (rootHtml.requestFullscreen) {
          rootHtml.requestFullscreen();
        } else if (rootHtml.msRequestFullscreen) {
          rootHtml.msRequestFullscreen();
        } else if (rootHtml.mozRequestFullScreen) {
          rootHtml.mozRequestFullScreen();
        } else if (rootHtml.webkitRequestFullscreen) {
          rootHtml.webkitRequestFullscreen();
        }
        fullscreenBtn.innerHTML = `<i class="las la-compress"></i>`;
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.msexitFullscreen) {
          document.msexitFullscreen();
        } else if (document.mozexitFullscreen) {
          document.mozexitFullscreen();
        } else if (document.webkitexitFullscreen) {
          document.webkitexitFullscreen();
        }
        fullscreenBtn.innerHTML = `<i class="las la-expand"></i>`;
      }
    });
  }

  // Ripple button effects==============
  Array.from(document.querySelectorAll('[data-anim="ripple"]'), (el) => {
    el.addEventListener("click", (e) => {
      e = e.touches ? e.touches[0] : e;
      const r = el.getBoundingClientRect(),
        d = Math.sqrt(Math.pow(r.width, 2) + Math.pow(r.height, 2)) * 2;
      el.style.cssText = `--s: 0; --o: 1;`;
      el.offsetTop;
      el.style.cssText = `--t: 1; --o: 0; --d: ${d}; --x:${
        e.clientX - r.left
      }; --y:${e.clientY - r.top};`;
    });
  });

  // Mobile Search bar
  const appSearchBtn = document.querySelector(".app-search-btn");
  if (appSearchBtn) {
    const appSearch = document.querySelector(".topbar-search");
    appSearchBtn.addEventListener("click", () => {
      appSearch.style.cssText = "transform:translateY(0);transition:0.3s";
      const overlay = document.createElement("div");
      overlay.setAttribute("class", "overlay");
      appSearch.appendChild(overlay);
      if (overlay) {
        overlay.addEventListener("click", () => {
          appSearch.style.cssText =
            "transform:translateY(-130%);transition:0.3s";
          overlay.remove();
        });
      }
    });
  }

  // Summer Note modal
  $(document).on("click", ".close", function (e) {
    $(this).closest(".modal").modal("hide");
  });

  // filter dropdown
  const filterBtn = document.querySelector(".filter-btn");
  const filterDropdown = document.querySelector(".filter-dropdown");

  if (filterDropdown) {
    filterDropdown.addEventListener("click", function (event) {
      event.stopPropagation();
    });
  }

  if (filterBtn) {
    filterBtn.addEventListener("click", function (event) {
      filterDropdown.classList.toggle("show");
      event.stopPropagation();
    });

    window.addEventListener("click", function () {
      filterDropdown.classList.remove("show"); // Close dropdown when clicking outside
    });
  }

  // application installer 

$(document).ready(function(){
  var current = 1;
  var steps = $("fieldset").length;

  setProgressBar(current);

  console.log(setProgressBar(current));

  $(".next, .previous").click(function () {
      var action = $(this).hasClass("next") ? 1 : -1;
      var current_fs = $(this).parent();
      var next_fs = action === 1 ? current_fs.next() : current_fs.prev();

      var multistepField = $('multistepField');

      if(multistepField){
      
        $(".substep-content").addClass("active");
      }

      $("#progressbar li").eq($("fieldset").index(action === 1 ? next_fs : current_fs)).toggleClass("active");

      next_fs.show();
      current_fs.animate({ opacity: 0 }, { step: function (now) {
          var opacity = 1 - now;
          current_fs.css({ 'display': 'none', 'position': 'relative' });
          next_fs.css({ 'opacity': opacity });
      }, duration: 500 });
      setProgressBar(current += action);
  });

  function setProgressBar(curStep) {
      $(".progress-bar").css("width", (100 / steps) * curStep + "%");
  }

  $(".submit").click(function () {
      return false;
  });
});


var fieldSet = document.querySelectorAll('fieldset');

fieldSet.forEach(function(field) {
  var navTabs = field.querySelector('.nav-js');
  var actionButton = field.querySelector('.action-button');
  var actionButtonPrev = field.querySelector('.action-button-previous');

  if (navTabs !== null) {
    actionButton.disabled = true;
    actionButtonPrev.disabled = true;

    actionButton.style.opacity = '0.3';
    actionButtonPrev.style.opacity = '0.3';

    var lastTab = navTabs.querySelector("#lastTab");

    lastTab.addEventListener("click", () => {
      actionButton.removeAttribute('disabled');
      actionButtonPrev.removeAttribute('disabled');

      actionButton.style.backgroundColor = '';
      actionButtonPrev.style.backgroundColor = '';
    });
  }
});

})();
