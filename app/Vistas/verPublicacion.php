<?php 
ob_start();
?>
<div class="publicacionesUsuario">
    <h3><?php echo $publicacion->getCabecera();?></h3><br>
    <?php if(count($publicacion->getImagenes()) > 1):?>
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img id="imgInteriorPublicacion" class="d-block w-40" src="/ProyectoAlvaroTFG/web/imgPublicaciones/<?=$publicacion->getImagenes()[0]->getNombreImagen()?>" alt="First slide">
            </div>
            <?php for($i = 1; $i < count($publicacion->getImagenes()); $i++):?>
                <div class="carousel-item">   
                    <img id="imgInteriorPublicacion" class="d-block w-40" src="/ProyectoAlvaroTFG/web/imgPublicaciones/<?=$publicacion->getImagenes()[$i]->getNombreImagen()?>" alt="<?= $i . "slide"?>">
                </div>
            <?php endfor;?>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </div><br>
    <?php endif;?>
    <?php if(count($publicacion->getImagenes()) == 1){?>
        <div id="imgInteriorPublicacion" style="background-image: url(imgPublicaciones/<?= $publicacion->getImagenes()[0]->getNombreImagen()?>)"></div>
    <?php }else if(count($publicacion->getImagenes()) < 1){?>
        <div id="imgInteriorPublicacion" style="background-image: url(imgWeb/interrogacion.jpg)"></div>
        <h3>SIN IMAGEN</h3><br>
    <?php }?>
    <?php echo $publicacion->getCuerpo();?><br><br>
    <?php echo "Continente: ".$publicacion->getContinente()->getNombre();?><br>
    <?php echo "Usuario creador: ".$publicacion->getUsuario()->getNombre();?><br>
    <?php echo "Fecha de publicación: ".$publicacion->getFecha();?>
</div><br><br>
<?php
$contenido = ob_get_clean();
require 'cabecera.php';
?>