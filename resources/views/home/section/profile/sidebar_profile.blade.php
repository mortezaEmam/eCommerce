<div class="myaccount-tab-menu nav" role="tablist">

    <a href="{{ route('home.user-profile.index') }}" class="{{ request()->is('profile') ? 'active' : '' }}">
        <i class="sli sli-user ml-1"></i>
        پروفایل
    </a>

    <a href="#" class="{{ request()->is('profile/orders') ? 'active' : '' }}">
        <i class="sli sli-basket ml-1"></i>
        سفارشات
    </a>

    <a href="#" class="{{ request()->is('profile/addresses') ? 'active' : '' }}">
        <i class="sli sli-map ml-1"></i>
        آدرس ها
    </a>

    <a href="#" class="{{ request()->is('profile/wishlist') ? 'active' : '' }}">
        <i class="sli sli-heart ml-1"></i>
        لیست علاقه مندی ها
    </a>

    <a href="{{ route('home.comment.users-profile-index') }}" class="{{ request()->is('profile/comments') ? 'active' : '' }}">
        <i class="sli sli-bubble ml-1"></i>
        نظرات
    </a>

    <a href="login.html">
        <i class="sli sli-logout ml-1"></i>
        خروج
    </a>

</div>
