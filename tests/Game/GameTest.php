<?php

namespace BinaryStudioAcademyTests\Game;

use BinaryStudioAcademy\Game\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    const TEST_COMMANDS = [
        ['status', "You're at hall. You have 0 coins."],
        ['observe', "There 1 coin(s) here."],
        ['grab', "Congrats! Coin has been added to inventory."],
        ['status', "You're at hall. You have 1 coins."],
        ['grab', "There is no coins left here. Type 'where' to go to another location."],
        ['where', "You're at hall. You can go to: basement, corridor."],
        ['go basement', "You're at basement. You can go to: cabinet, hall."],
        ['observe', "There 2 coin(s) here."],
        ['grab', "Congrats! Coin has been added to inventory."],
        ['grab', "Congrats! Coin has been added to inventory."],
        ['grab', "There is no coins left here. Type 'where' to go to another location."],
        ['status', "You're at basement. You have 3 coins."],
        ['where', "You're at basement. You can go to: cabinet, hall."],
        ['go tower', "Can not go to tower."],
        ['go cabinet', "You're at cabinet. You can go to: corridor."],
        ['observe', "There 1 coin(s) here."],
        ['collect', "Unknown command: 'collect'."],
        ['grab', "Congrats! Coin has been added to inventory."],
        ['status', "You're at cabinet. You have 4 coins."],
        ['go corridor', "You're at corridor. You can go to: hall, cabinet, bedroom."],
        ['grab', "There is no coins left here. Type 'where' to go to another location."],
        ['go bedroom', "You're at bedroom. You can go to: corridor."],
        ['observe', "There 1 coin(s) here."],
        ['grab', "Good job. You've completed this quest. Bye!"]
    ];

    public function test_should_win_the_game()
    {
        $gameTester = new GameTester(new Game);

        // We're testing internal state here so loop is required.

        foreach(self::TEST_COMMANDS as [$command, $expected]) {
            $gameTester->run($command);

            $this->assertContains($expected, $gameTester->getOutput());
        }
    }
}
