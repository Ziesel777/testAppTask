import Edit from './edit.js';

class App {
	constructor(){
		this.path = window.location.pathname;
		this.admin = false;
		this.page = 1;
		this.countTasktoPage = 3;
		this.countPage = null;
		this.data=null;
		this.validatorTaskForm=null;

		$(()=>{
			$('.js-pagination').hide();
			this.loaderHide();
			this.loaderShow();

			this.init();
		});
	}

	async init(){
		await this.isAdmin();

		switch (this.path) {
			case '/':{
				if(this.admin){
					this.edit = new Edit(this);
				}

				this.updateTasks();
				this.validateAddTask();
				this.clickSort();

				break;
			}

			default:{
				this.validateLogin();
				break;
			}
		}
	}

	async loadData(){
		this.data = await new Promise((resolve)=>{
			$.ajax({
				type: "POST",
				url: "/gettask",
				success: function (data) {
					resolve(data);
				}
			});
		});
	}

	async isAdmin(){
		this.admin = await new Promise((resolve)=>{
			$.ajax({
				type: "POST",
				url: "/account/isadmin",
				success: function (data) {
					resolve(data=='true');
				}
			});
		});
	}

	async updateTasks(){
		await this.loadData();

		$('.js-loader').fadeOut(500,()=>{
			$('#app').removeClass('invisible');
		});

		this.drawTasks();
		this.drawLinkPage();
	}

	clearForm(form){
		let $inputs = $(form).find('.form-control');

		$inputs.each(function (index, inp) {
			$(inp)
				.val('')
				.prop('checked', false)
				.prop('readonly', false);
		});
	}

	drawTasks(){
		let admin = this.admin;
		let data = this.data;
		let page = this.page;
		let count = this.countTasktoPage;

		$('.js-task-wrapper').html('');

		$.each(data, function (i, elem) {
			let id = elem.id,
				name = elem.name,
				email = elem.email,
				desc = elem.text_task,
				status = (elem.performed!=null && elem.performed!=0) ? 'выполнено':'в работе',
				edit = (elem.edited!=null && elem.edited!=0) ? '<br><b class="text-warning">отред.админ</br>':'',
				classPerf = (elem.performed!=null && elem.performed!=0) ? 'job':'success';

				let tpl =
					`<tr>
						<th scope="row">${i+1}</th>
						<td>${name}</td>
						<td>${email}</td>
						<td>${desc}</td>
						<td>
							<b class="${classPerf}">${status}</b>
						</td>
					</tr>`;

				if(admin){
					tpl =
					`<tr data-id="${id}">
						<th scope="row">${i+1}</th>
						<td>${name}</td>
						<td>${email}</td>
						<td>${desc}</td>
						<td>
							<b class="${classPerf}">${status}</b>
							${edit}
						</td>
						<td><div class="btn btn-sm btn-dark js-btn-edit">+</div></td>
					</tr>`;
				}

			if(i >= ((page-1)*count) && i<(page*count)){
				$('.js-task-wrapper').append(tpl);
			} else {
				return;
			}
		});

		if(this.admin){
			this.edit.clickEditMode();
		}

		this.loaderHide(500);
	}

	addTask(name,email,desc){
		let data = {
			name: name,
			email: email,
			desc: desc
		};

		let regxss = /<(|\/|[^\/>][^>]+|\/[^>][^>]+)>/g;
		let isXss = name.match(regxss) == null &&
					email.match(regxss) == null &&
					desc.match(regxss) == null;

		// console.log(isXss);

		if(isXss){
			$.ajax({
				type: "POST",
				url: "/addtask",
				data: data,
				dataType: "json",
				success: (res) => {
					if(res.success) {
						console.log(res.success);

						// this.page = this.countPage;
						this.updateTasks();
						this.alertShow('success');
					}
				}
			});
		} else {
			this.alertShow('danger');
		}
	}

	drawLinkPage() {
		let countItem = this.data.length;

		let $pagination = $('.js-pagination');
		let $linkWrapper = $pagination.find('.js-link-wrapper');

		let countPage = Math.ceil(countItem / this.countTasktoPage);
		this.countPage = countPage;

		if($pagination.length && countPage>1){
			$pagination.show();

			$linkWrapper.html('');
			// console.log($linkWrapper.html());
			for(let i=0;i<countPage;i++){
				let active = this.page==(i+1)?'active':'';
				let tpl = `<li class="page-item ${active}"><a class="page-link js-page-link" data-page="${i+1}" href="#">${i+1}</a></li>`;

				$linkWrapper.append(tpl);
			}

			this.clickLinkPage();
		} else {
			$pagination.hide();
		}
	}

	validateAddTask(){
		let app = this;
		let inputs = $('.js-form').find('.form-control');

		this.validatorTaskForm = $('.js-form').validate({
			rules: {
				name: {
					required: true,
					rangelength: [4, 40],
				},
				email: {
					required: true,
				},
				desc: {
					required: true,
					minlength: 10,
				},
			},
			messages: {
				name: {
					required: "Поле не заполненно",
					rangelength: "Имя должно быть не менее 4 и не более 40 символов",
				},
				email: {
					required: "Поле не заполненно",
					email: "Введите валидный email.",
				},
				desc: {
					required: "Поле не заполненно",
					minlength: "Текст задачи не может быть мение 10 символов",
				},
			},
			submitHandler: function(form) {
				let name = $('#name').val();
				let email = $('#email').val();
				let desc = $('#desc').val();

				app.addTask(name, email, desc);
				app.clearForm(form);
			}
		});

		for(let inp of inputs){
			$(inp).on('keyup change blur', function () {
				if ($('.js-form').valid()) {
					$('.js-form').find('.btn').prop('disabled', false);
				} else {
					$('.js-form').find('.btn').prop('disabled', true);
				}
			});
		}
	}

	login(name,pass){
		let data = {
			name: name,
			pass: pass
		};

		// console.log(data);
		let regxss = /<(|\/|[^\/>][^>]+|\/[^>][^>]+)>/g;
		let isXss = name.match(regxss) == null &&
					pass.match(regxss) == null;

		if(isXss){
			$.ajax({
				type: "POST",
				url: "/account/user",
				data: data,
				dataType: "json",
				success: (res) => {
					// console.log(res);
					if(res.success){
						window.location.pathname='';
					} else {
						this.alertShow('danger');
					}
				}
			});
		} else {
			this.alertShow('danger');
		}
	}

	validateLogin(){
		let app = this;
		let inputs = $('.js-form-login').find('.form-control');

		$('.js-form-login').validate({
			rules: {
				name: {
					required: true,
					rangelength: [4, 40],
				},
				pass: {
					required: true,
				},
			},
			messages: {
				name: {
					required: "Поле не заполненно",
					rangelength: "Имя должно быть не менее 4 и не более 40 символов",
				},
				pass: {
					required: "Поле не заполненно",
				},
			},
			submitHandler: function(form) {
				let name = $('#name').val();
				let pass = $('#pass').val();

				app.login(name, pass);
				app.clearForm(form);
			}
		});

		for(let inp of inputs){
			$(inp).on('keyup change blur', function () {
				if ($('.js-form-login').valid()) {
					$('.js-form-login').find('.btn').prop('disabled', false);
				} else {
					$('.js-form-login').find('.btn').prop('disabled', true);
				}
			});
		}
	}

	clickLinkPage() {
		let app = this;

		$('.js-page-link').off().click(function (e){
			e.preventDefault();
			app.loaderShow();

			app.page = $(this).data('page');

			app.drawTasks();
			app.drawLinkPage();
		});

		$('.js-page-prev').off().click(function (e){
			e.preventDefault();

			if(app.page > 1) {
				app.loaderShow();
				app.page--;

				app.drawTasks();
				app.drawLinkPage();
			}
		});

		$('.js-page-next').off().click(function (e){
			e.preventDefault();

			if(app.page < app.countPage) {
				app.loaderShow();
				app.page++;

				app.drawTasks();
				app.drawLinkPage();
			}
		});
	}

	loaderShow(duration=0){
		$('.js-loader').fadeIn(duration);
	}
	loaderHide(duration=0){
		$('.js-loader').fadeOut(duration);
	}

	alertShow(type,duration=600,infoText){
		switch (type) {
			case 'success': {
				let text = $('.js-alert-success').text();

				if(infoText) {
					$('.js-alert-success').text(infoText);
				}
				$('.js-alert-success').fadeIn(duration);

				setTimeout(() => {
					$('.js-alert-success').fadeOut(duration,()=>{
						if(infoText) {
							$('.js-alert-success').text(text);
						}
					});
				}, 4000);
			}
				break;

			case 'danger': {
				let text = $('.js-alert-danger').text();

				if(infoText) {
					$('.js-alert-danger').text(infoText);
				}
				$('.js-alert-danger').fadeIn(duration);

				setTimeout(() => {
					$('.js-alert-danger').fadeOut(duration,()=>{
						if(infoText) {
							$('.js-alert-danger').text(text);
						}
					});
				}, 4000);
			}
				break;
		}
	}

	sort(type, field){
		this.data.sort((a, b)=>{
			switch (type) {
				case 'up':
					return a[field] > b[field] ? 1 : -1;
				case 'down':
					return a[field] < b[field] ? 1 : -1;
			}
		});
	}

	clickSort(){
		let app = this;

		$('.js-upsort').click(function(){
			let field = $(this).closest('th').data('sort');

			app.sort('up',field);
			app.drawTasks();
		});

		$('.js-downsort').click(function(){
			let field = $(this).closest('th').data('sort');

			app.sort('down',field);
			app.drawTasks();
		});
	}
}

export default new App();