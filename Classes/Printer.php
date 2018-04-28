<?php

class Printer
{
    const cards_dimensions_height='127';
    const cards_dimensions_width='127';

    public static function get_cards()
    {
        $cards = array();
        for ($i = 0; $i < 40; $i++) {
            $cards[$i] = 'mosters_' . ($i + 1);
        }
        return $cards;
    }

    public static function print_cards($cards, $avoid_position)
    {
        for ($i = 0; $i < count($cards); $i++) {
            if ($cards[$i]['selected'] === 1 && $i !== $avoid_position) {
                echo '<img class="game-listener" id = "' . $i . '" src="assets/monsters/' . $cards[$i]['card'] . '.png"
					 height="' . self::cards_dimensions_height . '" width="' . self::cards_dimensions_width .
                     '" style = "margin: 10px;">';
            } else {
                echo '<img class="game-listener" id = "' . $i . '" src="assets/monsters/black.png"
					 height="' . self::cards_dimensions_height . '" width="' . self::cards_dimensions_width .
                     '" style = "margin: 10px;">';
            }
            if ($i === $avoid_position) {
                echo '<img class="game-listener" id = "' . $i . '" src="assets/monsters/' . $cards[$i]['card'] . '.png"
					 height="' . self::cards_dimensions_height . '" width="' . self::cards_dimensions_width .
                     '" style = "margin: 10px;">';
            }
        }
    }
}
