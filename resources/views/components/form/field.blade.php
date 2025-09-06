{{--
  Modern Form Field Component
  
  Usage:
  <x-form.field 
    name="email" 
    label="Email Address" 
    type="email" 
    :required="true"
    help="We'll never share your email"
    icon="mail"
  />
--}}

@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'help' => '',
    'icon' => null,
    'size' => 'md', // sm, md, lg
    'error' => null
])

@php
$fieldId = $name . '_' . uniqid();
$hasError = $errors->has($name) || $error;
$errorMessage = $error ?? $errors->first($name);

$inputClasses = [
    'input',
    'input--' . $size,
    $hasError ? 'input--error' : ''
];

$wrapperClasses = [
    'form-field',
    $hasError ? 'form-field--error' : ''
];
@endphp

<div {{ $attributes->merge(['class' => implode(' ', $wrapperClasses)]) }}>
    {{-- Label --}}
    @if($label)
    <label for="{{ $fieldId }}" class="form-field__label">
        @if($icon)
        <span class="form-field__icon" aria-hidden="true">
            @if(is_string($icon) && strlen($icon) === 1)
                {{ $icon }}
            @else
                <i data-feather="{{ $icon }}"></i>
            @endif
        </span>
        @endif
        
        {{ $label }}
        
        @if($required)
        <span class="text-red-500" aria-label="required">*</span>
        @endif
    </label>
    @endif

    {{-- Input Wrapper --}}
    <div class="form-field__input">
        @if($icon && $type !== 'textarea')
        <div class="relative">
            <input
                type="{{ $type }}"
                id="{{ $fieldId }}"
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                class="{{ implode(' ', $inputClasses) }} pl-10"
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                {{ $attributes->except(['class']) }}
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-feather="{{ $icon }}" class="h-4 w-4 text-outdoor-forest-400"></i>
            </div>
        </div>
        @elseif($type === 'textarea')
        <textarea
            id="{{ $fieldId }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            class="textarea {{ $size ? 'textarea--' . $size : '' }} {{ $hasError ? 'textarea--error' : '' }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes->except(['class', 'type']) }}
        >{{ old($name, $value) }}</textarea>
        @elseif($type === 'select')
        <select
            id="{{ $fieldId }}"
            name="{{ $name }}"
            class="select {{ $size ? 'select--' . $size : '' }} {{ $hasError ? 'select--error' : '' }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            {{ $attributes->except(['class', 'type']) }}
        >
            {{ $slot }}
        </select>
        @else
        <input
            type="{{ $type }}"
            id="{{ $fieldId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            class="{{ implode(' ', $inputClasses) }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes->except(['class']) }}
        />
        @endif

        {{-- Error Message --}}
        @if($hasError)
        <div class="form-field__error" role="alert">
            <i data-feather="alert-circle" class="h-3 w-3"></i>
            {{ $errorMessage }}
        </div>
        @endif

        {{-- Help Text --}}
        @if($help && !$hasError)
        <div class="form-field__help">
            {{ $help }}
        </div>
        @endif
    </div>
</div>