<?php 

/**
 * Auth: Luis Tahuilán
 * Proyecto origen: AppSalon
 */
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    protected $nombre;
    protected $email;
    protected $token;

    public function __construct($nombre, $email, $token){

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarEmail($accion) {

        //configuración del servidor de correo
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASS'];

        $phpmailer->setFrom('cuentas@devwebcamp.com');
        // $phpmailer->addAddress('cuentas@devwebcamp.com', 'devwebcamp.com');
        $phpmailer->addAddress($this->email);

        if($accion === 'confirmar') {

            $phpmailer->Subject = 'Confirma tu cuenta en devwebcamp';
            
            $phpmailer->isHTML(TRUE);
            $phpmailer->CharSet = 'UTF-8';
    
            $contenido = '<html>';
            $contenido .='<p>Hola <strong>'.$this->nombre.'</strong></p>';
            $contenido .='<p>Has creado tu cuenta en devwebcamp, solo hace falta confirmarla en el siguiente enlace:</p>';
            $contenido .='<p><a href="http://localhost:3000/confirmar-cuenta?token=' . $this->token . '">Confirma tu cuenta.</a></p>';
            $contenido .= '<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje.</p>';
            $contenido .= '</html>';
    
            $phpmailer->Body = $contenido;
            // debuguear('contenido');
            $phpmailer->send();
        }

        /**
         * Enviar instrucciones para reestablecer password
         */
        if($accion === 'reset') {
            $phpmailer->Subject = 'Restablece tu password de devwebcamp';
            
            $phpmailer->isHTML(TRUE);
            $phpmailer->CharSet = 'UTF-8';
    
            $contenido = '<html>';
            $contenido .='<p>Hola <strong>'.$this->nombre.'</strong></p>';
            $contenido .='<p>Para cambiar tu password haz clic en el siguiente enlace:</p>';
            $contenido .='<p><a href="http://localhost:3000/reset?token=' . $this->token . '">Recuperar password.</a></p>';
            $contenido .= '<p>Si tu no solicitaste cambiar tu password, puedes ignorar este mensaje.</p>';
            $contenido .= '</html>';
    
            $phpmailer->Body = $contenido;
            // debuguear('contenido');
            $phpmailer->send();
        }
    }
}
?>