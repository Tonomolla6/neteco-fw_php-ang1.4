$(document).ready(function() {
    $('.login').on("click",function() {
        window.location.href = amigable("?module=login");
    });
    $('.home').on("click",function() {
        window.location.href = amigable("?module=home");
    });
    validate_signin_js();
    validate_restart_js();
});

function validate_signin_js() {
    $('#signin').on("click",function() {
        var name = $('input[name=name]').val();
        var email = $('input[name=email]').val();
        var password = $('input[name=password]').val();
        var password2 = $('input[name=password2]').val();
        var num_errors = 0;
        
        //Nombre
        if(!name) {
            $('#error_nombre').html('El campo nombre es obligatorio');
            num_errors++;
        } else
            $('#error_nombre').html('');

        //Email
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!email) {
            $('#error_email').html('El campo nombre es obligatorio');
            num_errors++;
        } else if (!regex.test(email)) {
            $('#error_email').html('El email es incorrecto');
            num_errors++;
        } else 
            $('#error_email').html('');

        //Password
        if(!password) {
            $('#error_password').html('El campo contraseña es obligatorio');
            num_errors++;
        } else if (!password2) {
            $('#error_password').html('');
            $('#error_password2').html('El campo contraseña es obligatorio');
            num_errors++;
        } else if (password.length < 6 || password.length > 8) {
            $('#error_password2').html('');
            $('#error_password').html('Las contraseñas deben de tener entre 6 y 8 caracteres');
            num_errors++;
        } else if(password != password2) {
            $('#error_password').html('');
            $('#error_password2').html('Las contraseñas no coinciden');
            num_errors++;
        } else {
            $('#error_password').html('');
            $('#error_password2').html('');
        }

        if (num_errors == 0) {
            validate_signin_php(name,email,password);
        }
    });
}

function validate_signin_php(name,email,password) {
    var hash = hex_md5(email.trim().toLowerCase()); 
    $.ajax({
		type: 'POST',
		url: amigable("?module=login&function=signin"),
		data: {
            name: name,
            email: email,
            hash: hash,
            password: password
        },
		success: function(result) {
            if (result == "true") {
                $('.box').css('display','none');
                $('.box_check').css('display','flex');
                $('.box_check strong').html(name);
            } else {
                $('#error_email').html(result);
            }
        }
	});
}

function validate_restart_js() {
    $('#restart_button').on("click",function() {
        var password = $('input[name=password]').val();
        var password2 = $('input[name=password2]').val();
        var num_errors = 0;

        //Password
        if(!password) {
            $('#error_password').html('El campo contraseña es obligatorio');
            num_errors++;
        } else if (!password2) {
            $('#error_password').html('');
            $('#error_password2').html('El campo contraseña es obligatorio');
            num_errors++;
        } else if (password.length < 6 || password.length > 8) {
            $('#error_password2').html('');
            $('#error_password').html('Las contraseñas deben de tener entre 6 y 8 caracteres');
            num_errors++;
        } else if(password != password2) {
            $('#error_password').html('');
            $('#error_password2').html('Las contraseñas no coinciden');
            num_errors++;
        } else {
            $('#error_password').html('');
            $('#error_password2').html('');
        }

        if (num_errors == 0) {
            validate_restart_php(password);
        }
    });
}

function validate_restart_php(password) {
    $.ajax({
		type: 'POST',
		url: amigable("?module=login&function=change"),
		data: {
            password: password
        },
		success: function(result) {
            if (result == "true"){
                $('#succes_password2').html("Tu contraseña se ha cambiado con exito.");
                setTimeout(function(){ 
                    window.location.href = amigable("?module=login");
                }, 2000);
            } else
                $('#error_password2').html("Ha habido un error en la conexion, intentalo mas tarde");
        }
	});
}