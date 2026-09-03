<?php

namespace App\Helpers;

class GetInitials {

   /**
    *
    * @param string $args
    * @return string
    */
   public function __invoke($args): string
   {
        $name = preg_replace('/\s+/', ' ', trim($args));
        $parts = explode(' ', $name);
        $acount = count($parts);

        $initalName = $acount > 0 ? mb_strtoupper(mb_substr($parts[0], 0, 1)) : '';
        $initialLastName = $acount > 2 ? mb_strtoupper(mb_substr($parts[$acount - 2], 0, 1)) : ($acount > 1 ? mb_strtoupper(mb_substr($parts[1], 0, 1)) : '');

        return $initalName . $initialLastName;
   }

}