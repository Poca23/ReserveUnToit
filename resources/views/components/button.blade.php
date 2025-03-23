<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => 'px-4 py-2 rounded-md font-medium transition-colors ' . 
        ($variant === 'primary' ? 'bg-primary text-white hover:bg-primary/90' :
         ($variant === 'secondary' ? 'bg-secondary text-white hover:bg-secondary/90' :
          'bg-gray-200 text-gray-800 hover:bg-gray-300'))
    ]) }}
>
    {{ $slot }}
</button>
