<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-3 rounded-xl bg-rose-600 text-white text-sm font-medium shadow-sm hover:bg-rose-700 active:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-rose-500/60 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition']) }}>
    {{ $slot }}
</button>
