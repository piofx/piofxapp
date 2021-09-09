$(document).ready(function () {
    // Get internal and external links
    blogLinks();    
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

// Create Slug from text
function slugify(text) {
    return text
        .toString() // Cast to string
        .toLowerCase() // Convert the string to lowercase letters
        .normalize("NFD") // The normalize() method returns the Unicode Normalization Form of a given string.
        .trim() // Remove whitespace from both sides of a string
        .replace(/\s+/g, "-") // Replace spaces with -
        .replace(/[^\w\-]+/g, "") // Remove all non-word chars
        .replace(/\-\-+/g, "-"); // Replace multiple - with single -
}

// Create slug and meta title on keyup in title field
function createSlugAndMetaTitle() {
    let title = document.getElementById("title");

    // Increase Textarea size based on content
    if (title.clientHeight < title.scrollHeight) title.style.height=title.scrollHeight+"px";

    let slug = slugify(title.value);

    document.getElementById("slug").value = slug;

    if (document.getElementById("meta_title")) {
        document.getElementById("meta_title").innerHTML = title.value;
    }
}

function blogLinks(){
    let content = $("#post_editor").summernote("code");
    if (content) {
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
    }
}
