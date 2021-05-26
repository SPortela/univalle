window.fbAsyncInit = function() {
    FB.init({
        appId: '3908443369192338',
        xfbml: true,
        version: 'v10.0'
    });
};

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function subscribeApp(page_id, page_access_token) {
    console.log('Subscribing page to app! ' + page_id);
    FB.api(
        '/' + page_id + '/subscribed_apps',
        'post', {
            access_token: page_access_token,
            subscribed_fields: ['leadgen']
        },
        function(response) {
            console.log('Successfully subscribed page', response);
            alertify.alert("Se ha suscrito con éxito")
        }
    );
}
// Only works after `FB.init` is called
function myFacebookLogin() {
    FB.login(function(response) {
        console.log('Successfully logged in', response);
        FB.api('/me/accounts', function(response) {
            console.log('Successfully retrieved pages', response);
            var pages = response.data;
            var ul = document.getElementById('list');
            for (var i = 0, len = pages.length; i < len; i++) {
                var page = pages[i];
                var li = document.createElement('li');
                var a = document.createElement('a');
                a.href = "#";
                a.onclick = subscribeApp.bind(this, page.id, page.access_token);
                a.innerHTML = page.name;
                li.appendChild(a);
                ul.appendChild(li);
            }
        });
    }, {
        scope: 'pages_show_list'
    });
}