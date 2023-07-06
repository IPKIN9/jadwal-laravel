<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendors/iconly/bold.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.svg')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/css/pages/auth.scoped.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Jadwal Pintar</title>
		<style>
			#myIframe{
				all: unset;
				position: absolute;
				top: 15%;
				right: 10%;
				width: calc(85% - 50%);
				height: 85%;
				border: none;
				background-color: transparent;
				mix-blend-mode: multiply;
			}
			
			.title-info{
				margin-top: 5.5%;
				margin-left: 5%;
			}
			.title-info p{
				font-size: 21pt;
				margin-top: 15px;
			}
			.title-info h4{
				margin-top: -15px;
				font-size: 40pt;
				text-transform: uppercase;
				font-weight: 800;
			}
		</style>
  </head>
  <body>
    <div id="auth">
      <div class="row h-100">
        <div class="col-lg-5 col-12 shadow">
          <div id="auth-left" class="mt-5">
            <div class="auth-logo">
             
            </div>
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Silahkan masukan username dan password.</p>
    
						@if (session('status'))
							<div class="text-success">
								{{ session('status') }}
							</div>
						@elseif(session('statusErr'))
							<div class="text-danger">
								{{ session('statusErr') }}
							</div>
						@endif

            <form action="{{route('login.process')}}" method="POST">
							@csrf
              <div class="form-group position-relative has-icon-left mb-4">
                <input name="email" type="email" required class="form-control form-control-xl" placeholder="Email">
                <div class="form-control-icon">
                  <i class="bi bi-person"></i>
                </div>
              </div>
              <div class="form-group position-relative has-icon-left mb-4">
                <input name="password" type="password" required class="form-control form-control-xl" placeholder="Password">
                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
            </form>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="title-info text-center">
            <a href="#"><img src="{{asset('assets/images/logo/logosmkn2palu.png')}}" alt="Logo"
                style="height: 110px;"></a>
            <p>Sistem Informasi Penjadwalan</p>
            <h4>SMK Negeri 2 Palu</h4>
          </div>
          <iframe id="myIframe" src="https://embed.lottiefiles.com/animation/124048"></iframe>
        </div>
      </div>
    </div>
    <script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  </body>
</html>