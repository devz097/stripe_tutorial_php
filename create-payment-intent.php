<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('your-secret-key'); // Replace with your actual secret key

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$amount = $data['amount'];

$paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => $amount,
    'currency' => 'usd',
]);

echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
?>
