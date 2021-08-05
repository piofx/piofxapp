$(document).ready(function () {
    let content = $("#post_editor").summernote("code");
    var urlRegex = /(((https?:\/\/)|(www\.))[^\s]+)/g;
    let urls = content.match(urlRegex);

    let internalLinks = {};
    let externalLinks = {};

    let baseUrl = window.location.origin;
    urls.forEach((url) => {
        url = url.replace(/['"]+/g, "");
        let u = new URL(url);
        if (u.origin == baseUrl) {
            if (u.href in internalLinks) {
                internalLinks[u.href] += 1;
            } else {
                internalLinks[u.href] = 1;
            }
        } else {
            if (u.href in externalLinks) {
                externalLinks[u.href] += 1;
            } else {
                externalLinks[u.href] = 1;
            }
        }
    });

    for (let link in internalLinks) {
        document.getElementById("internalLinks").innerHTML +=
            "<p class='d-block m-0 mb-1'>" + link + "</p>";

        document.getElementById("internalLinksCount").innerHTML +=
            "<p class='d-block m-0 mb-1'>" + internalLinks[link] + "</p>";
    }

    for (let link in externalLinks) {
        document.getElementById("externalLinks").innerHTML +=
            "<p class='d-block m-0 mb-1'>" + link + "</p>";

        document.getElementById("externalLinksCount").innerHTML +=
            "<p class='d-block m-0 mb-1'>" + externalLinks[link] + "</p>";
    }
});

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
    fontNames: [
        "Arial",
        "Arial Black",
        "Comic Sans MS",
        "Courier New",
        "Merriweather",
        "Eczar",
    ],
    codemirror: {
        // codemirror options
        theme: "monokai",
        lineWrapping: true,
        mode: "text/html",
        htmlMode: true,
        lineNumbers: true,
    },
});

function showGroup() {
    var private = document.getElementById("private");
    var group = document.getElementById("group");
    group.style.display = private.checked ? "block" : "none";
}

function blogPostSubmit(form, event) {
    event.preventDefault();

    // Set the value of the published button
    document.getElementById("publishName").value = form.submitted;

    // Set the content from the text area
    document.getElementById("post_content").innerHTML =
        $("#post_editor").summernote("code");

    form.submit();
}
