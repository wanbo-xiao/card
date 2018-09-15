<?php

namespace App\Services\CardService;

class CardService {

    public function drawCards() {
        $cardSuites = array('s', 'h', 'c', 'd');
        $cardSpecialRank = array(0 => 'k', 1 => 'a', 11 => 'j', 12 => 'q');
        $cards = range(0, 51);
        shuffle($cards);
        $cardSets = array();

        for ($i = 0; $i < 5; $i++) {
            $drawCard = $cards[$i];
            $suit = $drawCard / 13;
            $rank = $drawCard % 13;
            $cardSets[] = (array_key_exists($rank, $cardSpecialRank) ? $cardSpecialRank[$rank] : $rank) . $cardSuites[$suit];
        }
        return $cardSets;
    }

    // 121 character
    public function isCardStraight($b) {
        $t = 0;
        foreach ($b as $s)
            $t |= (1 << (int) strtr($s, ['a' => 1, 'j' => 11, 'q' => 12, 'k' => 13]));
        return $t == 15362 || strstr(decbin($t), '11111');
    }

    // 143 character
    public function isCardStraight_1($b) {
        foreach ($b as &$s)
            $s = (int) strtr($s, ['a' => 1, 'j' => 11, 'q' => 12, 'k' => 13]);
        sort($b);
        return count(array_flip($b)) > 4 && ($b[4] - $b[0] < 5 || $b[1] - $b[0] == 9);
    }

}
