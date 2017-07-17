const REFRESH = 2000;

$(function() {

    // Get the form.
    var form = $('#message_sending');

    // Set up an event listener for the contact form.
    $(form).submit(function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        var recipientid = $('.recipient').attr('value');
        var message = $('#message').val();

        var jsonData = {};
        jsonData['recipientid'] = recipientid;
        jsonData['message'] = message;
        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: "message_dispatcher.php",
            data: jsonData
        })
        .done(function (response) {
            // Set the message text.
            console.log(response);

            // Clear the form.
            $('#message').val('');
            $('.active').fetch_messages();
        })
        .fail(function (data) {
            // Set the message text.
            if (data.responseText !== '') {
                console.log(data.responseText);
            } else {
                console.log('Oops! An error occured and your message could not be sent.');
            }
        });
    });
});

$(function() {
    $(".clickable").click(function() {  //select the element only if it has the class clickable
        $(".clickable").removeClass("active recipient"); //remove the class from all the other users
        $(this).addClass("active recipient");      //add the class to the clicked user
        $('.active').fetch_messages();
    });
});

(function( $ ){
    $.fn.fetch_messages = function() {
        $.getJSON("message_retriever.php", {senderid: $(this).attr('value')}, function(j) {
            var list = $('.message_list');
            list.empty();
            if (j === null){
                list.append('No messages found')
            } else {
                for (var i = 0; i < j.length; i++) {
                    messages = '<li class="media"><div class="media-body">' + j[i].message;
                    messages += '<br><small class="text-muted">' + j[i].user_name + ' | ' + j[i].date;
                    messages += '</small><hr></div></li>';
                    list.append(messages)
                }
            }
        });
    };
})( jQuery );

window.setInterval(function(){
    var user_selected = $('.active');
    if (user_selected.length ) {
        user_selected.fetch_messages();
    }
}, REFRESH);
