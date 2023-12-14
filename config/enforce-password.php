<?php

return [
  'passwordMinLength'     => 6,
  'passwordMaxLength'     => 255,
  'passwordHistoryLimit'  => 5, // Number of passwords kept in history, set to 0 to disable this feature
  'passwordMaxLifetime'   => 365, // Number of days a password can be used
  'enforceUppercase'      => false, // Min 1 uppercase letter
  'enforceLowercase'      => false, // Min 1 lowercase letter
  'enforceDigit'          => false, // Min 1 digit
  'enforceSymbol'         => false, // Min 1 symbol
];
