<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-3 rounded-xl ring-1 ring-slate-300 dark:ring-gray-700 bg-white text-gray-900 text-sm font-medium hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700 disabled:opacity-40 transition']) }}>
    {{ $slot }}
</button>
