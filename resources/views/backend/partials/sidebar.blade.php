  <!-- navbar vertical -->
  <div class="app-menu">
      <div class="navbar-vertical navbar nav-dashboard">
          <div class="h-100" data-simplebar>
              <!-- Brand logo -->
              <a class="navbar-brand" href="{{ route('dashboard') }}">
                  <img
                      src="{{ isset($admin_setting->logo) ? asset($admin_setting->logo) : asset('uploads/default.png') }}" />
              </a>
              <!-- Navbar nav -->
              <ul class="navbar-nav flex-column" id="sideNavbar">
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('dashboard') }}">
                          <i data-feather="bar-chart-2" class="nav-icon me-2 icon-xxs"></i>
                          Dashboard
                      </a>
                  </li>






                    {{-- Role Management --}}
                  <li class="nav-item {{ request()->routeIs('banner.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#bannerManagementCollapse"
                          aria-expanded="{{ request()->routeIs('banner.*') ? 'true' : 'false' }}"
                          aria-controls="bannerManagementCollapse">
                          <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                         Banner Management
                      </a>

                      <div id="bannerManagementCollapse"
                          class="collapse {{ request()->routeIs('banner.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">

                          <ul class="nav flex-column ms-3">
                              {{-- Users --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('banner.index*') ? 'active' : '' }}"
                                      href="{{ route('banner.index') }}">
                                      Banner
                                  </a>
                              </li>

                              {{-- Roles --}}

                          </ul>
                      </div>
                  </li>




                   <li class="nav-item {{ request()->routeIs('amenities.category.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#aminitiesCategoryCollapse"
                          aria-expanded="{{ request()->routeIs('banner.*') ? 'true' : 'false' }}"
                          aria-controls="aminitiesCategoryCollapse">
                          <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                          Amenities
                      </a>

                      <div id="aminitiesCategoryCollapse"
                          class="collapse {{ request()->routeIs('amenities.category.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">

                          <ul class="nav flex-column ms-3">
                              {{-- Users --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('amenities.category.index*') ? 'active' : '' }}"
                                      href="{{ route('amenities.category.index') }}">
                                      Amenities Category
                                  </a>
                              </li>


                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('amenities.category.feature*') ? 'active' : '' }}"
                                      href="{{ route('amenities.category.feature') }}">
                                      Amenities Feature
                                  </a>
                              </li>

                              {{-- Roles --}}

                          </ul>
                      </div>
                  </li>




                   <li class="nav-item {{ request()->routeIs('appartment.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#appartmentCategoryCollapse"
                          aria-expanded="{{ request()->routeIs('appartment.*') ? 'true' : 'false' }}"
                          aria-controls="appartmentCategoryCollapse">
                          <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                          Appartment Management
                      </a>

                      <div id="appartmentCategoryCollapse"
                          class="collapse {{ request()->routeIs('appartment.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">

                          <ul class="nav flex-column ms-3">
                              {{-- Users --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('appartment.index*') ? 'active' : '' }}"
                                      href="{{ route('appartment.index') }}">
                                      Appartment
                                  </a>
                              </li>



                              {{-- Roles --}}

                          </ul>
                      </div>
                  </li>















                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('dynamic-pages.index') }}">
                          <i class="bi bi-file-earmark-text fs-4 me-2"></i>
                          Dynamic Pages
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('faq.index') }}">
                          <i class="bi bi-question-square fs-4 me-2"></i>
                          FAQ
                      </a>
                  </li>

                  {{-- User Management
                  <li class="nav-item {{ request()->routeIs('product.*', 'category.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" href="#!" data-bs-toggle="collapse"
                          data-bs-target="#productCollapse"
                          aria-expanded="{{ request()->routeIs('product.*', 'category.*') ? 'true' : 'false' }}"
                          aria-controls="productCollapse">
                          <i data-feather="box" class="nav-icon me-2 icon-xxs"></i>Customer Management
                      </a>
                      <div id="productCollapse"
                          class="collapse {{ request()->routeIs('product.*', 'category.*') ? 'show' : '' }}"
                          data-bs-parent="#productCollapse">
                          <ul class="nav flex-column ms-3">
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}"
                                      href="">
                                      Customer List
                                  </a>
                              </li>

                          </ul>
                      </div>
                  </li> --}}


















                  {{-- Role Management --}}
                  <li class="nav-item {{ request()->routeIs('user.*', 'role.*', 'permission.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#roleManagementCollapse"
                          aria-expanded="{{ request()->routeIs('users.*', 'roles.*', 'permissions.*') ? 'true' : 'false' }}"
                          aria-controls="roleManagementCollapse">
                          <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                          Role Management
                      </a>

                      <div id="roleManagementCollapse"
                          class="collapse {{ request()->routeIs('user.*', 'role.*', 'permission.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">

                          <ul class="nav flex-column ms-3">
                              {{-- Users --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}"
                                      href="{{ route('user.index') }}">
                                      Users
                                  </a>
                              </li>

                              {{-- Roles --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('role.*') ? 'active' : '' }}"
                                      href="{{ route('role.index') }}">
                                      Roles
                                  </a>
                              </li>

                              {{-- Permissions --}}
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('permission.*') ? 'active' : '' }}"
                                      href="{{ route('permission.index') }}">
                                      Permissions
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </li>




                  {{-- Settings --}}
                  <li
                      class="nav-item {{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'active' : '' }}">
                      <a class="nav-link has-arrow" href="" data-bs-toggle="collapse"
                          data-bs-target="#settingsCollapse"
                          aria-expanded="{{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'true' : 'false' }}"
                          aria-controls="settingsCollapse">
                          <i data-feather="settings" class="nav-icon me-2 icon-xxs"></i>Settings
                      </a>

                      <div id="settingsCollapse"
                          class="collapse {{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'show' : '' }}"
                          data-bs-parent="#sidebarMenu">
                          <ul class="nav flex-column ms-3">
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                      href="{{ route('profile.index') }}">
                                      Profile Setting
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('whychoose.index') ? 'active' : '' }}"
                                      href="{{ route('whychoose.index') }}">
                                      Why Choose
                                  </a>
                              </li>

                              </li>

                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('system.index') ? 'active' : '' }}"
                                      href="{{ route('system.index') }}">
                                      Website Setting
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('admin.setting.index') ? 'active' : '' }}"
                                      href="{{ route('admin.setting.index') }}">
                                      Admin Setting
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('mail.index') ? 'active' : '' }}"
                                      href="{{ route('mail.index') }}">
                                      Mail Setting
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  {{-- Logout --}}
                  {{--  <li class="nav-item">
                      <a class="nav-link" href="#"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <i data-feather="log-out" class="nav-icon me-2 icon-xxs"></i>
                          Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </li>  --}}
              </ul>

          </div>
      </div>
  </div>
