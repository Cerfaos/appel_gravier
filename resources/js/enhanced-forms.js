import Alpine from 'alpinejs';

// Enhanced Image Gallery Manager
Alpine.data('imageGallery', () => ({
    images: [],
    draggedIndex: null,
    uploading: false,
    progress: 0,
    maxFiles: 10,
    maxFileSize: 10 * 1024 * 1024, // 10MB
    allowedTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
    featuredIndex: null,

    init() {
        this.loadExistingImages();
    },

    loadExistingImages() {
        // Load existing images from hidden inputs or data attributes
        const existingImagesData = this.$el.dataset.existingImages;
        if (existingImagesData) {
            try {
                this.images = JSON.parse(existingImagesData);
            } catch (e) {
                console.warn('Failed to parse existing images data');
            }
        }
    },

    handleFiles(files) {
        const fileArray = Array.from(files);
        
        // Check file count limit
        if (this.images.length + fileArray.length > this.maxFiles) {
            this.showNotification(`Vous ne pouvez uploader que ${this.maxFiles} images maximum`, 'warning');
            return;
        }

        this.uploading = true;
        this.progress = 0;

        const validFiles = fileArray.filter(file => this.validateFile(file));
        
        if (validFiles.length === 0) {
            this.uploading = false;
            return;
        }

        this.processFiles(validFiles);
    },

    validateFile(file) {
        // Check file type
        if (!this.allowedTypes.includes(file.type)) {
            this.showNotification(`Format non supporté: ${file.name}`, 'error');
            return false;
        }

        // Check file size
        if (file.size > this.maxFileSize) {
            this.showNotification(`Fichier trop volumineux: ${file.name} (max 10MB)`, 'error');
            return false;
        }

        return true;
    },

    async processFiles(files) {
        const totalFiles = files.length;
        let processedFiles = 0;

        for (const file of files) {
            try {
                const imageData = await this.processImage(file);
                this.images.push({
                    id: Date.now() + Math.random(),
                    file: file,
                    preview: imageData.preview,
                    caption: '',
                    name: file.name,
                    size: file.size,
                    dimensions: imageData.dimensions,
                    isNew: true
                });
                
                processedFiles++;
                this.progress = Math.round((processedFiles / totalFiles) * 100);
                
            } catch (error) {
                this.showNotification(`Erreur lors du traitement de ${file.name}`, 'error');
            }
        }

        this.uploading = false;
        this.progress = 0;
        this.updateFormInputs();
    },

    processImage(file) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            img.onload = () => {
                // Create preview
                const maxPreviewSize = 200;
                const ratio = Math.min(maxPreviewSize / img.width, maxPreviewSize / img.height);
                canvas.width = img.width * ratio;
                canvas.height = img.height * ratio;
                
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                
                resolve({
                    preview: canvas.toDataURL('image/jpeg', 0.8),
                    dimensions: {
                        width: img.width,
                        height: img.height
                    }
                });
            };
            
            img.onerror = () => reject(new Error('Failed to load image'));
            img.src = URL.createObjectURL(file);
        });
    },

    removeImage(index) {
        // Revoke object URL to prevent memory leaks
        const image = this.images[index];
        if (image.preview && image.preview.startsWith('blob:')) {
            URL.revokeObjectURL(image.preview);
        }
        
        this.images.splice(index, 1);
        
        // Adjust featured index if necessary
        if (this.featuredIndex === index) {
            this.featuredIndex = null;
        } else if (this.featuredIndex > index) {
            this.featuredIndex--;
        }
        
        this.updateFormInputs();
    },

    setFeatured(index) {
        this.featuredIndex = this.featuredIndex === index ? null : index;
        this.updateFormInputs();
    },

    updateCaption(index, caption) {
        if (this.images[index]) {
            this.images[index].caption = caption;
            this.updateFormInputs();
        }
    },

    // Drag and drop reordering
    startDrag(index) {
        this.draggedIndex = index;
    },

    dragOver(e) {
        e.preventDefault();
    },

    drop(e, targetIndex) {
        e.preventDefault();
        
        if (this.draggedIndex !== null && this.draggedIndex !== targetIndex) {
            const draggedItem = this.images[this.draggedIndex];
            this.images.splice(this.draggedIndex, 1);
            this.images.splice(targetIndex, 0, draggedItem);
            
            // Update featured index if necessary
            if (this.featuredIndex === this.draggedIndex) {
                this.featuredIndex = targetIndex;
            } else if (this.featuredIndex > this.draggedIndex && this.featuredIndex <= targetIndex) {
                this.featuredIndex--;
            } else if (this.featuredIndex < this.draggedIndex && this.featuredIndex >= targetIndex) {
                this.featuredIndex++;
            }
            
            this.updateFormInputs();
        }
        
        this.draggedIndex = null;
    },

    updateFormInputs() {
        // Update hidden form inputs for form submission
        this.$dispatch('images-updated', {
            images: this.images,
            featuredIndex: this.featuredIndex
        });
    },

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },

    showNotification(message, type = 'info') {
        this.$dispatch('show-notification', {
            message: message,
            type: type,
            duration: 5000
        });
    }
}));

// Form Validation Enhancement
Alpine.data('formValidator', () => ({
    errors: {},
    touched: {},
    validationRules: {},
    isSubmitting: false,

    init() {
        this.setupValidationRules();
        this.bindFieldEvents();
    },

    setupValidationRules() {
        // Define validation rules for different field types
        this.validationRules = {
            title: {
                required: true,
                minLength: 3,
                maxLength: 255
            },
            description: {
                required: true,
                minLength: 10,
                maxLength: 5000
            },
            meta_title: {
                maxLength: 60
            },
            meta_description: {
                maxLength: 160
            },
            difficulty_level: {
                required: true
            }
        };
    },

    bindFieldEvents() {
        // Add event listeners for real-time validation
        this.$nextTick(() => {
            const form = this.$el.querySelector('form');
            if (form) {
                const fields = form.querySelectorAll('input, textarea, select');
                fields.forEach(field => {
                    field.addEventListener('blur', () => this.validateField(field.name, field.value));
                    field.addEventListener('input', () => this.clearError(field.name));
                });
            }
        });
    },

    validateField(fieldName, value) {
        this.touched[fieldName] = true;
        const rules = this.validationRules[fieldName];
        
        if (!rules) return true;

        let isValid = true;
        let errorMessage = '';

        // Required validation
        if (rules.required && (!value || value.trim() === '')) {
            isValid = false;
            errorMessage = 'Ce champ est obligatoire';
        }
        // Min length validation
        else if (rules.minLength && value && value.length < rules.minLength) {
            isValid = false;
            errorMessage = `Minimum ${rules.minLength} caractères requis`;
        }
        // Max length validation
        else if (rules.maxLength && value && value.length > rules.maxLength) {
            isValid = false;
            errorMessage = `Maximum ${rules.maxLength} caractères autorisés`;
        }

        if (isValid) {
            delete this.errors[fieldName];
        } else {
            this.errors[fieldName] = errorMessage;
        }

        return isValid;
    },

    clearError(fieldName) {
        delete this.errors[fieldName];
    },

    validateForm() {
        const form = this.$el.querySelector('form');
        if (!form) return false;

        let isFormValid = true;
        const formData = new FormData(form);

        // Validate all fields with rules
        Object.keys(this.validationRules).forEach(fieldName => {
            const value = formData.get(fieldName) || '';
            if (!this.validateField(fieldName, value)) {
                isFormValid = false;
            }
        });

        return isFormValid;
    },

    async submitForm(e) {
        if (this.isSubmitting) {
            e.preventDefault();
            return;
        }

        if (!this.validateForm()) {
            e.preventDefault();
            this.showNotification('Veuillez corriger les erreurs dans le formulaire', 'error');
            return;
        }

        this.isSubmitting = true;
        
        // Show loading state
        this.showNotification('Sauvegarde en cours...', 'info');
    },

    showNotification(message, type = 'info') {
        this.$dispatch('show-notification', {
            message: message,
            type: type,
            duration: 5000
        });
    },

    getFieldError(fieldName) {
        return this.errors[fieldName] || '';
    },

    hasError(fieldName) {
        return !!this.errors[fieldName];
    },

    shouldShowError(fieldName) {
        return this.touched[fieldName] && this.hasError(fieldName);
    }
}));

// Global Notification System
Alpine.data('notificationSystem', () => ({
    notifications: [],
    nextId: 1,

    init() {
        // Listen for notification events
        this.$el.addEventListener('show-notification', (e) => {
            this.addNotification(e.detail);
        });
    },

    addNotification({ message, type = 'info', duration = 5000 }) {
        const notification = {
            id: this.nextId++,
            message,
            type,
            duration
        };

        this.notifications.push(notification);

        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                this.removeNotification(notification.id);
            }, duration);
        }
    },

    removeNotification(id) {
        const index = this.notifications.findIndex(n => n.id === id);
        if (index > -1) {
            this.notifications.splice(index, 1);
        }
    },

    getNotificationClass(type) {
        const baseClasses = 'px-4 py-3 rounded-md shadow-lg border-l-4 transition-all duration-300';
        
        switch (type) {
            case 'success':
                return `${baseClasses} bg-green-50 border-green-400 text-green-700`;
            case 'error':
                return `${baseClasses} bg-red-50 border-red-400 text-red-700`;
            case 'warning':
                return `${baseClasses} bg-yellow-50 border-yellow-400 text-yellow-700`;
            default:
                return `${baseClasses} bg-blue-50 border-blue-400 text-blue-700`;
        }
    },

    getIconClass(type) {
        switch (type) {
            case 'success':
                return 'fas fa-check-circle text-green-500';
            case 'error':
                return 'fas fa-exclamation-circle text-red-500';
            case 'warning':
                return 'fas fa-exclamation-triangle text-yellow-500';
            default:
                return 'fas fa-info-circle text-blue-500';
        }
    }
}));