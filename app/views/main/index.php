<?php

?>

<div class="loader js-loader">
	<div class="spinner-border text-secondary" role="status">
		<span class="sr-only">Loading...</span>
	</div>
</div>

<div id="app" class="invisible">
	<div class="container-fluid">
		<ul class="nav nav-pills justify-content-end mt-3">
			<li class="nav-item">
				<?php if($vars['isAdmin']): ?>
					<a class="btn btn-dark" href="/account/logout">Log out</a>
				<?php else: ?>
					<a class="btn btn-dark" href="/account/login">Log in</a>
				<?php endif ?>
			</li>
		</ul>
	</div>

	<div class="container">
		<h1 class="display-4 text-center mb-5">Задачник</h1>
		<form class="task-add-container js-form">
			<?php if($vars['isAdmin']): ?>
				<p class="lead info-lead text-primary text-right js-lead">
					<b>режим редактирования</b>
				</p>
			<?php endif ?>

			<div class="form-group col-4 pl-0">
				<input type="text" class="form-control mb-0" name="name" id="name" placeholder="Ваше имя ..." required>
			</div>

			<div class="form-group col-4 pl-0">
				<input type="email" class="form-control mb-0 mt-4" name="email" id="email" placeholder="Ваш email ..." required>
			</div>

			<div class="form-group">
				<textarea class="form-control mt-4" type="text" name="desc" id="desc" rows="5" placeholder="Описание задачи ..." required></textarea>
			</div>

			<?php if($vars['isAdmin']): ?>
				<div class="custom-control custom-switch check-status js-check-status">
					<input type="checkbox" class="custom-control-input form-control" name="perf" id="perf">
					<label class="custom-control-label" for="perf">Cтатус выполнения</label>
				</div>
			<?php endif ?>

			<div class="row justify-content-between p-3">
				<div>
					<div class="alert alert-success mb-0 js-alert-success" role="alert">
						Ваша задача успешно отправлена!
					</div>
					<div class="alert alert-danger mb-0 js-alert-danger" role="alert">
						Ошибка, попробуйте ещё раз!
					</div>
				</div>
				<div>
					<button type="submit" class="btn btn-success js-add-task">Создать задачу</button>

					<?php if($vars['isAdmin']): ?>
						<button type="button" class="btn btn-success btn-save js-btn-save mr-3">Сохранить</button>
						<button type="button" class="btn btn-success btn-cancel js-btn-cancel">Отмена</button>
					<?php endif ?>
				</div>
			</div>
		</form>
	</div>

	<hr>

	<div class="container mt-5">
		<nav>
			<ul class="pagination js-pagination">
				<li class="page-item">
					<a class="page-link js-page-prev" href="#">
						<span aria-hidden="true">&laquo;</span>
					</a>
				</li>
				<div class="link-wrapper js-link-wrapper">
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
				</div>
				<li class="page-item">
					<a class="page-link js-page-next" href="#">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>
			</ul>
		</nav>
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr class="head-table js-head-table">
					<th class="id" scope="col">
						<div class="input-group-prepend">#</div>
					</th>
					<th class="name js-name" scope="col" data-sort="name">
						<div class="input-group-prepend">
							Имя
							<button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item js-upsort" href="#">&#8593; - по возростанию</a>
								<a class="dropdown-item js-downsort" href="#">&#8595; - по убыванию</a>
							</div>
						</div>
					</th>
					<th class="email js-email" scope="col" data-sort="email">
						<div class="input-group-prepend">
							Email
							<button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item js-upsort" href="#">&#8593; - по возростанию</a>
								<a class="dropdown-item js-downsort" href="#">&#8595; - по убыванию</a>
							</div>
						</div>
					</th>
					<th class="desc" scope="col">
						<div class="input-group-prepend">Задача</div>
					</th>
					<th class="perf js-perf" scope="col" data-sort="performed">
						<div class="input-group-prepend">
							Статус
							<button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item js-upsort" href="#">&#8593; - по возростанию</a>
								<a class="dropdown-item js-downsort" href="#">&#8595; - по убыванию</a>
							</div>
						</div>
					</th>
					<?php if($vars['isAdmin']): ?>
						<th class="edit" scope="col">Ред</th>
					<?php endif ?>
				</tr>
			</thead>
			<tbody class="task-wrapper js-task-wrapper">
				<!-- <tr>
					<th scope="row">${i+1}</th>
					<td>${name}</td>
					<td>${email}</td>
					<td>${desc}</td>
					<td>${desc}</td>
					<td>
						<div class="btn btn-sm btn-dark">+</div>
					</td>
				</tr> -->
			</tbody>
		</table>
	</div>

</div>
