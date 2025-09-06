import Alpine from 'alpinejs';

Alpine.data('gpxUploader', () => ({
    isDragging: false,
    file: null,
    uploading: false,
    progress: 0,
    error: null,
    statistics: null,
    validationWarnings: [],
    previewMap: null,

    init() {
        // Initialize component
        this.$watch('file', (value) => {
            if (value) {
                this.validateFile();
            }
        });
    },

    handleDragOver(e) {
        e.preventDefault();
        this.isDragging = true;
    },

    handleDragLeave(e) {
        e.preventDefault();
        this.isDragging = false;
    },

    handleDrop(e) {
        e.preventDefault();
        this.isDragging = false;
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            this.handleFile(files[0]);
        }
    },

    handleFileInput(e) {
        const files = e.target.files;
        if (files.length > 0) {
            this.handleFile(files[0]);
        }
    },

    validateFile() {
        this.validationWarnings = [];
        
        if (!this.file) return;

        // Check file size (5MB limit)
        const maxSize = 5 * 1024 * 1024;
        if (this.file.size > maxSize) {
            this.error = 'Le fichier GPX est trop volumineux (maximum 5MB)';
            return false;
        }

        // Check file extension
        const validExtensions = ['.gpx', '.xml'];
        const fileName = this.file.name.toLowerCase();
        const isValidExtension = validExtensions.some(ext => fileName.endsWith(ext));
        
        if (!isValidExtension) {
            this.error = 'Veuillez sélectionner un fichier GPX ou XML valide';
            return false;
        }

        // File size warnings
        if (this.file.size > 1024 * 1024) {
            this.validationWarnings.push('Fichier volumineux - le traitement peut prendre du temps');
        }

        return true;
    },

    handleFile(file) {
        this.file = file;
        this.error = null;
        
        if (this.validateFile()) {
            this.previewFile();
        }
    },

    async previewFile() {
        if (!this.file) return;

        try {
            const content = await this.readFileContent();
            this.analyzeGpxContent(content);
        } catch (error) {
            this.error = 'Impossible de lire le fichier GPX';
        }
    },

    readFileContent() {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = (e) => reject(e);
            reader.readAsText(this.file);
        });
    },

    analyzeGpxContent(content) {
        try {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(content, 'application/xml');
            
            // Check for parsing errors
            const parseError = xmlDoc.querySelector('parsererror');
            if (parseError) {
                this.error = 'Fichier GPX invalide - erreur de format XML';
                return;
            }

            // Count track points
            const trackPoints = xmlDoc.querySelectorAll('trkpt');
            const pointCount = trackPoints.length;
            
            if (pointCount === 0) {
                this.error = 'Aucun point GPS trouvé dans le fichier GPX';
                return;
            }

            // Add informational messages
            if (pointCount > 10000) {
                this.validationWarnings.push(`Fichier très détaillé (${pointCount.toLocaleString()} points) - le traitement peut être long`);
            }

            // Check for suspicious content
            if (this.containsSuspiciousContent(content)) {
                this.error = 'Le fichier GPX contient du contenu suspect';
                return;
            }

            this.displayPreviewInfo(pointCount);
            
        } catch (error) {
            this.error = 'Erreur lors de l\'analyse du fichier GPX';
        }
    },

    containsSuspiciousContent(content) {
        const suspiciousPatterns = [
            /<script[^>]*>.*?<\/script>/is,
            /javascript:/i,
            /on\w+\s*=/i,
            /<iframe/i,
            /<object/i,
            /<embed/i,
            /<!ENTITY/i,
            /<!DOCTYPE.*\[/i
        ];

        return suspiciousPatterns.some(pattern => pattern.test(content));
    },

    displayPreviewInfo(pointCount) {
        // Create a simple preview info object
        this.statistics = {
            preview: true,
            point_count: pointCount,
            file_size: this.formatFileSize(this.file.size)
        };
    },

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },

    async uploadFile() {
        if (!this.file || !this.validateFile()) return;

        this.uploading = true;
        this.progress = 0;
        this.error = null;

        const formData = new FormData();
        formData.append('gpx_file', this.file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));

        try {
            const response = await fetch('/admin/parse/gpx', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Erreur lors de l\'upload');
            }

            const data = await response.json();
            this.statistics = data.statistics;
            this.progress = 100;
            
            // Dispatch event for other components
            this.$dispatch('gpx-uploaded', data);
            
            // Show success message
            this.showNotification('Fichier GPX traité avec succès!', 'success');
            
        } catch (error) {
            this.error = error.message || 'Erreur lors de l\'upload';
            this.showNotification('Erreur lors du traitement du fichier GPX', 'error');
        } finally {
            this.uploading = false;
        }
    },

    removeFile() {
        this.file = null;
        this.statistics = null;
        this.error = null;
        this.progress = 0;
        this.validationWarnings = [];
        
        // Reset file input
        const fileInput = this.$refs.fileInput;
        if (fileInput) {
            fileInput.value = '';
        }
    },

    showNotification(message, type = 'info') {
        // Dispatch notification event
        this.$dispatch('show-notification', {
            message: message,
            type: type,
            duration: 5000
        });
    },

    get progressBarClass() {
        if (this.error) return 'bg-red-500';
        if (this.progress === 100) return 'bg-green-500';
        return 'bg-blue-500';
    },

    get fileIconClass() {
        if (this.error) return 'text-red-500';
        if (this.statistics && !this.statistics.preview) return 'text-green-500';
        return 'text-blue-500';
    }
}));