<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testUserCreateAndReadFromDatabase(): void
    {
        // Load config
        App::load_config("../config.php");

        App::set('dbh', Connection::make(App::get('config')['database']));

        $user = User::fetchUsername("testUserCreateAndReadFromDatabase")[0];

        // Delete the user if already exists
        if($user)
        {
            $user->remove();
        }

        // Create and save user
        $user = new User();
        $user->username = "testUserCreateAndReadFromDatabase";
        $user->password = password_hash("totoPassword", PASSWORD_DEFAULT);
        $user->description = "Toto description";
        $current_date = date("Y-m-d H:i:s");
        $user->timestamp = $current_date;
        $user->save();

        // Fetch the user
        $retrievedUser = User::fetchUsername("testUserCreateAndReadFromDatabase")[0];

        $this->assertInstanceOf(
            User::class,
            $retrievedUser
        );

        $this->assertEquals(
            "Toto description",
            $retrievedUser->description
        );

        $this->assertEquals(
            $current_date,
            $retrievedUser->timestamp
        );

        $this->assertTrue(
            password_verify("totoPassword", $retrievedUser->password)
        );
    }

    public function testRemoveUserInDatabse() : void
    {
        // Create and save a user
        $user = new User();
        $user->username = "testRemoveUserInDatabse";
        $user->password = password_hash("totoPassword", PASSWORD_DEFAULT);
        $user->description = "Toto description";
        $user->timestamp = date("Y-m-d H:i:s");
        $user->save();

        // Fetch the user
        $retrievedUser = User::fetchUsername("testRemoveUserInDatabse")[0];

        $this->assertInstanceOf(
            User::class,
            $retrievedUser
        );

        // Remove the user
        $retrievedUser->remove();

        // Fetch the user
        $retrievedUser = User::fetchUsername("testRemoveUserInDatabse");

        $this->assertEmpty(
            $retrievedUser
        );
    }

    public function testDuplicateUserInDatabase(): void
    {
        $this->expectException(PDOException::class);

        // Create a user and save twice
        $user = new User();
        $user->username = "testDuplicateUserInDatabase";
        $user->password = password_hash("totoPassword", PASSWORD_DEFAULT);
        $user->description = "Toto description";
        $user->timestamp = date("Y-m-d H:i:s");

        $user->save();
        $user->save();
    }
}