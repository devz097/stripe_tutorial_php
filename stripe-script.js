const stripe = Stripe('your-publishable-key'); // Replace with your actual publishable key
const elements = stripe.elements();
const cardElement = elements.create('card');
cardElement.mount('#card-element');

const form = document.getElementById('payment-form');

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const response = await fetch('/create-payment-intent.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ amount: 5000 }) // Replace with your actual amount
    });

    const { clientSecret } = await response.json();

    const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: cardElement,
            billing_details: {
                name: 'Jenny Rosen', // Replace with the actual name
            },
        },
    });

    if (error) {
        document.getElementById('error-message').textContent = error.message;
    } else if (paymentIntent.status === 'succeeded') {
        console.log('Payment succeeded!');
    }
});
