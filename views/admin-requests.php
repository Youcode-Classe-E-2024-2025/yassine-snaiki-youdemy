<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Requests</h1>
        <p class="text-gray-600">Manage and monitor Requests</p>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="flex flex-col">
 
            <div class="bg-gray-50 p-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex-1">
                        <h2 class="text-lg font-medium text-gray-900">All Requests</h2>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                <?php foreach ($requests as $request): ?>
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center flex-1">
                            <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=<?=$request->getUsername()?>&background=random" alt="<?= htmlspecialchars($request->getUsername()) ?>">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($request->getUsername()) ?></div>
                                <div class="text-sm text-gray-500"><?= htmlspecialchars($request->getEmail()) ?></div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <form action="/accept-request" method="POST">
                            <input type="hidden" name="id" value="<?=$request->getId()?>">
                            <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Accept
                            </button>
                            </form>
                            <form action="/reject-request" method="POST">
                            <input type="hidden" name="id" value="<?=$request->getId()?>">
                            <button class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Reject
                            </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between">
                        <a href="/admin/requests?page=<?=$currPage-1 < 1 ? 1 : $currPage-1?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                        <ul class="flex gap-2">
                        <?php foreach(range(1, $pagesNum) as $n): ?>
                            <a href="/admin/requests?page=<?=$n?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700  hover:bg-gray-50 <?=$currPage == $n ? 'bg-gray-200':'bg-white'?>"><?=$n?></a>
                        <?php endforeach?>
                        </ul>
                        <a href="/admin/requests?page=<?=$currPage+1 > $pagesNum ? $pagesNum : $currPage+1?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>