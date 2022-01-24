<?php
ob_start();
?>
<div class="listadoPublicaciones">
    <?php if(count($publicacionesUsuario)>0):?>
        <?php foreach($publicacionesUsuario as $pU):?>
            <div class="elementoListadoPublicaciones">
                <a href="/ProyectoAlvaroTFG/web/index.php?accion=verPublicacion&id=<?= $pU->getIdPublicacion();?>"><?php echo $pU->getCabecera();?></a><br><br>
                <?php if(count($pU->getImagenes())>= 1):?>
                    <div class="imgPublicaciones" style="background-image: url(imgPublicaciones/<?= $pU->getImagenes()[0]->getNombreImagen()?>)"></div><br>
                <?php else:?>
                    <div class="imgPublicaciones" style="background-image: url(imgWeb/interrogacion.jpg)"></div><br>
                <?php endif;?>
                <?php 

                $estrellas = $pU->getEstrellas();

                if(!empty($estrellas)){
                    if($estrellas == 1 || $estrellas == 0){
                        echo '<i class="fas fa-star"></i>';
                    }
                    if($estrellas == 2){
                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i>';
                    }
                    if($estrellas == 3){
                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                    }
                    if($estrellas == 4){
                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                    }
                    if($estrellas == 5){
                        echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                    }
                }else{
                    echo 'No valorado.';
                }

                ?><br><br>
                <a href="/ProyectoAlvaroTFG/web/index.php?accion=borrarPublicacion&id=<?=$pU->getIdPublicacion()?>&tk=<?= $_SESSION['token']?>"><i class="fas fa-trash"></i></a>
            </div>
        <?php endforeach;?>
    <?php else:
        echo '<div class="sinPublicaciones">NO HAS HECHO PUBLICACIONES</div>';
    endif;
    ?>
</div><br><br>
<?php
$contenido = ob_get_clean();

require 'cabecera.php';
//class="d-block w-100"
?>