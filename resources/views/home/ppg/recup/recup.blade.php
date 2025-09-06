@extends('home.body.home_master')

@section('home')
<div class="bg-outdoor-cream min-h-screen">

  <section class="relative bg-outdoor-earth-500 text-white py-20" >
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                
                <!-- Content Side -->
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                        <span class="text-outdoor-cream-50">Récupération</span><br>
                        <span class="text-outdoor-ochre-200">Stretching spécial vélo</span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl mb-8 text-outdoor-cream-50/90 leading-relaxed">
                      Stretching ciblé pour une récupération optimale après vos sorties vélo
                    </p>
                    
                    <div class="bg-outdoor-cream-50/20 backdrop-blur-sm rounded-xl p-6 mb-8">
                        <p class="text-lg font-medium">
                          Choisis ta séance, lance les timers, et suis les cues pour une récupération efficace.
                        </p>
                    </div>
  
                    <!-- Stats or Features -->
                    
                </div>
  
                <!-- Image Side -->
                <div class="relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                    
                    <!-- Background Gradient Cards -->
                    <div class="absolute inset-0 bg-outdoor-ochre-300 rounded-2xl transform rotate-3 shadow-2xl"></div>
                    <div class="absolute inset-0 bg-outdoor-earth-300 rounded-2xl transform -rotate-1 shadow-xl opacity-70"></div>
                    
                    <!-- Main Image Container -->
                    <div class="relative bg-white rounded-2xl p-6 shadow-2xl">
                        <img 
                            src="{{ asset('frontend/assets/images/img_cerfaos/bandeau_ppg04.png') }}" 
                            alt="Préparation Physique Générale - Entraînement Outdoor" 
                            class="w-full h-80 object-cover rounded-xl"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                        />
                        <!-- Fallback content -->
                        <div class="w-full h-80 bg-outdoor-cream-100 rounded-xl flex items-center justify-center" style="display: none;">
                            <div class="text-center">
                                <i class="fas fa-dumbbell text-6xl text-outdoor-ochre-400 mb-4"></i>
                                <p class="text-outdoor-forest-500 font-semibold">Préparation Physique</p>
                            </div>
                        </div>
  
                        <!-- Floating Achievement Cards -->
                        <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-ochre-100 transform rotate-6 hover:rotate-3 transition-transform duration-300">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl">🎯</span>
                                <div>
                                    <div class="text-sm font-bold text-outdoor-forest-600">Performance</div>
                                    <div class="text-xs text-outdoor-forest-400">Optimisée</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-3 shadow-xl border border-outdoor-earth-100 transform -rotate-6 hover:-rotate-3 transition-transform duration-300">
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
                    <div class="absolute -z-10 top-1/4 -right-8 w-32 h-32 bg-outdoor-ochre-200 rounded-full opacity-20 blur-2xl"></div>
                    <div class="absolute -z-10 bottom-1/4 -left-8 w-40 h-40 bg-outdoor-earth-200 rounded-full opacity-20 blur-2xl"></div>
                </div>
            </div>
        </div>
    </div>
  </section>





    <!-- Banner Title Section -->
   

    <!-- Section Contenu -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                
                <!-- Contrôles de séance -->
                <div class="outdoor-card mb-8">
                    <div class="flex flex-wrap items-center gap-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-outdoor-ochre/10 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-outdoor-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17l1.5-3h11L19 17M6 17a2 2 0 100 4 2 2 0 000-4zM18 17a2 2 0 100 4 2 2 0 000-4zM7 14l2-6h6l2 6"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-outdoor-forest">Configuration de la séance</h2>
                                <p class="text-gray-600">Choisis ta séance et lance les timers</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-2">
                            <button id="themeToggle" class="bg-outdoor-ochre text-white px-3 py-1 rounded-full text-sm hover:bg-outdoor-earth transition-colors">
                                Thème
                            </button>
                            <button id="resetBtn" class="bg-red-600 text-white px-3 py-1 rounded-full text-sm hover:bg-red-700 transition-colors" title="Réinitialiser">
                                Réinitialiser
                            </button>
                            <button onclick="window.print()" class="bg-outdoor-forest text-white px-3 py-1 rounded-full text-sm hover:bg-opacity-80 transition-colors">
                                Imprimer
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="flex items-center gap-3">
                            <span class="font-medium text-outdoor-forest">Type de séance :</span>
                            <select id="planSel" class="bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-outdoor-ochre focus:border-transparent" aria-label="Choisir la séance">
                                <option value="apres">Après-vélo (12–15 min)</option>
                                <option value="complete">Complète bas du corps (25–30 min)</option>
                                <option value="bureau">Micro-routine bureau (6 min)</option>
                            </select>
                        </label>
                    </div>
                    
                    <div class="bg-outdoor-cream/50 rounded-lg p-4 mb-4">
                        <p class="text-outdoor-forest text-sm">
                            <strong>Règle d'or :</strong> Respire par le nez. Tension 6–7/10 (jamais de douleur vive). 
                            Si tu bloques la respiration, réduis l'amplitude.
                        </p>
                        <div class="text-xs text-outdoor-muted mt-2">
                            Fréquence : Après-vélo 2–4×/sem • Complète 1–2×/sem • Bureau quotidien
                        </div>
                    </div>
                    
                    <div class="bg-gray-200 rounded-full h-2 mb-2" aria-label="Progression">
                        <div class="bg-gradient-to-r from-outdoor-ochre to-outdoor-earth h-2 rounded-full transition-all duration-300" id="bar" style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-600 text-center">Progression de la séance</p>
                </div>
                
                <!-- Exercices dynamiques -->
                <div id="content"></div>
                
                <!-- Notes coach -->
                <div class="outdoor-card mt-8">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-outdoor-ochre/10 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-outdoor-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-outdoor-forest">Notes du coach vélo</h2>
                    </div>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="w-2 h-2 bg-outdoor-ochre rounded-full mt-2 flex-shrink-0"></span>
                            <span><strong class="text-outdoor-forest">Psoas/fessiers</strong> relâchés = bassin stable et confort selle.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-2 h-2 bg-outdoor-ochre rounded-full mt-2 flex-shrink-0"></span>
                            <span><strong class="text-outdoor-forest">Dorsiflexion cheville</strong> → meilleur "passage" du point mort haut, genoux protégés.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-2 h-2 bg-outdoor-ochre rounded-full mt-2 flex-shrink-0"></span>
                            <span>Enchaîne idéalement la séance <strong class="text-outdoor-forest">dans l'heure</strong> suivant la sortie vélo.</span>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </section>
</div>

<style>
    /* Styles spécifiques pour l'interface interactive */
    .timer {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }
    .t-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #283618;
        margin-bottom: 0.5rem;
        display: block;
    }
    .t-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .t-time {
        background: #fefae0;
        border: 1px solid #dda15e;
        border-radius: 0.25rem;
        padding: 0.25rem 0.75rem;
        font-family: ui-monospace, SFMono-Regular, Monaco, Consolas, monospace;
        text-align: center;
        min-width: 4rem;
        color: #283618;
    }
    .t-btn, .t-preset {
        background: #dda15e;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .t-btn:hover, .t-preset:hover {
        background: #bc6c25;
    }
    .t-preset {
        background: #6b7280;
    }
    .t-preset:hover {
        background: #4b5563;
    }
    .t-running .t-time {
        border-color: #34d399;
        background: #ecfdf5;
    }
    .t-done .t-time {
        border-color: #dda15e;
        background: rgba(221, 161, 94, 0.1);
    }
    .ex {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    .ex header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }
    .ex h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #283618;
        margin: 0;
    }
    .meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        font-size: 0.75rem;
    }
    .tag {
        background: rgba(221, 161, 94, 0.2);
        color: #283618;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        text-decoration: none;
    }
    .tag:hover {
        background: rgba(221, 161, 94, 0.3);
    }
    .ctrls {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid #e5e7eb;
    }
    .check {
        width: 1rem;
        height: 1rem;
        color: #dda15e;
        accent-color: #dda15e;
    }
    .check:focus {
        ring: 2px solid #dda15e;
    }
    .list {
        color: #6b7280;
    }
    .list li {
        margin: 0.25rem 0;
    }
</style>

<script>
        /* ====== Données des séances (articles StretchingPro liés) ====== */
        const A = {
          // Liens d'articles
          psoas1: "https://www.stretchingpro.com/etirements-psoas/",
          psoas2: "https://www.stretchingpro.com/assouplir-psoas/",
          ischios1: "https://www.stretchingpro.com/etirements-ischios-jambiers/",
          ischios2:
            "https://www.stretchingpro.com/assouplissement-ischio-jambiers/",
          mollets1: "https://www.stretchingpro.com/etirements-des-mollets/",
          mollets2:
            "https://www.stretchingpro.com/7-assouplissements-des-mollets-rapides-et-efficaces/",
          piriforme1: "https://www.stretchingpro.com/etirement-piriforme/",
          fessiers: "https://www.stretchingpro.com/etirements-fessiers/",
          adducteurs1: "https://www.stretchingpro.com/etirements-adducteurs/",
          adducteurs2: "https://www.stretchingpro.com/souplesse-adducteurs/",
          cheville: "https://www.stretchingpro.com/mobilite-cheville/",
        };

        const PLANS = {
          apres: [
            {
              nom: "Psoas en chevalier (fente basse)",
              type: "time",
              range: [30, 45],
              perSide: true,
              cues: "Rétroversion légère + serre le fessier arrière ; buste haut.",
              article: A.psoas1,
            },
            {
              nom: "Ischios unilatéral jambe sur support",
              type: "time",
              range: [30, 45],
              perSide: true,
              cues: "Antéversion bassin, dos long ; pointe du pied vers toi.",
              article: A.ischios1,
            },
            {
              nom: "Mollet au mur (gastrocnémien)",
              type: "time",
              range: [30, 40],
              perSide: true,
              cues: "Talon lourd au sol, genou tendu.",
              article: A.mollets1,
            },
            {
              nom: "Mollet au mur (soléaire)",
              type: "time",
              range: [30, 40],
              perSide: true,
              cues: "Talon lourd, genou légèrement fléchi.",
              article: A.mollets1,
            },
            {
              nom: "Piriforme / fessiers (figure-4)",
              type: "time",
              range: [30, 45],
              perSide: true,
              cues: "Genou aligné ; aucune torsion douloureuse.",
              article: A.piriforme1,
            },
            {
              nom: "Adducteurs (papillon assis)",
              type: "time",
              range: [30, 45],
              cues: "Dos long, mains sur tibias (pas sur les genoux).",
              article: A.adducteurs1,
            },
          ],
          complete: [
            // Bloc A – mobilité active courte
            {
              nom: "Chevilles : dorsiflexion au mur",
              type: "reps",
              reps: [10, 12],
              perSide: true,
              cues: "Genou vers l'avant sans décoller le talon.",
              article: A.cheville,
            },
            {
              nom: "Pont fessier + bascule bassin",
              type: "reps",
              reps: [10, 12],
              cues: "Rétroversion douce, active les fessiers.",
              article: A.fessiers,
            },

            // Bloc B – stretching principal
            {
              nom: "Psoas chevalier + bras au-dessus",
              type: "time",
              range: [40, 60],
              perSide: true,
              cues: "Rétroversion + fessier contracté ; évite de cambrer.",
              article: A.psoas2,
            },
            {
              nom: "Ischios sangle (allongé) ou assis dos droit",
              type: "time",
              range: [30, 45],
              perSide: true,
              cues: "Antéversion ; avance le sternum/nombril.",
              article: A.ischios2,
            },
            {
              nom: "Adducteurs en grenouille (genoux fléchis)",
              type: "time",
              range: [30, 45],
              cues: "Hanches ouvertes sans douleur ; respiration calme.",
              article: A.adducteurs2,
            },
            {
              nom: "Mollets : gastro → soléaire",
              type: "time",
              range: [30, 40],
              perSide: true,
              cues: "Talon bas ; version 1 genou tendu, version 2 genou fléchi.",
              article: A.mollets1,
            },
            {
              nom: "Piriforme (figure-4) prolongé",
              type: "time",
              range: [40, 40],
              perSide: true,
              cues: "Cherche une tension franche mais tolérable (6–7/10).",
              article: A.piriforme1,
            },
          ],
          bureau: [
            {
              nom: "Cheville au mur",
              type: "reps",
              reps: [10, 12],
              perSide: true,
              cues: "Talons au sol, amplitude facile.",
              article: A.cheville,
            },
            {
              nom: "Psoas chevalier statique",
              type: "time",
              range: [30, 30],
              perSide: true,
              cues: "Rétroversion + fessier ; buste haut.",
              article: A.psoas1,
            },
            {
              nom: "Ischios debout jambe sur chaise",
              type: "time",
              range: [30, 30],
              perSide: true,
              cues: "Antéversion ; dos neutre.",
              article: A.ischios1,
            },
            {
              nom: "Fessier figure-4 sur chaise",
              type: "time",
              range: [30, 30],
              perSide: true,
              cues: "Genou aligné, sans torsion.",
              article: A.fessiers,
            },
          ],
        };

        /* ====== Utilitaires & timers ====== */
        const $ = (s) => document.querySelector(s),
          $$ = (s) => Array.from(document.querySelectorAll(s));
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
          const bStart = el("button", "t-btn", "▶ Démarrer"),
            bPause = el("button", "t-btn", "❚❚ Pause"),
            bReset = el("button", "t-btn", "↺");
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
        function makeRepsCounter(range = [10, 12]) {
          const box = el("div", "timer");
          const lab = el(
            "span",
            "t-label",
            `Répétitions (cible ${range[0]}–${range[1]})`
          );
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
            () => (n.textContent = String(Math.max(0, Number(n.textContent) - 1)))
          );
          raz.addEventListener("click", () => (n.textContent = "0"));
          box.append(lab, n, plus, moins, raz);
          return box;
        }

        /* ====== Rendu ====== */
        const planSel = $("#planSel"),
          content = $("#content"),
          bar = $("#bar");
        const KEY_THEME = "stretch-theme",
          KEY_STATE = "stretch-state-v1";

        function stateKey() {
          return `plan-${planSel.value}`;
        }
        function updateBars() {
          const checks = $$("#content .check");
          const done = checks.filter((c) => c.checked).length;
          const total = checks.length;
          bar.style.width = total ? Math.round((done / total) * 100) + "%" : "0%";
        }
        function saveState() {
          const st = JSON.parse(localStorage.getItem(KEY_STATE) || "{}");
          st[stateKey()] = $$("#content .check").map((c) => c.checked);
          localStorage.setItem(KEY_STATE, JSON.stringify(st));
          updateBars();
        }
        function loadState() {
          const arr =
            JSON.parse(localStorage.getItem(KEY_STATE) || "{}")[stateKey()] || [];
          $$("#content .check").forEach((c, i) => (c.checked = !!arr[i]));
          updateBars();
        }

        function makeCard(item, idx) {
          const card = el("div", "ex");
          const head = el("header");
          const title = el("h3", "", `${idx}. ${item.nom}`);
          const meta = el("div", "meta");

          const tags = [];
          if (item.type === "time") {
            tags.push(`${item.range[0]}–${item.range[1]} s`);
          }
          if (item.type === "reps") {
            tags.push(`${item.reps[0]}–${item.reps[1]} reps`);
          }
          if (item.perSide) tags.push("G/D");
          if (item.cues) tags.push("Cues");

          tags.forEach((t) => meta.appendChild(el("span", "tag", t)));
          if (item.article) {
            const a = el("a", "tag", "Article");
            a.href = item.article;
            a.target = "_blank";
            a.rel = "noopener";
            meta.appendChild(a);
          }

          head.append(title, meta);
          card.appendChild(head);

          const ul = el("ul", "list");
          if (item.cues) ul.appendChild(el("li", "", item.cues));
          card.appendChild(ul);

          const ctrls = el("div", "ctrls");
          const label = el("label", "");
          const cb = document.createElement("input");
          cb.type = "checkbox";
          cb.className = "check";
          label.append(cb, document.createTextNode(" Terminé"));
          ctrls.appendChild(label);

          if (item.type === "time") {
            const presets = [
              item.range[0],
              Math.round((item.range[0] + item.range[1]) / 2),
              item.range[1],
            ];
            if (item.perSide) {
              ctrls.appendChild(makeTimer(presets[1], presets, "Gauche").root);
              ctrls.appendChild(makeTimer(presets[1], presets, "Droite").root);
            } else {
              ctrls.appendChild(makeTimer(presets[1], presets, "Durée").root);
            }
          } else {
            ctrls.appendChild(makeRepsCounter(item.reps));
          }

          ctrls.addEventListener("change", saveState);
          card.appendChild(ctrls);
          return card;
        }

        function render() {
          const plan = PLANS[planSel.value] || [];
          content.innerHTML = "";
          let i = 1;
          plan.forEach((it) => content.appendChild(makeCard(it, i++)));
          loadState();
        }

        /* ====== Thème / Reset ====== */
        const btnTheme = document.getElementById("themeToggle");
        (function initTheme() {
          const saved = localStorage.getItem(KEY_THEME);
          if (saved) document.documentElement.setAttribute("data-theme", saved);
          btnTheme?.addEventListener("click", () => {
            const cur = document.documentElement.getAttribute("data-theme") || "";
            const next = cur === "light" ? "dark" : "light";
            document.documentElement.setAttribute("data-theme", next);
            localStorage.setItem(KEY_THEME, next);
          });
        })();
        document.getElementById("resetBtn")?.addEventListener("click", () => {
          if (!confirm("Réinitialiser la progression de cette séance ?")) return;
          const all = JSON.parse(localStorage.getItem(KEY_STATE) || "{}");
          delete all[stateKey()];
          localStorage.setItem(KEY_STATE, JSON.stringify(all));
          $$("#content .check").forEach((c) => (c.checked = false));
          updateBars();
        });

        /* ====== Init ====== */
        planSel.addEventListener("change", render);
        render();
      </script>
@endsection