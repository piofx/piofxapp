// Delete Image
function deleteImage() {
    // document.getElementById("featured_image").style.display = "none";
    $("#featured_image").removeClass("d-block");
    // $("#featured_image").addClass("d-none");
    $("#dropzone").removeClass("d-none");
    // $("#dropzone").addClass("d-block");
}

// Summernote
$("#post_editor").summernote({
    minHeight: 750,
    focus: true,
    fontNames:['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Eczar'],
    codemirror: {
        // codemirror options
        theme: "monokai",
        lineWrapping: true,
        mode: "text/html",
        htmlMode: true,
        lineNumbers: true,
    },
});

function addTextarea() {
    document.getElementById("post_content").innerHTML =
        $("#post_editor").summernote("code");

    document.getElementById("post_form").submit();
}

function showGroup() {
    var private = document.getElementById("private");
    var group = document.getElementById("group");
    group.style.display = private.checked ? "block" : "none";
}

// Marquee
// function marquee(a, b) {
//     console.log("here");
//     var width = b.width();
//     var start_pos = a.width();
//     var end_pos = -width;

//     function scroll() {
//         if (b.position().left <= -width) {
//             b.css("left", start_pos);
//             scroll();
//         } else {
//             time =
//                 (parseInt(b.position().left, 10) - end_pos) *
//                 (10000 / (start_pos - end_pos)); // Increase or decrease speed by changing value 10000
//             b.animate(
//                 {
//                     left: -width,
//                 },
//                 time,
//                 "linear",
//                 function () {
//                     scroll();
//                 }
//             );
//         }
//     }

//     b.css({
//         width: width,
//         left: start_pos,
//     });
//     scroll(a, b);

//     b.mouseenter(function () {
//         // Remove these lines
//         b.stop(); //
//         b.clearQueue(); // if you don't want
//     }); //
//     b.mouseleave(function () {
//         // marquee to pause
//         scroll(a, b); //
//     }); // on mouse over
// }

// $(document).ready(function () {
//     marquee($("#marquee-parent"), $("#marquee-child"));
// });
