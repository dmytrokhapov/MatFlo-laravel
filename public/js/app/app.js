function startLoader(){
    // $(".preloader").fadeIn();
    $(".preloader").css({'height':'100%'});
    $(".preloader span").fadeIn();
    $(".preloader img").fadeIn();
}

function stopLoader(){
    // $(".preloader").fadeOut();
    $(".preloader").css({'height':'0'});
    $(".preloader span").fadeOut();
    $(".preloader img").fadeOut();
}