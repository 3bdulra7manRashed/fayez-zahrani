{{--
|--------------------------------------------------------------------------
| Field Component
|--------------------------------------------------------------------------
|
| Purpose: Form layout wrapper grouping labels, required states, validation errors, and guidelines.
| 
| Props:
|   - label (string, optional): Heading text for the input field.
|   - name (string, required): Used to associate inputs and errors.
|   - required (boolean): Appends a red asterisk if true. Default: false.
|   - hint (string, optional): Helper guideline text underneath the label.
|   - error (string, optional): Dynamic validation error text displayed below inputs.
|
| Slots:
|   - default: Form input control elements (e.g. <x-input>).
|
| Example Usage:
|   <x-field label="البريد الإلكتروني" name="email" :required="true" hint="مثال: user@example.com" :error="$errors->first('email')">
|       <x-input name="email" type="email" />
|   </x-field>
|
--}}
@props([
    'label' => null,
    'name',
    'required' => false,
    'hint' => null,
    'error' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5 w-full']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-body-small font-medium text-text-primary font-cairo select-none">
            {{ $label }}
            @if($required)
                <span class="text-danger font-semibold">*</span>
            @endif
        </label>
    @endif

    @if($hint)
        <p class="text-caption text-text-secondary select-none mt-0.5" id="{{ $name }}-hint">{{ $hint }}</p>
    @endif

    <div class="relative">
        {{ $slot }}
    </div>

    @if($error)
        <p class="text-caption text-danger font-cairo mt-1" id="{{ $name }}-error" role="alert">{{ $error }}</p>
    @endif
</div>
