<div class="log_reg_container">
	<div class="heading_buttons">
		<div class="left_btn">
			<button type="button" class="lr_btn tab_btn login_btn active" data-target="login_block">Вход в личный кабинет</button>
		</div>
		<div class="right_btn">
			<button type="button" class="lr_btn tab_btn register_btn_login" data-target="register_block">Регистрация</button>
		</div>
	</div>
	<div class="log_reg_conent">
		<div class="tab login_block">
			<form id="auth_form" method="POST">
				<div class="form-group">
					<label>Адрес электронной почты</label>
					<input name="email" type="text" id="login-email" class="form-control" placeholder="Введите адрес электронной почты">
				</div>
				<div class="form-group">
					<label>Пароль</label>
					<input type="password" id="login-pass" name="password" class="form-control" placeholder="Введите пароль">
				</div>
				<div class="form-group forgot_group">
					<a class="tab_btn forgot_pass" data-target="restore_block">Забыли пароль?</a>
				</div>
				<p id="login_message" class="alert_msg"></p>
				<div class="form-group">
					<button type="button" class="btn btn-success bottom_btn" id="login-ok">Войти</button>
				</div>
			</form>
			<!-- Soc login buttons -->
			<div class="form-group soc_group">
				<label>Войти с помощью:</label>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-danger" rel="nofollow" href="https://accounts.google.com/o/oauth2/auth?redirect_uri=http://inside3.ikiev.biz/auth_api/check_social_login/google/&response_type=code&client_id=466117815987-ivmeu3fvsp87lsuam89p64jtp0kkbsj7.apps.googleusercontent.com&scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile">Google Login</a>
					</div>
					<div class="col-md-6">
						<a class="btn btn-primary" rel="nofollow" id="fb_login_a"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a>
					</div>
				</div>
			</div>

		</div>
		<div class="tab register_block">
			<form id="auth_reg_form" method="POST">
				<div class="form-group">
					<label>Адрес электронной почты</label>
					<input id="reg-email" name="r_email" type="text" class="form-control" placeholder="Введите адрес электронной почты">
				</div>
				<div class="form-group">
					<label>Пароль</label>
					<input id="reg-pass" name="r_password" type="password" class="form-control" placeholder="Введите пароль">
				</div>
				<p id="register_message" class="alert_msg"></p>
				<div class="form-group">
					<button id="reg-ok" type="button" class="btn btn-success bottom_btn">Зарегистрироваться</button>
				</div>
			</form>
		</div>
		<div class="tab restore_block">
			<form id="auth_recovery_form" method="POST">
				<div class="form-group restore_title">
					<label>Восстановление пароля</label>
					<p>На адрес вашей электронной почты будет выслано письмо с инструкцией по смене пароля</p>
					<input id="recovery_email" name="recovery_email" type="text" class="form-control" placeholder="Введите адрес электронной почты">
				</div>
				<p id="recovery_message" class="alert_msg"></p>
				<div class="form-group">
					<button type="button" class="btn btn-success bottom_btn" id="instruction-ok">Восстановить пароль</button>
				</div>
			</form>
		</div>
	</div>
</div>