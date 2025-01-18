<?php require_once __DIR__ . "/header.php"; ?>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
  

        <!-- Main Content -->
        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out ">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="flex justify-between items-center px-20 py-4">
                    <div class="flex items-center">
                        <h2 class="text-xl font-semibold text-gray-800">Youdemy</h2>
                    </div>
                    <!-- Search Section -->
<div class="bg-white ml-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <form action="/courses" method="GET" class="mt-1 flex rounded-md shadow-sm">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    <input type="text" name="q" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-l-md pl-4 sm:text-sm border-gray-300" placeholder="Search for courses...">
                </div>
                <button type="submit" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    <span>Search</span>
                </button>
            </form>
        </div>
    </div>
</div>
                    <div class="flex items-center space-x-4">
                        <a href="/courses" class="relative p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600 rounded-full" >
                            Courses
                        </a>
                        <a href="/login"
                            class="relative p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600 rounded-full">
                            Login
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                {{content}}
            </main>
        </div>
    </div>
    <script src="/js/layout.js"></script>
</body>
<?php require_once __DIR__ . "/footer.php"; ?>