<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('admin/img/sidebar-1.jpg') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a href="{{ route('adminpannel') }}" class="simple-text logo-normal">
          Challanges
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active" id="dashboard">
            <a class="nav-link" href="{{ route('adminpannel') }}">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item " id="edit">
            <a class="nav-link" href="{{ route('categories') }}">
              <i class="material-icons">category</i>
              <p>Categories</p>
            </a>
          </li>
          <li class="nav-item " id="edit">
            <a class="nav-link" href="{{ route('challanges') }}">
              <i class="material-icons">category</i>
              <p>Challanges</p>
            </a>
          </li>
          <li class="nav-item " id="person">
            <a class="nav-link" href="{{ route('allusers') }}">
              <i class="material-icons">person</i>
              <p>Users</p>
            </a>
          </li>
          <!-- <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">Settings</i>
              <p>Settings</p>
            </a>
          </li> -->
          <!-- <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">library_books</i>
              <p>Typography</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">bubble_chart</i>
              <p>Icons</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">location_ons</i>
              <p>Maps</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">notifications</i>
              <p>Notifications</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="">
              <i class="material-icons">language</i>
              <p>RTL Support</p>
            </a>
          </li>
          <li class="nav-item active-pro ">
            <a class="nav-link" href="">
              <i class="material-icons">unarchive</i>
              <p>Upgrade to PRO</p>
            </a>
          </li> -->
        </ul>
      </div>
    </div>