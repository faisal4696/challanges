<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
 @include('admin.layouts.head')
</head>

<body class="">
  <div class="wrapper ">
    @include('admin.layouts.sidebar')
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Settings</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          @include('admin.layouts.top-right')
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        @if(Session::has('error'))
          <div class="alert alert-warning">{{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          @if(Session::has('success'))
          <div class="alert alert-success">{{ Session::get('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
        <div class="container-fluid">
           
           <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title"></span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#addsetting" data-toggle="tab">
                          Setting
                          <div class="ripple-container"></div>
                          </a>
                        </li>
                        <!-- <li class="nav-item">
                          <a class="nav-link" href="#viewsetting" data-toggle="tab">
                            <i class="material-icons">view</i> View Setting
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="addsetting">
                      <!-- <form action="{{ URL('/addsetting') }}" method="POST" enctype="multipart/form-data"> -->
                      <form action="{{ route('editsetting') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group">
                          <label for="copyright">Copyright</label>
                          <textarea class="form-control" name="copyright" id="" cols="30" rows="2" required>{{ $setting->copyright }}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="terms">Terms</label>
                          <textarea class="form-control" name="terms" id="" cols="30" rows="2" required>{{ $setting->terms }}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="privacy">Privacy</label>
                          <textarea class="form-control" name="privacy" id="" cols="30" rows="2" required>{{ $setting->privacy }}</textarea>
                        </div>
                        <img src="{{ asset('/uploads/images/'.$setting->logo) }}" style="height: 50px; width: 50px; background: black;" alt="logo">
                        <input type="hidden" name="setting_id" value="{{ $setting->id }}">
                        <input type="file" name="file" class="form-control">
                        <button class="btn btn-success" type="submit">Submit</button>
                      </form>
                    </div>
                    <!-- <div class="tab-pane" id="viewsetting">
                      <table class="table">
                        <tbody>
                          <tr>
                            <th>logo</th>
                            <th><img src="{{ asset('uploads/images/'.$setting->logo) }}" alt="logo"></th>
                          </tr>
                          <tr>
                            <th>copyright</th>
                            <td>{{ $setting->copyright }}</td>
                          </tr>
                          <tr>
                            <th>terms</th>
                            <td>{{ $setting->terms }}</td>
                          </tr>
                          <tr>
                            <th>privany</th>
                            <td>{{ $setting->privacy }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>

        </div>
      </div>
       @include('admin.layouts.footer')
    </div>
  </div>
   @include('admin.layouts.fixed-plug')
  @include('admin.layouts.script')
</body>

</html>