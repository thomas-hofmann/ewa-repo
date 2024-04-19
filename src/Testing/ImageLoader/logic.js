$(document).ready(function(){
    setInterval(request, 2000);
});

function request(){
    let response = $.ajax({
        type: "POST",
        url: "response.php",
        async: false
    }).responseText;

    response = JSON.parse(response);

    var flexItems = $('.flex-container').find('.flex-item');
    let imageCount = flexItems.length;
    let $output = $('#output');
    $firstChild = $output.children(":last").children(":first");

    console.log(response[0], $firstChild.attr('src'));
    if(response[0] !== $firstChild.attr('src')) {
        $output.find("div:first").remove();
        let $flexItem = $('<div>');
        $flexItem.addClass('flex-item');
        $imgTag = $('<img>').attr('src', response[0]);
        $imgTag.addClass('flex-image');
        $flexItem.append($imgTag);

        $output.append($flexItem);
    }
}