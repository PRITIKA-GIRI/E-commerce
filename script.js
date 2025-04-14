// Function to close message alerts
document.addEventListener('DOMContentLoaded', function() {
    const messageElements = document.querySelectorAll('.message i');
    
    messageElements.forEach(element => {
        element.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    });
    
    // Update cart quantity
    const updateButtons = document.querySelectorAll('input[name="update_update_btn"]');
    
    updateButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const quantityInput = this.parentElement.querySelector('input[name="update_quantity"]');
            if(quantityInput.value < 1) {
                e.preventDefault();
                alert('Quantity must be at least 1');
                quantityInput.value = 1;
            }
        });
    });
});

// Confirm before deleting all items from cart
function confirmDeleteAll() {
    return confirm('Are you sure you want to delete all items from your cart?');
}

// Confirm before removing item from cart/wishlist
function confirmRemoveItem() {
    return confirm('Are you sure you want to remove this item?');
} 