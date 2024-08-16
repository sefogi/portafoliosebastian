<?php

$receiving_email_address = 'sebast18@gmail.com';

// Verificar que el archivo php-email-form.php existe
if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

// Configuración de la dirección de correo
$contact->to = $receiving_email_address;
$contact->from_name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
$contact->from_email = isset($_POST['email']) ? strip_tags($_POST['email']) : '';
$contact->subject = isset($_POST['subject']) ? strip_tags($_POST['subject']) : '';

// Validaciones de entrada
if (empty($contact->from_name) || empty($contact->from_email) || empty($contact->subject)) {
    die('Por favor, completa todos los campos requeridos.');
}

// Agregar los mensajes al correo
$contact->add_message($contact->from_name, 'From');
$contact->add_message($contact->from_email, 'Email');
$contact->add_message(isset($_POST['message']) ? strip_tags($_POST['message']) : '', 'Message', 10);

// Enviar el formulario y mostrar el resultado
echo $contact->send();

?>


