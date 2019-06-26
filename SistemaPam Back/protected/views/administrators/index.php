<div class='adminTitle'><?php echo(Yii::app()->name);?></div>
<div class='adminSubtitle'>Datos del sistema</div>
<div class='adminTitleLine backgroundColor4'></div>
<div class='adminData'>
    <div class='adminMainOptions color1'>
        <div class='adminMainOption backgroundColor1'>Sesiones: <?php echo(Sessions::model()->count());?></div>
        <div class='adminMainOption backgroundColor1'>Usuarios: <?php echo(Users::model()->count());?></div>
    </div>
</div>