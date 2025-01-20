<div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        <span class="block">Revolutionize Your</span>
                        <span class="block text-indigo-200">Learning Journey</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-200 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Join Youdemy's interactive learning platform. Connect with expert teachers, explore diverse courses, and enhance your skills at your own pace.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                Get Started
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#courses" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 md:py-4 md:text-lg md:px-10">
                                Browse Courses
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>


<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Categories</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Explore Our Course Categories
            </p>
        </div>

        <div class="mt-10">
            <div class="flex flex-wrap justify-center gap-5 ">
                <?php foreach ($categories as $category): ?>
                <div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-5">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-indigo-50 text-indigo-700 ring-4 ring-white">
                            <!-- Heroicon name: outline/academic-cap -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="flex-1 text-center">
                        <h3 class="text-lg font-medium">
                            <a href="/courses?category=<?= $category->getName() ?>" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <?= htmlspecialchars($category->getName()) ?>
                            </a>
                        </h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="bg-white py-12">
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


<div class="bg-gray-50 py-12" id="courses">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center mb-12">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Featured Courses</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Most Popular Courses
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php if (isset($featuredCourses) && !empty($featuredCourses)) : ?>
                <?php foreach ($featuredCourses as $course): ?>
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow">
                    <?php if ($course->getThumbnail()): ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <img class="object-cover w-full" src="<?= htmlspecialchars($course->getThumbnail()) ?>" alt="<?= htmlspecialchars($course->getTitle()) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($course->getUsername()) ?>&background=random" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                  <?= htmlspecialchars($course->getUsername()) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= htmlspecialchars($course->getCategoryName()) ?>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <a href="/course/<?= $course->getId() ?>" class="hover:underline">
                                    <?= htmlspecialchars($course->getTitle()) ?>
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-500">
                                <?= htmlspecialchars(substr($course->getDescription(), 0, 150)) ?>...
                            </p>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <a href="/course?id=<?= $course->getId() ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Course
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No featured courses available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="bg-indigo-700">
    <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            <span class="block">Ready to start teaching?</span>
            <span class="block">Join our community of educators.</span>
        </h2>
        <p class="mt-4 text-lg leading-6 text-indigo-200">
            Share your knowledge with students worldwide. Create engaging courses and help others learn.
        </p>
        <a href="/register?role=teacher" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
            Become an Instructor
        </a>
    </div>
</div>