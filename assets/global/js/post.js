(function () {
  "use strict";


  function handleFileUpload(files) {
    var preview = $(".file-list");
    $(files).each(function (i, file) {
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
      });

  }

  var uploadedFiles = [];
  var fileInput ;
  $(".upload-filed input").on("change", function () {

    fileInput = this;
    uploadedFiles = Array.from(uploadedFiles);
    handleFileUpload(fileInput.files);
    handelFilePreview(fileInput.files);
    uploadedFiles = createFileList(uploadedFiles);
    fileInput.files = uploadedFiles;
  });



  $(document).on('click','.remove-list',function(e){

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
  })



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
    const composeInput = composeWrapper.querySelector(".compose-input"),
      allCaptionText = composeWrapper.querySelectorAll(".caption-text"),
      inputLink = composeWrapper.querySelector("#link"),
      captionLink = composeWrapper.querySelectorAll(".caption-link");

    // Caption Text
    const updateCaptionText = (value) => {
      allCaptionText.forEach((text) => {
        text.innerText = value;
      });
    };

    composeInput.addEventListener("change", (e) => {
      updateCaptionText(e.target.value);
    });

    composeInput.addEventListener("input", (e) => {
      updateCaptionText(e.target.value);
    });

    //Caption With Link
    inputLink.addEventListener("input", (e) => {
      captionLink.forEach((link) => {
        if (e.target.value) {
          link.classList.remove("d-none");

          link.innerHTML = `
             <a href="javascript:void(0)" >
               <span class="link-domin">
                 ${e.target.value}
               </span>
               <h6>Preview</h6>
               <p>
                 Preview approximates how your content will
                 display when published.
               </p>
             </a>
           `;
        } else {
          link.classList.add("d-none");
        }
      });
    });
  }
})();
