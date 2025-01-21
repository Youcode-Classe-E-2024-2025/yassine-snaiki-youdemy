<?php require_once __DIR__."/header.php";?>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
       
        <div id="sidebar" class="bg-gray-800 text-white w-64 py-6 flex flex-col fixed h-full transition-transform duration-400 ease-in-out z-20">
            <div class="px-6 mb-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Youdemy Admin</h1>
            </div>
            <nav class="flex-1">
                <a href="/admin/dashboard" class="block px-6 py-3 hover:bg-gray-700 <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'bg-gray-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
                <a href="/admin/teachers" class="block px-6 py-3 hover:bg-gray-700 <?= strpos($_SERVER['REQUEST_URI'], 'teachers') !== false ? 'bg-gray-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Teachers
                </a>
                <a href="/admin/students" class="block px-6 py-3 hover:bg-gray-700 <?= strpos($_SERVER['REQUEST_URI'], '/admin/students') !== false ? 'bg-gray-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    Students
                </a>
                <a href="/admin/requests" class="block px-6 py-3 hover:bg-gray-700 <?= strpos($_SERVER['REQUEST_URI'], '/admin/courses') !== false ? 'bg-gray-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Requests
                </a>
                <a href="/admin/categories" class="block px-6 py-3 hover:bg-gray-700 <?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'bg-gray-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                    Categories & Tags
                </a>
                <a href="/admin/blacklist" class="block px-6 py-3 hover:bg-gray-700 <?= strpos($_SERVER['REQUEST_URI'], '/admin/statistics') !== false ? 'bg-gray-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Blacklist
                </a>
            </nav>
            <div class="px-6 py-4 border-t border-gray-700">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin" class="w-8 h-8 rounded-full mr-3">
                    <div>
                        <p class="text-sm font-medium">Admin</p>
                        <a href="/logout" class="text-xs text-gray-400 hover:text-white">Logout</a>
                    </div>
                </div>
            </div>
        </div>


        <div id="main-content" class="flex-1 transition-all duration-400 ease-in-out ml-64">

            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="p-2 rounded-md bg-slate-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 mr-4 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800">Youdemy</h2>
                    </div>
            
                </div>
            </header>

    
            <main class="p-6">
                {{content}}
            </main>
        </div>
    </div>
    <script src="/js/layout.js"></script>
</body>
<?php require_once __DIR__."/footer.php";?>