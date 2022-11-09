  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">    
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img src="{{asset('dist/img/cat.jpeg')}}" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="{{asset('dist/img/cat.jpeg')}}" class="img-circle elevation-2" alt="User Image">

            <p>
               Keluarkan Session
            </p>
          </li>
          
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="" class="btn btn-default btn-flat float-right">Sign out</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar  sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Selang Nangka</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="{{URL('/')}}" class="d-block"> Tampilkan kode </a>
        </div>
      </div>
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 
          @foreach($Data as $Values)
          <li class="nav-item {{$Values['slug']}}">
            <a href="{{ $Values['url'] }}" class="nav-link {{$Values['slug']}}">
              <i class="nav-icon {{ $Values['icon'] }}"></i>
              <p>
              {{ $Values['name'] }}
              @if(!empty($Values['child']))
                <i class="right fas fa-angle-left"></i>
              @endif
              </p>
            </a>

            @foreach($Values['child'] as $Child)
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ $Child['url'] }}" class="nav-link {{$Child['slug']}}">
                  <i class="{{ $Child['icon'] }} nav-icon"></i>
                  <p>{{ $Child['name'] }}</p>
                </a>
              </li>
            </ul>
            @endforeach
          </li>
          @endforeach
        </ul>
      </nav>
    </div>
  </aside>

  <script>
    $("document").ready(function(){
      var parent = "{{$Parent->slug}}";
      $( "."+parent).addClass( "menu-is-opening menu-open active" );

      var modul = "{{$Pages['FilterMenu']->slug}}";
      $( "."+modul).addClass( "active" );
    });
  </script>
