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
            <a class="navbar-brand" href="">Mileston</a>
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
       @if(Session::has('success'))
          <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <span><b>{{ Session::get('success') }}</b></span>
            </div>
        @endif
        @if(Session::has('error'))
          <div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
              </button>
              <span><b>{{ Session::get('error') }}</b></span>
            </div>
        @endif
        <div class="container-fluid">
           
           <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title"><a href="{{ URL::previous() }}" class="text-white">Challanges</a> / Mileston</span>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active">
                      <table class="table text-center table-responsive-md">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Challange Title</th>
                            <th scope="col">Challange Description</th>
                            <th scope="col">Mileston Title</th>
                            <th scope="col">Mileston Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($milestons as $key=>$val)
                          <tr>
                            <td scope="row">{{ $key+1 }}</td>
                            <td>{{ $val->challange->title }}</td>
                            <td>{{ $val->challange->description }}</td>
                            <td>{{ $val->title }}</td>
                            <td>{{ $val->description }}</td>
                            <td>{{ $val->status }}</td>
                            <td>
                              <!-- start edit post modal -->
                              <button type="button" rel="tooltip" title="Edit Post" class="btn btn-primary btn-link btn-sm" data-toggle="modal" data-target="#editmodal{{ $val->id }}">
                                <i class="material-icons">edit</i>
                              </button>

                              <div class="modal fade" id="editmodal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"></h4>
                                      </div>
                                      <form action="{{ route('update-mileston',$val->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label for="title">Title</label>
                                            <input class="form-control" type="text" name="title" value="{{ $val->title }}" requied>
                                            <input class="form-control" type="hidden" name="mileston_id" value="{{ $val->id }}">
                                          </div>
                                          <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ $val->description }}</textarea>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              <!-- end edit post modal -->

                              <!-- start Delete Modal -->
                              <button type="button" rel="tooltip" title="Delete" class="btn btn-danger btn-link btn-sm" data-toggle="modal" data-target="#deletemodal{{ $val->id }}">
                                <i class="material-icons">delete</i>
                              </button>
                        
                                <div class="modal fade" id="deletemodal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"></h4>
                                      </div>
                                      <div class="modal-body">
                                        <strong class="text-danger">Are Yor Sure You Want To Delete this Mileston?</strong>
                                        <p><strong>Challange Title: </strong>{{ $val->challange->title }}</p>
                                        <p><strong>Challange Description: </strong>{{ $val->challange->description }}</p>
                                        <p><strong>Mileston Title: </strong>{{ $val->title }}</p>
                                        <p><strong>Mileston Description: </strong>{{ $val->description }}</p>
                                        <p><strong>Mileston Status: </strong>{{ $val->status }}</p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <a href="{{ route('delete-mileston',$val->id) }}" class="btn btn-primary">Delete</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                              <!-- end delete modal -->
                            </td>
                          </tr>
                          @endforeach 
                        </tbody>
                      </table>
                    </div>
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