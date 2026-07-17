{{--
|--------------------------------------------------------------------------
| Textarea Component
|--------------------------------------------------------------------------
|
| Purpose: Standard multi-line form text area control.
| 
| Props:
|   - name (string, required): Element name and identifier.
|   - rows (int): Size height of input block. Default: 4.
|   - required (boolean): Default: false.
|   - error (string, optional): Pass error string to apply validation error borders. Default: null.
|
| Example Usage:
|   <x-textarea name="message" rows="5" placeholder="اكتب رسالتك هنا..." />
|
--}}
@props([
    'name',
    'rows' => 4,
    'required' => false,
    'error' => null,
])

<textarea 
    id="{{ $name }}" 
    name="{{ $name }}" 
    rows="{{ $rows }}"
    {{ $required ? 'required' : '' }} 
    {{ $attributes->merge(['class' => 'block w-full px-space-16 py-space-12 bg-surface border rounded-sm text-body-small font-cairo text-text-primary transition-normal focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent placeholder:text-text-secondary/60 disabled:opacity-50 disabled:pointer-events-none ' . ($error ? 'border-danger focus:ring-danger' : 'border-border focus:ring-primary')]) }}
>{{ $slot }}</textarea>
