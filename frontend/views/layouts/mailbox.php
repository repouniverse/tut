
     <li class="dropdown tasks-menu">
                <?php
                $unread = (integer)\frontend\modules\message\models\Message::find()->where(['to' => yii::$app->user->id, 'status' => 0])->count();
                // var_dump(\frontend\modules\message\models\Message::find()->where(['to' => $user->id, 'status' => 0])->createCommand()->getRawSql(),$unread );die();
                   if ($unread > 0)
                            $messagelabel='<span style="font-size:14px; font-weight:600;"><span class="label label-danger">'.$unread.'</span></span>';
                $messagelabel .='<span class="fas fa-envelope"></span>';

echo yii\bootstrap\Nav::widget([
    'encodeLabels' => false, // important to display HTML-code (fontawesome icons)
    'items' => [
    // ...
    [
      'label' => $messagelabel,
      'url' => '',
      'visible' => !Yii::$app->user->isGuest, 'items' => [
        ['label' => '<i class="fas fa-inbox"></i> '.Yii::t('message','Inbox'), 'url' => ['/message/message/inbox']],
        ['label' => '<i class="fas fa-share-square"></i>'.Yii::t('message', 'Sent'), 'url' => ['/message/message/sent']],
        '<hr>',
        ['label' => '<i class="fab fa-firstdraft"></i> '.Yii::t('message', 'Drafts'), 'url' => ['/message/message/drafts']],
        ['label' => '<i class="fas fa-clone"></i>'.Yii::t('message', 'Signature'), 'url' => ['/message/message/signature']],
        ['label' => '<i class="fas fa-calendar-times"></i> '.Yii::t('message', 'Out off office'), 'url' => ['/message/message/out-of-office']],
        ['label' => '<i class="fas fa-ban"></i>'.Yii::t('message', 'Manage Ignorelist'), 'url' => ['/message/message/ignorelist']],
        '<hr>',
        ['label' => '<i class="fas fa-plus"></i> '.Yii::t('message', 'Write a message'), 'url' => ['/message/message/compose']],
      ]
    ],

  ]]);
                ?>
             </li>  
