$(document).ready(() => {
    // change 'placeholder' of custom file input
    $(document).on('change', '.custom-file-input', (e) => {
        var fileName = $(e.target).val().split('\\').pop();
        $(e.target).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // remove file to be uploaded on custom file input
    $(document).on('click', '.remove-file-btn', (e) => {
        var el = $(e.target);
        var file_container = el.closest('.custom-file-container')
        var logo_preview = $('.logo-preview');
        file_container.find('.custom-file-input').val('').trigger('change');
        file_container.find('.custom-file-label').text('Choose file');
        logo_preview.attr('src', '#');
        logo_preview.parent().addClass('d-none');
        el.closest('.remove-file-container').addClass('d-none');
    });

    // remove error messages in forms when value is changed
    $(document).on('change', '.is-invalid', (e) => {
        var el = $(e.target);
        el.removeClass('is-invalid');

        if (el.hasClass('custom-file-input')) {
            el.closest('.input-group').siblings('.custom-invalid-feedback').remove();
        } else {
            el.siblings('.invalid-feedback').remove();
        }
    });

   // customization of datatable filter CSS
    $('div.dataTables_wrapper div.dataTables_filter > label > input')
    .css({
        "background": "url(images/search.png) no-repeat scroll left center / 20px auto",
        "padding-left": "20px"
    });
    
    // show a preview of an image on file select
    preview_image = (input) =>  {
        var url = input.val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        // if file has a valid extension
        if (input.prop('files') && input.prop('files')[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = (e) => {
                $('.logo-preview').attr('src', e.target.result);
                $('.remove-file-container').removeClass('d-none');
                $('.logo-preview-container').removeClass('d-none');
            }
            reader.readAsDataURL(input.prop('files')[0]);
        } else {
            // hide preview container
            $('.logo-preview').attr('src', '#');
            $('.logo-preview-container').addClass('d-none');
        }
    }

    

});