@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => [],
    'required' => false
])

<div class="mb-3" x-data="multiSelect('{{ $name }}', {{ json_encode($selected) }})">
    @if($label)
        <label class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <div class="position-relative">
        <div 
            @click="open = !open"
            class="form-control cursor-pointer d-flex flex-wrap gap-1"
            style="min-height: 40px; cursor: pointer;"
        >
            <template x-for="item in selectedItems" :key="item">
                <span class="badge bg-primary d-inline-flex align-items-center">
                    <span x-text="getOptionLabel(item)"></span>
                    <button @click.stop="removeItem(item)" type="button" class="btn-close btn-close-white ms-1" style="font-size: 0.6rem;" aria-label="Close"></button>
                </span>
            </template>
            <div x-show="selectedItems.length === 0" class="text-muted">
                Cliquez pour sélectionner...
            </div>
        </div>
        
        <div 
            x-show="open" 
            @click.away="open = false"
            class="position-absolute w-100 bg-white border rounded shadow-lg"
            style="z-index: 1050; max-height: 240px; overflow-y: auto; margin-top: 4px;"
        >
            @foreach($options as $value => $label)
                <div 
                    @click="toggleItem('{{ $value }}')"
                    class="px-3 py-2 d-flex align-items-center"
                    style="cursor: pointer;"
                    :class="selectedItems.includes('{{ $value }}') ? 'bg-primary bg-opacity-10 text-primary' : ''"
                    onmouseover="this.classList.add('bg-light')"
                    onmouseout="this.classList.remove('bg-light')"
                >
                    <input 
                        type="checkbox" 
                        :checked="selectedItems.includes('{{ $value }}')"
                        class="form-check-input me-2"
                        readonly
                        style="margin-top: 0;"
                    >
                    {{ $label }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- Hidden inputs for form submission -->
    <template x-for="item in selectedItems" :key="item">
        <input type="hidden" :name="'{{ $name }}[]'" :value="item">
    </template>
    
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<script>
function multiSelect(name, initialSelected = []) {
    return {
        open: false,
        selectedItems: Array.isArray(initialSelected) ? initialSelected : [],
        options: @json($options),
        
        toggleItem(value) {
            if (this.selectedItems.includes(value)) {
                this.removeItem(value);
            } else {
                this.selectedItems.push(value);
            }
        },
        
        removeItem(value) {
            this.selectedItems = this.selectedItems.filter(item => item !== value);
        },
        
        getOptionLabel(value) {
            return this.options[value] || value;
        }
    }
}
</script>