// Add click event listeners to all options
document.querySelectorAll('.options').forEach(optionGroup => {
    optionGroup.addEventListener('click', function (event) {
        const target = event.target;

        // Check if the clicked element is an option button
        if (target.classList.contains('option')) {
            // Remove the 'selected' class from all sibling buttons
            optionGroup.querySelectorAll('.option').forEach(button => {
                button.classList.remove('selected');
            });

            // Add the 'selected' class to the clicked button
            target.classList.add('selected');
        }
    });
});
