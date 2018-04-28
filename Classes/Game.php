<?php
require_once 'DBHelper.php';
require_once 'Printer.php';

class Game
{
    protected $number_of_cards;
    protected $is_started;
    protected $cards;
    protected $database_helper;

    public function __construct($number_of_cards)
    {
        $this->number_of_cards = $number_of_cards;
        $this->database_helper = new DBHelper();
        session_start();
        if ($_SESSION["game_id"] > -1) {
            $this->cards = json_decode($this->database_helper->get_game($_SESSION["game_id"]), true);
        }
    }

    public function render($clicked_item_id)
    {
        if (strcmp($clicked_item_id, 'new_game_btn') === 0) {
            if ($_SESSION["game_id"] === -1) {
                $this->generate_new_game();
            }
        } else if (strcmp($clicked_item_id, 'reset_game_btn') === 0) {
            if ($_SESSION["game_id"] > -1) {
                $this->reset_game();
            }
        } else {
            $avoid_position = intval($clicked_item_id);
            $this->set_card_selected($avoid_position);
            $this->update_game();
            if ($this->count_selected_cards() === 3) {
                if ($this->equal_cards($avoid_position) === true) {
                    $this->on_match_found($avoid_position);
                } else {
                    $this->on_match_not_found($avoid_position);
                }
            }
            $this->update_game();
            $this->print_game($this->database_helper, $avoid_position);
        }
        $this->database_helper->close_connection();
    }

    protected function generate_new_game()
    {
        $this->cards         = $this->select_cards();
        $_SESSION["game_id"] = $this->database_helper->new_game(json_encode($this->cards));
        $this->print_game(-1);
    }

    protected function reset_game()
    {
        $this->cards = $this->select_cards();
        $this->database_helper->update_game($_SESSION["game_id"], json_encode($this->cards));
        $this->print_game(-1);
    }

    protected function count_selected_cards()
    {
        $count = 0;
        for ($i = 0; $i < $this->number_of_cards; $i++) {
            if ($this->cards[$i]['selected'] === 1 && $this->cards[$i]['found_pair'] === 0) {
                $count++;
            }
        }
        return $count;
    }

    protected function equal_cards($avoid_position)
    {
        $indexes = $this->get_indexes_of_selected_cards($avoid_position);
        return strcmp($this->cards[$indexes[0]]['card'], $this->cards[$indexes[1]]['card']) === 0;
    }

    protected function on_match_found($avoid_position)
    {
        $indexes                                = $this->get_indexes_of_selected_cards($avoid_position);
        $this->cards[$indexes[0]]['selected']   = 1;
        $this->cards[$indexes[0]]['found_pair'] = 1;
        $this->cards[$indexes[1]]['selected']   = 1;
        $this->cards[$indexes[1]]['found_pair'] = 1;
    }

    protected function on_match_not_found($avoid_position)
    {
        $indexes                                = $this->get_indexes_of_selected_cards($avoid_position);
        $this->cards[$indexes[0]]['selected']   = 0;
        $this->cards[$indexes[0]]['found_pair'] = 0;
        $this->cards[$indexes[1]]['selected']   = 0;
        $this->cards[$indexes[1]]['found_pair'] = 0;
    }

    protected function get_indexes_of_selected_cards($avoid_position)
    {
        $index_one;
        $index_two;
        $count = 0;
        for ($i = 0; $i < $this->number_of_cards; $i++) {
            if ( 		$this->cards[$i]['selected'] === 1 && $this->cards[$i]['found_pair'] === 0 &&
           		 		$count === 0 &&
           		 		$i !== $avoid_position ) {
                $index_one = $i;
                $count++;
            } else if ( $this->cards[$i]['selected'] === 1 &&
            			$this->cards[$i]['found_pair'] === 0 &&
            			$count === 1 &&
            			$i !== $avoid_position ) {
                $index_two = $i;
                break;
            }
        }
        return array($index_one, $index_two);
    }

    protected function set_card_selected($position)
    {
        if ($this->cards[$position]['selected'] === 0) {
            $this->cards[$position]['selected'] = 1;
            $this->update_game();
        }
    }

    protected function select_cards()
    {
        $all_cards = Printer::get_cards();
        shuffle($all_cards);
        $playable_cards = array();
        for ($i = 0; $i < ($this->number_of_cards / 2); $i++) {
            $temp_arr = array(
                'card'       => $all_cards[$i],
                'selected'   => 0,
                'found_pair' => 0,
            );
            array_push($playable_cards, $temp_arr);
            array_push($playable_cards, $temp_arr);
        }
        shuffle($playable_cards);
        return $playable_cards;
    }

    protected function print_game($avoid_position)
    {
        Printer::print_cards($this->cards, $avoid_position);
    }

    protected function update_game()
    {
        $this->database_helper->update_game($_SESSION["game_id"], json_encode($this->cards));
    }
}
