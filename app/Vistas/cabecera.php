<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="css/estilos.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>    
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcontenido" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarcontenido">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php"><i class="fas fa-home"></i> INICIO</a>
                        </li>
                        <?php if(Sesion::existe()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php?accion=publicacionesUsuario"><i class="fas fa-user"></i> MIS PUBLICACIONES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php?accion=mostrarNuevaPublicacion"><i class="fas fa-plus"></i> NUEVA PUBLICACIÓN</a>
                            </li>
                        <?php endif;?>
                        <li class="nav-item">
                            <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php?accion=mostrarBuscarPublicacion"><i class="fas fa-search"></i> BUSCAR PUBLICACIONES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php?accion=mejoresPublicaciones"><i class="fas fa-star"></i> PUBLICACIONES TOP</a>
                        </li>
                        <?php if(!Sesion::existe()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php?accion=mostrarIniciarSesion"><i class="fas fa-sign-in-alt"></i> INICIAR SESIÓN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php?accion=mostrarRegistrarSesion"><i class="fas fa-registered"></i> REGISTRO</a>
                            </li>
                        <?php endif;?>
                        <?php if(Sesion::existe()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/ProyectoAlvaroTFG/web/index.php?accion=cerrarSesion"><i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN</a>
                            </li>
                        <?php endif;?>
                        <?php if(Sesion::existe()): ?>
                            <li class="nav-item">
                                <div id="imgUsuario" style="background-image: url(imgUsuarios/<?= Sesion::obtener()->getImagen()?>)"></div>
                                <form id="formulario_actualizar_foto" action="/ProyectoAlvaroTFG/web/index.php?accion=cambiarFoto" method="post" enctype="multipart/form-data">
                                    <input type="file" name="imagen" id="input_foto">
                                    <input type="submit">
                                </form>
                            </li>
                        <?php endif;?>    
                    </ul>
                </div>
            </div>
        </nav>
        <main>        
            <?= $contenido ?>
        </main>
        <footer class="footerMensajes"> 
            <div>
                <?= mostrarMensajes::imprimirMensaje();?>
            </div>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript">

            $('#imgUsuario').click(function () {
                $('#input_foto').click();
            });

            $('#input_foto').change(function () {
                $('#formulario_actualizar_foto').submit();
            })

        </script>
    </body>
</html>
