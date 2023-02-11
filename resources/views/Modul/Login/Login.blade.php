@include("layouts.header_meta")
<body class="login-page" style="min-height: 496.391px;">
	<div class="login-box">
	  <div class="login-logo">
	    <a href=""><b>LOGIN</b> DASHBOARD</a>
	  </div>
	  <div class="card">
	    <div class="card-body login-card-body">
        <form class="form-login">
	        <div class="input-group mb-3">
	          <input type="text" class="form-control"  name="username" placeholder="Username">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-envelope"></span>
	            </div>
	          </div>
	        </div>
	        <div class="toast"></div>
	        <div class="input-group mb-3">
	          <input type="password" class="form-control"  name="password" placeholder="Pasword">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-lock"></span>
	            </div>
	          </div>
	        </div>
	        <div class="row">
	          <div class="col-12">
	            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
	          </div>
	        </div>
	      </form>	    
	    </div>
	  </div>
	</div>
</body>
@include("layouts.footer_meta")


<script>
	$(".form-login").submit(function(e){
        e.preventDefault();
        e.stopPropagation();
        var btn = $(".btn");
        var formdata = new FormData(this);
		
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{URL("login")}}',
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            type: 'POST',
            beforeSend: function(){
				toastr.warning('Loadings...');
            },
            success: function(d){
                window.location.href = "{{URL('/')}}";
            },
            error: function(d){
                toastr.error(d.responseJSON);
            }
        });
    });
</script>
