var isAdvancedUpload = function() {
    var div = document.createElement('div');
    return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
}();

if(isAdvancedUpload) {
    $('.drag-upload').addClass("has-drag");
    var $form = $('.drag-upload').parents("form");

    $form.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    })
        .on('dragover dragenter', function() {
            $form.addClass('is-dragover');
        })
        .on('dragleave dragend drop', function() {
            $form.removeClass('is-dragover');
        })
        .on('drop', function(e) {
            document.querySelector('#images').files = e.originalEvent.dataTransfer.files;
        });
}

var pendingImagesContainer = $(".pending-images");

function previewFiles() {
    pendingImagesContainer.empty();
    var files   = document.querySelector('#images').files;
    var count   = 0;

    function readAndPreview(file) {
        console.log(file);
        if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                var template = "<div class='col-sm-6'>\n" +
                    "               <div class='pending'>\n" +
                    "                    <div class='pending-image text-center'>\n" +
                    "                        <img src='"+this.result+"' alt='' />\n" +
                    "                    </div>\n" +
                    "                    <div class='form'>\n" +
                    "                        <div class='form-group'>\n" +
                    "                            <label class='control-label'>Image Caption</label>\n" +
                    "                            <input type='text' class='form-control' name='caption["+file.name+"]' />\n" +
                    "                        </div>\n" +
                    "                        <div class='form-group'>\n" +
                    "                            <label class='control-label'>Alt Text</label>\n" +
                    "                            <input type='text' class='form-control' name='alt_text["+file.name+"]' />\n" +
                    "                        </div>\n" +
                    "                    </div>\n" +
                    "                    <div class='text-right'>" +
                    "                       <button class='btn btn-sm btn-danger remove-image'>Remove</button>" +
                    "                    </div>\n" +
                    "                </div>\n" +
                "               </div>";
                pendingImagesContainer.append( template );
                count++;
            }, false);

            reader.readAsDataURL(file);
        }
    }

    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

$(document).on("click", ".remove-image", function(event) {
    event.preventDefault();
    $(this).parents(".pending").parent().remove();
});