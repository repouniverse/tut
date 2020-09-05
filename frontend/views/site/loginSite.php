  <?php use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  ?>

<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
				
				 <?php $form = ActiveForm::begin(['id' => 'form-database',
                                     'options'=>['class'=>"login100-form validate-form"]
                                     ]); ?>	

					<div class="wrap-input100 validate-input m-b-16"  data-validate = "Debe colocar nombre de usuario">
						<input id="loginform-username" name="LoginForm[username]" class="input100" type="text" name="email" placeholder="Usuario" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="fa fa-user"></span>
						</span>
					</div>
                                       <div class="help-block"></div>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Contraseña es obligatoria">
						<input id="loginform-password" name="LoginForm[password]"   class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="fa fa-lock"></span>
						</span>
					</div>
                                       <div class="help-block"></div>
					
					
					<div class="container-login100-form-btn p-t-25">
						<button class="login100-form-btn">
							Autenticar
						</button>
					</div>
                                    <br>
                                     <?= Html::a(yii::t('base.actions','¿Olvidó su password?'), ['site/request-password-reset'],['class'=>"txt1 bo1 hov1"]) ?> <?='      '?>  
                                    
                                    <span style="font-size:0.8em !important;"><span class="fa fa-bolt"></span>  V. 2.1.2.0</span>
					</div>
			     <?php ActiveForm::end(); ?>	
			</div>
		</div>
	