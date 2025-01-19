<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<div class="bg-gray-900 min-h-screen text-white">
    <!-- Course Header -->
    <div class="bg-gray-800 text-white py-4 px-6 mb-6">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold"><?= htmlspecialchars($course->getTitle()) ?></h1>
            <p class="text-gray-400 mt-2"><?= htmlspecialchars($course->getDescription()) ?></p>
        </div>
    </div>
<div id="preview" class=" p-10"></div>
</div>
<script>
const content = <?php echo json_encode(htmlspecialchars_decode($course->getContent())) ?>;
document.getElementById("preview").innerHTML = marked.parse(content);
</script>