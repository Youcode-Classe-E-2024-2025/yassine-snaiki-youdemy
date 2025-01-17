document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    let isSidebarOpen = true;

    const menuIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>`;

    const closeIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>`;

    toggleButton.addEventListener('click', function() {
        isSidebarOpen = !isSidebarOpen;
        if (isSidebarOpen) {            
            sidebar.style.transform = 'translateX(0)';
            sidebar.style.visibility = 'visible';
            sidebar.style.width = '16rem'; 
            mainContent.style.marginLeft = '16rem';
            toggleButton.innerHTML = closeIcon;
        } else {
            sidebar.style.transform = 'translateX(-100%)';
            sidebar.style.visibility = 'hidden';
            sidebar.style.width = '0';
            mainContent.style.marginLeft = '0';
            toggleButton.innerHTML = menuIcon;
        }
    });
});
