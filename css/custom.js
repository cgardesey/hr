jQuery(function ($) {
       $(".nav-item ul li a")
        .click(function(e) {
            var link = $(this);

            var item = link.parent(".nav-item ul li");
            if (item.hasClass("start active open")) {
                item.removeClass("start active open").children("a").removeClass("start active open");
                
            } else {
                item.addClass("start active open").children("a").addClass("start active open");
            }

            if (item.children("ul").length > 0) {
                var href = link.attr("href");
                link.attr("href", "#");
                setTimeout(function () { 
                    link.attr("href", href);
                }, 300);
                e.preventDefault();
            }
        })
        .each(function() {
            var link = $(this);
            if (link.get(0).href === location.href) {
                link.addClass("start active open").parents("li").addClass("start active open");
                return false;
            }
        });  
});