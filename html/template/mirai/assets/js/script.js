// SP MENU
var nav_width;
$(".menu_btn").click(function() {
    $(this).toggleClass('active');
    nav_width = document.getElementById("sp_nav").style.right;
    if (nav_width == "-100%") {
        $('.nav_container').fadeIn();
        document.getElementById("sp_nav").style.right = "0%";
        $('body').css('overflow', 'hidden');
    } else {
        $('.nav_container').fadeOut();
        document.getElementById("sp_nav").style.right = "-100%";
        $('body').css('overflow', 'auto');
    }
});

const items = document.querySelectorAll(".sp_nav_body button");

function toggleAccordionsp() {
    const itemToggle = this.getAttribute('aria-expanded');

    for (k = 0; k < items.length; k++) {
        items[k].setAttribute('aria-expanded', 'false');
    }

    if (itemToggle == 'false') {
        this.setAttribute('aria-expanded', 'true');
    }
}

items.forEach(item => item.addEventListener('click', toggleAccordionsp));

// FQA
const accordions = document.querySelectorAll(".accordion button");

function toggleAccordion() {
    const itemToggle = this.getAttribute('aria-expanded');

    for (k = 0; k < accordions.length; k++) {
        accordions[k].setAttribute('aria-expanded', 'false');
    }

    if (itemToggle == 'false') {
        this.setAttribute('aria-expanded', 'true');
    }
}

accordions.forEach(item => item.addEventListener('click', toggleAccordion));


$(".p-pagelink_contain a").on('click', function(event) {
    if (this.hash !== "") {
        event.preventDefault();
        var hash = this.hash;

        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 300, function() {

            window.location.hash = hash;
        });
    }
});


function openPage(pageName, elmnt) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "transparent";
        tablinks[i].style.color = "#000";
        // tablinks[i].style.borderBottom = "1px solid #707070";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = "#7FB744";
    elmnt.style.color = "#fff";
    // elmnt.style.borderBottom = "none";
}

function opentab(pageName, elmnt) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("p-mypage_content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("mypage_tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "transparent";
        tablinks[i].style.color = "#7FB744";
    }
    document.getElementById(pageName).style.display = "block";
    elmnt.style.backgroundColor = "#7FB744";
    elmnt.style.color = "#fff";
    elmnt.style.borderBottom = "none";
}

$('.pagetop').on('click', function() {
    $('html,body').animate({'scrollTop': 0}, 500);
});

// $('.p-menu').on('mouseover', function() {
//     $(this).parents('.nav_list').children('.active').removeClass();

//     $(this).addClass('active');
// });

// document.getElementById("defaultOpen").click();