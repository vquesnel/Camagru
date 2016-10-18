function reset() {
    var elem = document.body;
    if (elem.className.match(/(?:^|\s)width--sidebar(?!\S)/))
        elem.className = '';
}

function hide() {
    var body = document.body;

    if (body.className.match(/(?:^|\s)width--sidebar(?!\S)/))
        body.className = '';
    else
        body.className = 'width--sidebar';
}

function deleteCom() {
    if (confirm("Are you sure you want to delete this comment ?")) {
        document.load('script/delete-com.php');
    } else {}
}

function buttonStart() {
    document.getElementById("selector").setAttribute("style", "display:inline-block");
    document.getElementById("finish").setAttribute("style", "display:inline-block");
}

function hideButton() {
    document.getElementById("selector").setAttribute("style", "display:none");
    document.getElementById("finish").setAttribute("style", "display:none");
}

function showMontage() {
    document.getElementById("photo").setAttribute("style", "display:block");
    document.getElementById("finish").setAttribute("src", "script/image.php");
    document.getElementById("video").setAttribute("style", "display:none");
}