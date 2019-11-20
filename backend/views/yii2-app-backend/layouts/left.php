<?php use mdm\admin\components\Menuhelper; ?>
<aside class="main-sidebar">

    <section class="sidebar">

        
       
        <!-- /.search form -->
        <?php $items=mdm\admin\components\MenuHelper::getAssignedMenu(yii::$app->user->id);?>  
       
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' =>$items ,
            ]
        ) ?>

    </section>

</aside>
