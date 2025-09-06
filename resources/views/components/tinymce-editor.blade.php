@props([
    'id' => 'tinymce-editor',
    'name' => 'content',
    'value' => '',
    'config' => []
])

<textarea 
    id="{{ $id }}"
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'form-control tinymce-editor']) }}
>{!! $value !!}</textarea>

@once
<!-- TinyMCE 6 via CDN officiel -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Attendre que TinyMCE soit chargé
    function initTinyMCE() {
        if (typeof tinymce !== 'undefined') {
            const customConfig = @json($config);
            
            const baseConfig = {
                selector: '#{{ $id }}',
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image | code preview fullscreen',
                height: 400,
                branding: false,
                menubar: false,
                
                // Style Forest Premium
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #2d5016; } h1,h2,h3,h4,h5,h6 { color: #2d5016; font-weight: 600; }',
                
                // Couleurs Forest Premium
                color_map: [
                    '#606c38', 'Olive',
                    '#2d5016', 'Forest', 
                    '#4a5429', 'Sage',
                    '#dda15e', 'Ochre',
                    '#bc6c25', 'Earth',
                    '#fefae0', 'Cream'
                ],
                
                setup: function(editor) {
                    editor.on('change keyup', function() {
                        editor.save();
                    });
                    editor.on('init', function() {
                        console.log('TinyMCE 6 initialized for #{{ $id }}');
                    });
                }
            };
            
            const finalConfig = { ...baseConfig, ...customConfig };
            tinymce.init(finalConfig);
        } else {
            setTimeout(initTinyMCE, 100);
        }
    }
    
    initTinyMCE();
});
</script>
@endonce