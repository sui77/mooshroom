$('.js-help').click( function() {
        swal({
            title: $(this).data('title'),
            buttonsStyling: false,
            confirmButtonClass: "btn btn-success btn-fill",
            html: $( $(this).data('content') ).html()
        });
    }
);