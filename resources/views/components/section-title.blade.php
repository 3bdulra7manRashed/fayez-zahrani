{{--
|--------------------------------------------------------------------------
| Section Title Component (Deprecated - Backward Compatibility Wrapper)
|--------------------------------------------------------------------------
|
| Purpose: Retained for backward compatibility. Wraps the updated section-header.
|
| Props:
|   - align (string): Alignment of headings. Default: "right".
|   - subtitle (string, optional): Subtitle block.
|
--}}
@props([
    'align' => 'right',
    'subtitle' => null,
])

<x-section-header :align="$align" :subtitle="$subtitle" :title="$slot" />
