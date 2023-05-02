<?php 

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class AuthController {
    
    /**
     * muestra la pagina de login
     */
    public static function login(Router $router) {
        
        if($_SERVER['REQUEST_URI'] === '/') {
            header('Location: /login');
        }

        $alertas = [];
        
        //validar formulario
        $usuario = new Usuario;
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sincronizar objeto en memoria con $_POST
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarLogin();

            if(empty($alertas)) {
                //verificar si usuario existe en la BD
                $usuario = Usuario::where('email', $_POST['email']);

                /**
                 * Verificar si usuario existe y esta confirmado
                 */
                if(!$usuario || !$usuario->confirmado) {
                    Usuario::setAlertas('El usuario no existe o no esta verificado', 'error');
                }else {

                    //validar password
                    if( !password_verify($_POST['password'], $usuario->password) ) {
                        Usuario::setAlertas('Password incorrecto', 'error');
                    }else {
                        //Inicializar la sesión
                        session_start();
                        $_SESSION = []; //aplica reset a los valores previos de la sesión (recomendado);
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['admin'] = (int) $usuario->admin === 1 ? (int) $usuario->admin : NULL;

                        //redireccionar hacia proyectos
                        // debuguear($_SESSION);

                        if($_SESSION['admin'] !== NULL) {
                            header('Location: /admin/dashboard');
                        }else {
                            debuguear('NO eres admin...');
                            header('Location: /finalizar-registro');
                        }
                        
                    }
                }
            }
        }
        
        //recuperar las alertas
        $alertas = Usuario::getAlertas();

        //renderizar la vista
        $router->render('auth/login', [
            'titulo' => 'Inciar Sesión',
            'alertas' => $alertas
        ]);
    }

    /**
     * Cierra sesión
     */
    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /login');
    }

    /**
     * crear nueva cuenta
     */
    public static function registro(Router $router) {
        $alertas = [];    
        //crear instancia de Usuario
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sincronizar la variable con los datos existentes en POST
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar();

            if(empty($alertas)) {
                //comprobar si el usuario existe en la BD
                $existeUsuario = Usuario::where('email', $usuario->email );

                if($existeUsuario) {
                    Usuario::setAlertas("El usuario '". $usuario->email ."' ya existe", 'error');
                    $alertas = Usuario::getAlertas();
                }else {
                    //hashear password
                    $usuario->hashPassword();

                    //Eliminar password2
                    unset($usuario->password2);

                    //generar token
                    $usuario->setToken();

                    // debuguear($usuario);

                    //guardar registro en la base de datos
                    $resultado = $usuario->guardar();


                    //Enviar email de confirmación
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarEmail('confirmar');

                    //redireccionando 
                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/registro', [
            'titulo' => 'Crea tu cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);

    }

    /**
     * Verifica si un usuario existe, genera un nuevo token y envía instrucciones por correo 
     */
    public static function recuperar(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                /**
                 * La variable $usuario contendrá el valor del $_POST, servirá para pasar el name="email" a setAlertas()
                 * La variable $existeUsuario almacena el registro de la BD si se encuentra
                 * Posterio, se asigna los datos de $existeUsuario a $usuario
                 */
                $existeUsuario = $usuario->where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->confirmado) {
                    $usuario = $existeUsuario;

                    //genear un nuvo token
                    $usuario->setToken();

                    //actualizar el usuario
                    $usuario->guardar();

                    //enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarEmail('reset');
                    
                    //mostrar mensaje
                    Usuario::setAlertas('Hemos enviado a tu email las instrucciones pararecuperar tu password', 'exito');

                    // debuguear($usuario);
                }else {
                    Usuario::setAlertas("El usuario '".$usuario->email."' no existe o no esta confirmado", "error");
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar', [
            'titulo' => 'Recuperar password',
             'alertas' => $alertas
        ]);
    }

    /**
     * Guardar nuevo password, verifica si el nuevo token existe
     */
    public static function reset(Router $router) {
        $alertas = [];
        $token_valido = true; //se utilizará para mostrar o no un bloque de HTML
        
        //validar token
        $token = sanitizar($_GET['token']);
        
        if(!$token) header('Location: /');
        
        //buscar el token en la BD
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            Usuario::setAlertas('El token no es válido', 'error');
            $token_valido = false;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            //añadir el nuevo password
            $usuario->sincronizar($_POST);

            //validar password
            $alertas = $usuario->validar();
            
            if(empty($alertas)) {
                //hashear password
                $usuario->hashPassword();

                //borrar token
                $usuario->token = '';

                //guardar cambios
                $resultado = $usuario->guardar();

                if($resultado) {
                    header('Location: /login');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/reset', [
            'titulo' => 'Ingresa tu nuevo password',
            'alertas' => $alertas,
            'token_valido' => $token_valido
        ]);
    }

    /**
     * 
     */
    public static function mensaje(Router $router) {
        
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada correctamente'
        ]);

    }

    /**
     * 
     */
    public static function confirmar(Router $router) {
        $token = sanitizar($_GET['token']);
        $alertas = [];
        if(!$token) header('Location: /');

        //buscar token en la BD 
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {

            Usuario::setAlertas('Usuario no encontrado o el token no es válido', 'error');

        }else {
            $usuario->token = ''; //borrar el token
            $usuario->confirmado = 1; //cambiar confirmado a 1
            unset($usuario->password2); //borrar el password2
            $usuario->guardar(); //actualizar registro en la BD
            Usuario::setAlertas('Cuenta confirmada correctamente', 'exito');
        }
        
        $alertas = Usuario::getAlertas();        

        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta WebDevCamp',
            'alertas' => $alertas
        ]);
    }
}

?>
