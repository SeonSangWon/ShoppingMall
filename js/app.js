/*Login or Registration Form Submit*/
$("#login_form").submit(function (e) {
    e.preventDefault();
    var obj = $(this), action = obj.attr('name'); /*Define variables*/
    $.ajax({
        type: "POST",
        url: e.target.action,
        data: obj.serialize()+"&Action="+action,
        cache: false,
        success: function (JSON) {
            if (JSON.error != '') {
                $("#"+action+" #display_error").show().html(JSON.error);
            } else {
                //root경로 폴더 안에 index.php가 위치할 경우 ""
                //root경로에 index.php가 위치할 경우 "
                window.location.href = "";
            }
        }
    });
});

