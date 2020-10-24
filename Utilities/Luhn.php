<?php
//funciones para verificacion de tarjetas
namespace Utilities;
Class Luhn
{
    public static function luhn_validate($number, $mod5 = false) {
        $parity = strlen($number) % 2;
        $total = 0;
        // Split each digit into an array
          $digits = str_split($number);
          foreach($digits as $key => $digit) { // Foreach digit
            // for every second digit from the right most, we must multiply * 2
              if (($key % 2) == $parity) 
                  $digit = ($digit * 2);
            // each digit place is it's own number (11 is really 1 + 1)
              if ($digit >= 10) {
                // split the digits
                  $digit_parts = str_split($digit);
                // add them together
                  $digit = $digit_parts[0]+$digit_parts[1];
              }
            // add them to the total
            $total += $digit;
          }
        return ($total % ($mod5 ? 5 : 10) == 0 ? true : false); // If the mod 10 or mod 5 value is equal to zero (0), then it is valid
    }
}
?>