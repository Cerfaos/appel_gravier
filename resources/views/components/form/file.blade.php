@props([
    'name',
    'label' => null,
    'accept' => null,
    'required' => false
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <input 
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        @if($accept) accept="{{ $accept }}" @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'form-control']) }}
    >
    
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>