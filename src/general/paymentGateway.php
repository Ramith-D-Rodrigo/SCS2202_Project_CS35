<?php

    require_once('../../config.php');    //get the configuration file for Stripe
    require_once('../../libs/Stripe/init.php');    //get the Stripe library

    class paymentGateway{
        // Set your Stripe API keys
        public static function chargePayment($stripeToken, $chargeAmount, $chargeDescription, $currency): array{    //returns the array with the status and the message
            \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
            try {
                // Create a charge
                $charge = \Stripe\Charge::create(array(
                    'amount' => $chargeAmount * 100,    //to convert the amount to cents
                    'currency' => $currency,
                    'description' => $chargeDescription,
                    'source' => $stripeToken
                ));

                if($charge -> paid == true){    //if the payment is successful
                    return [true, "Payment Successful"];
                }
                else{
                    return [false, "Payment Failed"];
                }
            /*} catch(\Stripe\Exception\CardException $e) {   // Handle card errors
                echo "CardException: " . $e -> getMessage();
                return false;

            } catch (\Stripe\Exception\RateLimitException $e) {     // Handle rate limit errors
                echo "RateLimitException: " . $e -> getMessage();
                return false;

            } catch (\Stripe\Exception\InvalidRequestException $e) {     // Handle invalid request errors
                echo "InvalidRequestException: " . $e -> getMessage();
                return false;

            } catch (\Stripe\Exception\AuthenticationException $e) {     // Handle authentication errors
                echo "AuthenticationException: " . $e -> getMessage();
                return false;

            } catch (\Stripe\Exception\ApiConnectionException $e) {     // Handle API connection errors
                echo "ApiConnectionException: " . $e -> getMessage();
                return false;

            } catch (\Stripe\Exception\ApiErrorException $e) {     // Handle other API errors
                echo "ApiErrorException: " . $e -> getMessage();
                return false;
            */
            } catch (\Stripe\Exception\CardException $e) {     // Handle other errors
                //echo "Exception: " . $e -> getMessage();
                $errCode = $e -> getError() -> code;
                switch($errCode){
                    case 'card_declined':
                        return [false, "Card Declined"];
                        break;
                    case 'incorrect_cvc':
                        return [false, "Incorrect CVC"];
                        break;
                    case 'expired_card':
                        return [false, "Expired Card"];
                        break;
                    case 'incorrect_number':
                        return [false, "Incorrect Card Number"];
                        break;
                    case 'incorrect_zip':
                        return [false, "Incorrect Zip Code"];
                        break;
                    case 'processing_error':
                        return [false, "Processing Error"];
                        break;
                    default:
                        return [false, "Payment Failed"];
                        break;
                }
            }
        }

        public static function userReservationPayment($reservationPrice, $description, $currency, $stripeToken){
            return self::chargePayment($stripeToken, $reservationPrice, $description, $currency);
        }
    }


?>