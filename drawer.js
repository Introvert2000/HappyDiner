        // JavaScript for side drawer animation
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const closeSidebarButton = document.getElementById("closeSidebar");
        const sidebar = document.getElementById("sidebar");

        toggleSidebarButton.addEventListener("click", () => {
            sidebar.style.width = "250px";
        });

        closeSidebarButton.addEventListener("click", () => {
            sidebar.style.width = "0";
        });
