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
            <a class="navbar-brand">Catecories</a>
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
          <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if(Session::has('success'))
          <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="container-fluid">
          <div class="row">
           <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title"></span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#allcategories" data-toggle="tab">
                          All Categories
                          <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#addnew" data-toggle="tab">
                            <i class="material-icons">add</i> Add new Category
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="allcategories">
                      <table class="table text-center table-responsive-md">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($categories as $key=>$category)
                          <tr>
                            <td scope="row">{{ $key+1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                              <img style="height: 50px; width: 50px;" src="{{ asset('uploads/images/'.$category->image) }}" alt="cat-img">
                            </td>
                            <td>
                              <!-- start edit post modal -->
                              <button type="button" rel="tooltip" title="Edit Post" class="btn btn-primary btn-link btn-sm" data-toggle="modal" data-target="#editmodal{{ $category->id }}">
                                <i class="material-icons">edit</i>
                              </button>

                              <div class="modal fade" id="editmodal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel{{ $category->id }}"></h4>
                                      </div>
                                      <form action="{{ route('updatecategory') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label for="name">Name</label>
                                            <input class="form-control" type="text" name="name" value="{{ $category->name }}" required>
                                          </div>
                                          <input type="file" name="image" class="form-control">
                                          <input type="hidden" name="cat_id" value="{{ $category->id }}">
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
                              <button type="button" rel="tooltip" title="Delete" class="btn btn-danger btn-link btn-sm" data-toggle="modal" data-target="#deletemodal{{ $category->id }}">
                                <i class="material-icons">delete</i>
                              </button>
                        
                                <div class="modal fade" id="deletemodal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel{{ $category->id }}"></h4>
                                      </div>
                                      <div class="modal-body">
                                        <strong class="text-danger">Are Yor Sure You Want To Delete this Category?</strong>
                                        <p><strong>Name:</strong>{{ $category->name }}</p>
                                        <img style="height: 50px; width: 50px" src="{{ asset('/uploads/images/'.$category->image) }}" alt="cat_img">
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <a href="{{ URL('deletecategory/'.$category->id) }}" class="btn btn-primary">Delete</a>
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
                    <div class="tab-pane" id="addnew">
                      <table>
                      <form action="{{ route('addcategory') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" name="name" placeholder="Enter Category Name" required>
                        </div>
                        <input type="file" class="form-control" name="file" required>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                        
                      </table>
                    </div>
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