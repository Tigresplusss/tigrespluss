$(document).ready(function() {
    // Asignar la acción del botón al presionar la tecla Enter
    $(document).keypress(function(e) {
        if (e.which == 13) { // Verificar si la tecla presionada es Enter
            if ($('#loginform').is(":visible")) {
                $("#loginbutton").click(); // Hacer clic en el botón de login
            } else if ($('#signupform').is(":visible")) {
                $("#signupbutton").click(); // Hacer clic en el botón de registro
            }
        }
    });

    // Mostrar el formulario de registro y ocultar el de inicio de sesión
    $('#signup').click(function() {
        $('#loginform').slideUp(); // Ocultar el formulario de login
        $('#signupform').slideDown(); // Mostrar el formulario de registro
        $('#myalert').slideUp(); // Ocultar alertas
        $('#signform')[0].reset(); // Reiniciar el formulario de registro
    });

    // Mostrar el formulario de inicio de sesión y ocultar el de registro
    $('#login').click(function() {
        $('#loginform').slideDown(); // Mostrar el formulario de login
        $('#signupform').slideUp(); // Ocultar el formulario de registro
        $('#myalert').slideUp(); // Ocultar alertas
        $('#logform')[0].reset(); // Reiniciar el formulario de login
    });

    // Manejar el clic en el botón de registro
    $(document).on('click', '#signupbutton', function() {
        if ($('#susername').val() != '' && $('#spassword').val() != '') { // Verificar si ambos campos están llenos
            $('#signtext').text('Signing up...'); // Cambiar el texto del botón
            $('#myalert').slideUp(); // Ocultar alertas
            var signform = $('#signform').serialize(); // Serializar los datos del formulario
            $.ajax({
                method: 'POST',
                url: 'signup.php',
                data: signform,
                success: function(data) {
                    setTimeout(function() {
                        $('#myalert').slideDown(); // Mostrar alertas
                        $('#alerttext').html(data); // Mostrar mensaje de respuesta
                        $('#signtext').text('Sign up'); // Restaurar el texto del botón
                        $('#signform')[0].reset(); // Reiniciar el formulario de registro
                    }, 2000); // Esperar 2 segundos antes de mostrar la alerta
                }
            });
        } else {
            alert('Please input both fields to Sign Up'); // Mensaje de advertencia si los campos están vacíos
        }
    });

    // Manejar el clic en el botón de login
    $(document).on('click', '#loginbutton', function() {
        if ($('#username').val() != '' && $('#password').val() != '') { // Verificar si ambos campos están llenos
            $('#logtext').text('Logging in...'); // Cambiar el texto del botón
            $('#myalert').slideUp(); // Ocultar alertas
            var logform = $('#logform').serialize(); // Serializar los datos del formulario
            setTimeout(function() {
                $.ajax({
                    method: 'POST',
                    url: 'login.php',
                    data: logform,
                    success: function(data) {
                        if (data == '') { // Verificar si la respuesta es vacía
                            $('#myalert').slideDown(); // Mostrar alertas
                            $('#alerttext').text('Login Successful. User Verified!'); // Mensaje de éxito
                            $('#logtext').text('Login'); // Restaurar el texto del botón
                            $('#logform')[0].reset(); // Reiniciar el formulario de login
                            setTimeout(function() {
                                location.reload(); // Recargar la página después de 2 segundos
                            }, 2000);
                        } else {
                            $('#myalert').slideDown(); // Mostrar alertas
                            $('#alerttext').html(data); // Mostrar mensaje de respuesta
                            $('#logtext').text('Login'); // Restaurar el texto del botón
                            $('#logform')[0].reset(); // Reiniciar el formulario de login
                        }
                    }
                });
            }, 2000); // Esperar 2 segundos antes de enviar la solicitud
        } else {
            alert('Please input both fields to Login'); // Mensaje de advertencia si los campos están vacíos
        }
    });
});
