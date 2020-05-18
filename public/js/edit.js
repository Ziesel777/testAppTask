export default class Edit {
	constructor(app){
		this.app = app;
		this.isMode = false;
		this.task = false;

		this.form ='.js-form';
		this.$inpName = $('#name');
		this.$inpEmail = $('#email');
		this.$inpDesc = $('#desc');
		this.$inpPerf = $('#perf');

		this.init();
	}

	init(){
		console.log('run class Edit()');

		this.clickCancelEdit();
		this.clickSaveEdit();
	}

	clickEditMode(){
		let ed = this;
		let app = this.app;

		$('.js-btn-edit').click(function () {
			if(!ed.isMode){
				let id = $(this).closest('tr').data('id');

				ed.isMode = true;

				app.loaderShow();
				ed.btnEditShow();
				ed.app.clearForm(this.form);
				app.validatorTaskForm.resetForm();

				ed.getTask(id);
			}
		});
	}

	clickSaveEdit(){
		let ed = this;
		let app = this.app;

		$('.js-btn-save').click(function () {
			if(ed.isMode){
				ed.isMode = false;

				app.loaderShow();
				ed.setTask();
			}
		});
	}

	clickCancelEdit(){
		let ed = this;

		$('.js-btn-cancel').click(function () {
			if(ed.isMode){
				ed.isMode = false;

				ed.btnEditHide();
				ed.app.clearForm(this.form);
			}
		});
	}

	async getTask(id){
		let app = this.app;
		let data = {
			id: id,
		};

		if(id){
			this.task = await new Promise((resolve)=>{
				$.ajax({
					type: "POST",
					url: "/getidtask",
					data: data,
					dataType: "json",
					success: (res) => {
						if(res.data){
							app.loaderHide(500);
							resolve(res.data);
						} else if(res.error=='admin'){
							window.location.pathname='/account/login';
						}
						console.log(res);
					}
				});
			});
		}

		if(this.task) {
			this.createFormEditMode();
		}
	}

	setTask(){
		let ed = this;
		let app = this.app;
		let data = {
			id: this.task.id,
			desc: this.$inpDesc.val(),
			perf: this.$inpPerf.prop('checked')? 1 : null,
			edit: this.task.edited,
		};
		if(data.desc!=this.task.text_task) data.edit = 1;

		if(data.desc!=this.task.text_task || data.perf!=this.task.performed){
			$.ajax({
				type: "POST",
				url: "/setidtask",
				data: data,
				dataType: "json",
				success: (res) => {
					app.loaderHide(500);
					app.clearForm(this.form);
					ed.btnEditHide();
					app.updateTasks();
					if(res.success){
						app.alertShow('success',600,'Изменения успешно сохранены!');
					} else if(res.error=='admin'){
						window.location.pathname='/account/login';
					}
					console.log(res);
				}
			});
		} else {
			ed.isMode=true;
			app.loaderHide(500);
			app.alertShow('danger',600,'Нет изменений задачи!');
		}
	}

	createFormEditMode() {
		let task = this.task;
		console.log(task);

		this.$inpName
			.prop('readonly', true)
			.val(task.name);

		this.$inpEmail
			.prop('readonly', true)
			.val(task.email);

		this.$inpDesc
			.val(task.text_task);

		this.$inpPerf
			.prop('checked',(task.performed!=null&&task.performed!=0));
	}

	btnEditShow(duration=300){
		$('.js-btn-save').show(duration);
		$('.js-btn-cancel').show(duration);
		$('.js-check-status').show(duration);
		$('.js-lead').show(duration);

		$('.js-add-task').hide(duration);
	}
	btnEditHide(duration=300){
		$('.js-btn-save').hide(duration);
		$('.js-btn-cancel').hide(duration);
		$('.js-check-status').hide(duration);
		$('.js-lead').hide(duration);

		$('.js-add-task').show(duration);
	}
}