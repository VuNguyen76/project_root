$(document).ready(function() {
    $('#chonhet').click(function() {
        var status = this.checked;
        $('input[name=chon]').each(function() {
            this.checked = status;
        });
    });
});