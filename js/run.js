$(document).ready(function() {
    insertNews();
    insertStat();
});

$("button").on("click", function() {
    $.ajax({
        method: "GET",
        url: "php/db/parse.php",
        success: function() {
            insertNews();
            insertStat();
        }
    });
});

function insertNews() {
    $('.news table').children('tbody').empty();
    $.ajax({
        method: "GET",
        url: "php/db/getNews.php",
        success: function(e) {
            $('.news table').children('tbody').html(e);
        }
    });
}

function insertStat() {
    $('.stat table').children('tbody').empty();
    $.ajax({
        method: "GET",
        url: "php/db/getStat.php",
        success: function(e) {
            $('.stat table').children('tbody').html(e);
        }
    });
}

$(document).on("click", '.link', function() {
    $url = $(this).data("url");
    $('.embed-responsive').html("<iframe class='embed-responsive-item' src='php/db/page.php?link=" + $url + "'></iframe>");
});

$(document).on("click", 'th', function() {
    var table = $(this).parents('table').eq(0);
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc) {
        rows = rows.reverse();
    }
    table.children('tbody').empty().html(rows);
});

function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index),
            valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ?
            valA - valB : valA.localeCompare(valB);
    };
};

function getCellValue(row, index) {
    return $(row).children('td').eq(index).text();
};
