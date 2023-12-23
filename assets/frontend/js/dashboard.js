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
                    otherSideMenuLink.classList.remove("active");
                    hiddenOverlay.remove();
                  }
                }
              });
  
              sideBarDropdown.classList.toggle("show-sideMenu");
              sideMenuLink.classList.toggle("active");
  
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
                sideMenuLink.classList.remove("active");
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
  
    // Calendar
    const calendarWrapper = document.querySelector(".calendar-wrapper");
    if (calendarWrapper) {
      const monthTitle = calendarWrapper.querySelector(".month-title"),
        todayBtn = calendarWrapper.querySelector(".today-btn"),
        days = calendarWrapper.querySelector(".days"),
        prevNext = calendarWrapper.querySelectorAll(".prev-next");
  
      let date = new Date(),
        currentYear = date.getFullYear(),
        currentMonth = date.getMonth();
  
      const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
  
      const renderCalendar = () => {
        let firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay(),
          lastDateOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate(),
          lastDayOfMonth = new Date(
            currentYear,
            currentMonth,
            lastDateOfMonth
          ).getDay(),
          lastDateOfLastMonth = new Date(currentYear, currentMonth, 0).getDate();
  
        let dayItem = "";
  
        // Previous month last days
        for (let i = firstDayOfMonth; i > 0; i--) {
          dayItem += `<div class="day inactive">
                          <h6 class="day-title">${
                            lastDateOfLastMonth - i + 1
                          }</h6>
                        </div>`;
        }
  
        // Current month
        for (let i = 1; i <= lastDateOfMonth; i++) {
          let isToday =
            i === date.getDate() &&
            currentMonth === date.getMonth() &&
            currentYear === date.getFullYear();
  
          dayItem += `<div class="day ${isToday ? "today" : ""}">
                          <h6 class="day-title">${i}</h6>
    
                          <div class="day-action">
                            <span
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              data-bs-title="Schedule Post"
                            >
                              <a href="./create-post.html"
                                class="post icon-btn icon-btn-md primary circle"
                              >
                                <i class="bi bi-pencil-square"></i>
                              </a>
                            </span>
  
                            <span>
                                  <a href="./create-post.html"
                                    class="post icon-btn icon-btn-md danger circle"
                                  >
                                    <i class="bi bi-send"></i>
                                  </a>
                            </span>
                          </div>
  
  
                          ${
                            isToday
                              ? `<div class="day-to-post">
                                  <a href="#">5 Posts</a>
                                </div>
                                `
                              : ""
                          }
  
                        </div>`;
        }
  
        // Next month first days
        for (let i = lastDayOfMonth; i < 6; i++) {
          dayItem += `<div class="day inactive">
                          <h6 class="day-title">${i - lastDayOfMonth + 1}</h6>
                        </div>`;
        }
        monthTitle.innerText = `${months[currentMonth]} ${currentYear}`;
        days.innerHTML = dayItem;
      };
  
      renderCalendar();
  
      // Previous & Next month
      prevNext.forEach((item) => {
        item.addEventListener("click", () => {
          if (item.id === "prev") {
            currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
            currentYear = currentMonth === 11 ? currentYear - 1 : currentYear;
          } else {
            currentMonth = currentMonth === 11 ? 0 : currentMonth + 1;
            currentYear = currentMonth === 0 ? currentYear + 1 : currentYear;
          }
  
          renderCalendar();
        });
      });
  
      // Back to Today
      todayBtn.addEventListener("click", () => {
        const currentDate = new Date();
        currentMonth = currentDate.getMonth();
        currentYear = currentDate.getFullYear();
  
        renderCalendar();
      });
    }
  
    // Social Post Previewer
  
    // File Uploader Start
    var uploadedFiles = [];
    $(".upload-filed input").on("change", function () {
      var fileInput = this;
      uploadedFiles = Array.from(uploadedFiles);
      var preview = $(".file-list");
  
      // Preview Handler
      function handleFileUpload(file) {
        var reader = new FileReader();
        uploadedFiles.push(file);
  
        reader.onload = function (e) {
          preview.append(
            `<li>
            <span class="remove-list" data-name="${file.name}">
              <i class="bi bi-x-circle"></i>
            </span>
            <img src="${e.target.result}" alt="${file.name}" />
          </li>`
          );
        };
        reader.readAsDataURL(file);
      }
  
      $(fileInput.files).each(function (i, file) {
        handleFileUpload(file);
      });
  
      // handelFilePreview Called
      handelFilePreview(fileInput.files);
  
      uploadedFiles = createFileList(uploadedFiles);
      fileInput.files = uploadedFiles;
  
      // Remove Preview And update file
  
      preview.on("click", ".remove-list", function () {
        var fileName = $(this).data("name");
        $(this).parent().remove();
  
        var selectedFiles = Array.from(uploadedFiles);
  
        selectedFiles = selectedFiles.filter(function (file) {
          return file.name != fileName;
        });
  
        var newFileList = new DataTransfer();
        selectedFiles.forEach(function (file) {
          newFileList.items.add(file);
        });
  
        uploadedFiles = newFileList.files;
        fileInput.files = newFileList.files;
        handelFilePreview(uploadedFiles);
      });
    });
  
    function handelFilePreview(files) {
      var captionImgs = document.querySelectorAll(".caption-imgs");
  
      captionImgs.forEach((imageWrap) => {
        imageWrap.innerHTML = "";
        let count = 0;
  
        Array.from(files).forEach((file) => {
          files.length === 1
            ? imageWrap.classList.add("imgOne")
            : imageWrap.classList.remove("imgOne");
  
          files.length === 2
            ? imageWrap.classList.add("imgTwo")
            : imageWrap.classList.remove("imgTwo");
  
          if (count < 3) {
            const reader = new FileReader();
            reader.addEventListener("load", (e) => {
              imageWrap.innerHTML += `
                <div class="caption-img">
                  <img src="${e.target.result}" alt="${file.name}" />
                    ${
                      count === 3 && files.length > 3
                        ? `
                          <div class="overlay">
                            <p>+${files.length - 3}</p>
                          </div>
                          `
                        : ""
                    }
                </div>
              `;
            });
            reader.readAsDataURL(file);
            count++;
          } else {
            return;
          }
        });
      });
    }
  
    function createFileList(fileItems) {
      const dataTransfer = new DataTransfer();
      console.log(dataTransfer);
      fileItems.forEach((fileItem) => {
        const file = new File([fileItem], fileItem.name);
        dataTransfer.items.add(file);
      });
      return dataTransfer.files;
    }
  
    // File Uploader End
    const composeBody = document.querySelector(".compose-body");
    if (composeBody) {
      composeBody.addEventListener("mouseover", () => {
        composeBody.classList.add("focused");
      });
  
      composeBody.addEventListener("mouseout", () => {
        composeBody.classList.remove("focused");
      });
    }
  
    const composeWrapper = document.querySelector(".compose-wrapper");
    if (composeWrapper) {
      const composeInput = composeWrapper.querySelector("#compose-input"),
        allCaptionText = composeWrapper.querySelectorAll(".caption-text"),
        inputLink = composeWrapper.querySelector("#link"),
        captionLink = composeWrapper.querySelectorAll(".caption-link");
  
      // Caption Text
      composeInput.addEventListener("input", (e) => {
        allCaptionText.forEach((text) => {
          text.innerText = e.target.value;
        });
      });
  
      //Caption With Link
      inputLink.addEventListener("input", (e) => {
        captionLink.forEach((link) => {
          link.innerHTML = `
            <a href="javascript:void(0)" class="">
              <span class="link-domin">
                ${e.target.value}
              </span>
              <h6>Sign Up | Example</h6>
              <p>
                Preview approximates how your content will
                display when published. Tests and updates
              </p>
            </a>
          `;
        });
      });
    }
  })();
  