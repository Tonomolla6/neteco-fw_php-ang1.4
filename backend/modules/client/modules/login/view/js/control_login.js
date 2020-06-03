var total;
$(document).ready(function() {
    login('session');
    activity();
});

function login(stat) {
    var login_promise = function () {
        return new Promise(function(resolve, reject) {
            $.ajax({ 
                    type: 'POST',
                    url: amigable("?module=login&function=checking"),
                    dataType: 'json',
                    data: {
                        stat: stat,
                        token: localStorage.getItem("token")}
                 })
                 .done(function(data) {
                    total = data;
                    resolve(data);
                 })
                 .fail(function(textStatus) {
                    resolve("error");
            });
        });
    }

    if (stat == 'session') {
        login_promise()
        .then(function(result) {
            cart_reload();
            if (result == "error") {
                window.location.href = amigable("?module=login&function=view_checking");
            } else if (!result["stat"]) {
                $('#login i').removeClass('fa-sort-down');
                $('#login i').addClass('fa-user');
                $('#login p').html("Iniciar sesión");
                $('#login .options').css('display','none');
                $('#login .avatar').css('display','none');
                $('#login').attr('id_stat','login');
                return false;
            } else {
                $('#login p').html(result["name"]);
                $('#login i').removeClass('fa-user');
                $('#login i').addClass('fa-sort-down');
                $('#login i').css('margin','5px 0px 10px 5px');
                $('#login').css('flex-direction','row-reverse');
                $('#login .avatar').css('display','flex');
                $('#login .avatar').css('background-image','url('+result["avatar"]+')');
                $('#login .options').css('display','flex');
                $('#login').attr('id_stat','none');
                return true;
            }
        });
    } else {
        login_promise()
        .then(function(result) {
            return result["stat"];
        });
    }
}

function activity() {
    setInterval(function(){
		$.ajax({
			type : 'POST',
			url  : amigable("?module=login&function=time"),
			success :  function(result){						
				if (result == "false") 
                    window.location.href = amigable("?module=login&function=view_checking");
			}
		});
	}, 10000);
}