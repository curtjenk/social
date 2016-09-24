/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var postId = 0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click', function(event) {
     event.preventDefault();
     postBodyElement = event.target.parentNode.parentNode.childNodes[1];
     var postBody = postBodyElement.textContent;
     postId = event.target.parentNode.parentNode.dataset['postid'];
     console.log(postBody);
     $('#modal-text').val(postBody);
     $('#edit-modal').modal();

});

$('#modal-save').on('click', function() {
    var postBody = $('#modal-text').val();
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: {body: postBody, postId: postId, _token: token}
    })
    .done(function(msg){
        console.log(msg);
        //console.log(msg['message']);
      //change the post body to the new text
        //$(postBodyElement).text(postBody);  //my way
        $(postBodyElement).text(msg['new_body']); //tutorial way
        $('#edit-modal').modal('hide');
     });

})

$('.like').on('click', function(event) {
    postId = event.target.parentNode.parentNode.dataset['postid'];
    //assume Like is first and Dislike is second
    var isLike = event.target.previousElementSibling == null ? true : false;
    //isLike == true  Like clicked
    //isLike == false Dislike clicked
    console.log('Like: ', isLike);

    $.ajax({
        method: 'POST',
        url: urlLike,
        data: {isLike: isLike, postId: postId, _token: token}
    })
    .done(function(msg){
        //event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You like this post' : 'Like' : event.target.innerText == 'Dislike' ? 'You dislike this post' : 'Dislike';
        if (isLike) {
            if (event.target.textContent == 'Like') {
               event.target.textContent = 'You like this post';
           } else {
                event.target.textContent = 'Like';
           }
            event.target.nextElementSibling.textContent = 'Dislike';
        } else {
            if (event.target.textContent == 'Dislike') {
               event.target.textContent = 'You Dislike this post';
           } else {
                event.target.textContent = 'DisLike';
           }
            event.target.previousElementSibling.textContent = 'Like';
        }
     });
})