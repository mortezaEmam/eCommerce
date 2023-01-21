<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion pr-0" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">eCommerce.ir</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span> داشبورد </span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        فروشگاه
    </div>

    <!-- Nav Item - brands -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.brands.index')}}">
            <i class="fas fa-fw fa-store"></i>
            <span> برند ها </span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span> محصولات </span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> صفحات ورود : </h6>
                <a class="collapse-item" href="login.html"> ورود </a>
                <a class="collapse-item" href="register.html"> عضویت </a>
                <a class="collapse-item" href="forgot-password.html"> فراموشی رمز عبور </a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header"> صفحات دیگر : </h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="{{route('admin.attributes.index')}}">ویژگی ها</a>
            </div>
        </div>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
