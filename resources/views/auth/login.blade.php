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
 @include('layouts.head')
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
          <div class="card mt-5" style="margin-top: 150px !important;">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <center><span style="font-weight: bold;">Login</span></center>
                </div>
              </div>
            </div>
            <div class="card-body">
              {{ $errors->first('email') }}
              {{ $errors->first('password') }}
              <div class="tab-content">
                <div class="tab-pane active">
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control" placeholder="Enter Your Password">
                    </div>
                    <button class="btn btn-info" type="submit">{{ __('Login') }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
  @include('layouts.script')
</body>

</html>