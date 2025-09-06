@extends('admin.admin_master_outdoor')
@section('admin')

<div class="main__container">

        <!-- Header Outdoor Cerfaos -->
        <div class="u-flex u-justify-between u-items-center" style="margin-bottom: var(--cerfaos-space-8);">
            <div class="u-flex u-items-center u-gap-6">
                <div class="u-flex u-items-center u-gap-4">
                    <span style="font-size: 3rem; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));">🏔️</span>
                    <div>
                        <h1 class="u-text-primary" style="font-size: var(--cerfaos-font-size-3xl); font-weight: 700; margin: 0;">Dashboard Cerfaos</h1>
                        <p class="u-text-muted" style="font-size: var(--cerfaos-font-size-lg); margin: var(--cerfaos-space-1) 0 0 0;">Votre centre de commandement pour les aventures outdoor</p>
                    </div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: var(--cerfaos-space-2); background: linear-gradient(135deg, var(--cerfaos-success) 0%, var(--cerfaos-accent) 100%); color: white; padding: var(--cerfaos-space-3) var(--cerfaos-space-4); border-radius: var(--cerfaos-radius-xl); font-weight: 600; box-shadow: var(--cerfaos-shadow-md);">
                <i data-feather="zap" style="width: 16px; height: 16px;"></i>
                <span style="font-size: var(--cerfaos-font-size-sm);">Expédition Active</span>
            </div>
        </div>

        <!-- Actions Rapides Outdoor -->
        <div>
            <div>
                <div>
                    <div style="padding: 2rem;">
                        <h5>
                            <span>🚀</span>Actions de l'Aventurier
                        </h5>
                        <div>
                            <div>
                                <a href="{{ route('admin.profile') }}">
                                    <span class="action-icon">🎯</span>
                                    <span class="action-text">Mon Profil</span>
                                </a>
                            </div>
                            <div>
                                <a href="/" target="_blank">
                                    <span class="action-icon">🌲</span>
                                    <span class="action-text">Site Live</span>
                                </a>
                            </div>
                            <div>
                                <button>
                                    <span class="action-icon">📈</span>
                                    <span class="action-text">Analytics</span>
                                </button>
                            </div>
                            <div>
                                <button>
                                    <span class="action-icon">⚙️</span>
                                    <span class="action-text">Config</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques Outdoor -->
        <div>
            <div>
                <div>

                    <div>
                        <div>
                            <div>
                                <div>🌐</div>
                                <div>91.6K</div>
                                <div>Explorateurs Web</div>
                                <div>
                                    <span>
                                        <i data-feather="trending-up" style="width: 12px; height: 12px;"></i>
                                        15%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <div>
                                <div>🎯</div>
                                <div>15%</div>
                                <div>Taux Aventure</div>
                                <div>
                                    <span>
                                        <i data-feather="trending-down" style="width: 12px; height: 12px;"></i>
                                        -10%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <div>
                                <div>⏱️</div>
                                <div>90 Min</div>
                                <div>Temps Exploration</div>
                                <div>
                                    <span>
                                        <i data-feather="trending-up" style="width: 12px; height: 12px;"></i>
                                        25%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <div>
                                <div>🥾</div>
                                <div>2,986</div>
                                <div>Randonneurs Actifs</div>
                                <div>
                                    <span>
                                        <i data-feather="trending-up" style="width: 12px; height: 12px;"></i>
                                        4%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques Outdoor -->
        <div>
            <div>
                <div>
                    <div>
                        <div>
                            <i data-feather="trending-up"></i>
                        </div>
                        <h5>Progression des Aventures</h5>
                    </div>
                    <div>
                        <div id="monthly-sales" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <div>
                <div>
                    <div>
                        <div>
                            <i data-feather="compass"></i>
                        </div>
                        <h5>Sources de Trafic</h5>
                    </div>
                    <div>
                        <div>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="color: var(--cerfaos-forest); font-family: var(--font-ui); text-transform: uppercase; letter-spacing: 0.1em;">Plateforme</th>
                                        <th colspan="2" style="color: var(--cerfaos-forest); font-family: var(--font-ui); text-transform: uppercase; letter-spacing: 0.1em;">Explorateurs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="color: var(--cerfaos-bark); font-weight: 500;">🏔️ Instagram</td>
                                        <td style="color: var(--cerfaos-forest); font-weight: bold;">3,550</td>
                                        <td>
                                            <div class="progress-bar-container" style="height: 8px; background-color: var(--cerfaos-sand); border-radius: 10px;">
                                                <div class="progress-bar-fill" style="width: 80%; background: linear-gradient(90deg, var(--trail-easy), var(--cerfaos-forest)); border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: var(--cerfaos-bark); font-weight: 500;">🌐 Facebook</td>
                                        <td style="color: var(--cerfaos-forest); font-weight: bold;">1,245</td>
                                        <td>
                                            <div class="progress-bar-container" style="height: 8px; background-color: var(--cerfaos-sand); border-radius: 10px;">
                                                <div class="progress-bar-fill" style="width: 55.9%; background: linear-gradient(90deg, var(--trail-moderate), var(--cerfaos-sunset)); border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: var(--cerfaos-bark); font-weight: 500;">🐦 Twitter</td>
                                        <td style="color: var(--cerfaos-forest); font-weight: bold;">1,798</td>
                                        <td>
                                            <div class="progress-bar-container" style="height: 8px; background-color: var(--cerfaos-sand); border-radius: 10px;">
                                                <div class="progress-bar-fill" style="width: 67%; background: linear-gradient(90deg, var(--cerfaos-sky), var(--cerfaos-mountain)); border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: var(--cerfaos-bark); font-weight: 500;">📺 YouTube</td>
                                        <td style="color: var(--cerfaos-forest); font-weight: bold;">986</td>
                                        <td>
                                            <div class="progress-bar-container" style="height: 8px; background-color: var(--cerfaos-sand); border-radius: 10px;">
                                                <div class="progress-bar-fill" style="width: 38.72%; background: linear-gradient(90deg, var(--trail-difficult), var(--cerfaos-ember)); border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: var(--cerfaos-bark); font-weight: 500;">📌 Pinterest</td>
                                        <td style="color: var(--cerfaos-forest); font-weight: bold;">854</td>
                                        <td>
                                            <div class="progress-bar-container" style="height: 8px; background-color: var(--cerfaos-sand); border-radius: 10px;">
                                                <div class="progress-bar-fill" style="width: 45.08%; background: linear-gradient(90deg, var(--cerfaos-sunrise), var(--cerfaos-flame)); border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: var(--cerfaos-bark); font-weight: 500;">💼 LinkedIn</td>
                                        <td style="color: var(--cerfaos-forest); font-weight: bold;">650</td>
                                        <td>
                                            <div class="progress-bar-container" style="height: 8px; background-color: var(--cerfaos-sand); border-radius: 10px;">
                                                <div class="progress-bar-fill" style="width: 68%; background: linear-gradient(90deg, var(--cerfaos-earth), var(--cerfaos-stone-light)); border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: var(--cerfaos-bark); font-weight: 500;">🏘️ Nextdoor</td>
                                        <td style="color: var(--cerfaos-forest); font-weight: bold;">420</td>
                                        <td>
                                            <div class="progress-bar-container" style="height: 8px; background-color: var(--cerfaos-sand); border-radius: 10px;">
                                                <div class="progress-bar-fill" style="width: 56.4%; background: linear-gradient(90deg, var(--cerfaos-sage), var(--cerfaos-moss)); border-radius: 10px;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-xxl -->
</div> <!-- content -->

@section('charts')
@endsection

<style>
/* Styles additionnels pour les tableaux outdoor */
.table-cerfaos tbody tr {
    border-bottom: 1px solid var(--cerfaos-sand) !important;
    transition: var(--transition-smooth);
}

.table-cerfaos tbody tr:hover {
    background: linear-gradient(135deg, rgba(250, 240, 230, 0.5), rgba(244, 228, 193, 0.3)) !important;
    transform: translateX(4px) !important;
}

.table-cerfaos td {
    padding: 1rem 1.5rem !important;
    vertical-align: middle !important;
    border: none !important;
}

/* Animation pour les barres de progression */
.progress-bar {
    transition: width 1s ease-in-out !important;
}

/* Effet de texture sur les cartes */
.cerfaos-main-card .cerfaos-card-body {
    position: relative;
}

.cerfaos-main-card .cerfaos-card-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--texture-canvas);
    opacity: 0.1;
    pointer-events: none;
}
</style>

@endsection