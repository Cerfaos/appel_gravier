// Enhanced GPX Uploader with better UX and security
document.addEventListener('DOMContentLoaded', function() {
    const gpxUploader = {
        init() {
            this.setupDropzone();
            this.setupPreview();
            this.setupValidation();
            this.setupProgressTracking();
        },

        setupDropzone() {
            const dropzoneElement = document.getElementById('gpx-dropzone');
            if (!dropzoneElement) return;

            // Enhanced Dropzone configuration
            const dropzone = new Dropzone(dropzoneElement, {
                url: '/api/gpx/analyze',
                paramName: 'gpx_file',
                maxFiles: 1,
                maxFilesize: 5, // 5MB
                acceptedFiles: '.gpx,.xml',
                addRemoveLinks: true,
                dictDefaultMessage: 'Glissez votre fichier GPX ici ou cliquez pour sélectionner',
                dictFileTooBig: 'Le fichier est trop volumineux (maximum 5MB)',
                dictInvalidFileType: 'Seuls les fichiers GPX sont acceptés',
                dictRemoveFile: 'Supprimer',
                dictCancelUpload: 'Annuler',

                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },

                init: function() {
                    this.on('addedfile', function(file) {
                        console.log('GPX file added:', file.name);
                        gpxUploader.showAnalyzing();
                    });

                    this.on('success', function(file, response) {
                        console.log('GPX analysis successful:', response);
                        gpxUploader.displayGpxData(response);
                        gpxUploader.updateFormFields(response.statistics);
                    });

                    this.on('error', function(file, error) {
                        console.error('GPX upload error:', error);
                        gpxUploader.showError(error.message || 'Erreur lors de l\'analyse du fichier GPX');
                    });

                    this.on('removedfile', function(file) {
                        gpxUploader.clearGpxData();
                    });
                }
            });
        },

        setupPreview() {
            this.previewContainer = document.getElementById('gpx-preview');
            this.mapContainer = document.getElementById('gpx-map');
            this.statsContainer = document.getElementById('gpx-stats');
        },

        setupValidation() {
            // Real-time form validation
            const form = document.getElementById('itinerary-form');
            if (!form) return;

            const titleInput = form.querySelector('input[name="title"]');
            const descriptionInput = form.querySelector('textarea[name="description"]');

            if (titleInput) {
                titleInput.addEventListener('input', this.validateTitle);
            }

            if (descriptionInput) {
                descriptionInput.addEventListener('input', this.validateDescription);
            }
        },

        validateTitle(event) {
            const title = event.target.value;
            const feedback = event.target.nextElementSibling;

            if (title.length < 3) {
                gpxUploader.showFieldError(event.target, 'Le titre doit contenir au moins 3 caractères');
            } else if (title.length > 255) {
                gpxUploader.showFieldError(event.target, 'Le titre ne peut pas dépasser 255 caractères');
            } else {
                gpxUploader.clearFieldError(event.target);
            }
        },

        validateDescription(event) {
            const description = event.target.value;
            
            if (description.length < 10) {
                gpxUploader.showFieldError(event.target, 'La description doit contenir au moins 10 caractères');
            } else if (description.length > 5000) {
                gpxUploader.showFieldError(event.target, 'La description ne peut pas dépasser 5000 caractères');
            } else {
                gpxUploader.clearFieldError(event.target);
            }
        },

        showFieldError(field, message) {
            field.classList.add('border-red-500');
            let errorDiv = field.parentNode.querySelector('.field-error');
            
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'field-error text-red-500 text-sm mt-1';
                field.parentNode.appendChild(errorDiv);
            }
            
            errorDiv.textContent = message;
        },

        clearFieldError(field) {
            field.classList.remove('border-red-500');
            const errorDiv = field.parentNode.querySelector('.field-error');
            if (errorDiv) {
                errorDiv.remove();
            }
        },

        setupProgressTracking() {
            this.progressBar = document.getElementById('upload-progress');
            this.progressText = document.getElementById('progress-text');
        },

        showAnalyzing() {
            if (this.progressBar) {
                this.progressBar.style.display = 'block';
                this.progressText.textContent = 'Analyse du fichier GPX en cours...';
            }
        },

        displayGpxData(data) {
            if (!this.previewContainer) return;

            this.previewContainer.style.display = 'block';
            
            // Display statistics
            if (this.statsContainer && data.statistics) {
                this.statsContainer.innerHTML = this.generateStatsHTML(data.statistics);
            }

            // Display map if coordinates are available
            if (this.mapContainer && data.points && data.points.length > 0) {
                this.renderMap(data.points, data.statistics);
            }

            // Hide progress
            if (this.progressBar) {
                this.progressBar.style.display = 'none';
            }
        },

        generateStatsHTML(stats) {
            return `
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-outdoor-cream-50 rounded-lg">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-outdoor-forest-500">${stats.distance_km || 0} km</div>
                        <div class="text-sm text-gray-600">Distance</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-outdoor-forest-500">${stats.elevation_gain_m || 0} m</div>
                        <div class="text-sm text-gray-600">Dénivelé +</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-outdoor-forest-500">${stats.point_count || 0}</div>
                        <div class="text-sm text-gray-600">Points GPS</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-outdoor-forest-500">${Math.round((stats.distance_km || 0) / 25 * 60)} min</div>
                        <div class="text-sm text-gray-600">Durée estimée</div>
                    </div>
                </div>
            `;
        },

        renderMap(points, statistics) {
            // Clear existing map
            this.mapContainer.innerHTML = '<div id="leaflet-map" style="height: 300px; width: 100%;"></div>';
            
            // Initialize Leaflet map
            const map = L.map('leaflet-map');
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Create polyline from points
            const latLngs = points.map(point => [point.latitude, point.longitude]);
            const polyline = L.polyline(latLngs, { color: '#606c38', weight: 3 }).addTo(map);
            
            // Fit map to polyline bounds
            map.fitBounds(polyline.getBounds(), { padding: [10, 10] });

            // Add start and end markers
            if (latLngs.length > 0) {
                L.marker(latLngs[0])
                    .addTo(map)
                    .bindPopup('Départ')
                    .openPopup();
                
                if (latLngs.length > 1) {
                    L.marker(latLngs[latLngs.length - 1])
                        .addTo(map)
                        .bindPopup('Arrivée');
                }
            }
        },

        updateFormFields(statistics) {
            // Auto-fill form fields based on GPX analysis
            const fields = {
                'distance_km': statistics.distance_km,
                'elevation_gain_m': statistics.elevation_gain_m,
                'elevation_loss_m': statistics.elevation_loss_m,
                'estimated_duration_minutes': Math.round((statistics.distance_km || 0) / 25 * 60),
                'min_latitude': statistics.min_latitude,
                'max_latitude': statistics.max_latitude,
                'min_longitude': statistics.min_longitude,
                'max_longitude': statistics.max_longitude
            };

            Object.entries(fields).forEach(([fieldName, value]) => {
                const field = document.querySelector(`input[name="${fieldName}"]`);
                if (field && value !== null && value !== undefined) {
                    field.value = value;
                }
            });

            // Auto-suggest difficulty based on distance and elevation
            this.suggestDifficulty(statistics);
        },

        suggestDifficulty(statistics) {
            const difficultySelect = document.querySelector('select[name="difficulty_level"]');
            if (!difficultySelect) return;

            const distance = statistics.distance_km || 0;
            const elevation = statistics.elevation_gain_m || 0;

            let suggestedDifficulty = 'facile';

            if (distance > 50 || elevation > 1000) {
                suggestedDifficulty = 'difficile';
            } else if (distance > 25 || elevation > 500) {
                suggestedDifficulty = 'moyen';
            }

            // Highlight suggested difficulty
            const options = difficultySelect.querySelectorAll('option');
            options.forEach(option => {
                option.classList.remove('bg-yellow-100');
                if (option.value === suggestedDifficulty) {
                    option.classList.add('bg-yellow-100');
                    option.textContent += ' (suggéré)';
                }
            });
        },

        clearGpxData() {
            if (this.previewContainer) {
                this.previewContainer.style.display = 'none';
            }
            
            // Clear auto-filled fields
            const fieldsTolear = [
                'distance_km', 'elevation_gain_m', 'elevation_loss_m',
                'estimated_duration_minutes', 'min_latitude', 'max_latitude',
                'min_longitude', 'max_longitude'
            ];

            fieldsTolear.forEach(fieldName => {
                const field = document.querySelector(`input[name="${fieldName}"]`);
                if (field) {
                    field.value = '';
                }
            });
        },

        showError(message) {
            const errorContainer = document.getElementById('gpx-error');
            if (errorContainer) {
                errorContainer.style.display = 'block';
                errorContainer.textContent = message;
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    errorContainer.style.display = 'none';
                }, 5000);
            }

            if (this.progressBar) {
                this.progressBar.style.display = 'none';
            }
        }
    };

    // Initialize the GPX uploader
    gpxUploader.init();

    // Auto-save functionality (optional)
    const form = document.getElementById('itinerary-form');
    if (form) {
        let autoSaveTimeout;
        
        form.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                gpxUploader.autoSave();
            }, 30000); // Auto-save after 30 seconds of inactivity
        });
    }

    // Add auto-save method
    gpxUploader.autoSave = function() {
        const form = document.getElementById('itinerary-form');
        if (!form) return;

        const formData = new FormData(form);
        formData.append('auto_save', '1');

        fetch('/api/itinerary/auto-save', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                console.log('Auto-save successful');
                // Show subtle success indicator
                const indicator = document.getElementById('auto-save-indicator');
                if (indicator) {
                    indicator.textContent = 'Sauvegardé automatiquement';
                    indicator.classList.add('text-green-600');
                }
            }
        }).catch(error => {
            console.error('Auto-save failed:', error);
        });
    };
});