@props(['secondary'=>null])

<a {{ $attributes->class([
    'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
    'bg-gray-800 dark:bg-gray-200 border-transparent  text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300  focus:ring-indigo-500 ' => !$secondary,
    ]) }}>
    {{ $slot }}
</a>
