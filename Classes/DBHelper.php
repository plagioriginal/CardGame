<?php


class DBHelper
{
    const server_name   = 'localhost';
    const username      = 'root';
    const password      = '';
    const database_name = 'card_game';

    protected $connection;

    public function __construct()
    {
        $this->connection = new mysqli(
        	self::server_name,
            self::username,
            self::password,
            self::database_name
        );
    }

    public function get_game($id)
    {
        $sql_statement = "SELECT * FROM `game` WHERE `game_id` = " . $id;
        $result        = $this->connection->query($sql_statement);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['json_cards'];
            }
        }
    }

    public function new_game($json)
    {
        $sql_statement = "INSERT INTO game (json_cards) VALUES ('" . $json . "')";
        $result        = $this->connection->query($sql_statement);
        if ($result === true) {
            $last_id = $this->connection->insert_id;
        } else {
            $last_id = -1;
        }
        return $last_id;
    }

    public function update_game($id, $json)
    {
        $sql_statement = "UPDATE game SET json_cards = '" . $json . "' WHERE game_id = " . $id;
        $result        = $this->connection->query($sql_statement);
    }

    public function close_connection()
    {
        $this->connection->close();
    }
}
