<?php
/** @var array $categories */
/** @var array $tags */
?>

<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Categories & Tags Management</h1>
        <p class="text-gray-600">Manage course categories and their associated tags</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Categories Section -->
        <div>
            <!-- Add Category Form -->
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <form class="space-y-4" method="POST" action="/admin/add-category">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">New Category</label>
                        <input type="text" id="category" name="category" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>

            <!-- Categories List -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-900">Categories</h2>
                </div>
                <div class="divide-y divide-gray-200 overflow-auto" style="max-height: 400px;">
                    <?php foreach ($categories as $category): ?>
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700"><?= htmlspecialchars($category->getName()) ?></span>
                                <button class="text-red-600 hover:text-red-800 p-1" data-category-id="<?= $category->getName() ?>">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Tags Section -->
        <div>
            <!-- Add Tags Form -->
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <div class="space-y-4">
                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700">Add New Tags</label>
                        <input type="text" id="tags" name="tags" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="button" id="addTagsBtn"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Tags
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tags List -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-900">Tags</h2>
                </div>
                <div class="p-4 overflow-auto" style="max-height: 400px;">
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($tags as $tag): ?>
                            <div class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1">
                                <span class="text-sm text-gray-700"><?= htmlspecialchars($tag->getName()) ?></span>
                                <button class="ml-2 text-gray-500 hover:text-red-600" data-tag-id="<?= $tag->getName() ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize Tagify on the tags input
var tagsInput = document.querySelector('input[name=tags]');
var tagify = new Tagify(tagsInput,{
        pattern: /^[a-z0-9]{3,10}$/,
        maxTags: 20, 
        enforceWhitelist: false, 
        dropdown: {
            enabled: 1, 
            maxItems: 20, 
            closeOnSelect: false,
            highlightFirst: true 
        }
});

// Handle tag submission
document.getElementById('addTagsBtn').addEventListener('click', function() {
    const tags = tagify.value.map(tag => tag.value);
    
    fetch('/admin/add-tags', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ tags: tags })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the page to show new tags
            window.location.reload();
        } else {
            alert('Error adding tags: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding tags');
    });
});
</script>