$(document).ready(function() {
    // $.ajax({
    //     method: "GET",
    //     url: "php/db/get.php"
    // })
});

$("button").on("click", function() {
    $.ajax({
        method: "GET",
        url: "php/db/parse.php",
        success: function(e) {
            console.log(e);
        }
    });
});