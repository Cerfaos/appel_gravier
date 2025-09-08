import './bootstrap';

// Import core utilities
import { animations, dom, eventBus, forms, http, storage, utils } from './modules/core-utilities';

// Import Alpine.js
import Alpine from 'alpinejs';

// Make utilities globally available
window.CerfaosUtils = {
  utils,
  animations,
  dom,
  storage,
  http,
  forms,
  eventBus
};

// Initialize Alpine.js
window.Alpine = Alpine;

// Alpine.js global configuration
Alpine.start();

// Initialize Feather icons when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  if (typeof feather !== 'undefined') {
    feather.replace();
  }
});

// Global error handling
window.addEventListener('error', (event) => {
  console.error('Global error:', event.error);
});

// Performance monitoring
if ('performance' in window) {
  window.addEventListener('load', () => {
    setTimeout(() => {
      const navigation = performance.getEntriesByType('navigation')[0];
      console.log('Page load time:', navigation.loadEventEnd - navigation.loadEventStart + 'ms');
    }, 0);
  });
}
