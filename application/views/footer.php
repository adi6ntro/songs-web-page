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
	<!-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.14.0/dist/sweetalert2.all.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/custom.js?v=2021"></script>
	<script type="text/javascript">
        $(document).ready(function(){
			if (!$(".music_list_main_area_container").has(".single_music_item").length) {
				var h = window.innerHeight-333;
				$(".music_list_main_area_container").css("height", h+"px");
			}
            $( "#searchLang" ).autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "<?php echo site_url('autocomplete/language');?>",
						type: 'post',
						dataType: "json",
						data: {
							term: request.term,song:$( "#song_name_lang" ).val()
						},
						success: function( data ) {
							response( data );
						}
					});
				},
				// source: "<?php echo site_url('autocomplete/language');?>",
				select: function(event, ui){
					$('#lang_id').val(ui.item.id);
					$('#lang_id_song').val(ui.item.name);
					$('#searchLang').val(ui.item.name);
					$("#searchLangForm").submit();
				},
				focus: function(event, ui){
					$('#lang_id').val(ui.item.id);
					$('#searchLang').val(ui.item.name);
				}
            });

            $( "#searchSong" ).autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "<?php echo site_url('autocomplete/song');?>",
						type: 'post',
						dataType: "json",
						data: {
							term: request.term,lang_id:$( "#lang_id_song" ).val()
						},
						success: function( data ) {
							response( data );
						}
					});
				},
				// source: "<?php echo site_url('autocomplete/song');?>",
				select: function(event, ui){
					$('#song_name').val(ui.item.name);
					$('#song_name_lang').val(ui.item.name);
					$('#searchSong').val(ui.item.name);
					$("#searchSongForm").submit();
				},
				focus: function(event, ui){
					$('#song_id').val(ui.item.id);
					$('#searchSong').val(ui.item.name);
				}
            });

			$(".toggle-password").click(function() {
				$(this).toggleClass("fa-eye fa-eye-slash");
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text");
				} else {
					input.attr("type", "password");
				}
			});
			$('#email,#reemail').bind("cut copy paste",function(e) {
				e.preventDefault();
			});
		});

		function cancelEnter(event){
			if (event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		}

		<?php if ($this->uri->segment(1) == 'songs'){ ?>
		let note;
		ClassicEditor.create( document.querySelector( '#noteeditor' ) )
			.then( editor => {
				note = editor;
			} )
			.catch( error => {
				console.error( error );
			} );
		
		function updatenotes() {
			$('#updatenotes').hide();
			$('#savenotes').show();
			$('#note').hide();
			// $('#noteeditor').show();
			$('.ck-editor').show();
		}
		function savenotes() {
			$('#updatenotes').show();
			$('#savenotes').hide();
			$.ajax({
				url:"<?php echo site_url('savenote');?>",
				method:"POST",
				data:{note:note.getData(),song_id:<?php echo $row->id; ?>},
				cache:false,
				success:function(data){
					if(data){
						$('#note').html(note.getData());
					}
				}
			});
			$('#note').show();
			$('.ck-editor').hide();
		}
		<?php } ?>

		<?php if (in_array($this->uri->segment(1), array('','search','selected','home','songs'))){ ?>
		function load_more_songs(tipe, limit, start) {
				<?php // tipe ('selected','all','artist') ?>
				$('#load_data_message').html('<img src="<?php echo base_url();?>assets/img/Loading.gif" alt="Loading" height=100>');
				var song = (tipe == 'artist')?'<?php echo $artist;?>':'<?php echo $song;?>';
				$.ajax({
					url:"<?php echo site_url('loadmore');?>",
					method:"POST",
					data:{limit:limit, start:start, selected:tipe, song:song, lang: '<?php echo $lang_id;?>'},
					cache:false,
					success:function(data){
						var res = data.split("|");
						if (typeof image_array !== 'undefined' && image_array.length > 0) {
							$('#load_data').append(res[1]);
						}
						if(res[0] == 'no'){
							$('#load_data_message').css("display","none");
						}else{
							start = start + limit;
							$('#load_data_message').html("<a class='btn btn-loadmore' onclick='load_more_songs("+tipe+","+limit+","+start+")' id='loadMore'><i class='fa fa-caret-down' aria-hidden='true'></i> More Songs...</a>");
						}
					}
				});
		};
		<?php } ?>

		function readmore() {
			var dots = document.getElementById("dots");
			var moreText = document.getElementById("more");
			var btnText = document.getElementById("readmore");

			if (dots.style.display === "none") {
				dots.style.display = "inline";
				btnText.innerHTML = "More"; 
				moreText.style.display = "none";
			} else {
				dots.style.display = "none";
				btnText.innerHTML = "Less"; 
				moreText.style.display = "inline";
			}
		}

		function set_favorite(elem,id) {
			console.log(id);
			console.log($(elem)[0].checked);
			<?php if (!$this->session->userdata('logged_in')) { ?>
				window.location = '<?php echo base_url().'sign_up'; ?>';
			<?php } else { ?>
				$.ajax({
					url:"<?php echo site_url('selected/record');?>",
					method:"POST",
					data:{songsid:id,favorite:$(elem)[0].checked},
					cache:false,
					success:function(data){
						if (!data) {
							window.location = '<?php echo base_url().'sign_up'; ?>';
						}
						// 	show_popup('star',"Your selected song has been saved");
						// } else {
						// 	show_popup('star',"Cannot save your selected");
						// }
					}
				});
			<?php } ?>
		}

		function show_popup(type, msg) {
			let bowal = Swal.fire({
				// title: 'username',
				html: msg,
				confirmButtonText: 'CLOSE',
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			});
			if (type == 'register' || type == 'delete-account'){
				bowal.then((result) => {
					if (result.isConfirmed) {
						window.location = (type == 'delete-account')?'<?php echo base_url().'logout'; ?>':'<?php echo base_url(); ?>';
					}
				});
			}
		}

		// var csrfName = '<?php //echo $this->security->get_csrf_token_name(); ?>',
		// 	csrfHash = '<?php //echo $this->security->get_csrf_hash(); ?>';
		function change_username() {
			$('#chuserbtn').attr('disabled','true');
			$.ajax({
				url:"<?php echo site_url('change/username');?>",
				method:"POST",
				data:$('#change_user').serialize(),
				cache:false,
				success:function(data){
					$('#chuserbtn').removeAttr('disabled');
					if (data == 'yes') {
						$('#hisusername').html($('#username').val());
						$('#h-username').html($('#username').val());
						$('#username').val('');
						show_popup('username',"Your <b>username</b><br>has been successfully changed");
					} else {
						show_popup('username',data);
					}
				}
			});
		}

		function change_password() {
			$('#chpassbtn').attr('disabled','true');
			if ($("#password").val().length >= 8) {
				$.ajax({
					url:"<?php echo site_url('change/password');?>",
					method:"POST",
					data:$('#change_pass').serialize(),
					cache:false,
					success:function(data){
						$('#chpassbtn').removeAttr('disabled');
						if (data=='yes') {
							$('#password').val('');
							show_popup('password',"Your <b>password</b><br>has been successfully changed");
						} else {
							show_popup('password',data);
						}
					}
				});
			} else {
				$('#chpassbtn').removeAttr('disabled');
				show_popup('password',"Password can be changed at least 8 characters");
			}
		}

		function register() {
			$('#send').attr('disabled','true');
			$.ajax({
				url:"<?php echo site_url('register');?>",
				method:"POST",
				data:$('#signup').serialize(),
				cache:false,
				success:function(data){
					$('#send').removeAttr('disabled');
					if (data == 'email') {
						Swal.fire({
							html: `The email <b>${$('#email').val()}</b><br>is already being used in an account.<br><br>'+
								'If the account and email<br>are yours, we can send you<br>your password to this same email.`,
							showCancelButton: true,
							confirmButtonText: 'YES, SEND MY PASSWORD',
							cancelButtonText: 'CANCEL',
							customClass: {
								confirmButton: 'btn btn-swal2-confirm',
								cancelButton: 'btn btn-swal2-cancel-dark'
							},
							buttonsStyling: false,
							allowOutsideClick: false,
						}).then((result) => {
							if (result.isConfirmed) {
								$.ajax({
									url:"<?php echo site_url('forgot');?>",
									method:"POST",
									data:{email:$('#email').val()},
									cache:false,
									success:function(data){
										if (data == 'yes') {
											show_popup('register',`We have sent your last <b>password</b> to your email<br>'+
												'<b style="color:darkred">${$('#email').val()}</b><br>so you can use it to <b>log in</b>.`);
										} else {
											show_popup('reset password',data);
										}
									}
								});
							}
						});
					} else if (data.includes("successfully")) {
						$('#username').val('');
						$('#email').val('');
						$('#reemail').val('');
						show_popup('register',data);
					} else {
						show_popup('register not',data);
					}
				}
			});
		}

		function reset_password() {
			$('#forgotbtn').attr('disabled','true');
			$.ajax({
				url:"<?php echo site_url('forgot');?>",
				method:"POST",
				data:$('#forgot').serialize(),
				cache:false,
				success:function(data){
					$('#forgotbtn').removeAttr('disabled');
					if (data == 'yes') {
						show_popup('reset password',`We have sent your last <b>password</b> to your email<br>'+
				'<b style="color:#C00100">${$('#email').val()}</b><br>so you can use it to <b>log in</b>.`);
						$('#email').val('');
					} else {
						show_popup('reset password',data);
					}
				}
			});
		}
		
		<?php if($this->session->flashdata('result_signup')){ ?>
			show_popup('show result',`<?php echo $this->session->flashdata('result_signup');?>`);
		<?php } ?>

		<?php if ($this->uri->segment(1) == 'songs') { ?>
		var swiper1 = new Swiper('.swiper1', {
			slidesPerView: 1,
			spaceBetween: 30,
			centeredSlides: true,
			// loop: true,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
		var swiper2 = new Swiper('.swiper2', {
			spaceBetween: 0,
			width: 100,
			centeredSlides: true,
			autoplay: {
				delay: 5500,
				disableOnInteraction: false,
			},
		});
		<?php } else { ?>
		var swiper = new Swiper('.swiper-container', {
			spaceBetween: 0,
			width: 100,
			centeredSlides: true,
			autoplay: {
				delay: 5500,
				disableOnInteraction: false,
			},
		});
		<?php } ?>

		function delete_account(){
			Swal.fire({
				html: `Are you sure you<br>want to <b>delete</b><br>your account?<br>
					<div style='margin-top:10px;color: #C00100;font-weight:700;font-size:12px'>
					This can't be undone<br>and you will lose<br>all your saved data<br>and preferences</div>`,
				showCancelButton: true,
				reverseButtons: true,
				confirmButtonText: 'Yes, delete my account',
				cancelButtonText: 'No, please keep my account',
				customClass: {
					confirmButton: 'btn btn-swal2-confirm',
					cancelButton: 'btn btn-swal2-cancel-darker'
				},
				buttonsStyling: false,
				allowOutsideClick: false,
			}).then((result) => {
				if (result.isConfirmed) {
					confirmdelete();
				}
			});
		}

		async function confirmdelete() {
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
				inputValidator: (value) => {
					if (!value) {
						return 'You need to input your password!'
					}
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
						if (data == 'yes') {
							show_popup('delete-account',`Your Account has been deleted!<br>You cannot access your account anymore!`);
						} else {
							show_popup('password',data);
						}
					}
				});
			}
		}
	</script>
</body>

</html>
