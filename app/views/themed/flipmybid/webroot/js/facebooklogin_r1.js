window.fbAsyncInit = function () {
    FB.init({
        appId: '449785581872611',
        xfbml: true,
        version: 'v2.5'
    });

    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {

            FB.api('/me', {fields: 'id, name, email, first_name, last_name, gender', access_token: response.authResponse.accessToken},
                function (response3) {
                    window.facebookId = response3.id;
                    window.facebookEmail = response3.email;
                    window.facebookFirstName = response3.first_name;
                    window.facebookLastName = response3.last_name;
                    window.facebookGender = response3.gender;
                    window.facebookBirthDay = response3.birthday;
                    window.location.replace('/users/register/' + facebookId + '/' + facebookEmail+ '/'
                        + facebookFirstName+ '/' + facebookLastName+ '/' + facebookGender + '/' + username );
                    return false;
                }
            );
        }
    });
};

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.facebookId = '';
//window.facebookName = '';
window.facebookEmail = '';
$(function () {
    var username = '';
    $(document).keyup(function(e) {
        if (e.which === 27) {
            $('#overlay').remove();
        }
    });

    $(document).on('click','#loading',function(e){
        $('#overlay').remove();
    });

    $('.fb-login-button').on('click', function () {
        //$('#loading-full').show();
        // var over = '<div id="overlay">' +
        //     '<div id="loading" ></div>' +
        //     '<div class="over-test">If nothing happens - Please disable any pop-up blockers in your browser<br/>(Press esc or click to close this message)</div>' +
        //     '</div>';
        // $(over).appendTo('body');

        FB.login(function (response) {
            if (response.authResponse) {
                FB.api('/me', {fields: 'id, name, email', access_token: response.authResponse.accessToken, display: 'popup'},
                    function (response3) {
                        window.facebookId = response3.id;
                        window.facebookEmail = response3.email;
                        window.location.replace('/users/login/' + facebookId + '/' + facebookEmail);
                        return false;
                    }
                );
            }
        }, {scope: 'email,public_profile,user_friends'});

        // click on the overlay to remove it
        //$('#overlay').click(function() {
        //    $(this).remove();
        //});

        // hit escape to close the overlay

        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                FB.api('/me', {fields: 'id, name, email', access_token: response.authResponse.accessToken},
                    function (response3) {
                        window.facebookId = response3.id;
                        window.facebookEmail = response3.email;
                        window.location.replace('/users/login/' + facebookId + '/' + facebookEmail);
                        return false;
                    }
                );

            }
        });
    });

    $('.fb-register-button').on('click', function (e) {
        console.log('start');
        //$('#loading-full').show();
        username = $('#FacebookUsername').val();
        if(!username){
            $('#FacebookUsername').css('border', '2px solid #FF3300')
            return false;
        }

        // var over = '<div id="overlay">' +
        //     '<div id="loading" ></div>' +
        //     '<div class="over-test">If nothing happens - Please disable any pop-up blockers in your browser<br/>(Press esc or click to close this message)</div>' +
        //     '</div>';
        // $(over).appendTo('body');

        // click on the overlay to remove it
        //$('#overlay').click(function() {
        //    $(this).remove();
        //});

        // hit escape to close the overlay
        $(document).keyup(function(e) {
            if (e.which === 27) {
                $('#overlay').remove();
            }
        });
        console.log(username);

        FB.login(function (response) {
            if (response.authResponse) {
                FB.api('/me', {fields: 'id, name, email, first_name, last_name, gender', access_token: response.authResponse.accessToken},
                    function (response3) {
                        window.facebookId = response3.id;
                        window.facebookEmail = response3.email;
                        window.facebookFirstName = response3.first_name;
                        window.facebookLastName = response3.last_name;
                        window.facebookGender = response3.gender;
                        window.facebookBirthDay = response3.birthday;
                        window.location.replace('/users/register/' + facebookId + '/' + facebookEmail+ '/'
                            + facebookFirstName+ '/' + facebookLastName+ '/' + facebookGender + '/' + username  );
                        return false;
                    }
                );
            }
        }, {scope: 'email,public_profile,user_friends,user_birthday'});
        
    });

    $('.fb-register-button-menu').on('click', function (e) {
        console.log('start');
        //$('#loading-full').show();
        username = $('#FacebookUsernameMenu').val();
        if(!username){
            $('#FacebookUsernameMenu').css('border', '2px solid #FF3300');
            return false;
        }

        var over = '<div id="overlay">' +
            '<div id="loading" ></div>' +
            '<div class="over-test">If nothing happens - Please disable any pop-up blockers in your browser<br/>(Press esc or click to close this message)</div>' +
            '</div>';
        $(over).appendTo('body');

        // click on the overlay to remove it
        //$('#overlay').click(function() {
        //    $(this).remove();
        //});

        // hit escape to close the overlay
        $(document).keyup(function(e) {
            if (e.which === 27) {
                $('#overlay').remove();
            }
        });

        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {

                FB.api('/me', {fields: 'id, name, email, first_name, last_name, gender, birthday', access_token: response.authResponse.accessToken},
                    function (response3) {
                        window.facebookId = response3.id;
                        window.facebookEmail = response3.email;
                        window.facebookFirstName = response3.first_name;
                        window.facebookLastName = response3.last_name;
                        window.facebookGender = response3.gender;
                        window.facebookBirthDay = response3.birthday;
                        console.log(window.facebookBirthDay);
                        //window.location.replace('/users/register/' + facebookId + '/' + facebookEmail+ '/'
                        //    + facebookFirstName+ '/' + facebookLastName+ '/' + facebookGender + '/' + username + '/' + window.facebookBirthDay );
                        return false;
                    }
                );
            }
            else {
                FB.login(function (response) {
                    if (response.authResponse) {
                        FB.api('/me', {fields: 'id, name, email, first_name, last_name, gender, birthday', access_token: response.authResponse.accessToken},
                            function (response3) {
                                window.facebookId = response3.id;
                                window.facebookEmail = response3.email;
                                window.facebookFirstName = response3.first_name;
                                window.facebookLastName = response3.last_name;
                                window.facebookGender = response3.gender;
                                window.facebookBirthDay = response3.birthday;
                                console.log(window.facebookBirthDay);
                                //window.location.replace('/users/register/' + facebookId + '/' + facebookEmail+ '/'
                                //    + facebookFirstName+ '/' + facebookLastName+ '/' + facebookGender + '/' + username + '/' + window.facebookBirthDay  );
                                return false;
                            }
                        );
                    }
                }, {scope: 'email,public_profile,user_friends,user_birthday'});
            }
        });
    });


});




$('.fb-connect-button').on('click', function (e) {
    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            window.location.replace('/users/connect_facebook/' + response.authResponse.userID + '/' + response.authResponse.accessToken);
        }
        else {
            FB.login(function (response) {
                if (response.authResponse) {
                    window.location.replace('/users/connect_facebook/' + response.authResponse.userID + '/' + response.authResponse.accessToken);
                }
            });
        }
    });
});

$('.fb-logout-button').on('click', function () {
    FB.logout(function (response) {
        // Person is now logged out
        window.location.reload();
    });
});