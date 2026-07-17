{{--
|--------------------------------------------------------------------------
| Input Component
|--------------------------------------------------------------------------
|
| Purpose: Standard single-line form text input control.
| 
| Props:
|   - name (string, required): Element name and identifier.
|   - type (string): Input field type (text, email, tel, etc.). Default: "text".
|   - required (boolean): Default: false.
|   - error (string, optional): Pass error string to apply validation error borders. Default: null.
|
| Example Usage:
|   <x-input name="email" type="email" placeholder="example@domain.com" />
|
--}}
@props([
    'name',
    'type' => 'text',
    'required' => false,
    'error' => null,
])

<input 
    id="{{ $name }}" 
    name="{{ $name }}" 
    type="{{ $type }}" 
    {{ $required ? 'required' : '' }} 
    {{ $attributes->merge(['class' => 'block w-full px-space-16 py-space-12 bg-surface border rounded-sm text-body-small font-cairo text-text-primary transition-normal focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent placeholder:text-text-secondary/60 disabled:opacity-50 disabled:pointer-events-none ' . ($error ? 'border-danger focus:ring-danger' : 'border-border focus:ring-primary')]) }}
/>
