<div>
  <div data-simplebar>

      <!--- Sidemenu -->
      <div id="sidebar-menu">

          <div class="logo-box">
              <a href="{{ route('dashboard') }}" class="logo logo-light">
                  <div>
                      <div class="logo-text">Cerfaos</div>
                      <div class="logo-subtitle">Administration</div>
                  </div>
              </a>
          </div>

          <ul id="side-menu">

              <li>Dashboard</li>
              <li>
                <a href="{{ route('dashboard') }}">
                    <div>
                        <i data-feather="home"></i>
                    </div>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.profile') }}">
                    <div>
                        <i data-feather="user"></i>
                    </div>
                    <span>Mon Profil</span>
                </a>
            </li>

            <li>
                <a href="/" target="_blank">
                    <div>
                        <i data-feather="globe"></i>
                    </div>
                    <span>Voir le Site</span>
                </a>
            </li>

              <li>Gestion</li>

            <li>
                <a href="#sidebarItineraries" data-bs-toggle="collapse">
                    <div>
                        <i data-feather="map-pin"></i>
                    </div>
                    <span>Itinéraires</span>
                    @php
                        $itineraryCount = App\Models\Itinerary::count();
                    @endphp
                    @if($itineraryCount > 0)
                        <span>{{ $itineraryCount }}</span>
                    @endif
                    <span></span>
                </a>
                <div class="collapse" id="sidebarItineraries">
                    <ul>
                        <li>
                            <a href="{{ route('admin.all.itinerary') }}">
                                <i data-feather="list" class="sub-icon"></i>
                                <span>Tous les itinéraires</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.add.itinerary') }}">
                                <i data-feather="plus-circle" class="sub-icon"></i>
                                <span>Créer un itinéraire</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="#sidebarRides" data-bs-toggle="collapse">
                    <div>
                        <i data-feather="zap"></i>
                    </div>
                    <span>Sorties</span>
                    @php
                        $sortieCount = App\Models\Sortie::count();
                    @endphp
                    @if($sortieCount > 0)
                        <span>{{ $sortieCount }}</span>
                    @endif
                    <span></span>
                </a>
                <div class="collapse" id="sidebarRides">
                    <ul>
                        <li>
                            <a href="{{ route('admin.all.sortie') }}">
                                <i data-feather="list" class="sub-icon"></i>
                                <span>Toutes les sorties</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.add.sortie') }}">
                                <i data-feather="plus-circle" class="sub-icon"></i>
                                <span>Nouvelle sortie</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="#sidebarActivities" data-bs-toggle="collapse">
                    <div>
                        <i data-feather="activity"></i>
                    </div>
                    <span>Activités</span>
                    @php
                        $featureCount = App\Models\Feature::count();
                    @endphp
                    @if($featureCount > 0)
                        <span>{{ $featureCount }}</span>
                    @endif
                    <span></span>
                </a>
                <div class="collapse" id="sidebarActivities">
                    <ul>
                        <li>
                            <a href="{{ route('all.feature') }}">
                                <i data-feather="list" class="sub-icon"></i>
                                <span>Toutes les activités</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('add.feature') }}">
                                <i data-feather="plus-circle" class="sub-icon"></i>
                                <span>Créer une activité</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

              <li>Contenu</li>

              <li>
                  <a href="#sidebarReviews" data-bs-toggle="collapse">
                      <div>
                          <i data-feather="star"></i>
                      </div>
                      <span>Avis</span>
                      @php
                          $reviewCount = App\Models\Review::count();
                          $recentReviews = App\Models\Review::where('created_at', '>=', now()->subDays(7))->count();
                      @endphp
                      @if($reviewCount > 0)
                          <span>{{ $reviewCount }}</span>
                      @endif
                      <span></span>
                  </a>
                  <div class="collapse" id="sidebarReviews">
                      <ul>
                          <li>
                              <a href="{{ route('all.review') }}">
                                  <i data-feather="list" class="sub-icon"></i>
                                  <span>Tous les avis</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('add.review') }}">
                                  <i data-feather="plus-circle" class="sub-icon"></i>
                                  <span>Créer un avis</span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>

              <li>
                  <a href="#sidebarSlogan" data-bs-toggle="collapse">
                      <div>
                          <i data-feather="edit-3"></i>
                      </div>
                      <span>Slogan</span>
                      <span></span>
                  </a>
                  <div class="collapse" id="sidebarSlogan">
                      <ul>
                          <li>
                              <a href="{{ route('get.slider') }}">
                                  <i data-feather="edit" class="sub-icon"></i>
                                  <span>Gérer les Slogans</span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>

              <li>Système</li>
              
              <li>
                  <form method="POST" action="{{ route('logout') }}" class="m-0">
                      @csrf
                      <button type="submit">
                          <div>
                              <i data-feather="log-out"></i>
                          </div>
                          <span>Déconnexion</span>
                      </button>
                  </form>
              </li>

          </ul>

      </div>
      <!-- End Sidebar -->

      <div class="clearfix"></div>

  </div>
</div>