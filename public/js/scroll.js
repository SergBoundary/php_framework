var d = new Date();
var curr_day = d.getDate();
var curr_month = d.getMonth() + 1;
var curr_year = d.getFullYear();
var delta_day = [-2, -1, 0, 1, 2];
var delta_month = [-1, 0, 1];
var delta_year = [-1, 0, 1];

var symbol = [];
var delta_symbol = 1;
scrollLanguage ();

scrollTimes ();
scrollThemes ();
scrollAuthors ();

$(document).ready(function () {
    $("#times").click(function () {
        var btn_times = $("#times").text();
        $("#menu-scroll").text(btn_times);
        $("#menu-scroll-times").css("display","inline-block");
        $("#menu-scroll-themes").css("display","none");
        $("#menu-scroll-authors").css("display","none");
    });
    $("#themes").click(function () {
        var btn_themes = $("#themes").text();
        $("#menu-scroll").text(btn_themes);
        $("#menu-scroll-times").css("display","none");
        $("#menu-scroll-themes").css("display","inline-block");
        $("#menu-scroll-authors").css("display","none");
//        $.post("/main/ajax", {ajax_sql: 'themes'}, function(data) {
//            data = JSON.parse(data);
////                alert(data);
//            for(var id in data) {
//                alert(id+'. '+data[id]);
//            }
//        });
    });
    $("#authors").click(function () {
        var btn_authors = $("#authors").text();
        $("#menu-scroll").text(btn_authors);
        $("#menu-scroll-times").css("display","none");
        $("#menu-scroll-themes").css("display","none");
        $("#menu-scroll-authors").css("display","inline-block");
        sectionAjax ('authors');
    });

    $(document).on("click", "#times-pre-year", function () {
        delta_year[0] = delta_year[0] - 1;
        delta_year[1] = delta_year[1] - 1;
        delta_year[2] = delta_year[2] - 1;
        scrollTimes ();
    });
    $(document).on("click", "#times-post-year", function () {
        delta_year[0] = delta_year[0] + 1;
        delta_year[1] = delta_year[1] + 1;
        delta_year[2] = delta_year[2] + 1;
        scrollTimes ();
    });

    $(document).on("click", "#times-pre-month", function () {
        if (curr_month + delta_month[1] >= 1) {
            if (curr_month + delta_month[1] == 1) {
                delta_year[0] = (curr_month + delta_month[0] == 1) ? delta_year[0] - 1 : delta_year[0];
                delta_year[1] = delta_year[1] - 1;
                delta_year[2] = (curr_month + delta_month[2] == 1) ? delta_year[2] - 1 : delta_year[2];
                delta_month[0] = 12 - curr_month - 1;
                delta_month[1] = 12 - curr_month;
                delta_month[2] = (12 - curr_month + 1) - 12;
            } else {
                delta_year[0] = (curr_month + delta_month[0] == 1) ? delta_year[0] - 1 : delta_year[0];
                delta_year[2] = (curr_month + delta_month[2] == 1) ? delta_year[2] - 1 : delta_year[2];
                delta_month[0] = (curr_month + delta_month[0] == 1) ? 12 - curr_month : delta_month[0] - 1;
                delta_month[1] = delta_month[1] - 1;
                delta_month[2] = (curr_month + delta_month[2] == 1) ? 12 - curr_month : delta_month[2] - 1;
                if (curr_day + delta_day[2] > daysInMonth (delta_month[1])) {
                    delta_day[2] = delta_day[2] - 1;
                }
            }
            scrollTimes ();
        }
    });
    $(document).on("click", "#times-post-month", function () {
        if (curr_month + delta_month[1] <= 12) {
            if (curr_month + delta_month[1] == 12) {
                delta_year[0] = (curr_month + delta_month[0] == 12) ? delta_year[0] + 1 : delta_year[0];
                delta_year[1] = delta_year[1] + 1;
                delta_year[2] = (curr_month + delta_month[2] == 12) ? delta_year[2] + 1 : delta_year[2];
                delta_month[0] = 12 - curr_month;
                delta_month[1] = (12 - curr_month + 1) - 12;
                delta_month[2] = (12 - curr_month + 1) - 12 + 1;
            } else {
                delta_year[0] = (curr_month + delta_month[0] == 12) ? delta_year[0] + 1 : delta_year[0];
                delta_year[2] = (curr_month + delta_month[2] == 12) ? delta_year[2] + 1 : delta_year[2];
                delta_month[0] = (curr_month + delta_month[0] == 12) ? (12 - curr_month + 1) - 12 : delta_month[0] + 1;
                delta_month[1] = delta_month[1] + 1;
                delta_month[2] = (curr_month + delta_month[2] == 12) ? (12 - curr_month + 1) - 12 : delta_month[2] + 1;
                if (curr_day + delta_day[2] > daysInMonth (delta_month[1])) {
                    delta_day[2] = delta_day[2] - 1;
                }
            }
            scrollTimes ();
        }
    });

    $(document).on("click", "#times-pre-day", function () {
        if (curr_day + delta_day[2] > 1) {
            if (curr_day + delta_day[2] == 1) {
                delta_month[1] = 12 - curr_month;
                delta_day[1] = daysInMonth (delta_month[1]);
            } else {
                if (curr_day + delta_day[0] == 1) {
                    delta_year[0] = (curr_month + delta_month[0] == 1) ? delta_year[0] - 1 : delta_year[0];
                    delta_month[0] = (curr_month + delta_month[0] == 1) ? 12 - curr_month : delta_month[0] - 1;
                    delta_day[0] = daysInMonth (delta_month[0]);
                } else {
                    delta_day[0] = delta_day[0] - 1;
                }
                if (curr_day + delta_day[1] == 1) {
                    delta_day[1] = daysInMonth (delta_month[0]);
                } else {
                    delta_day[1] = delta_day[1] - 1;
                }
                delta_day[2] = delta_day[2] - 1;
                delta_day[3] = delta_day[3] - 1;
                delta_day[4] = delta_day[4] - 1;
            }
            scrollTimes ();
        }
    });
    $(document).on("click", "#times-post-day", function () {
        if (curr_day + delta_day[2] < daysInMonth (delta_month[1])) {
            if (curr_day + delta_day[2] == daysInMonth (delta_month[1])) {
                
            } else {
                delta_day[0] = delta_day[0] + 1;
                delta_day[1] = delta_day[1] + 1;
                delta_day[2] = delta_day[2] + 1;
                delta_day[3] = delta_day[3] + 1;
                delta_day[4] = delta_day[4] + 1;
            }
            scrollTimes ();
        }
    });
    
    $(document).on("click", "#themes-pre-letter", function () {
        if (delta_symbol > 1) {
            delta_symbol = delta_symbol - 1;
        } else {
            delta_symbol = symbol[0];
        }
        scrollThemes ();
    });
    $(document).on("click", "#themes-post-letter", function () {
        if (delta_symbol < symbol[0]) {
            delta_symbol = delta_symbol + 1;
        } else {
            delta_symbol = 1;
        }
        scrollThemes ();
    });
    
    $(document).on("click", "#authors-pre-letter", function () {
        if (delta_symbol > 1) {
            delta_symbol = delta_symbol - 1;
        } else {
            delta_symbol = symbol[0];
        }
        scrollThemes ();
    });
    $(document).on("click", "#authors-post-letter", function () {
        if (delta_symbol < symbol[0]) {
            delta_symbol = delta_symbol + 1;
        } else {
            delta_symbol = 1;
        }
        scrollThemes ();
    });
});

function scrollLanguage () {
    switch (language) {
        case 'de': {
                symbol = [29, 'A', 'Ä', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'Ö', 'P', 'Q', 'R', 'S', 'T', 'U', 'Ü', 'V', 'W', 'X', 'Y', 'Z'];
            }
            break;
        case 'en': {
                symbol = [26, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            }
            break;
        case 'fr': {
                symbol = [40, 'A', 'Â', 'À', 'B', 'C', 'Ç', 'D', 'E', 'É', 'Ê', 'È', 'Ë', 'F', 'G', 'H', 'I', 'Î', 'Ï', 'J', 'K', 'L', 'M', 'N', 'O', 'Ô', 'P', 'Q', 'R', 'S', 'T', 'U', 'Û', 'Ù', 'Ü', 'V', 'W', 'X', 'Y', 'Ÿ', 'Z'];
            }
            break;
        case 'it': {
                symbol = [37, 'A', 'À', 'Ạ', 'B', 'C', 'D', 'E', 'É', 'È', 'F', 'G', 'H', 'I', 'Í', 'Ì', 'Î', 'J', 'K', 'L', 'M', 'N', 'O', 'Ò', 'Ó', 'P', 'Q', 'R', 'S', 'T', 'U', 'Ù', 'Ú', 'V', 'W', 'X', 'Y', 'Z'];
            }
            break;
        case 'pl': {
                symbol = [34, 'A', 'Ą', 'B', 'C', 'D', 'E', 'Ę', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'Ł', 'M', 'N', 'Ń', 'O', 'Ó', 'P', 'Q', 'R', 'S', 'Ś', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ż', 'Ź'];
            }
            break;
        case 'ru': {
                symbol = [30, 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Э', 'Ю', 'Я'];
            }
            break;
        case 'sp': {
                symbol = [27, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            }
            break;
        case 'ua': {
                symbol = [32, 'А', 'Б', 'В', 'Г', 'Ґ', 'Д', 'Е', 'Є', 'Ж', 'З', 'И', 'І', 'Ї', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ю', 'Я'];
            }
            break;
    }
}

function scrollTimes () {
    $("#times-pre-year-data").text(curr_year + delta_year[0]);
    $("#times-pre-month-data").text(('0' + (curr_month + delta_month[0])).slice(-2));
    $("#times-pre-day-data-2").text(('0' + (curr_day + delta_day[0])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#times-pre-day-data-1").text(('0' + (curr_day + delta_day[1])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#times-day-data-0").text(('0' + (curr_day + delta_day[2])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2) + '.' + (curr_year + delta_year[1]));
    $("#times-post-day-data-1").text(('0' + (curr_day + delta_day[3])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#times-post-day-data-2").text(('0' + (curr_day + delta_day[4])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#times-post-month-data").text(('0' + (curr_month + delta_month[2])).slice(-2));
    $("#times-post-year-data").text(curr_year + delta_year[2]);
}

function scrollThemes () {
    $("#themes-pre-letter-data").text(symbol[delta_symbol]);
    $("#themes-pre-syllable-data").text(('0' + (curr_month + delta_month[0])).slice(-2));
    $("#themes-pre-title-data-1").text(('0' + (curr_day + delta_day[1])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#themes-title-data-0").text(symbol[delta_symbol]);
    $("#themes-post-title-data-1").text(('0' + (curr_day + delta_day[3])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#themes-post-syllable-data").text(('0' + (curr_month + delta_month[2])).slice(-2));
    $("#themes-post-letter-data").text(symbol[delta_symbol]);
}

function scrollAuthors () {
    $("#authors-pre-letter-data").text(symbol[delta_symbol]);
    $("#authors-pre-syllable-data").text(('0' + (curr_month + delta_month[0])).slice(-2));
    $("#authors-pre-fullname-data-1").text(('0' + (curr_day + delta_day[1])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#authors-fullname-data-0").text(symbol[delta_symbol]);
    $("#authors-post-fullname-data-1").text(('0' + (curr_day + delta_day[3])).slice(-2) + '.' + ('0' + (curr_month + delta_month[1])).slice(-2));
    $("#authors-post-syllable-data").text(('0' + (curr_month + delta_month[2])).slice(-2));
    $("#authors-post-letter-data").text(symbol[delta_symbol]);
}

function daysInMonth (delta) {
    return new Date(curr_year + delta_year[1], curr_month + delta, 0).getDate();
}

function sectionAjax (scroll_ajax) {
    $.ajax({
        url: '/main/ajax',
        type: 'post',
        data: {'theories': scroll_ajax, 'list': 'new'},
        success: function (res) {
            $('#theories-new').html(res);
        },
        error: function () {
            alert('Error!');
        }
    });
    $.ajax({
        url: '/main/ajax',
        type: 'post',
        data: {'theories': scroll_ajax, 'list': 'edited'},
        success: function (res) {
            $('#theories-edited').html(res);
        },
        error: function () {
            alert('Error!');
        }
    });
    $.ajax({
        url: '/main/ajax',
        type: 'post',
        data: {'theories': scroll_ajax, 'list': 'responses'},
        success: function (res) {
            $('#theories-responses').html(res);
        },
        error: function () {
            alert('Error!');
        }
    });
}
