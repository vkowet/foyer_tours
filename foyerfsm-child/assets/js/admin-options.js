jQuery(document).ready(function($) {
    // Media uploader
    $('.media-uploader').click(function(e) {
        e.preventDefault();
        
        var button = $(this);
        var target = button.data('target');
        var field = $('#' + target);
        
        var frame = wp.media({
            title: 'Choisir une image',
            multiple: false
        });
        
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            field.val(attachment.id);
            $('#preview-' + target).html('<img src="' + attachment.sizes.thumbnail.url + '" />');
            button.siblings('.media-remove').show();
        });
        
        frame.open();
    });
    
    // Remove image
    $('.media-remove').click(function(e) {
        e.preventDefault();
        
        var button = $(this);
        var target = button.data('target');
        $('#' + target).val('');
        $('#preview-' + target).empty();
        button.hide();
    });
});