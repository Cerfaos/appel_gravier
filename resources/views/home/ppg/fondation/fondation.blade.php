@extends('home.body.home_master')

@section('home')

<!-- Nouvelle section -->
<div class="bg-outdoor-cream-50 min-h-screen ppg-fondation-page">

<!-- Hero Section Préparation -->
<section class="relative bg-gradient-to-r from-outdoor-forest-500 to-outdoor-forest-800 text-white py-20" >
  <div class="container mx-auto px-4">
      <div class="max-w-6xl mx-auto">
          <div class="grid md:grid-cols-2 gap-12 items-center">
              
              <!-- Content Side -->
              <div>
                  <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                      <span class="text-outdoor-cream-50">Fondation</span><br>
                      <span class="text-outdoor-ochre-200">Performance & Puissance</span>
                  </h1>
                  
                  <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                    Développez vos bases fondamentales pour exceller en vélo
                  </p>
                  
                  <div class="bg-outdoor-cream-50/20 backdrop-blur-sm p-6 mb-8">
                      <p class="text-lg font-medium">
                        Maîtrisez les mouvements fondamentaux avec des exercices progressifs et des conseils détaillés.
                      </p>
                  </div>

                  <!-- Stats or Features -->
                  
              </div>

              <!-- Image Side -->
              <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                  
                  <!-- Background Gradient Cards -->
                  <div class="absolute inset-0 bg-outdoor-ochre-300 transform rotate-3 shadow-2xl"></div>
                  <div class="absolute inset-0 bg-outdoor-earth-300 transform -rotate-1 shadow-xl opacity-70"></div>
                  
                  <!-- Main Image Container -->
                  <div class="relative bg-white p-6 shadow-2xl">
                      <img 
                          src="{{ asset('frontend/assets/images/img_cerfaos/bandeau_ppg02.png') }}" 
                          alt="Préparation Physique Générale - Entraînement Outdoor" 
                          class="w-full h-80 object-cover"
                          onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                      />
                      <!-- Fallback content -->
                      <div class="w-full h-80 bg-outdoor-cream-100 flex items-center justify-center" style="display: none;">
                          <div class="text-center">
                              <i class="fas fa-dumbbell text-6xl text-outdoor-ochre-400 mb-4"></i>
                              <p class="text-outdoor-forest-500 font-semibold">Préparation Physique</p>
                          </div>
                      </div>

                      <!-- Floating Achievement Cards -->
                      <div class="absolute -top-4 -right-4 bg-white p-3 shadow-xl border border-outdoor-ochre-100 transform rotate-6 hover:rotate-3 transition-transform duration-300">
                          <div class="flex items-center space-x-2">
                              <span class="text-2xl">🎯</span>
                              <div>
                                  <div class="text-sm font-bold text-outdoor-forest-600">Performance</div>
                                  <div class="text-xs text-outdoor-forest-400">Optimisée</div>
                              </div>
                          </div>
                      </div>
                      
                      <div class="absolute -bottom-4 -left-4 bg-white p-3 shadow-xl border border-outdoor-earth-100 transform -rotate-6 hover:-rotate-3 transition-transform duration-300">
                          <div class="flex items-center space-x-2">
                              <span class="text-2xl">💪</span>
                              <div>
                                  <div class="text-sm font-bold text-outdoor-forest-600">Force</div>
                                  <div class="text-xs text-outdoor-forest-400">Développée</div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Decorative Elements -->
                  <div class="absolute -z-10 top-1/4 -right-8 w-32 h-32 bg-outdoor-ochre-200 opacity-20 blur-2xl"></div>
                  <div class="absolute -z-10 bottom-1/4 -left-8 w-40 h-40 bg-outdoor-earth-200 opacity-20 blur-2xl"></div>
              </div>
          </div>
      </div>
  </div>
</section>


<!-- ancienne section -->


<style>
  /* ===== Thème Outdoor Unifié ===== */
  .ppg-fondation-page {
    --bg: #fefae0;
    --bg2: #f7f5e8;
    --panel: rgba(40, 54, 24, 0.06);
    --text: #1a2410;
    --muted: #2d3d1a;
    --stroke: rgba(40, 54, 24, 0.14);
    --g1: #dda15e;
    --g2: #bc6c25;
    --ok: #606c38;
    --warn: #dda15e;
    --danger: #bc6c25;
    --r-xl: 22px;
    --r-md: 14px;
    --shadow: 0 14px 40px rgba(40, 54, 24, 0.15);
  }
  @media (prefers-color-scheme: light) {
    .ppg-fondation-page {
      --bg: #fefae0;
      --bg2: #f7f5e8;
      --panel: rgba(40, 54, 24, 0.04);
      --text: #283618;
      --muted: #606c38;
      --stroke: rgba(40, 54, 24, 0.12);
      --shadow: 0 14px 36px rgba(40, 54, 24, 0.16);
    }
  }
  .ppg-fondation-page[data-theme="dark"] {
    --bg: #283618;
    --bg2: #1f2a13;
    --panel: rgba(254, 250, 224, 0.06);
    --text: #fefae0;
    --muted: #dda15e;
    --stroke: rgba(254, 250, 224, 0.14);
  }
  .ppg-fondation-page[data-theme="light"] {
    --bg: #fefae0;
    --bg2: #f7f5e8;
    --panel: rgba(40, 54, 24, 0.04);
    --text: #1a2410;
    --muted: #2d3d1a;
    --stroke: rgba(40, 54, 24, 0.12);
    --shadow: 0 14px 36px rgba(40, 54, 24, 0.16);
  }

  * {
    box-sizing: border-box;
  }
  html,
  body {
    margin: 0;
  }
  body {
    color: var(--text);
    background: linear-gradient(180deg, var(--bg) 0%, var(--bg2) 100%);
    font: 16px/1.6 ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto,
      Inter, Arial, "Noto Sans";
    letter-spacing: 0.2px;
  }
  a {
    color: var(--text);
    text-decoration: none;
    border-bottom: 1px dashed var(--stroke);
  }
  a:hover {
    opacity: 0.9;
  }
  .wrap {
    background: white;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(40, 54, 24, 0.1);
    margin: -80px auto 40px;
    max-width: 1200px;
    position: relative;
    z-index: 10;
  }

  /* ===== Navigation ===== */
  .nav-header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: var(--bg);
    border-bottom: 1px solid var(--stroke);
    padding: 16px 0;
    margin-bottom: 22px;
    backdrop-filter: blur(10px);
  }
  .nav-content {
    max-width: 1200px;
    margin: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 22px;
  }
  .nav-logo {
    font-weight: 600;
    font-size: 18px;
    color: var(--text);
  }
  .nav-links {
    display: flex;
    gap: 20px;
    align-items: center;
  }
  .nav-link {
    color: var(--muted);
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s ease;
  }
  .nav-link:hover {
    color: var(--text);
    background: rgba(255, 255, 255, 0.05);
  }
  .nav-link.active {
    color: var(--text);
    background: rgba(255, 255, 255, 0.1);
  }

  /* ===== Header ===== */
  .hero {
    position: relative;
    overflow: hidden;
    border: 1px solid var(--stroke);
    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 0.06),
      rgba(255, 255, 255, 0.04)
    );
    backdrop-filter: blur(14px);
    padding: 22px;
    box-shadow: var(--shadow);
  }
  .hero::before {
    content: "";
    position: absolute;
    inset: -2px;
    border-radius: inherit;
    padding: 1px;
    background: linear-gradient(
      120deg,
      var(--g1),
      transparent 30%,
      var(--g2)
    );
    -webkit-mask: linear-gradient(#000 0 0) content-box,
      linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0.6;
    pointer-events: none;
  }
  .title {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
  }
  h1 {
    margin: 0;
    font-size: clamp(22px, 2.2vw, 32px);
  }
  .badge {
    padding: 6px 10px;
    font-size: 12px;
    color: var(--muted);
    border: 1px dashed var(--stroke);
    border-radius: 999px;
  }
  .row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    margin-top: 10px;
  }
  .ghost {
    appearance: none;
    cursor: pointer;
    font: inherit;
    color: var(--text);
    padding: 8px 12px;
    border-radius: 12px;
    border: 1px solid var(--stroke);
    background: linear-gradient(
      120deg,
      transparent,
      rgba(255, 255, 255, 0.05)
    );
    transition: 0.12s transform ease;
  }
  .ghost:hover {
    transform: translateY(-1px);
  }
  .ghost.danger {
    border-color: rgba(252, 165, 165, 0.6);
  }
  .note {
    color: var(--muted);
    margin: 0.4rem 0 0;
  }
  .hr {
    height: 1px;
    background: var(--stroke);
    margin: 12px 0;
  }
  .chip {
    font-size: 13px;
    color: var(--muted);
    border: 1px solid var(--stroke);
    padding: 6px 10px;
    border-radius: 12px;
  }

  /* ===== Panneau config ===== */
  .panel {
    border: 1px solid var(--stroke);
    border-radius: 16px;
    padding: 12px;
    background: var(--panel);
    backdrop-filter: blur(10px);
  }
  label.sel {
    display: flex;
    gap: 8px;
    align-items: center;
    margin: 6px 0;
  }
  select {
    padding: 8px 10px;
    border-radius: 10px;
    border: 1px solid var(--stroke);
    background: transparent;
    color: var(--text);
  }
  .help {
    font-size: 13px;
    color: var(--muted);
  }
  .progress {
    height: 9px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.08);
    overflow: hidden;
  }
  .bar {
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, var(--g1), var(--g2));
  }

  /* ===== Sections & Exos ===== */
  section {
    border: 1px solid var(--stroke);
    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 0.05),
      rgba(255, 255, 255, 0.03)
    );
    padding: 16px;
    margin-top: 16px;
  }
  h2 {
    margin: 0 0 10px;
  }
  h4 {
    margin: 0 0 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
  }
  .ex {
    border: 1px solid var(--stroke);
    border-radius: 16px;
    padding: 12px;
    margin: 12px 0;
    background: rgba(255, 255, 255, 0.03);
  }
  .ex header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
  }
  .ex h3 {
    margin: 0;
    font-size: 16px;
  }
  .meta {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    font-size: 12px;
    color: var(--muted);
  }
  .tag {
    border: 1px solid var(--stroke);
    border-radius: 999px;
    padding: 2px 8px;
  }
  ul.list {
    margin: 6px 0 0;
    padding-left: 18px;
  }
  ul.list li {
    margin: 2px 0;
  }
  .ctrls {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 12px;
  }
  .serie-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    padding: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.02);
  }
  .serie-label {
    min-width: 80px;
    font-weight: 500;
    color: var(--g1);
  }
  .serie-controls {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    flex: 1;
  }
  .check {
    accent-color: #22c55e;
    width: 18px;
    height: 18px;
  }
  .small {
    font-size: 13px;
    color: var(--muted);
  }

  /* ===== Timers ===== */
  .timer {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    border: 1px solid var(--stroke);
    border-radius: 12px;
    padding: 8px;
    background: rgba(255, 255, 255, 0.035);
  }
  .t-label {
    font-size: 12px;
    color: var(--muted);
  }
  .t-time {
    min-width: 72px;
    text-align: center;
    font-variant-numeric: tabular-nums;
    border: 1px solid var(--stroke);
    border-radius: 10px;
    padding: 6px 10px;
  }
  .t-btn,
  .t-preset {
    appearance: none;
    cursor: pointer;
    font: inherit;
    color: var(--text);
    border: 1px solid var(--stroke);
    border-radius: 10px;
    padding: 6px 10px;
    background: linear-gradient(
      120deg,
      transparent,
      rgba(255, 255, 255, 0.05)
    );
  }
  .t-preset {
    font-size: 12px;
    opacity: 0.9;
  }
  .t-running .t-time {
    border-color: rgba(134, 239, 172, 0.6);
  }
  .t-done .t-time {
    border-color: rgba(192, 132, 252, 0.7);
  }

  /* ===== Sommaire flottant ===== */
  .toc-fab {
    position: fixed;
    right: 16px;
    bottom: 16px;
    z-index: 50;
    width: 48px;
    height: 48px;
    border-radius: 999px;
    border: 1px solid var(--stroke);
    background: linear-gradient(
      135deg,
      rgba(255, 255, 255, 0.08),
      rgba(255, 255, 255, 0.03)
    );
    color: var(--text);
    font-size: 20px;
    box-shadow: var(--shadow);
    cursor: pointer;
    transition: transform 0.14s ease, opacity 0.14s ease;
  }
  .toc-fab:hover {
    transform: translateY(-1px);
  }
  .toc-panel {
    position: fixed;
    right: 16px;
    bottom: 72px;
    z-index: 50;
    width: min(88vw, 300px);
    max-height: 70vh;
    overflow: auto;
    border: 1px solid var(--stroke);
    border-radius: 16px;
    background: var(--panel);
    backdrop-filter: blur(10px);
    padding: 10px;
    display: none;
    box-shadow: var(--shadow);
  }
  .toc-panel.open {
    display: block;
    animation: tocIn 0.14s ease both;
  }
  @keyframes tocIn {
    from {
      transform: translateY(6px);
      opacity: 0;
    }
    to {
      transform: none;
      opacity: 1;
    }
  }
  .toc-links {
    display: grid;
    gap: 6px;
    margin: 6px 0 10px;
  }
  .toc-link {
    display: block;
    padding: 6px 8px;
    border-radius: 8px;
    border: 1px solid transparent;
  }
  .toc-link::before {
    content: "• ";
    color: var(--g1);
    font-weight: 700;
  }
  .toc-link:hover {
    border-color: var(--stroke);
    background: rgba(255, 255, 255, 0.04);
  }
  .toc-progress {
    height: 6px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.08);
    overflow: hidden;
  }
  .toc-bar {
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, var(--g1), var(--g2));
  }

  /* ===== Impression ===== */
  @media print {
    body {
      background: #fff;
    }
    .ghost,
    .toc-fab,
    .toc-panel {
      display: none !important;
    }
    .wrap {
      padding: 0;
    }
  }
</style>



    <div class="wrap">
      <!-- Navigation -->
     

      <!-- HERO -->
      <header class="hero" id="top">
        <div class="title">
          <svg
            width="34"
            height="34"
            viewBox="0 0 24 24"
            fill="none"
            aria-hidden="true"
          >
            <defs>
              <linearGradient id="g1" x1="0" y1="0" x2="24" y2="24">
                <stop stop-color="var(--g1)" />
                <stop offset="1" stop-color="var(--g2)" />
              </linearGradient>
            </defs>
            <path
              d="M12 2L15.5 8.5L22 9L17 14L18.5 21L12 17.5L5.5 21L7 14L2 9L8.5 8.5L12 2Z"
              stroke="url(#g1)"
              stroke-width="1.6"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          <h1>Programme Force & Mobilité Jambes</h1>
          <span class="badge">Programme complet • 3 phases progressives</span>
        </div>
        <p class="note">
          Programme basé sur les méthodes d'Ido Portal et les principes de force
          fonctionnelle.
          <strong>Vidéos tutoriels incluses pour chaque exercice</strong>.
        </p>
        <div class="row">
          <span class="chip">2 séances / semaine • 72h entre séances</span>
         
          <button
            id="resetBtn"
            class="ghost danger"
            title="Réinitialiser progression & timers"
          >
            Réinitialiser
          </button>
          <button onclick="window.print()" class="ghost" title="Imprimer">
            Imprimer
          </button>
        </div>
        <div class="hr"></div>

        <!-- Panneau config -->
        <div class="panel">
          <label class="sel">
            <strong>Phase</strong>
            <select id="phaseSel" aria-label="Choisir la phase">
              <option value="1">Phase 1 - Fondations (4 sem.)</option>
              <option value="2">Phase 2 - Développement (4 sem.)</option>
              <option value="3">Phase 3 - Avancé (4 sem.)</option>
            </select>
          </label>
          <label class="sel" id="seanceRow">
            <strong>Séance</strong>
            <select id="seanceSel" aria-label="Choisir la séance">
              <option value="1">Séance A - Force</option>
              <option value="2">Séance B - Mobilité & Équilibre</option>
            </select>
          </label>
          <p class="help">
            Conseils : Commencez avec des amplitudes réduites et augmentez
            progressivement. Écoutez votre corps et ne forcez jamais en cas de
            douleur.
          </p>
          <div class="progress" aria-label="Progression de la séance">
            <div class="bar" id="bar"></div>
          </div>
        </div>
      </header>

      <!-- Sommaire flottant -->
      <button class="toc-fab" id="tocFab" aria-label="Sommaire">☰</button>
      <div
        class="toc-panel"
        id="tocPanel"
        role="dialog"
        aria-modal="false"
        aria-label="Sommaire"
      >
        <nav class="toc-links" id="tocLinks"></nav>
        <div class="toc-progress">
          <div class="toc-bar" id="barFloat"></div>
        </div>
      </div>

      <!-- Échauffement complet -->
      <section id="warmup-section">
        <h2>Échauffement complet (45-50 min)</h2>
        <p class="note">
          Échauffement progressif en 4 phases pour préparer le corps aux
          exercices de force et mobilité.
          <strong>Ne jamais négliger cette étape cruciale.</strong>
        </p>

        <!-- Phase 1: Activation générale -->
        <div class="ex" id="phase1-warmup">
          <header>
            <h3>Bloc 1 - Activation générale (10 min)</h3>
            <div class="meta">
              <span class="tag">Réveil corporel</span>
              <span class="tag">Circulation sanguine</span>
            </div>
          </header>
          <ul class="list">
            <li>
              <strong>Marche dynamique</strong> : 3 min sur place ou
              déplacement, bras balançants
            </li>
            <li>
              <strong>Rotations articulaires</strong> : 2 min - chevilles,
              genoux, hanches, bassin
            </li>
            <li>
              <strong>Balancement jambes</strong> : 2×10 avant/arrière, 2×10
              latéral par jambe
            </li>
            <li><strong>Montées de genoux</strong> : 30 sec dynamiques</li>
            <li><strong>Talons-fesses</strong> : 30 sec progressifs</li>
            <li><strong>Squats libres</strong> : 2×10 amplitude progressive</li>
          </ul>
          <div class="ctrls">
            <div class="serie-row">
              <div class="serie-label">Activation</div>
              <div class="serie-controls">
                <label
                  ><input type="checkbox" class="check" /> Bloc terminé</label
                >
                <div id="timer-phase1"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Phase 2: Cardio - Rameur -->
        <div class="ex" id="phase2-rameur">
          <header>
            <h3>Bloc 2 - Cardio rameur (30 min)</h3>
            <div class="meta">
              <span class="tag">Endurance</span>
              <span class="tag">Échauffement systémique</span>
              <span class="tag">FC cible: 60-70% FCmax</span>
            </div>
          </header>
          <ul class="list">
            <li>
              <strong>Structure:</strong> 5 min échauffement + 20 min tempo
              modéré + 5 min retour au calme
            </li>
            <li>
              <strong>Minutes 1-5:</strong> Intensité progressive, focus sur la
              technique
            </li>
            <li>
              <strong>Minutes 6-25:</strong> Tempo constant, respiration
              contrôlée
            </li>
            <li>
              <strong>Minutes 26-30:</strong> Diminution progressive de
              l'intensité
            </li>
            <li>
              <strong>Technique:</strong> Poussée jambes → traction bras →
              retour contrôlé
            </li>
            <li><strong>Cadence cible:</strong> 20-24 coups/minute</li>
          </ul>
          <div class="ctrls">
            <div class="serie-row">
              <div class="serie-label">Échauffement</div>
              <div class="serie-controls">
                <label><input type="checkbox" class="check" /> 0-5 min</label>
                <div id="timer-rameur-1"></div>
              </div>
            </div>
            <div class="serie-row">
              <div class="serie-label">Tempo</div>
              <div class="serie-controls">
                <label><input type="checkbox" class="check" /> 5-25 min</label>
                <div id="timer-rameur-2"></div>
              </div>
            </div>
            <div class="serie-row">
              <div class="serie-label">Récup</div>
              <div class="serie-controls">
                <label><input type="checkbox" class="check" /> 25-30 min</label>
                <div id="timer-rameur-3"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Phase 3: Mobilité spécifique -->
        <div class="ex" id="phase3-mobility">
          <header>
            <h3>Bloc 3 - Mobilité spécifique jambes (8 min)</h3>
            <div class="meta">
              <span class="tag">Préparation articulaire</span>
              <span class="tag">Amplitude de mouvement</span>
            </div>
          </header>
          <ul class="list">
            <li>
              <strong>Routine Ido Portal</strong> : 2 min -
              <a
                href="https://youtu.be/V46uT-ldYQE"
                target="_blank"
                rel="noopener"
                >🎬 Voir vidéo</a
              >
            </li>
            <li>
              <strong>Genoux au sol dynamique</strong> : 2 min -
              <a
                href="https://youtu.be/jxwZgV8-Uk8"
                target="_blank"
                rel="noopener"
                >🎬 Voir vidéo</a
              >
            </li>
            <li>
              <strong>Tibias parallèles</strong> : 2 min -
              <a
                href="https://youtu.be/xD7JUxaEAgE"
                target="_blank"
                rel="noopener"
                >🎬 Voir vidéo</a
              >
            </li>
            <li>
              <strong>Squat complet maintien</strong> : 2×30-60 sec, respiration
              profonde
            </li>
          </ul>
          <div class="ctrls">
            <div class="serie-row">
              <div class="serie-label">Mobilité</div>
              <div class="serie-controls">
                <label
                  ><input type="checkbox" class="check" /> Routine
                  terminée</label
                >
                <div id="timer-mobility"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Phase 4: Activation neuro-musculaire -->
        <div class="ex" id="phase4-activation">
          <header>
            <h3>Phase 4 - Activation neuro-musculaire (5 min)</h3>
            <div class="meta">
              <span class="tag">Préparation séance</span>
              <span class="tag">Connexion corps-esprit</span>
            </div>
          </header>
          <ul class="list">
            <li>
              <strong>Squats tempo lent</strong> : 2×5 (3 sec descente, 1 sec
              montée)
            </li>
            <li>
              <strong>Fentes alternées</strong> : 2×6 par jambe, amplitude
              progressive
            </li>
            <li>
              <strong>Calf raises</strong> : 2×10 montée explosive, descente
              lente
            </li>
            <li>
              <strong>Équilibre unipodal</strong> : 30 sec par jambe, yeux
              fermés
            </li>
            <li>
              <strong>Respirations profondes</strong> : 5 cycles, focus mental
              sur la séance
            </li>
          </ul>
          <div class="ctrls">
            <div class="serie-row">
              <div class="serie-label">Activation</div>
              <div class="serie-controls">
                <label
                  ><input type="checkbox" class="check" /> Préparation
                  terminée</label
                >
                <div id="timer-activation"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Résumé timing -->
        <div class="panel" style="margin-top: 16px">
          <h4 style="margin: 0 0 8px">Timing total de l'échauffement</h4>
          <div class="row" style="margin: 0">
            <span class="chip">Phase 1: 10 min</span>
            <span class="chip">Phase 2: 30 min</span>
            <span class="chip">Phase 3: 8 min</span>
            <span class="chip">Phase 4: 5 min</span>
            <span
              class="chip"
              style="
                background: linear-gradient(90deg, var(--g1), var(--g2));
                color: white;
                border: none;
              "
            >
              <strong>Total: 53 min</strong>
            </span>
          </div>
          <p class="help" style="margin: 8px 0 0">
            <strong>Important:</strong> Cet échauffement complet prépare
            optimalement le corps. Vous pouvez raccourcir le rameur à 20 min si
            le temps manque, mais ne descendez jamais sous 15 min.
          </p>
        </div>
      </section>

      <!-- Contenu dynamique -->
      <main id="content"></main>

      <footer class="small" style="opacity: 0.85; margin: 18px 0 38px">
        <div class="hr"></div>
        <p>
          Programme stocké localement dans votre navigateur.
          <a href="#top">Haut de page</a>
        </p>
      </footer>
    </div>
    
    </div>
    
    <!-- Section Contenu -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            
        </div>
    </section>
</div>

    <script>
      /* ========= Liens vidéo officiels ========= */
      const WARMUP_VIDS = [
        {
          label: "Routine de squat d'Ido Portal",
          url: "https://youtu.be/V46uT-ldYQE",
        },
        {
          label: "Genoux au sol dynamique",
          url: "https://youtu.be/jxwZgV8-Uk8",
        },
        { label: "Tibias parallèles", url: "https://youtu.be/xD7JUxaEAgE" },
        {
          label: "Mobilité générale jambes",
          url: "https://youtu.be/BMQ7KlLgqRM",
        },
      ];

      /* Mapping exercices ➜ vidéos */
      const VIDEO_MAP = {
        1: {
          // Phase 1 - Fondations
          "Split squats": "https://youtu.be/UfiJxe4CbZI",
          "Pistol assisté": "https://youtu.be/rDxAHScYrKY",
          "Sissy squats": "https://youtu.be/mgxKEQcwhec",
          "Active hero": "https://youtu.be/_XvrNQ6XMUI",
          "Hamstring curls": "https://youtu.be/k_Pvo0FsG6Q",
          "Low Gate Positions - Pistol": "https://youtu.be/rDxAHScYrKY",
          "Low Gate Positions - Kozak": "https://youtu.be/Dom_h5fdT1I",
          "Squat complet maintien": "https://youtu.be/V46uT-ldYQE",
        },
        2: {
          // Phase 2 - Développement
          "Pistol squats progression": "https://youtu.be/KuIiPRkHq4A",
          "Split squats lestés": "https://youtu.be/UfiJxe4CbZI",
          "Curls nordiques": "https://youtu.be/pz4KrTaS4MQ",
          "Shrimp progression": "https://youtu.be/_nTtiAxbs5E",
          "Good mornings lestés": "https://youtu.be/wXmYVw0QP8Q",
          "Coffee shop squat": "https://youtu.be/l6jSYU4YHk4",
          "Peing dog": "https://youtu.be/T7o9vGr2obw",
          "Squat ballerine": "https://youtu.be/1GVC6HNKNpI",
        },
        3: {
          // Phase 3 - Avancé
          "Pistol squats complets": "https://youtu.be/KuIiPRkHq4A",
          "Dragon pistol squat": "https://youtu.be/jRIBidSqdM0",
          "Shrimp complet": "https://youtu.be/_nTtiAxbs5E",
          "Curls nordiques avancés": "https://youtu.be/pz4KrTaS4MQ",
          "Dragon LGP": "https://youtu.be/wkalrq4EKaw",
          "Squat 360°": "https://youtu.be/1Q-vps_leOQ",
          "Improvisation locomotion":
            "https://www.youtube.com/watch?v=G6BBk3Nvj9k",
        },
      };

      /* ========= Programme complet ========= */
      const PROGRAM = {
        1: {
          // Phase 1 - Fondations
          1: [
            // Séance A - Force
            {
              code: "A1",
              nom: "Split squats",
              sets: 4,
              type: "reps",
              reps: [8, 12],
              perSide: true,
              rpe: 7,
              restSec: 90,
              notes:
                "Base de la force unilatérale. Focus sur l'amplitude complète.",
            },
            {
              code: "A2",
              nom: "Pistol assisté",
              sets: 4,
              type: "reps",
              reps: [3, 6],
              perSide: true,
              rpe: 8,
              restSec: 120,
              notes: "Utilisez un support ou élastique. Descendez lentement.",
            },
            {
              code: "B1",
              nom: "Sissy squats",
              sets: 3,
              type: "reps",
              reps: [5, 10],
              rpe: 7,
              restSec: 90,
              notes: "Développe les quadriceps et la mobilité arrière.",
            },
            {
              code: "B2",
              nom: "Active hero",
              sets: 3,
              type: "reps",
              reps: [10, 15],
              rpe: 6,
              restSec: 60,
              notes: "Excellent pour étirer les quadriceps activement.",
            },
            {
              code: "C1",
              nom: "Hamstring curls",
              sets: 3,
              type: "reps",
              reps: [12, 20],
              rpe: 7,
              restSec: 60,
              notes: "Renforcement des ischios avec volume.",
            },
          ],
          2: [
            // Séance B - Mobilité & Équilibre
            {
              code: "A1",
              nom: "Low Gate Positions - Pistol",
              sets: 4,
              type: "time",
              range: [15, 30],
              perSide: true,
              rpe: 6,
              restSec: 60,
              notes: "Explorez la position. Utilisez les mains si nécessaire.",
            },
            {
              code: "A2",
              nom: "Low Gate Positions - Kozak",
              sets: 4,
              type: "time",
              range: [15, 30],
              perSide: true,
              rpe: 6,
              restSec: 60,
              notes: "Rotation interne importante. Progressez lentement.",
            },
            {
              code: "B1",
              nom: "Squat complet maintien",
              sets: 4,
              type: "time",
              range: [30, 60],
              rpe: 5,
              restSec: 60,
              notes: "Position de repos naturelle. Talons au sol si possible.",
            },
            {
              code: "B2",
              nom: "Routine Ido Portal",
              sets: 3,
              type: "reps",
              reps: [10, 20],
              rpe: 6,
              restSec: 90,
              notes: "Échauffement dynamique pour toutes les articulations.",
            },
          ],
        },
        2: {
          // Phase 2 - Développement
          1: [
            // Séance A - Force
            {
              code: "A1",
              nom: "Pistol squats progression",
              sets: 5,
              type: "reps",
              reps: [3, 8],
              perSide: true,
              rpe: 8,
              restSec: 120,
              notes: "Réduisez l'assistance. Contrôlez la descente.",
            },
            {
              code: "A2",
              nom: "Split squats lestés",
              sets: 4,
              type: "reps",
              reps: [8, 12],
              perSide: true,
              rpe: 8,
              restSec: 90,
              notes: "Ajoutez du poids ou élevez le pied arrière.",
            },
            {
              code: "B1",
              nom: "Curls nordiques",
              sets: 4,
              type: "reps",
              reps: [3, 8],
              rpe: 9,
              restSec: 120,
              notes: "Exercice intense. Contrôlez l'excentrique.",
            },
            {
              code: "B2",
              nom: "Shrimp progression",
              sets: 3,
              type: "reps",
              reps: [2, 5],
              perSide: true,
              rpe: 8,
              restSec: 120,
              notes: "Le squat le plus dur. Utilisez un support.",
            },
            {
              code: "C1",
              nom: "Good mornings lestés",
              sets: 3,
              type: "reps",
              reps: [8, 12],
              rpe: 7,
              restSec: 90,
              notes: "Souplesse et force des ischios simultanément.",
            },
          ],
          2: [
            // Séance B - Mobilité & Équilibre
            {
              code: "A1",
              nom: "Coffee shop squat",
              sets: 4,
              type: "time",
              range: [10, 20],
              perSide: true,
              rpe: 7,
              restSec: 90,
              notes: "Position avancée. Explorez vos limites.",
            },
            {
              code: "A2",
              nom: "Peing dog",
              sets: 4,
              type: "time",
              range: [15, 30],
              perSide: true,
              rpe: 6,
              restSec: 60,
              notes: "Rotation externe et force en position basse.",
            },
            {
              code: "B1",
              nom: "Squat ballerine",
              sets: 4,
              type: "reps",
              reps: [5, 10],
              rpe: 7,
              restSec: 90,
              notes: "Genoux vers l'avant, tibias parallèles au sol.",
            },
            {
              code: "B2",
              nom: "Routine mobilité avancée",
              sets: 3,
              type: "custom",
              rpe: 6,
              restSec: 60,
              notes: "Enchaînement libre entre les LGP apprises.",
            },
          ],
        },
        3: {
          // Phase 3 - Avancé
          1: [
            // Séance A - Force
            {
              code: "A1",
              nom: "Pistol squats complets",
              sets: 5,
              type: "reps",
              reps: [5, 10],
              perSide: true,
              rpe: 9,
              restSec: 120,
              notes: "Version complète sans assistance.",
            },
            {
              code: "A2",
              nom: "Dragon pistol squat",
              sets: 4,
              type: "reps",
              reps: [1, 3],
              perSide: true,
              rpe: 10,
              restSec: 180,
              notes: "Le mouvement le plus complexe. Patience requise.",
            },
            {
              code: "B1",
              nom: "Shrimp complet",
              sets: 4,
              type: "reps",
              reps: [2, 5],
              perSide: true,
              rpe: 9,
              restSec: 150,
              notes: "Force et mobilité extrêmes combinées.",
            },
            {
              code: "B2",
              nom: "Curls nordiques avancés",
              sets: 4,
              type: "combo",
              reps: 5,
              hold: [3, 5],
              rpe: 9,
              restSec: 120,
              notes: "5 reps + maintien isométrique final.",
            },
          ],
          2: [
            // Séance B - Exploration & Flow
            {
              code: "A1",
              nom: "Dragon LGP",
              sets: 4,
              type: "time",
              range: [10, 20],
              perSide: true,
              rpe: 8,
              restSec: 120,
              notes: "Position la plus avancée des LGP.",
            },
            {
              code: "A2",
              nom: "Squat 360°",
              sets: 4,
              type: "custom",
              rpe: 7,
              restSec: 90,
              notes: "Problème moteur : poussez objets dans toutes directions.",
            },
            {
              code: "B1",
              nom: "Flow libre LGP",
              sets: 3,
              type: "time",
              range: [60, 120],
              rpe: 6,
              restSec: 120,
              notes: "Enchaînement improvisé entre toutes les positions.",
            },
            {
              code: "B2",
              nom: "Improvisation locomotion",
              sets: 2,
              type: "time",
              range: [180, 300],
              rpe: 5,
              restSec: 180,
              notes: "Expression libre basée sur vos acquis.",
            },
          ],
        },
      };

      /* ========= Utilitaires ========= */
      const $ = (sel) => document.querySelector(sel);
      const $$ = (sel) => Array.from(document.querySelectorAll(sel));
      function el(tag, cls, html) {
        const e = document.createElement(tag);
        if (cls) e.className = cls;
        if (html != null) e.innerHTML = html;
        return e;
      }
      function fmt(sec) {
        sec = Math.max(0, Math.round(sec));
        const m = String(Math.floor(sec / 60)).padStart(2, "0");
        const s = String(sec % 60).padStart(2, "0");
        return `${m}:${s}`;
      }
      function beep() {
        try {
          const C = window.AudioContext || window.webkitAudioContext;
          const ctx = new C();
          const o = ctx.createOscillator(),
            g = ctx.createGain();
          o.type = "sine";
          o.frequency.value = 880;
          g.gain.setValueAtTime(0.001, ctx.currentTime);
          g.gain.exponentialRampToValueAtTime(0.2, ctx.currentTime + 0.01);
          g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.2);
          o.connect(g);
          g.connect(ctx.destination);
          o.start();
          o.stop(ctx.currentTime + 0.22);
          setTimeout(() => ctx.close(), 400);
        } catch (e) {}
      }

      /* ========= Timers ========= */
      function makeTimer(def = 30, presets = [20, 30, 40], label = "Timer") {
        const box = el("div", "timer");
        box.dataset.default = def;
        const lab = el("span", "t-label", label);
        const row1 = el("div", "t-row");
        const row2 = el("div", "t-row");
        presets.forEach((p) => {
          const b = el("button", "t-preset", p + "s");
          b.dataset.sec = p;
          row1.appendChild(b);
        });
        const timeEl = el("span", "t-time", fmt(def));
        const bStart = el("button", "t-btn", "▶ Démarrer");
        const bPause = el("button", "t-btn", "❚❚ Pause");
        const bReset = el("button", "t-btn", "↺");
        row2.append(timeEl, bStart, bPause, bReset);
        box.append(lab, row1, row2);
        let remaining = def,
          running = false,
          iv = null;
        function render() {
          timeEl.textContent = fmt(remaining);
          box.classList.toggle("t-running", running);
        }
        function start() {
          if (running) return;
          running = true;
          render();
          iv = setInterval(() => {
            remaining -= 1;
            render();
            if (remaining <= 0) {
              clearInterval(iv);
              iv = null;
              running = false;
              remaining = 0;
              render();
              box.classList.add("t-done");
              beep();
            }
          }, 1000);
        }
        function pause() {
          if (iv) {
            clearInterval(iv);
            iv = null;
          }
          running = false;
          render();
        }
        function reset(to = def) {
          pause();
          remaining = Number(to) || def;
          box.classList.remove("t-done");
          render();
        }
        row1
          .querySelectorAll("button")
          .forEach((btn) =>
            btn.addEventListener("click", () => reset(Number(btn.dataset.sec)))
          );
        bStart.addEventListener("click", start);
        bPause.addEventListener("click", pause);
        bReset.addEventListener("click", () => reset());
        reset(def);
        return { root: box, reset, pause };
      }

      /* ========= Affichage échauffement ========= */
      function renderWarmupRefs() {
        // Initialisation des timers d'échauffement
        const timers = [
          { id: "timer-phase1", duration: 600, label: "Phase 1 (10 min)" },
          {
            id: "timer-rameur-1",
            duration: 300,
            label: "Rameur échauffement (5 min)",
          },
          {
            id: "timer-rameur-2",
            duration: 1200,
            label: "Rameur tempo (20 min)",
          },
          {
            id: "timer-rameur-3",
            duration: 300,
            label: "Rameur récup (5 min)",
          },
          { id: "timer-mobility", duration: 480, label: "Mobilité (8 min)" },
          {
            id: "timer-activation",
            duration: 300,
            label: "Activation (5 min)",
          },
        ];

        timers.forEach((timer) => {
          const container = document.getElementById(timer.id);
          if (container) {
            const timerObj = makeTimer(
              timer.duration,
              [
                Math.floor(timer.duration * 0.5),
                timer.duration,
                Math.floor(timer.duration * 1.5),
              ],
              timer.label
            );
            container.appendChild(timerObj.root);
          }
        });

        // Timer global pour l'échauffement complet
        const globalWarmupTimer = makeTimer(
          3180, // 53 minutes total
          [2700, 3180, 3600], // 45, 53, 60 min
          "Échauffement complet"
        );

        // Ajouter le timer global à la section
        const warmupSection = document.getElementById("warmup-section");
        if (warmupSection) {
          const globalTimerDiv = el("div", "panel");
          globalTimerDiv.style.marginTop = "16px";
          globalTimerDiv.innerHTML =
            "<h4 style='margin: 0 0 12px'>Timer global échauffement</h4>";
          globalTimerDiv.appendChild(globalWarmupTimer.root);
          warmupSection.appendChild(globalTimerDiv);
        }
      }
      function getVideoLink(phase, exName) {
        const map = VIDEO_MAP[phase] || {};
        return map[exName] || null;
      }

      /* ========= Rendu dynamique ========= */
      const phaseSel = $("#phaseSel"),
        seanceSel = $("#seanceSel"),
        content = $("#content");
      const bar = $("#bar"),
        barFloat = $("#barFloat");
      const KEY_THEME = "fmj-theme",
        KEY_STATE = "fmj-state-v1";

      function stateKey() {
        return `p${phaseSel.value}-s${seanceSel.value}`;
      }
      function saveState() {
        const st = JSON.parse(localStorage.getItem(KEY_STATE) || "{}");
        st[stateKey()] = $(
          ".ex input[type=checkbox], #warmup-section input[type=checkbox]"
        ).map((c) => c.checked);
        localStorage.setItem(KEY_STATE, JSON.stringify(st));
        updateBars();
      }
      function loadState() {
        const st =
          JSON.parse(localStorage.getItem(KEY_STATE) || "{}")[stateKey()] || [];
        $(
          ".ex input[type=checkbox], #warmup-section input[type=checkbox]"
        ).forEach((c, i) => (c.checked = !!st[i]));
        updateBars();
      }
      function updateBars() {
        const checks = $(
          ".ex input[type=checkbox], #warmup-section input[type=checkbox]"
        );
        const total = checks.length,
          done = checks.filter((c) => c.checked).length;
        const pct = total ? Math.round((done / total) * 100) : 0;
        if (bar) bar.style.width = pct + "%";
        if (barFloat) barFloat.style.width = pct + "%";
      }

      function makeRestTimer(sec = 90) {
        return makeTimer(sec, [60, 90, 120, 180], "Repos").root;
      }

      function renderExercise(ex) {
        const card = el("div", "ex");
        card.id = `ex-${ex.code}`;
        const head = el("header");
        const title = el("h3", "", `${ex.code}. ${ex.nom}`);
        const meta = el("div", "meta");

        const tags = [];
        if (ex.type === "time") {
          tags.push(`${ex.sets}× ${ex.range[0]}–${ex.range[1]} s`);
        } else if (ex.type === "reps") {
          tags.push(
            `${ex.sets}× ${
              Array.isArray(ex.reps) ? ex.reps[0] + "–" + ex.reps[1] : ex.reps
            } reps`
          );
        } else if (ex.type === "combo") {
          tags.push(
            `${ex.sets}× ${ex.reps} reps + ${ex.hold[0]}–${ex.hold[1]} s`
          );
        } else if (ex.type === "custom") {
          tags.push(`${ex.sets}× exploration libre`);
        }
        if (ex.perSide) tags.push("G/D");
        if (ex.rpe != null) tags.push(`RPE ${ex.rpe}`);
        tags.push(`Repos ${ex.restSec || 90}s`);
        tags.forEach((t) => meta.appendChild(el("span", "tag", t)));

        const vurl = getVideoLink(phaseSel.value, ex.nom);
        if (vurl) {
          const vid = el("a", "tag", "🎬 Tutoriel vidéo");
          vid.href = vurl;
          vid.target = "_blank";
          vid.rel = "noopener";
          meta.appendChild(vid);
        } else {
          const miss = el("span", "tag", "(vidéo à venir)");
          meta.appendChild(miss);
        }

        head.append(title, meta);
        card.appendChild(head);

        const ul = el("ul", "list");
        if (ex.notes) ul.appendChild(el("li", "", `Note : ${ex.notes}`));
        if (ex.type === "custom") {
          ul.appendChild(
            el(
              "li",
              "",
              "Exploration libre : pas de règles strictes, explorez le mouvement à votre rythme."
            )
          );
        }
        card.appendChild(ul);

        const ctrls = el("div", "ctrls");
        const timers = [];
        for (let i = 1; i <= ex.sets; i++) {
          const serieRow = el("div", "serie-row");
          const serieLabel = el("div", "serie-label", `Série ${i}`);
          serieRow.appendChild(serieLabel);

          const serieControls = el("div", "serie-controls");

          const label = el("label", "");
          const cb = document.createElement("input");
          cb.type = "checkbox";
          cb.className = "check";
          cb.addEventListener("change", saveState);
          label.append(cb, document.createTextNode(" Terminée"));
          serieControls.appendChild(label);

          if (ex.type === "time") {
            const presets = [
              ex.range[0],
              Math.round((ex.range[0] + ex.range[1]) / 2),
              ex.range[1],
            ];
            if (ex.perSide) {
              const g = makeTimer(presets[1], presets, "Gauche"),
                d = makeTimer(presets[1], presets, "Droite");
              timers.push(g, d);
              serieControls.append(g.root, d.root);
            } else {
              const t = makeTimer(presets[1], presets, "Durée");
              timers.push(t);
              serieControls.appendChild(t.root);
            }
          }
          if (ex.type === "reps") {
            const target = Array.isArray(ex.reps)
              ? `${ex.reps[0]}–${ex.reps[1]}`
              : ex.reps;
            const box = el("div", "timer");
            const lab = el("span", "t-label", `Répétitions (cible ${target})`);
            const n = el("span", "t-time", "0");
            n.style.minWidth = "40px";
            const plus = el("button", "t-btn", "+"),
              moins = el("button", "t-btn", "−"),
              raz = el("button", "t-btn", "↺");
            plus.addEventListener(
              "click",
              () => (n.textContent = String(Number(n.textContent) + 1))
            );
            moins.addEventListener(
              "click",
              () =>
                (n.textContent = String(Math.max(0, Number(n.textContent) - 1)))
            );
            raz.addEventListener("click", () => (n.textContent = "0"));
            box.append(lab, n, plus, moins, raz);
            serieControls.appendChild(box);
          }
          if (ex.type === "combo") {
            const repsBox = el("div", "timer");
            repsBox.append(el("span", "t-label", `Répétitions (${ex.reps})`));
            const repsCount = el("span", "t-time", "0");
            repsCount.style.minWidth = "40px";
            const plus = el("button", "t-btn", "+"),
              moins = el("button", "t-btn", "−"),
              raz = el("button", "t-btn", "↺");
            plus.addEventListener(
              "click",
              () =>
                (repsCount.textContent = String(
                  Number(repsCount.textContent) + 1
                ))
            );
            moins.addEventListener(
              "click",
              () =>
                (repsCount.textContent = String(
                  Math.max(0, Number(repsCount.textContent) - 1)
                ))
            );
            raz.addEventListener("click", () => (repsCount.textContent = "0"));
            const hold = makeTimer(
              Math.round((ex.hold[0] + ex.hold[1]) / 2),
              [
                ex.hold[0],
                Math.round((ex.hold[0] + ex.hold[1]) / 2),
                ex.hold[1],
              ],
              "Maintien final"
            );
            timers.push(hold);
            repsBox.append(repsCount, plus, moins, raz);
            serieControls.appendChild(repsBox);
            serieControls.appendChild(hold.root);
          }
          if (ex.type === "custom") {
            const t = makeTimer(60, [30, 60, 90, 120], "Exploration");
            timers.push(t);
            serieControls.appendChild(t.root);
          }

          serieControls.appendChild(makeRestTimer(ex.restSec || 90));
          serieRow.appendChild(serieControls);
          ctrls.appendChild(serieRow);
        }
        card.appendChild(ctrls);
        card._timers = timers;
        return card;
      }

      function render() {
        const phase = phaseSel.value;
        const plan = PROGRAM[phase][seanceSel.value];
        const toc = $("#tocLinks");
        toc.innerHTML = "";

        // Ajouter l'échauffement au sommaire
        const warmupLink = el("a", "toc-link", "Échauffement complet");
        warmupLink.href = "#warmup-section";
        toc.appendChild(warmupLink);

        content.innerHTML = "";
        const headerSec = el("section", "");
        const phaseNames = {
          1: "Fondations",
          2: "Développement",
          3: "Avancé",
        };
        const seanceNames = {
          1: "Force",
          2:
            seanceSel.value === "2" && phase === "3"
              ? "Exploration & Flow"
              : "Mobilité & Équilibre",
        };
        headerSec.appendChild(
          el(
            "h2",
            "",
            `Phase ${phase} - ${phaseNames[phase]} | Séance ${
              seanceNames[seanceSel.value]
            }`
          )
        );
        content.appendChild(headerSec);

        const sec = el("section", "");
        (plan || []).forEach((ex) => {
          const card = renderExercise(ex);
          sec.appendChild(card);
          const a = el("a", "toc-link", `${ex.code} · ${ex.nom}`);
          a.href = `#${card.id}`;
          toc.appendChild(a);
        });
        content.appendChild(sec);

        const notesSec = el("section", "");
        notesSec.appendChild(el("h2", "", "Notes importantes"));
        const ul = el("ul", "list");

        if (phase === "1") {
          ul.innerHTML = `
            <li><strong>Fondations</strong> : Maîtrisez les mouvements de base avant de progresser.</li>
            <li><strong>Amplitude</strong> : Commencez avec des amplitudes réduites, augmentez progressivement.</li>
            <li><strong>Assistance</strong> : N'hésitez pas à utiliser des supports (chaise, élastique).</li>
            <li><strong>Écoute du corps</strong> : Arrêtez en cas de douleur, la tension est normale.</li>`;
        } else if (phase === "2") {
          ul.innerHTML = `
            <li><strong>Progression</strong> : Réduisez l'assistance, augmentez la difficulté graduellement.</li>
            <li><strong>Qualité > Quantité</strong> : Préférez un mouvement bien exécuté qu'un volume élevé.</li>
            <li><strong>Patience</strong> : Les mouvements avancés demandent du temps à maîtriser.</li>
            <li><strong>Repos</strong> : Respectez les temps de repos, la récupération est cruciale.</li>`;
        } else {
          ul.innerHTML = `
            <li><strong>Maîtrise</strong> : Vous explorez maintenant les limites du mouvement humain.</li>
            <li><strong>Créativité</strong> : Laissez place à l'improvisation et à l'expression personnelle.</li>
            <li><strong>Sécurité</strong> : Restez prudent avec les mouvements extrêmes.</li>
            <li><strong>Intégration</strong> : Combinez force, mobilité et coordination en un seul mouvement.</li>`;
        }

        notesSec.appendChild(ul);
        content.appendChild(notesSec);

        loadState();
      }

      /* ========= Thème & UI ========= */
      const btnTheme = $("#themeToggle");
      (function initTheme() {
        const saved = localStorage.getItem(KEY_THEME);
        if (saved) {
          document.documentElement.setAttribute("data-theme", saved);
        }
        btnTheme?.addEventListener("click", () => {
          const cur = document.documentElement.getAttribute("data-theme") || "";
          const next = cur === "light" ? "dark" : "light";
          document.documentElement.setAttribute("data-theme", next);
          localStorage.setItem(KEY_THEME, next);
        });
      })();

      const tocFab = $("#tocFab"),
        tocPanel = $("#tocPanel");
      tocFab?.addEventListener("click", () =>
        tocPanel.classList.toggle("open")
      );
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") tocPanel.classList.remove("open");
      });

      /* ========= Reset ========= */
      $("#resetBtn")?.addEventListener("click", () => {
        if (
          !confirm(
            "Réinitialiser la progression et les timers de cette séance ?"
          )
        )
          return;
        const all = JSON.parse(localStorage.getItem(KEY_STATE) || "{}");
        delete all[`p${phaseSel.value}-s${seanceSel.value}`];
        localStorage.setItem(KEY_STATE, JSON.stringify(all));
        $(
          ".ex input[type=checkbox], #warmup-section input[type=checkbox]"
        ).forEach((c) => (c.checked = false));
        $(".ex").forEach((ex) => {
          if (ex._timers) {
            ex._timers.forEach((t) => {
              t.pause?.();
              t.reset?.();
            });
          }
        });
        // Reset des timers d'échauffement
        $("#warmup-section .timer").forEach((timer) => {
          const resetBtn = timer.querySelector('.t-btn[textContent="↺"]');
          if (resetBtn) resetBtn.click();
        });
        updateBars();
      });

      /* ========= Init ========= */
      renderWarmupRefs();

      // Ajouter les event listeners pour les checkboxes d'échauffement
      setTimeout(() => {
        $("#warmup-section input[type=checkbox]").forEach((cb) => {
          cb.addEventListener("change", saveState);
        });
      }, 100);

      phaseSel.addEventListener("change", render);
      seanceSel.addEventListener("change", render);
      render();
    </script>
               

            </div>
        </div>
    </section>
</div>
</div>
@endsection
