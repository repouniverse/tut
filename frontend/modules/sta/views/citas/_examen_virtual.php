<?php
$cadena="window.onbeforeunload = function(event)
    {
        return confirm('Esta acción eliminará el token y tendrá que solicitar uno nuevo');
    };";
 //$this->registerJs($cadena, \yii\web\View::POS_BEGIN);
$wizard_config = [
	'id' => 'stepwizard',
        'steps'=>$steps,
	/*'steps' => [
		1 => [
			'title' => 'Step 1',
			'icon' => 'glyphicon glyphicon-cloud-download',
			'content' => '<h3>Step 1</h3>This is step 1',
			'buttons' => [
				'next' => [
					'title' => 'Forward', 
					'options' => [
						'class' => 'disabled'
					],
				 ],
			 ],
		],
		2 => [
			'title' => 'Step 2',
			'icon' => 'glyphicon glyphicon-cloud-upload',
			'content' => '<h3>Step 2</h3>This is step 2',
			'skippable' => true,
		],
		3 => [
			'title' => 'Step 3',
			'icon' => 'glyphicon glyphicon-transfer',
			'content' => '<h3>Step 3</h3>This is step 3',
		],
    
	],*/
	'complete_content' => $this->render('_done',['id'=>$id]), // Optional final screen
	'start_step' => 1, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

