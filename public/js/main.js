$('.js-help').click( function() {
        swal({
            title: $(this).data('title'),
            buttonsStyling: false,
            confirmButtonClass: "btn btn-success btn-fill",
            html: $( $(this).data('content') ).html()
        });
    }
);


$(function() {

    var uptime = function(l) {
        var totalSeconds = $(l).data('seconds')+1;
        $(l).data('seconds', totalSeconds)

        var days= Math.floor(totalSeconds / 86400);
        totalSeconds %= 86400;
        var hours = Math.floor(totalSeconds / 3600);
        totalSeconds %= 3600;
        var minutes = Math.floor(totalSeconds / 60);
        var seconds = totalSeconds % 60;

        var result = '';
        if (days > 0) {
            result += days + ' days, ';
        } else  {
            result += hours + ':' + minutes + ':' + seconds;
        }

        $(l).html( result );
    }

   $('.js-uptime').each(function(el, l) {
       uptime(l);
       window.setInterval(function() { uptime(l); }, 1000);
   }) ;
});