<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- start main footer -->
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="footer_container text-center">
						<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="25" width="27" style="margin: 0px -3px;">
						<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="25" width="27" style="margin: 0px -3px;">
						<img src="<?php echo base_url();?>assets/img/logo.svg" alt="Logo" height="25" width="27" style="margin: 0px -3px;">
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- start main footer -->
	<!-- all javascript load here -->
	<script src="<?php echo base_url();?>assets/js/vendor/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url().'assets/js/vendor/jquery-ui.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/js/swiper-bundle.min.js'?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.14.0/dist/sweetalert2.all.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/custom.js?v=2021"></script>
	<script type="text/javascript">
        $(document).ready(function(){
			if (!$(".music_list_main_area_container").has(".single_music_item").length) {
				var h = window.innerHeight-333;
				$(".music_list_main_area_container").css("height", h+"px");
			}
            $( "#searchInput" ).autocomplete({
				source: "<?php echo site_url('language/autocomplete');?>",
				select: function(event, ui){
					$('#lang_id').val(ui.item.lang_id);
					$('#searchInput').val(ui.item.lang_name);
					$("form").submit();
				},
				focus: function(event, ui){
					$('#lang_id').val(ui.item.lang_id);
					$('#searchInput').val(ui.item.lang_name);
				}
            });

			<?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'search'){ ?>
			var limit = <?php echo $limit; ?>;
			var start = <?php echo $start_limit; ?>;
			var action = 'inactive';
			function load_more_songs(limit, start){
				$.ajax({
					url:"<?php echo ($lang_id=="")?site_url('loadmore'):site_url('loadmore/'.$lang_id);?>",
					method:"POST",
					data:{limit:limit, start:start},
					cache:false,
					success:function(data){
						$('#load_data').append(data);
						if(data == ''){
							$('#load_data_message').css("display","none");
							action = 'active';
						}else{							
							$('#load_data_message').html('<img src="<?php echo base_url();?>assets/img/Loading.gif" alt="Loading" height=100>');
							action = "inactive";
						}
					}
				});
			}

			if(action == 'inactive'){
				action = 'active';
				load_more_songs(limit, start);
			}
			$(window).scroll(function(){
				if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive'){
					action = 'active';
					start = start + limit;
					setTimeout(function(){
						load_more_songs(limit, start);
					}, 1000);
				}
			});
			<?php } ?>

			jQuery.validator.addMethod("noSpace", function(value, element) {
				return value.indexOf(" ") < 0 && value !== "";
			}, "Space is not allowed");
			jQuery.validator.addMethod("regex",function(value, element, regexp) {
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			}, "Please check your input");
			$.validator.setDefaults({
				highlight: function(element) {
					$(element).closest('.form-group').addClass('has-error');
				},
				unhighlight: function(element) {
					$(element).closest('.form-group').removeClass('has-error');
					$(element).closest('.form-group').addClass('has-success');
				},
				errorElement: 'span',
				errorClass: 'help-block',
				errorPlacement: function(error, element) {
					if(element.parent('.input-group').length) {
					error.insertAfter(element.parent());
					} else {
					error.insertAfter(element);
					}
				}
			});
			$("#signup").validate({
				rules: {
					username: {
						noSpace: true,
						regex: "^[a-zA-Z0-9._-\\s]{1,40}$",
						remote: {
							url: "<?php echo site_url();?>auth/check_username",
							type: "post",
							data: {
								login: function(){
								return $('#signup :input[name="username"]').val();
								}
							}
						}
					},
					email: {
						remote: {
							url: "<?php echo site_url();?>/auth/check_email",
							type: "post",
							data: {
								login: function(){
									return $('#signup :input[name="email"]').val();
								}
							}
						}
					},
				},
				onfocusout: function (element){
					if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element))){
						var currentObj = this;
						var currentElement = element;
						var delay = function () { currentObj.element(currentElement); };
						setTimeout(delay, 0);
					}
				},
				messages:{
					username:{
						remote: jQuery.validator.format("username is unavailable")
					},
					email:{
						remote: jQuery.validator.format("email is unavailable")
					}
				}
			});
			$("#login").validate({
				rules: {
					username: {
						noSpace: true,
						required: true
					},
					password: {
						required: true
					},
				},
				onfocusout: function (element){
					if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element))){
						var currentObj = this;
						var currentElement = element;
						var delay = function () { currentObj.element(currentElement); };
						setTimeout(delay, 0);
					}
				},
			});
		});

		function set_favorite(elem,id) {
			console.log(id);
			window.location = '<?php echo base_url().'sign_up'; ?>';
		}

		function show_popup(type, msg) {
			Swal.fire({
				// title: 'username',
				html: msg,
				confirmButtonText: 'CLOSE',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			});
		}

		function change_username() {
			$.ajax({
				url:"<?php echo site_url('change/username');?>",
				method:"POST",
				data:$('#change_user').serialize(),
				cache:false,
				success:function(data){
					if (data) {
						show_popup('username',"Your <b>username</b><br>has been successfully changed");
					} else {
						show_popup('username',data);
					}
				}
			});
		}

		function change_password() {
			$.ajax({
				url:"<?php echo site_url('change/password');?>",
				method:"POST",
				data:$('#change_pass').serialize(),
				cache:false,
				success:function(data){
					if (data) {
						show_popup('password',"Your <b>password</b><br>has been successfully changed");
					} else {
						show_popup('password',data);
					}
				}
			});
		}

		function reset_password() {
			Swal.fire({
				title: 'password',
				html: "Your <b>password</b><br>has been successfully changed",
				confirmButtonText: 'CLOSE',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			});
		}

		function register() {
			Swal.fire({
				title: 'password',
				html: "Your <b>password</b><br>has been successfully changed",
				confirmButtonText: 'CLOSE',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			});
		}
		var swiper = new Swiper('.swiper-container', {
			spaceBetween: 0,
			width: 100,
			centeredSlides: true,
			autoplay: {
			delay: 5500,
			disableOnInteraction: false,
			},
		});

		// $(".delete-account").click(function(){
		// });
		function delete_account(){
			Swal.fire({
				html: "Are you sure you want to <b>delete</b> your account?<br>"+
					"<span style='color: #C00100;font-weight:700;font-size:12px'>This can't be undone and you will lose all your saved data and preferences</span>",
				showCancelButton: true,
				reverseButtons: true,
				confirmButtonText: 'Yes, delete my account',
				cancelButtonText: 'No, please keep my account',
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			}).then((result) => {
				if (result.isConfirmed) {
					const { value: password } = await Swal.fire({
						html: "Please enter your <b>password</b>",
						input: 'password',
						inputAttributes: {
							autocapitalize: 'off'
						},
						showLoaderOnConfirm: true,
						showCancelButton: true,
						confirmButtonText: 'DELETE MY ACCOUNT',
						cancelButtonText: 'CANCEL',
						showClass: {
							popup: 'animate__animated animate__fadeInDown'
						},
						hideClass: {
							popup: 'animate__animated animate__fadeOutUp'
						},
						customClass: {
							confirmButton: 'btn btn-swal2-confirm',
							cancelButton: 'btn btn-swal2-cancel-dark'
						},
						buttonsStyling: false,
						allowOutsideClick: false,
					});
					if (password) {
						$.ajax({
							url:"<?php echo site_url('delete-account');?>",
							method:"POST",
							data:{password:password},
							cache:false,
							success:function(data){
								if (data) {
									window.location = '<?php echo base_url(); ?>';
								} else {
									show_popup('password',data);
								}
							}
						});
					}
				}
			});
		}
	</script>
</body>

</html>
