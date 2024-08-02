<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('your-secret-key'); // Replace with your actual secret key

$endpoint_secret = 'your-webhook-signing-secret'; // Replace with your actual webhook signing secret

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'payment_intent.succeeded':
        $paymentIntent = $event->data->object; // Contains a StripePaymentIntent
        // Then define and call a function to handle the successful payment intent.
        // handlePaymentIntentSucceeded($paymentIntent);
        break;
    // ... handle other event types
    default:
        echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);
?>
