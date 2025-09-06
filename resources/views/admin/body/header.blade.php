<div class="topbar-custom">
  <div class="container-xxl">
      <div>
          <ul>
              <li>
                  <button>
                      <i data-feather="menu" class="noti-icon"></i>
                  </button>
              </li>
              <li>
                  <div>
                      <input type="text" placeholder="🔍 Rechercher dans Cerfaos...">
                      <i></i>
                  </div>
              </li>
              <!-- Logo Cerfaos Outdoor -->
              <li>
                  <div>
                      <div class="logo-icon-wrapper">
                          <span class="logo-icon">🏔️</span>
                      </div>
                      <div>
                          <span class="logo-main-text">CERFAOS</span>
                          <span class="logo-sub-text">Administration</span>
                      </div>
                  </div>
              </li>
          </ul>

          <ul>

              <li>
                  <button type="button" data-toggle="fullscreen">
                      <i data-feather="maximize"></i>
                  </button>
              </li>

              <li class="dropdown notification-list topbar-dropdown">
                  <a data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                      <i data-feather="bell" class="noti-icon"></i>
                      <span>9</span>
                  </a>
                  <div>

                      <!-- item-->
                      <div>
                          <h5 class="m-0">
                              <span>
                                  <a href="">
                                      <small>Clear All</small>
                                  </a>
                              </span>Notification
                          </h5>
                      </div>

                      <div class="noti-scroll" data-simplebar>

                          <!-- item-->
                          <a href="javascript:void(0);">
                              <div class="notify-icon">
                                  <img src="{{ asset('backend/assets/images/users/user-12.jpg') }}" alt="" />
                              </div>
                              <div>
                                  <p class="notify-details">Carl Steadham</p>
                                  <small>5 min ago</small>
                              </div>
                              <p>
                                  <small>Completed <span>Improve workflow in Figma</span></small>
                              </p>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);">
                              <div class="notify-icon">
                                  <img src="{{ asset('backend/assets/images/users/user-2.jpg') }}" alt="" />
                              </div>
                              <div class="notify-content">
                                  <div>
                                      <p class="notify-details">Olivia McGuire</p>
                                      <small>1 min ago</small>
                                  </div>
                      
                                  <div>
                                      <div class="notify-sub-icon">
                                          <i></i>
                                      </div>

                                      <div>
                                          <p>dark-themes.zip</p>
                                          <small>2.4 MB</small>
                                      </div>
                                  </div>

                              </div>
                          </a>

                          <!-- item-->
                          

                          <!-- item-->
                         

                          <!-- item-->
                          

                          <!-- item-->
                         
                      </div>

                      <!-- All-->
                      <a href="javascript:void(0);">
                          View all
                          <i></i>
                      </a>

                  </div>
              </li>

              @php
                  $id = Auth::user()->id;
                  $profileData = App\Models\User::find($id);

              @endphp

              <li class="dropdown notification-list topbar-dropdown">
                  <a data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                      <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="user-image">
                      <span>
                          {{ $profileData->name }} <i class="mdi mdi-chevron-down"></i> 
                      </span>
                  </a>
                  <div>
                      <!-- item-->
                      <div>
                          <h6>Bienvenue !</h6>
                      </div>

                      <!-- item-->
                      <a href="{{ route('admin.profile') }}">
                          <i></i>
                          <span>Mon compte</span>
                      </a>

                      <!-- item-->
                      <a href="auth-lock-screen.html">
                          <i></i>
                          <span>Verrouiller</span>
                      </a>

                      <div></div>

                      <!-- item-->
                      <a href="{{ route('admin.logout') }}">
                          <i></i>
                          <span>Logout</span>
                      </a>

                  </div>
              </li>

          </ul>
      </div>

  </div>
 
</div>

