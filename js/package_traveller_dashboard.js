function togglePackageSelection(packageId, event) {
        
        event.preventDefault();
        event.stopPropagation();

        // Get current URL parameters and preserve filters
        const url = new URL(window.location);

        // Set the selected package to view
        url.searchParams.set('view', packageId);

        // Navigate to show this package's details
        window.location = url.toString();
    }

// Ensure the function is available globally and bind click handlers
document.addEventListener('DOMContentLoaded', () => {
    // expose to global scope for inline handlers
    window.togglePackageSelection = togglePackageSelection;

    // Attach click listeners to package cards in case inline onclick isn't used
    document.querySelectorAll('.package-card').forEach(card => {
        card.addEventListener('click', (event) => {
            const pkgId = card.dataset.packageId;
            if (pkgId) togglePackageSelection(pkgId, event);
        });
    });
});
