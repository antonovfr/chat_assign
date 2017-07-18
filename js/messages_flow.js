const REFRESH = 2000;
const userlist = $(".clickable");
const chatarea = $('.current-chat-area');

/**
 * Process form and send the message via ajax to the database
 */
$(function() {
    // Get the form element.
    var form = $('#message_sending');

    // Set up an event listener to be executed when the send button is clicked.
    $(form).submit(function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        //Store the id of the recipient
        var recipientid = $('.recipient').attr('value');
        //If no recipient is chosen, raise a visual alert
        if (typeof(recipientid) === 'undefined'){
            userlist.addClass('recipient-error');
            userlist.parent().append('<p class="error-message">Please choose a recipient</p>')
            return;
        }
        //Store the message in a variable
        var message = $('#message').val();

        //Encode the variable and the message into JSON
        var jsonData = {};
        jsonData['recipientid'] = recipientid;
        jsonData['message'] = message;


        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: "message_dispatcher.php",
            data: jsonData
        })

        //Action if the Request is successful
        .done(function () {
            // Clear the form.
            $('#message').val('');
            $('.active').fetch_messages();
        })
        //Action if the request doesn't succeed
        .fail(function (data) {
            // Output troubleshooting information to the console
            if (data.responseText !== '') {
                console.log(data.responseText);
            } else {
                console.log('Oops! An error occured and your message could not be sent.');
            }
        });
    });
});

/**
 * Handle the click on a recipient
 */
$(function() {
    userlist.click(function() { //Execute when an element from the user list is clicked
        userlist.removeClass('recipient-error');    //Remove error message and class if they exist
        $('.error-message').remove();   //Remove error message and class if they exist
        userlist.removeClass("active recipient");   //Clean the class from all the other users so that only one user can be selected
        $(this).addClass("active recipient");      //add the class to the clicked user to identify the recipient
        $('.active').fetch_messages();  //Fetch the message in the conversation from the database
    });
});

/**
 * function to fetch the messages from the database via ajax
 */
(function( $ ){
    $.fn.fetch_messages = function() {
        $.getJSON("message_retriever.php", {senderid: $(this).attr('value')}, function(j) { //Get the messages for a specific conversation
            var list = $('.message_list');
            var old = list.html(); //Store the message list to be compared with the new one, allows to detect new messages
            list.empty();
            if (j === null){
                list.append('No messages found')
            } else {
                //Format all the messages and display them in the chat
                for (var i = 0; i < j.length; i++) {
                    messages = '<li class="media"><div class="media-body">' + j[i].message;
                    messages += '<br><small class="text-muted">' + j[i].user_name + ' | ' + j[i].date;
                    messages += '</small><hr></div></li>';
                    list.append(messages)
                }
            if (old !== list.html()){ //If ever a new message is received, scroll down to display it
                chatarea.animate({
                    scrollTop: chatarea.get(0).scrollHeight
                }, 1500)
            }
            }
        });
    };
})( jQuery );

/**
 * Refresh function to fetch new message every $REFRESH milliseconds
 * This function is only executed if a recipient is selected
 */
window.setInterval(function(){
    var user_selected = $('.active');
    if (user_selected.length ) {
        user_selected.fetch_messages();
    }
}, REFRESH);
