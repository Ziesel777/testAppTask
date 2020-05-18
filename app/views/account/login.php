<?php
	// debug($title);
?>

<div class="bg-login-form">
	<form class="p-4 login-form border rounded js-form-login">
		<div class="alert-info-container">
			<div class="alert alert-danger mb-0 js-alert-danger" role="alert">
				Извините! Неверный логин или пароль!
			</div>
		</div>
		<h1 class="font-weight-light text-muted text-center mb-5"><?=$title?></h1>
		<div class="form-group mb-4">
			<input type="text" id="name" name="name" class="form-control" placeholder="Username" required>
		</div>
		<div class="form-group mb-4">
			<input type="password" id="pass" name="pass" class="form-control" placeholder="Password" required>
		</div>

		<button type="submit" class="btn btn-dark mt-3 float-right">Log in</button>
		<a class="back-to-main" href="/">&#8592; назад на главную</a>
	</form>

</div>