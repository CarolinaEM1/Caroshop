document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', event => {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const price = parseFloat(button.getAttribute('data-price'));

        const quantity = parseInt(prompt(`¿Cuántos ${name} desea agregar al carrito?`, "1"));
        if (!isNaN(quantity) && quantity > 0) {
            addToCart(id, name, price, quantity);
        }
    });
});

function addToCart(id, name, price, quantity) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&name=${name}&price=${price}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        updateCart();
    });
}

function removeFromCart(id) {
    fetch('remove_from_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        updateCart();
    });
}

function updateCart() {
    fetch('get_cart.php')
    .then(response => response.json())
    .then(cart => {
        const cartItems = document.getElementById('cart-items');
        if (cartItems) {
            cartItems.innerHTML = '';
            let total = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>$${itemTotal.toFixed(2)}</td>
                    <td><button class="remove-from-cart" data-id="${item.id}">Eliminar</button></td>
                `;
                cartItems.appendChild(row);
            });

            document.getElementById('cart-total').textContent = total.toFixed(2);

            document.querySelectorAll('.remove-from-cart').forEach(button => {
                button.addEventListener('click', event => {
                    const id = button.getAttribute('data-id');
                    removeFromCart(id);
                });
            });
        }
    });
}

document.getElementById('checkout-button')?.addEventListener('click', event => {
    fetch('get_cart.php')
    .then(response => response.json())
    .then(cart => {
        if (cart.length === 0) {
            event.preventDefault();
            alert('El carrito está vacío.');
        }
    });
});

document.getElementById('payment-form')?.addEventListener('submit', event => {
    event.preventDefault();
    alert('Pago procesado exitosamente!');
    fetch('clear_cart.php', { method: 'POST' })
    .then(() => {
        window.location.href = 'index.html';
    });
});

updateCart();
