@props([
    'email', 
    'text' => null
])

@php
    // Fallback to the email string if no distinct display text is passed
    $displayText = $text ?? $email;
@endphp

<div x-data="{
    {{-- Safe Base64 encoding on the server side --}}
    e: '{{ base64_encode($email) }}',
    t: '{{ base64_encode($displayText) }}',
    
    {{-- UTF-8 Safe Base64 decoding in the browser --}}
    decode(str) {
        const binString = atob(str);
        const bytes = Uint8Array.from(binString, (m) => m.codePointAt(0));
        return new TextDecoder().decode(bytes);
    }
}" class="inline">
    <a :href="'mailto:' + decode(e)" 
       x-text="decode(t)"
       {{ $attributes->merge(['class' => 'text-blue-600 hover:underline']) }}>
        [Loading...]
    </a>
</div>