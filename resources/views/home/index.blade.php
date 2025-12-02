  <!doctype html>

  <html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../../assets/"
    data-template="vertical-menu-template-no-customizer"
    data-style="light">
    <head>
      <meta charset="utf-8" />
      <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
      <title>Application Management Inventaris</title>

      <meta name="description" content="" />

      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

      <!-- Icons -->
      <link rel="stylesheet" href="../../assets/vendor/fonts/remixicon/remixicon.css" />
      <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" /> 

      <!-- Menu waves for no-customizer fix -->
      <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

      <!-- Core CSS -->
      <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" />
      <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" />
      <link rel="stylesheet" href="../../assets/css/demo.css" />

      <!-- Vendors CSS -->
      <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
      <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
      <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
      <link rel="stylesheet" href="../../assets/vendor/libs/swiper/swiper.css" />

      <!-- Page CSS -->
      <link rel="stylesheet" href="../../assets/vendor/css/pages/cards-statistics.css" />
      <link rel="stylesheet" href="../../assets/vendor/css/pages/cards-analytics.css" />

      <!-- Helpers -->
      <script src="../../assets/vendor/js/helpers.js"></script>
      <script src="../../assets/js/config.js"></script>
      
    </head>

    <body>
      <!-- Layout wrapper -->
      <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
          <!-- Menu -->

  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <!-- Logo -->
        <span class="app-brand-logo demo">
          <img src="../../assets/img/favicon/REKENG.png" alt="Logo" style="width:100px; height:auto;">
        </span>
        <!-- Text ApMIN -->
        <span class="app-brand-text demo fw-semibold">ApMIN</span>
      </a>
      

      <!-- Toggle Sidebar -->
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ri-menu-line"></i></a>
        <svg width="2 4" height="24" viewBox="0 0 24 24" fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
            fill-opacity="0.9" />
          <path
            d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
            fill-opacity="0.4" />
        </svg>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <!-- Menu -->
    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item active open">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ri-home-smile-line"></i>
          <div data-i18n="Dashboards">Dashboards</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->routeIs('stock.index') ? 'active text-primary' : '' }}">
            <a href="{{ route('stock.index') }}" class="menu-link">
              <div data-i18n="Stock">Stock</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('purchase-requests.index') ? 'active text-primary' : '' }}">
            <a href="{{ route('purchase-requests.index') }}" class="menu-link">
              <div data-i18n="PR">PR</div>
            </a>
          </li>
        <!-- Master Data -->
      <li class="menu-item active open">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ri-database-2-line"></i>
          <div data-i18n="Master Data">Master Data</div>
        </a>
      <ul class="menu-sub">
      <li class="menu-item">
        </a>
      </li>
      <li class="menu-item {{ request()->routeIs('merk.index') ? 'active text-primary' : '' }}">
        <a href="{{ route (name: 'merk.index')}}" class="menu-link">
          <div data-i18n="Merk">Merk</div></a>
      </li>
      <li class="menu-item {{ request()->routeIs('unit.index') ? 'active text-primary' : '' }}">
        <a href="{{ route (name: 'unit.index')}}" class="menu-link">
          <div data-i18n="Unit">Unit</div></a>
      <li class="menu-item {{ request()->routeIs('category.index') ? 'active text-primary' : '' }}">
        <a href="{{ route (name: 'category.index')}}" class="menu-link">
          <div data-i18n="Category">Category</div></a>
          <li class="menu-item {{ request()->routeIs('vendor.index') ? 'active text-primary' : '' }}">
        <a href="{{ route (name: 'vendor.index')}}" class="menu-link">
          <div data-i18n="Vendor">Vendor</div></a>
                </li>
                </ul>
              </li>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </aside>

  <!-- Tambahkan CSS -->
  <style>
    .app-brand-link {
      display: flex;
      flex-direction: column; 
      align-items: center;    
      text-decoration: none;
    }
    .app-brand-text {
    margin-top: 8px;
    font-size: 18px;
    font-weight: bold;   
    color: #000 !important; 
  }

  </style>

          <!-- Layout container -->
          <div class="layout-page">
            <!-- Navbar -->

            <nav
              class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
              id="layout-navbar">
              <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                  <i class="ri-menu-fill ri-22px"></i>
                </a>
              </div>

              <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <!-- Search -->
                <div class="navbar-nav align-items-center">
                  <div class="nav-item navbar-search-wrapper mb-0">
                    <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                      <i class="ri-search-line ri-22px scaleX-n1-rtl me-3"></i>
                      <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                    </a>
                  </div>
                </div>
                <!-- /Search -->

                <ul class="navbar-nav flex-row align-items-center ms-auto">


                  <!-- User -->
                  <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                        <img src="../../assets/img/avatars/donat.jpeg" alt="User Avatar" class="rounded-circle" />
                      </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                              <div class="avatar avatar-online">
                                <img src="{{ asset('../../assets/img/avatars/donat.jpeg') }}" alt="User Avatar" class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <span class="fw-medium d-block small">User</span>
                              <small class="text-muted">Admin</small>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      <li>
                        <a class="dropdown-item" href="pages-profile-user.html">
                          <i class="ri-user-3-line ri-22px me-3"></i><span class="align-middle">My Profile</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                          <i class="ri-settings-4-line ri-22px me-3"></i><span class="align-middle">Settings</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="pages-account-settings-billing.html">
                          <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 ri-file-text-line ri-22px me-3"></i>
                            <span class="flex-grow-1 align-middle">Billing</span>
                            <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger">4</span>
                          </span>
                        </a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      <li>
                        <a class="dropdown-item" href="pages-pricing.html">
                          <i class="ri-money-dollar-circle-line ri-22px me-3"></i
                          ><span class="align-middle">Pricing</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="pages-faq.html">
                          <i class="ri-question-line ri-22px me-3"></i><span class="align-middle">FAQ</span>
                        </a>
                      </li>
                      <li>
                        <div class="d-grid px-4 pt-2 pb-1">
                          <a class="btn btn-sm btn-danger d-flex" href="auth-login-cover.html" target="_blank">
                            <small class="align-middle">Logout</small>
                            <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </li>
                  <!--/ User -->
                </ul>
              </div>

              <!-- Search Small Screens -->
              <div class="navbar-search-wrapper search-input-wrapper d-none">
                <input
                  type="text"
                  class="form-control search-input container-xxl border-0"
                  placeholder="Search..."
                  aria-label="Search..." />
                <i class="ri-close-fill search-toggler cursor-pointer"></i>
              </div>
            </nav>

            <!-- / Navbar -->

  @yield('content')
              <div class="content-backdrop fade"></div>
            </div>
            >
          <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
      </div>
         <!-- Vendor JS -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>

    <!-- Main JS -->
<script src="{{ asset('assets/js/helpers.js') }}"></script>
<script src="{{ asset('assets/js/menu.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="../../assets/js/dashboards-analytics.js"></script>

    <!-- Vite -->
    @vite(['resources/js/app.js'])

    <!-- DataTables JS (setelah jQuery vendor) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Tempat script custom dari view -->
    @stack('scripts')
  </body>
</html>
