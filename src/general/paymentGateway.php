<?php

    require_once('../../config.php');    //get the configuration file for Stripe
    require_once('../../libs/Stripe/init.php');    //get the Stripe library

    class paymentGateway{
        // Set your Stripe API keys
        public static function chargePayment($stripeToken, $chargeAmount, $chargeDescription, $currency){

            
            \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
            try {
                // Create a charge
                $charge = \Stripe\Charge::create(array(
                    'amount' => $chargeAmount,
                    'currency' => $currency,
                    'description' => $chargeDescription,
                    'source' => $stripeToken
                ));

                if($charge -> paid == true){    //if the payment is successful
                    return true;
                }
                else{
                    return false;
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
            } catch (Exception $e) {     // Handle other errors
                //echo "Exception: " . $e -> getMessage();
                return false;
            }
        }

        public static function userReservationPayment($reservationPrice, $reservationDescription, $currency, $stripeToken){
            return self::chargePayment($stripeToken, $reservationPrice, $reservationDescription, $currency);
        }
    }


?>