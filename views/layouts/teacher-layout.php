<?php require_once __DIR__ . "/header.php"; ?>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
       
        <div id="sidebar"
            class="bg-indigo-800 text-white w-64 py-6 flex flex-col fixed h-full transition-transform duration-300 ease-in-out z-20">
            <div class="px-6 mb-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Youdemy Teacher</h1>
            </div>
            <nav class="flex-1">
                <a href="/"
                    class="block px-6 py-3 hover:bg-indigo-700 <?= $_SERVER['REQUEST_URI'] ==='/' ? 'bg-indigo-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Home
                </a>
                <a href="/teacher/dashboard"
                    class="block px-6 py-3 hover:bg-indigo-700 <?= strpos($_SERVER['REQUEST_URI'], '/teacher/dashboard') !== false ? 'bg-indigo-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Dashboard
                </a>
                <a href="/teacher/create"
                    class="block px-6 py-3 hover:bg-indigo-700 <?= strpos($_SERVER['REQUEST_URI'], '/teacher/create') !== false ? 'bg-indigo-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Create Course
                </a>
                <a href="/teacher/courses"
                    class="block px-6 py-3 hover:bg-indigo-700 <?= strpos($_SERVER['REQUEST_URI'], '/teacher/courses') !== false ? 'bg-indigo-700' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-block mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    My Courses
                </a>
            </nav>
            <div class="px-6 py-4 border-t border-indigo-700">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Teacher&background=random" alt="Teacher"
                        class="w-8 h-8 rounded-full mr-3">
                    <div>
                        <p class="text-sm font-medium">Teacher</p>
                        <a href="/logout" class="text-xs text-indigo-300 hover:text-white">Logout</a>
                    </div>
                </div>
            </div>
        </div>


        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out ml-64">
          
            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center">
                        <button id="sidebar-toggle"
                            class="p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800">Youdemy</h2>
                        
                    </div>
                    <div class="bg-white ml-auto">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                <div class="max-w-3xl mx-auto">
                                    <form action="/courses" method="GET" class="mt-1 flex rounded-md shadow-sm">
                                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                            <input type="text" name="q" id="search"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-l-md pl-4 sm:text-sm border-gray-300"
                                                placeholder="Search for courses...">
                                        </div>
                                        <button type="submit"
                                            class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>Search</span>
                                        </button>
                                    </form>
                                </div>
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
<?php require_once __DIR__ . "/footer.php"; ?>