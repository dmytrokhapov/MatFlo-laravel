function startLoader(){
    // $(".preloader").fadeIn();
    $(".preloader").css({'height':'100%'});
    $(".preloader span").fadeIn();
}

function stopLoader(){
    // $(".preloader").fadeOut();
    $(".preloader").css({'height':'0'});
    $(".preloader span").fadeOut();
}