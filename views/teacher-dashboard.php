    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Teacher Dashboard</h1>
            <p class="text-gray-600 mt-2">You have <?= $courseNum ?> courses published</p>
        </div>

        <div class="space-y-6">
            <?php foreach ($course as $c): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <?php if ($c->getThumbnail()): ?>
                            <img src="<?= htmlspecialchars($c->getThumbnail()) ?>" 
                                 alt="<?= htmlspecialchars($c->getTitle()) ?>" 
                                 class="w-full md:w-48 h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full md:w-48 h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No thumbnail</span>
                            </div>
                        <?php endif; ?>

                        <div class="flex-1 p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($c->getTitle()) ?></h3>
                                <span class="text-sm text-gray-500 mt-2 md:mt-0"><?= htmlspecialchars($c->getCategoryName()) ?></span>
                            </div>
                            
                            <div class="mt-4 md:w-1/2">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-600">Enrollments</span>
                                    <span class="text-sm font-bold text-gray-800"><?= $c->enrollmentsCount() ?></span>
                                </div>
                                <?php
                                    $enrollmentCount = $c->enrollmentsCount();
                                    $maxEnrollments = 100;
                                    $percentage = min(($enrollmentCount / $maxEnrollments) * 100, 100);
                                    $colorClass = $percentage < 30 ? 'bg-blue-500' : ($percentage < 70 ? 'bg-blue-600' : 'bg-blue-700');
                                ?>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="<?= $colorClass ?> h-2.5 rounded-full" style="width: <?= $percentage ?>%"></div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
