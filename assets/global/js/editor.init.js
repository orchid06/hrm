

$(document).ready(function() {
    'use strict'

    $('.summernote').summernote({
        height: 300,
        placeholder: 'Start typing...',
        dialogsInBody: true,
        toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['fullscreen'],
        ['insert', ['picture', 'link', 'video']],
        ['view', ['codeview']],

        ],
        callbacks: {
            onInit: function() {
                
            }
        }
    });

    $(".note-image-input").removeAttr('name');

  });